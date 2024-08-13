@extends('layouts.app')

@section('content')
    <div class="container p-10 ">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Add Student</h1>
        <form action="{{ route('students.store') }}" method="POST">
        @csrf
            <div class="form-group mb-4">
                <label for="name">Student Name</label>
                <input type="text" class="form-control rounded-md border-gray-300" id="name" name="name" placeholder="e.g. Nur Aisyah">
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="matric_no">Matric No</label>
                        <input type="text" class="form-control rounded-md border-gray-300" id="matric_no" name="matric_no" placeholder="e.g. A20EC0226">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control rounded-md border-gray-300" id="dob" name="dob">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="faculty">Faculty</label>
                        <select class="form-control" id="faculty" name="faculty">
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
                        <input type="text" class="form-control rounded-md border-gray-300" id="phone_no" name="phone" placeholder="e.g. 0123456789">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
            </div>
                <a href="{{ route('students.index') }}" class="btn btn-light">Back</a>
                <button type="submit" class="btn btn-success">Save</button>
        </form>
</div>
@endsection