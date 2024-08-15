<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Student;

use Yajra\DataTables\DataTables;

class ServerSideController extends Controller
{
    //
    public function index()
    {
        return view('serverside.index'); // Renders the view with the DataTable
    }


    public function getData(Request $request)
    {
        $query = Student::query();

        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $query->where('name', 'like', "%$search%")
                ->orWhere('matric_no', 'like', "%$search%");
        }

        $totalRecords = $query->count();

        if ($request->has('length')) {
            $query->skip($request->input('start'))
                ->take($request->input('length'));
        }

        $students = $query->get();

        // Add the action column data
        $data = $students->map(function($student) {
            return [
                'id' => $student->id, // or any other unique identifier
                'name' => $student->name,
                'matric_no' => $student->matric_no,
                'dob' => $student->dob,
                'address' => $student->address,
                'phone' => $student->phone,
                'faculty' => $student->faculty,
                'action' => $student->id,
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }


    
    public function create()
    {
        return view('serverside.create');
    }

    public function show($id)
    {
        return Student::findOrFail($id); // Fetch the note by ID
        //return view('serverside.show', compact('student'));
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

            // Student::updateOrCreate(['id'=>$request->student_id],
            // ['name' => $request->name,
            //     'matric_no' => $request->matric_no,
            //     'dob' => $request->dob,
            //     'faculty' => $request->faculty,
            //     'phone' => $request->phone, 
            //     'address' => $request->address,]);
    
            Student::create([
                'name' => $request->name,
                'matric_no' => $request->matric_no,
                'dob' => $request->dob,
                'faculty' => $request->faculty,
                'phone' => $request->phone, 
                'address' => $request->address,
                'user_id' => Auth::id(),
            ]);
            // Redirect to the serverside index page with a success message
            //return redirect()->route('serverside.index')->with('success', 'New student record added successfully.');
            return response()->json(['success' => 'Student details saved successfully.']);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        // Check if the student exists
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }
        return response()->json($student);
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

        return response()->json(['success' => 'Student details updated successfully.']);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return response()->json(['success' => 'Student details deleted successfully.']);
        } else {
            return response()->json(['error' => 'Student not found.'], 404);
        }
    }


}
