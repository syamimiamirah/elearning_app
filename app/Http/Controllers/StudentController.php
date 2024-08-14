<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Student;

use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    //
    public function index() {
        $students = Student::all(); // Fetch all students without pagination
        return view('students.index', compact('students')); // Pass students to the view
    }
    
    
    public function create()
    {
        return view('students.create');
    }

    public function show($id)
    {
        $student = Student::findOrFail($id); // Fetch the note by ID
        return view('students.show', compact('student'));
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

    public function edit($id)
    {
        $student = Student::findOrFail($id); // Fetch the note by ID
        return view('students.edit', compact('student')); // Return the edit view with note data
    }
    
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'matric_no' => 'required|string|max:15',
            'dob' => 'required|date',
            'faculty' => 'required|string',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string',
        ]);

        if ($student->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $student->update([
           'name' => $request->name,
            'matric_no' => $request->matric_no,
            'dob' => $request->dob,
            'faculty' => $request->faculty,
            'phone' => $request->phone, 
            'address' => $request->address,
        ]);

        return redirect()->route('students.index')->with(['success' => 'Student details updated successfully.']);
    }

    public function destroy(Request $request, Student $student)
    {
        $studentIds = $request->input('selected_students', []);
        if (!empty($studentIds)) {
            Student::whereIn('id', $studentIds)->delete();
            return redirect()->route('students.index')->with('success', 'Selected students deleted successfully.');
        }
        return redirect()->route('students.index')->with('error', 'No students selected for deletion.');
    }

    //Server-side processing
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $students = Student::query();
            return DataTables::of($students)
                ->addIndexColumn() // Adds the row number column
                ->addColumn('actions', function($row) {
                    return view('partials.actions', ['row' => $row]);
                })
                ->make(true);
        }
    }
}
