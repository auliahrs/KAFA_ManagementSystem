<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add this line

class StudentResultController extends Controller
{
    //Display a list of student.
    public function teacherListStudent()
    {
        // Retrieve all students from the database
        $students = Student::all();

        // Return the data to the view
        return view('ManageStudentResults.TeacherResultList', ['students' => $students]);
    }
    
    //Show the form to add a new result.
    public function teacherAddResult($studentID)
    {
        // Fetch the student by ID
        $student = Student::findOrFail($studentID);

        // Fetch all subjects
        $subjects = Subject::all();
        
        // Fetch the classroom information
        $classroom = Classroom::findOrFail($student->classroom_id);

        // Fetch the result
        $results = Result::where('student_id', $studentID)->get();

        $mode = 0; //means adding mode

        // Pass the student and classroom data to the view
        return view('ManageStudentResults.TeacherManageResult', compact('student', 'classroom', 'subjects', 'results', 'mode'));
    }

    //Show the form to edit a result.
    public function teacherEditResult($studentID)
    {
        // Fetch the student by ID
        $student = Student::findOrFail($studentID);

        // Fetch all subjects
        $subjects = Subject::all();
        
        // Fetch the classroom information
        $classroom = Classroom::findOrFail($student->classroom_id);

        // Fetch the result
        $results = Result::where('student_id', $studentID)->get();
        
        //means editing
        $mode = 1;
        
        // Pass the student and classroom data to the view
        return view('ManageStudentResults.TeacherManageResult', compact('results', 'student', 'classroom', 'subjects', 'mode'));
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'marks.*' => 'required|integer|min:0|max:100',
        'comments' => 'required|string|max:255',
    ]);

    if ($request->has('edit')) {
        // Update existing results
        foreach ($request->marks as $subject => $mark) {
            $result = Result::where('student_id', $request->studentId)
                            ->where('subject_id', $subject)
                            ->first();
            if ($result) {
                $result->update([
                    'marks' => $mark,
                    'grade' => $this->calculateGrade($mark),
                    'year' => $request->year,
                    'typeOfExamination' => $request->typeOfExamination,
                    'comment' => $request->comments
                ]);
            } else {
                // If no existing result found, create a new one
                Result::create([
                    'student_id' => $request->studentId,
                    'subject_id' => $subject,
                    'marks' => $mark,
                    'grade' => $this->calculateGrade($mark),
                    'year' => $request->year,
                    'typeOfExamination' => $request->typeOfExamination,
                    'comment' => $request->comments
                ]);
            }
        }

        // Redirect back with success message
        return redirect()->route('teacher.listStudent')->with('success', 'Results updated successfully.');
    } else {
        // Store new results
        foreach ($request->marks as $subject => $mark) {
            Result::create([
                'student_id' => $request->studentId,
                'subject_id' => $subject,
                'marks' => $mark,
                'grade' => $this->calculateGrade($mark),
                'year' => $request->year,
                'typeOfExamination' => $request->typeOfExamination,
                'comment' => $request->comments
            ]);
        }

        // Redirect back with success message
        return redirect()->route('teacher.listStudent')->with('success', 'Results added successfully.');
    }
}


    //Display student's result.
    public function teacherViewResult($studentID)
    {
        // Fetch the student by ID
        $student = Student::findOrFail($studentID);
        
        // Fetch the result by student ID
        $resultsAll = Result::where('student_id', $studentID)->get();

        $latestYear = Result::where('student_id', $studentID)->max('year');
        $results = Result::where('student_id', $studentID)
                 ->where('year', $latestYear)
                 ->get();

        // Fetch the classroom of the student
        $classroom = Classroom::findOrFail($student->classroom_id);

        // Retrieve the subject
        $subjects = Subject::all();

        // Return the data to the view
        return view('ManageStudentResults.StudentViewResult', ['student' => $student, 'results' => $results, 'resultsAll' => $resultsAll, 'classroom' => $classroom, 'subjects' => $subjects])->with('filter',false);
    }

    public function teacherFilterResult(Request $request)
    {
        $studentId = $request->input('student_id'); // Assume this is passed in the form
        $year = $request->input('year');
        $typeOfExamination = $request->input('typeOfExamination');

        // Fetch the student and classroom details
        $student = Student::findOrFail($studentId);
        $classroom = Classroom::findOrFail($student->classroom_id);

        // Filter results based on the selected year and type of examination
        $query = Result::where('student_id', $studentId);
        
        if ($year) {
            $query->where('year', $year);
        }

        if ($typeOfExamination) {
            $query->where('typeOfExamination', $typeOfExamination);
        }

        $results = $query->get();

        $resultsAll = Result::where('student_id', $studentId)->get();

        //lets calculate total marks
        $totalmarks = $results->sum('marks');

        //lets calculate percentage
        $percentage = $totalmarks/8 * 100;

        // Fetch results for all students in the same class, year, and examination type
        $allResults = Result::where('year', $year)
                            ->where('typeOfExamination', $typeOfExamination)
                            ->get()
                            ->groupBy('student_id');

        //lets determine student ranking in class
        // Calculate percentages for all students
        $studentPercentages = [];
        foreach ($allResults as $studentId => $studentResults) {
            $studentTotalMarks = $studentResults->sum('marks');
            $studentPercentages[$studentId] = $studentTotalMarks / 8 * 100;
        }

        // Sort students by percentage in descending order and determine ranking
        arsort($studentPercentages);
        $rankings = array_keys($studentPercentages);

        // Determine the rank of the specific student
        $studentRank = array_search($studentId, $rankings) + 1;

        return view('ManageStudentResults.StudentViewResult', compact('totalmarks', 'percentage', 'studentRank', 'results', 'resultsAll', 'student', 'classroom'))->with('filter', true);
    }

    private function calculateRankingInClass($studentID) {
        //get current student info
        $student = Student::findOrFail($studentID);

        //lets get all students in the same class shall we
        $studentSameClass = Student::where('classroom_id', $student->classroom_id);

        //
    }

    private function calculateGrade($mark)
    {
        if ($mark >= 90) return 'A';
        if ($mark >= 80) return 'B';
        if ($mark >= 70) return 'C';
        if ($mark >= 60) return 'D';
        return 'F';
    }
}
