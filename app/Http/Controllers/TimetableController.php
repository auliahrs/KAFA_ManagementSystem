<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kafa;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Timetable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TimetableController extends Controller
{
    use AuthorizesRequests;

    public function index(){

        $user = Auth::user();

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;
            $timetables = $teacher ? $teacher->timetables()->with('classroom')->get() : collect();
        } elseif ($user->role === 'guardian') {
            $guardian = $user->guardian;

            // Fetch the students (children) associated with the guardian
            $students = Student::where('guardian_id', $guardian->id)->get();

            // If the guardian has children, get their classroom IDs
            if ($students->isNotEmpty()) {
                $classroomIds = $students->pluck('classroom_id'); // Get the classroom IDs of the guardian's children

                // Fetch timetables for the classrooms of the guardian's children
                $timetables = Timetable::with('classroom')->whereIn('classroom_id', $classroomIds)->get();
            } else {
                $timetables = collect(); // No students found, return an empty collection
            }
        } else {
            // For kafa, fetch all timetables
            $timetables = Timetable::with('classroom')->get();
        }

        // Format the time and capitalize the weekday
        $timetables->transform(function ($timetable) {
            $timetable->formatted_time = Carbon::parse($timetable->start_time)->format('H:i');
            $timetable->weekday = ucfirst($timetable->weekday); // Capitalize the first letter
            return $timetable;
        });

        // Group timetables by classroom
        $groupedTimetables = $timetables->groupBy(function ($item) {
            return $item->classroom->classroomName; // Group by classroom name
        });

        return view('ManageTimetable.IndexTimetable', compact('groupedTimetables'));
    }

    public function showCreateTimetable(){
        
        $this->authorize('kafa');
        $teachers = Teacher::all();
        $classes = Classroom::all();
        $subjects = Subject::all();

        return view('ManageTimetable.TimetableForm', compact('classes', 'subjects', 'teachers'));
    }

    public function editTimetable(Request $request, int $id){

        $this->authorize('kafa');

        $timetable = Timetable::findOrFail($id);
        $teachers = Teacher::all();
        $classes = Classroom::all();
        $subjects = Subject::all();
        return view('ManageTimetable.TimetableForm', compact('timetable', 'classes', 'subjects', 'teachers'));
    }

    public function saveTimetable(Request $request){

        $this->authorize('kafa');

        $request->validate([
            'classroom_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'weekday' => 'required',
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'], // Ensure end_time is after start_time
        ], [
            'start_time.validate_time_range' => 'The selected start time is not valid.',
            'end_time.validate_time_range' => 'The selected end time is not valid.',
            'end_time.after' => 'The end time must be after the start time.',
            'start_time.date_format' => 'The start time field must match the format H:i.',
            'end_time.date_format' => 'The end time field must match the format H:i.',
        ]);

        $existingTimetable = Timetable::where([
            'subject_id' => $request->subject_id,
            'weekday' => $request->weekday,
            'start_time' => $request->start_time,
        ])->first();

        if ($existingTimetable) {
            return redirect('/timetable/create-timetable')
            ->withErrors(['subject_id' => 'This time slot is already occupied for the selected subject.'])
            ->withInput($request->input()); // Preserve form data for re-submission
        }

        //insert data into timetables table in db
        $timetable = new Timetable([
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'weekday' => $request->weekday,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        if ($timetable->save()) {
            // Record saved successfully
            return redirect()->route('timetable.index')->with('status', 'Timetable Created Successfully');
        } else {
            // Handle the error
            return "Error persists";
        }
    }

    public function viewTimetable(int $id){
        $timetable = Timetable::findOrFail($id);
        $timetableData = [];
        $user = auth()->user();

        // Define the time slots and the recess period
        foreach (['08:30', '09:00', '09:30', '10:00', '10:30', '11:00'] as $start_time) {
            $row = [
                'time' => $start_time . ' - ' . date('H:i', strtotime($start_time) + 30 * 60),
            ];

            $is_recess = $start_time === '10:00'; // Recess period

            foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day) {
                if ($is_recess) {
                    $row[$day] = '<span class="recess">Recess</span>';
                } else {
                    // Filter records based on user role and other criteria
                    $query = Timetable::where('classroom_id', $timetable->classroom_id)
                        ->where('start_time', $start_time)
                        ->where('weekday', $day);

                    // If the user is a teacher, filter by teacher ID
                    if ($user->role === 'teacher') {
                        $query->where('teacher_id', $user->teacher->id); // Ensure you use the teacher's ID
                    }

                    $record = $query->with('subject', 'teacher')->first();

                    if ($record) {
                        $row[$day] = '<span class="subject-name">' . ucwords(strtolower($record->subject->subjectName)) . '</span>' .
                                    '<br><span class="teacher-name text-muted small">(' . ucwords(strtolower($record->teacher->user->name)) . ')</span>';
                    } else {
                        $row[$day] = '-'; // No class scheduled
                    }
                }
            }
            $timetableData[] = $row;
        }

        return view('ManageTimetable.ViewTimetable', compact('timetable', 'timetableData'));
    }

    public function updateTimetable(Request $request, int $id){
        
        $this->authorize('kafa'); // Authorize the user

        // Find the timetable by ID
        $timetable = Timetable::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'classroom_id' => 'required',
            'subject_id' => 'required',
            'teacher_id' => 'required',
            'weekday' => 'required',
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ], [
            'end_time.after' => 'The end time must be after the start time.',
            'start_time.date_format' => 'The start time field must match the format H:i.',
            'end_time.date_format' => 'The end time field must match the format H:i.',
        ]);

        // Check for existing timetable conflicts
        $existingTimetable = Timetable::where('id', '!=', $id) // Exclude the current timetable
            ->where('subject_id', $request->subject_id)
            ->where('weekday', $request->weekday)
            ->where('start_time', $request->start_time)
            ->first();

        if ($existingTimetable) {
            return redirect()->route('timetable.edit', $id)
                ->withErrors(['subject_id' => 'This time slot is already occupied for the selected subject.'])
                ->withInput($request->input());
        }

        // Update the timetable data
        $timetable->update([
            'classroom_id' => $request->classroom_id,
            'subject_id' => $request->subject_id,
            'teacher_id' => $request->teacher_id,
            'weekday' => $request->weekday,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        // Redirect with success message
        return redirect()->route('timetable.index')->with('status', 'Timetable Updated Successfully');
    }

    public function deleteTimetable(int $id){
        
        $this->authorize('kafa'); // Authorize the user

        // Find the timetable by ID
        $timetable = Timetable::findOrFail($id);

        // Delete the timetable
        $timetable->delete();

        // Redirect with success message
        return redirect()->route('timetable.index')->with('status', 'Timetable Deleted Successfully');
    }
}