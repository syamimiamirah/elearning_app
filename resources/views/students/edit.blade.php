@extends('layouts.app')

@section('content')
<div class="container p-10">
    <div class="mx-auto sm:px-6 lg:px-8">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Update Student Details</h1>
        <section class="bg-white p-6 rounded-lg shadow-md pb-10">
            <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PATCH')
                <div class="form-group mb-4">
                    <label for="name">Student Name</label>
                    <input type="text" class="form-control rounded-md border-gray-300" id="name" name="name" placeholder="e.g. Nur Aisyah" value="{{ $student->name }}">
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="matric_no">Matric No</label>
                            <input type="text" class="form-control rounded-md border-gray-300" id="matric_no" name="matric_no" placeholder="e.g. A20EC0226" value="{{ $student->matric_no }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control rounded-md border-gray-300" id="dob" name="dob" value="{{ $student->dob }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="faculty">Faculty</label>
                            <select class="form-control" id="faculty" name="faculty" value="{{ $student->faculty }}">
                            <option>Faculty of Civil Engineering</option>
                            <option>Faculty of Mechanical Engineering</option>
                            <option>Faculty of Electrical Engineering</option>
                            <option>Faculty of Chemical & Energy Engineering</option>
                            <option>Faculty of Computing</option>
                            <option>Faculty of Science</option>
                            <option>Faculty of Built Environment & Surveying</option>
                            <option>Faculty of Social Sciences & Humanities</option>
                            <option>Faculty of Management</option>
                            <option>Faculty of Artificial Intelligence</option>
                            <option>Malaysia-Japan International Institute of Technology</option>
                            <option>Azman Hashim International Business School</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_no">Phone No</label>
                            <input type="text" class="form-control rounded-md border-gray-300" id="phone_no" name="phone" placeholder="e.g. 0123456789" value="{{ $student->phone }}">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" >{{ $student->address }}</textarea>
                </div>
                    <a href="{{ route('students.index') }}" class="btn btn-light">Back</a>
                    <button type="submit" class="btn btn-success">Update</button>
            </form>
    </section>
    </div>
</div>
@endsection