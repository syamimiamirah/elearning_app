@extends('layouts.app')

@section('content')
<div class="container p-10">
    <div class="mx-auto sm:px-6 lg:px-8">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-6">Update Student Details</h1>
        <section class="bg-white p-6 rounded-lg shadow-md pb-10">
        <div class="mb-4">
                <strong>Name:</strong> {{ $student->name }}
            </div>
            <div class="mb-4">
                <strong>Matric No:</strong> {{ $student->matric_no }}
            </div>
            <div class="mb-4">
                <strong>Date of Birth:</strong> {{ $student->dob }}
            </div>
            <div class="mb-4">
                <strong>Address:</strong> {{ $student->address }}
            </div>
            <div class="mb-4">
                <strong>Phone:</strong> {{ $student->phone }}
            </div>
            <div class="mb-4">
                <strong>Faculty:</strong> {{ $student->faculty }}
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Back to List</a>
        </section>
    </div>
</div>
@endsection