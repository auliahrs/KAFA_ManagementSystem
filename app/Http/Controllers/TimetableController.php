<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kafa;
use App\Models\User;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Timetable;
// use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TimetableController extends Controller
{
    use AuthorizesRequests;

    public function index(){
        $user = Auth::user(); // Get the currently authenticated user

        if ($user->role === 'teacher') {
            // Get the teacher associated with the authenticated user
            $teacher = $user->teacher;

            // Fetch timetables that belong to the authenticated teacher
            $timetables = $teacher ? $teacher->timetables()->with('classroom')->get() : collect(); // Use an empty collection if no teacher found
        } else {
            // For kafa and guardian, fetch all timetables
            $timetables = Timetable::with('classroom')->get();
        }

        // Format the time and capitalize the weekday
        $timetables->transform(function ($timetable) {
            $timetable->formatted_time = \Carbon\Carbon::parse($timetable->start_time)->format('H:i');
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
        // Format start_time and end_time to match the dropdown options
        // $timetable->start_time = Carbon::parse($timetable->start_time)->format('H:i');
        // $timetable->end_time = Carbon::parse($timetable->end_time)->format('H:i');
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

    //currently working method*
    // public function viewTimetable(int $id){
        
    //     $timetable = Timetable::findOrFail($id);
    //     $timetableData = [];
    //     $user = auth()->user();

    //     // Define the time slots and the recess period
    //     foreach (['08:30', '09:00', '09:30', '10:00', '10:30', '11:00'] as $start_time) {
    //         $row = [
    //             'time' => $start_time . ' - ' . date('H:i', strtotime($start_time) + 30 * 60),
    //         ];

    //         $is_recess = $start_time === '10:00'; // Recess period

    //         foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day) {
    //             if ($is_recess) {
    //                 $row[$day] = '<span class="recess">Recess</span>';
    //             } else {
    //                 // Filter records based on user role and other criteria
    //                 $query = Timetable::where('classroom_id', $timetable->classroom_id)
    //                     ->where('start_time', $start_time)
    //                     ->where('weekday', $day);

    //                 // If the user is a teacher, filter by teacher ID
    //                 if ($user->role === 'teacher') {
    //                     $query->where('teacher_id', $user->id);
    //                 }

    //                 $record = $query->with('subject', 'teacher')->first();

    //                 if ($record) {
    //                     $row[$day] = '<span class="subject-name">' . ucwords(strtolower($record->subject->subjectName)) . '</span>' .
    //                                 '<br><span class="teacher-name">(' . ucwords(strtolower($record->teacher->user->name)) . ')</span>';
    //                 } else {
    //                     $row[$day] = '-'; // No class scheduled
    //                 }
    //             }
    //         }
    //         $timetableData[] = $row;
    //     }

    //     return view('ManageTimetable.ViewTimetable', compact('timetable', 'timetableData'));
    // }

    // public function viewTimetable(int $id){
        
    //     $timetable = Timetable::findOrFail($id);
    //     $timetableData = [];
    //     $user = auth()->user();

    //     foreach (['08:30', '09:00', '09:30', '10:00', '10:30', '11:00'] as $start_time) {
    //         $row = [
    //             'time' => $start_time . ' - ' . date('H:i', strtotime($start_time) + 30 * 60),
    //         ];

    //         $is_recess = $start_time === '10:00';

    //         foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day) {
    //             if ($is_recess) {
    //                 $row[$day] = '<span class="recess">Rehat</span>';
    //             } else {
    //                 if ($user->role === 'teacher') {
    //                     $record = Timetable::where('class_id', $timetable->class_id)
    //                         ->where('start_time', $start_time)
    //                         ->where('weekday', $day)
    //                         ->where('teacher_id', $timetable->teacher->id) // Filter by the teacher's ID
    //                         ->with('subject', 'teacher')
    //                         ->first();
    //                 } else {
    //                     $record = Timetable::where('class_id', $timetable->class_id)
    //                         ->where('start_time', $start_time)
    //                         ->where('weekday', $day)
    //                         ->with('subject', 'teacher')
    //                         ->first();
    //                 }

    //                 if ($record) {
    //                     $row[$day] = '<span class="subject-name">' . ucwords(strtolower($record->subject->SubjectName)) . '</span>' .
    //                                 '<br><span class="teacher-name">(' . ucwords(strtolower($record->teacher->name)) . ')</span>';
    //                 } else {
    //                     $row[$day] = '-';
    //                 }
    //             }
    //         }
    //         $timetableData[] = $row;
    //     }

    //     return view('ManageTimetable.ViewTimetable', compact('timetable', 'timetableData'));
    // }

    // public function viewTimetable($id){
        
    //     // Fetch timetable entries for the specific classroom
    //     $timetableEntries = Timetable::where('classroom_id', $id)
    //                                 ->with(['subject', 'teacher'])
    //                                 ->get();
        
    //     // Fetch the classroom with its timetable entries
    //     $classroom = Classroom::with(['timetables.subject', 'timetables.teacher'])
    //                     ->findOrFail($id);

    //     // Organize timetable data by day
    //     $timetableData = [
    //         'monday'    => [],
    //         'tuesday'   => [],
    //         'wednesday' => [],
    //         'thursday'  => [],
    //         'friday'    => [],
    //     ];

    //     foreach ($timetableEntries as $entry) {
    //         $day = strtolower($entry->weekday);
    //         $timetableData[$day][] = [
    //             'time' => $entry->start_time->format('H:i') . ' - ' . $entry->end_time->format('H:i'),
    //             'subject' => $entry->subject->subjectName,
    //             'teacher' => $entry->teacher->user->name,
    //         ];
    //     }

    //     return view('ManageTimetable.ViewTimetable', compact('timetableData'));

    // }
    
//     public function teacherviewtimetable()
// {
//     // Fetch timetables for the logged-in teacher
//     // $user = auth()->user();
//     // $timetables = Timetable::where('teacher_id', $user->id)->get();
//     $timetables = Timetable::all();

//     // Return the view to display the timetables
//     return view('ManageTimetable.TeacherViewTimetable', compact('timetables'));
// }


//     public function teacherdisplaytimetable($id)
// {
//     // Fetch the timetable by ID
//     $timetable = Timetable::findOrFail($id);
//     $timetableData = [];
//     $user = auth()->user(); // Get the authenticated user

//     foreach (['08:30', '09:00', '09:30', '10:00', '10:30', '11:00'] as $start_time) {
//         $row = [
//             'time' => $start_time . ' - ' . date('H:i', strtotime($start_time) + 30 * 60),
//         ];

//         $is_recess = $start_time === '10:00';

//         foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $weekday) {
//             if ($is_recess) {
//                 $row[$weekday] = '<span class="recess">Rehat</span>';
//             } else {
//                 $record = Timetable::where('classroom_id', $timetable->classroom_id)
//                     ->where('start_time', $start_time)
//                     ->where('weekday', $weekday)
//                     ->where('teacher_id', $user->id) // Filter by the teacher's ID
//                     ->with('subject', 'teacher')
//                     ->first();

//                 if ($record) {
//                     $row[$weekday] = '<span class="subject-name">' . ucwords(strtolower($record->subject->SubjectName)) . '</span>' .
//                                     '<br><span class="teacher-name">(' . ucwords(strtolower($record->teacher->id)) . ')</span>';
//                 } else {
//                     $row[$weekday] = '-';
//                 }
//             }
//         }
//         $timetableData[] = $row;
//     }

//     // Return the view with the timetable data
//     return view('ManageTimetable.TeacherDisplayTimetable', compact('timetable', 'timetableData'));
// }


//     public function guardianviewtimetable()
//     {
//         // Assuming you have a Student model
//         $students = Student::all(); // Fetch all students from the database

//         // Assume each student has a classroom_id
//         foreach ($students as $student) {
//             $classroom = Classroom::find($student->classroom_id); // Fetch classroom data based on classroom_id
//             $student->classroomName = $classroom->classroomName; // Assign className to student object
//         }

//         // Pass $students data to the view
//         return view('ManageTimetable.ParentsViewTimetable', compact('students'));
//     }

//     public function kafaviewAlltimetable()
//     {
//         // Fetch all teachers from the database
//         // $teachers = Teacher::all();
//         $timetables = Timetable::all();

//         // Return the data to the view
//         return view('ManageTimetable.KAFAViewAllTimetable', compact('timetables'));
//     }


//     /**
//      * Show the form for creating a new resource.
//      */
//     public function kafaaddtimetable()
//     {
//         // Fetch subjects from the database
//         $subjects = Subject::all();
//         // Fetch all teachers from the database
//         $teachers = Teacher::all();
//         $classes = Classroom::all();
//         $users = User::all();

//         // Pass the subjects to the view
//         return view('ManageTimetable.KAFAAddTimetable', compact('subjects', 'teachers', 'users', 'classes'));
//     }

//     public function kafadisplaytimetable($id){
//         // Your existing method logic here
//         $timetable = Timetable::findOrFail($id);
//         $timetableData = [];
//         $user = auth()->user();

//         foreach (['08:30', '09:00', '09:30', '10:00', '10:30', '11:00'] as $start_time) {
//             $row = [
//                 'time' => $start_time . ' - ' . date('H:i', strtotime($start_time) + 30 * 60),
//             ];

//             $is_recess = $start_time === '10:00';

//             foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $weekday) {
//                 if ($is_recess) {
//                     $row[$weekday] = '<span class="recess">Rehat</span>';
//                 } else {
//                     if ($user->role === 'teacher') {
//                         $record = Timetable::where('classroom_id', $timetable->classroom_id)
//                             ->where('start_time', $start_time)
//                             ->where('weekday', $weekday)
//                             ->where('teacher_id', $timetable->teacher->id) // Filter by the teacher's ID
//                             ->with('subject', 'teacher')
//                             ->first();
//                     } else {
//                         $record = Timetable::where('classroom_id', $timetable->classroom_id)
//                             ->where('start_time', $start_time)
//                             ->where('weekday', $weekday)
//                             ->with('subject', 'teacher')
//                             ->first();
//                     }

//                     if ($record) {
//                         $row[$weekday] = '<span class="subject-name">' . ucwords(strtolower($record->subject->SubjectName)) . '</span>' .
//                                     '<br><span class="teacher-name">(' . ucwords(strtolower($record->teacher->id)) . ')</span>';
//                     } else {
//                         $row[$weekday] = '-';
//                     }
//                 }
//             }
//             $timetableData[] = $row;
//         }

//         return view('ManageTimetable.TeacherDisplayTimetable', compact('timetable', 'timetableData'));
//     }


//     //to save timetable
//     public function kafasavetimetable(Request $request) {
//         // Validate the incoming data
//         // $request->validate([
//         //     'class_id' => 'required',
//         //     'subject_id' => 'required',
//         //     'teacher_id' => 'required',
//         //     'weekday' => 'required',
//         //     'start_time' => ['required', 'date_format:H:i'],
//         //     'end_time' => ['required', 'date_format:H:i', 'after:start_time'], // Ensure end_time is after start_time
//         //     // 'year' => 'required|numeric',
//         // ], [
//         //     'start_time.validate_time_range' => 'The selected start time is not valid.',
//         //     'end_time.validate_time_range' => 'The selected end time is not valid.',
//         //     'end_time.after' => 'The end time must be after the start time.',
//         //     'start_time.date_format' => 'The start time field must match the format H:i.',
//         //     'end_time.date_format' => 'The end time field must match the format H:i.',
//         // ]);

        
//         //insert data into timetables table in db
//         $timetable = new Timetable([
//             'classroom_id' => $request->classroom_id,
//             'subject_id' => $request->subject_id,
//             'teacher_id' => $request->teacher_id,
//             'weekday' => $request->weekday,
//             'start_time' => $request->start_time,
//             'end_time' => $request->end_time,
//             // 'year' => $request->year,
//         ]);

//         if ($timetable->save()) {
//             // Record saved successfully
//         return redirect()->route('kafa.viewAllTimetable')->with('success', 'Timetable saved successfully!');

//         } else {
//             // Handle the error
//             return "Error persists";
//         }

//     }
    

//     public function kafaedittimetable()
//     {
//         // Fetch subjects from the database
//         $subjects = Subject::all();
//         // Fetch all teachers from the database
//         $teachers = Teacher::all();

//         // Pass the subjects to the view
//         return view('ManageTimetable.KAFAAddTimetable', compact('subjects', 'teachers'));
//     }
}