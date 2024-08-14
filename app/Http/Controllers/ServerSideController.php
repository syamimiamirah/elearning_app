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
                'DT_RowIndex' => $student->id, // or any other unique identifier
                'name' => $student->name,
                'matric_no' => $student->matric_no,
                'dob' => $student->dob,
                'address' => $student->address,
                'phone' => $student->phone,
                'faculty' => $student->faculty,
                'action' => '<div style="display: flex; gap: 5px;"><a href="' . route('serverside.edit', $student->id) . '" class="edit btn btn-warning">Edit</a> 
                            <form action="' . route('serverside.destroy', $student->id) . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="delete btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this student?\')">Delete</button>
                            </form>
                            </div>'
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
        $student = Student::findOrFail($id); // Fetch the note by ID
        return view('serverside.show', compact('student'));
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
            // Redirect to the serverside index page with a success message
            return redirect()->route('serverside.index')->with('success', 'New student record added successfully.');
        
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id); // Fetch the note by ID
        return view('serverside.edit', compact('student')); // Return the edit view with note data
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

        return redirect()->route('serverside.index')->with(['success' => 'Student details updated successfully.']);
    }

    public function destroy(Request $request, Student $student)
    {
        $studentIds = $request->input('selected_students', []);
        if (!empty($studentIds)) {
            Student::whereIn('id', $studentIds)->delete();
            return redirect()->route('serverside.index')->with('success', 'Selected students deleted successfully.');
        }
        return redirect()->route('serverside.index')->with('error', 'No students selected for deletion.');
    }

}
