<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Classroom;
use App\Models\Result;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the activity.
     */
    public function kafaListReportActivity()
    {
        // Fetch all records from the 'activities' table
        $activities = Activity::all();

        // Return the data to KAFAListReportActivity page with list of activities
        return view('ManageReportsAndActivities.KAFAListReportActivity')->with('activities', $activities);
    }

    /**
     * Show the detail of the report activity.
     */
    public function kafaViewReportActivity(Activity $activity)
    {
        // Return the data to KAFAListReportActivity page with list of activities
        return view('ManageReportsAndActivities.KAFAViewReportActivity')->with('activity', $activity);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function KAFACreateReportActivity(Activity $activity)
    {
        // Return the data to KAFAViewReportActivity page with list of activities
        return view('ManageReportsAndActivities.KAFACreateReportActivity')->with('activity', $activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function kafaUpdateReportActivity(Request $request, Activity $activity)
    {
        // dd($request);
        // Validate the incoming request data
        $request->validate([
            'feedback' => 'string',
        ]);

        // Update the activity with the validated data
        $activity->update([
            'status' => 'Finished',
            'feedback' => $request->input('feedback'),
        ]);

        // Redirect or return a response
        return redirect()->route('kafa.listReportActivity')->with('success', 'Activity updated successfully.');
    }

    /**
     * Display a listing of the activity.
     */
    public function muipListReportActivity()
    {
        // Fetch all records from the 'activities' table
        $activities = Activity::where('status', 'finished')->get();

        // Return the data to MUIPListReportActivity page with list of activities
        return view('ManageReportsAndActivities.MUIPListReportActivity')->with('activities', $activities);
    }

    /**
     * Show the detail of the report activity.
     */
    public function muipViewReportActivity(Activity $activity)
    {
        // Return the data to MUIPViewReportActivity page with list of activities
        return view('ManageReportsAndActivities.MUIPViewReportActivity')->with('activity', $activity);
    }

    /**
     * Display a listing of the activity.
     */
    public function muipListClassReport()
    {
        // Fetch all records from the 'activities' table
        $classrooms = Classroom::all();

        // Return the data to MUIPListClassReport page with list of classes
        return view('ManageReportsAndActivities.MUIPManageAcademic')->with('classrooms', $classrooms);
    }

    public function muipClassAcademicReport(Classroom $classroom)
    {
        // Retrieve the students data where classroom_id matches the classroom's id, ordered by average_result in descending order
        $students = Student::where('classroom_id', $classroom->id)
            ->orderBy('averageResult', 'desc')
            ->get();

        // Prepare data for the chart
        $studentNames = $students->pluck('studentName');
        $averageResults = $students->pluck('averageResult');

        // Return the data to MUIPClassAcademic page
        return view('ManageReportsAndActivities.MUIPClassAcademic')
            ->with('classroom', $classroom)
            ->with('students', $students)
            ->with('studentNames', $studentNames)
            ->with('averageResults', $averageResults);
    }

    /**
     * Show the detail of the report student.
     */
    public function muipStudentAcademicReport(Student $student, Classroom $classroom)
    {
        // Retrieve the result data where student_id matches the student's id
        $results = Result::where('student_id', $student->id)
            ->orderBy('subject_id', 'asc')
            ->get()
            ->keyBy('subject_id');

        $subjects = Subject::orderBy('id', 'asc')->get();

        // Return the data to MUIPStudentAcademic page with list of activities
        return view('ManageReportsAndActivities.MUIPStudentAcademic')
            ->with('student', $student)
            ->with('classroom', $classroom)
            ->with('subjects', $subjects)
            ->with('results', $results);
    }
}
