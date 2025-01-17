<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentResultController extends Controller
{
    // Display a list of students with filtering capabilities
    public function teacherListStudent(Request $request)
    {
        // Retrieve classrooms for dropdown
        $classrooms = Classroom::all();

        // Initialize the query
        $query = Student::query();

        // Apply filtering by student name
        if ($request->filled('studentName')) {
            $query->where('studentName', 'like', '%' . $request->input('studentName') . '%');
        }

        // Apply filtering by classroom
        if ($request->filled('classroom')) {
            $query->where('classroom_id', $request->input('classroom'));
        }

        // Retrieve the filtered list of students
        $students = $query->get();

        // Pass data to the view
        return view('ManageStudentResults.TeacherResultList', [
            'students' => $students,
            'classrooms' => $classrooms,
        ]);
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
        $studentId = $request->input('student_id');
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

        // Fetch all results for the student
        $resultsAll = Result::where('student_id', $studentId)->get();

        // Calculate total marks
        $totalMarks = $results->sum('marks');

        // Calculate percentage
        $percentage = $results->count() > 0 ? round(($totalMarks / ($results->count() * 100)) * 100, 2) : 0;

        // Calculate the ranking in the class
        $rankingsInClass = $this->calculateRankingInClass($studentId, $year, $typeOfExamination);
        $studentRank = array_search($studentId, array_keys($rankingsInClass)) + 1;

        // Total number of students in the same class and exam type
        $totalStudentsInClass = count($rankingsInClass);

        // Calculate the ranking in the standard
        $rankingsInStandard = $this->calculateRankingInStandard($typeOfExamination, $year);
        $rankInStandard = array_search($studentId, array_keys($rankingsInStandard)) + 1;

        // Total number of students in the standard
        $totalStudentsInStandard = count($rankingsInStandard);

        // Fetch the comment for the selected type of examination
        $comment = Result::where('student_id', $studentId)
                        ->where('typeOfExamination', $typeOfExamination)
                        ->value('comment');

        // Pass the selected year and type back to the view
        return view('ManageStudentResults.StudentViewResult', compact(
            'results', 
            'resultsAll', 
            'student', 
            'classroom', 
            'totalMarks', 
            'percentage', 
            'studentRank', 
            'rankInStandard', 
            'totalStudentsInClass', 
            'totalStudentsInStandard', 
            'comment',
            'year', // Pass back selected year
            'typeOfExamination' // Pass back selected type of exam
        ))->with(['filter' => true, 'selectedYear' => $year, 'selectedType' => $typeOfExamination]);
    }

    //To calculate total marks
    public function calculateTotalMarks($studentId, $typeOfExamination)
    {
        // Retrieve all results for the given student and type of examination
        $results = Result::where('student_id', $studentId)
                        ->where('typeOfExamination', $typeOfExamination)
                        ->get();

        // Calculate the total marks
        $totalMarks = $results->sum('marks');

        return $totalMarks;
    }

    private function calculateRankingInClass($studentID, $year, $typeOfExamination)
    {
        // Get the student's classroom ID
        $student = Student::findOrFail($studentID);
        $classroomId = $student->classroom_id;

        // Fetch results for all students in the same classroom, year, and examination type
        $allResults = Result::where('year', $year)
                            ->where('typeOfExamination', $typeOfExamination)
                            ->whereIn('student_id', function ($query) use ($classroomId) {
                                $query->select('id')
                                    ->from('students')
                                    ->where('classroom_id', $classroomId);
                            })
                            ->get()
                            ->groupBy('student_id');

        // Calculate total marks for each student
        $studentTotalMarks = [];
        foreach ($allResults as $id => $studentResults) {
            $studentTotalMarks[$id] = $studentResults->sum('marks');
        }

        // Sort students by total marks in descending order
        arsort($studentTotalMarks);

        // Return the rankings as an array
        return $studentTotalMarks;
    }

    private function calculateRankingInStandard($typeOfExamination, $year)
    {
        // Fetch results for all students in the selected year and type of examination
        $allResults = Result::where('year', $year)
                            ->where('typeOfExamination', $typeOfExamination)
                            ->get()
                            ->groupBy('student_id');

        // Calculate total marks for each student
        $studentTotalMarks = [];
        foreach ($allResults as $id => $studentResults) {
            $studentTotalMarks[$id] = $studentResults->sum('marks');
        }

        // Sort students by total marks in descending order
        arsort($studentTotalMarks);

        // Return the rankings as an array
        return $studentTotalMarks;
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