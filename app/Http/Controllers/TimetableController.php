<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classroom;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function teacherviewtimetable()
    {
        // Return the data to the view
        return view('ManageTimetable.TeacherViewTimetable');
    }

    public function guardianviewtimetable()
    {
        // Assuming you have a Student model
        $students = Student::all(); // Fetch all students from the database

        // Assume each student has a classroom_id
        foreach ($students as $student) {
            $classroom = Classroom::find($student->classroom_id); // Fetch classroom data based on classroom_id
            $student->classroomName = $classroom->classroomName; // Assign className to student object
        }

        // Pass $students data to the view
        return view('ManageTimetable.ParentsViewTimetable', compact('students'));
    }

    public function kafaviewtimetable()
    {
        // Fetch all teachers from the database
        $teachers = Teacher::all();

        // Return the data to the view
        return view('ManageTimetable.KAFAViewTimetable', compact('teachers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function kafaaddtimetable()
    {
        // Fetch subjects from the database
        $subjects = Subject::all();
        // Fetch all teachers from the database
        $teachers = Teacher::all();

        // Pass the subjects to the view
        return view('ManageTimetable.KAFAAddTimetable', compact('subjects', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store the timetable data
        $validatedData = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            // Add other validation rules for the timetable slots
        ]);

        // Logic to store timetable data
        // Timetable::create($validatedData);

        // For demonstration, redirect back with success message
        return redirect()->back()->with('success', 'Timetable saved successfully.');
    }

    public function kafaedittimetable()
    {
        // Fetch subjects from the database
        $subjects = Subject::all();
        // Fetch all teachers from the database
        $teachers = Teacher::all();

        // Pass the subjects to the view
        return view('ManageTimetable.KAFAAddTimetable', compact('subjects', 'teachers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
