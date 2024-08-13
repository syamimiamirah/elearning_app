@extends('layouts.app')

@section('content')
    <div class="container p-10 ">
    @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-6">List of Students</h1>
        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add New Student</a>
        <table id="students-table" class="table table-striped">
            <thead>
                <tr>
                    
                    <th>No</th>
                    <th>Student Name</th>
                    <th>Matric No</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Faculty</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td></td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->matric_no}}</td>
                        <td>{{ $student->dob }}</td>
                        <td>{{ $student->address }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->faculty }}</td>
                        <td>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



<script>
$(document).ready(function() {
    $('#students-table').DataTable({
        "drawCallback": function(settings) {
            // Iterate over all rows in the table
            $('#students-table').find('tbody tr').each(function(index) {
                // Set the text of the first cell to the index + 1
                $(this).find('td:first').text(index + 1);
            });
        }
    });
});
</script>

<style>
     .dataTables_filter input {
        margin-bottom: 1rem; /* Adjust the margin as needed */
        }

    .dataTables_length select {
        width: 70px; /* Adjust width as needed */
        padding: 0.5rem; /* Add padding for better spacing */
        font-size: 0.875rem; /* Adjust font size if needed */
        border-radius: 0.25rem; /* Optional: add border radius for rounded corners */
        height: auto; /* Ensure height is not too restricted */
        text-align: center;
    }

    /* Adjust the font size and padding of the dropdown items */
    .dataTables_length select option {
        padding: 0.5rem; /* Add padding to dropdown items */
    }

</style>

@endsection

