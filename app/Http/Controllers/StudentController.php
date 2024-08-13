<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Student;

class StudentController extends Controller
{
    //
    public function index() {
        $students = Student::all(); // Fetch all students
        return view('students.index', compact('students')); // Pass students to the view
    }
    
    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request) {
        $request->validate([
                'name' => 'required|string|max:255',
                'matric_no' => 'required|string|max:15',
                'dob' => 'required|date',
                'faculty' => 'required|string',
                'phone' => 'required|string|max:15',
                'address' => 'nullable|string',
            ]);
    
            Student::create([
                'name' => $request->name,
                'matric_no' => $request->matric_no,
                'dob' => $request->dob,
                'faculty' => $request->faculty,
                'phone' => $request->phone, 
                'address' => $request->address,
                'user_id' => Auth::id(),
            ]);
            // Redirect to the students index page with a success message
            return redirect()->route('students.index')->with('success', 'New student record added successfully.');
        }
    


    // public function create() {
    //     return view('students.create');
    // }

    // public function store(Request $request) {
    //     $request->validate([
    //         'student_number' => 'required|unique:students',
    //         'dob' => 'required|date',
    //         'address' => 'nullable|string',
    //         'phone' => 'nullable|string',
    //     ]);

    //     Student::create($request->all());

    //     return redirect()->route('students.index')->with('success', 'Student created successfully.');
    // }

    // public function show(Student $student) {
    //     return view('students.show', compact('student'));
    // }

    // public function edit(Student $student) {
    //     return view('students.edit', compact('student'));
    // }

    // public function update(Request $request, Student $student) {
    //     $request->validate([
    //         'student_number' => 'required|unique:students,student_number,' . $student->id,
    //         'dob' => 'required|date',
    //         'address' => 'nullable|string',
    //         'phone' => 'nullable|string',
    //     ]);

    //     $student->update($request->all());

    //     return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    // }

    // public function destroy(Student $student) {
    //     $student->delete();

    //     return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    // }
}
