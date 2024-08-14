@extends('layouts.app')

@section('content')
<div class="container p-10">
    <div class="mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-6">List of Students</h1>
        <section class="bg-white p-6 rounded-lg shadow-md pb-10">
            <form id="bulk-delete-form" action="{{ route('students.destroy') }}" method="POST" onsubmit="return confirmBulkDelete()">
                @csrf
                @method('DELETE')

                <table id="students-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
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
                                <td><input type="checkbox" name="selected_students[]" value="{{ $student->id }}"></td>
                                <td></td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->matric_no }}</td>
                                <td>{{ $student->dob }}</td>
                                <td>{{ $student->address }}</td>
                                <td>{{ $student->phone }}</td>
                                <td>{{ $student->faculty }}</td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-info">View</a>
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('students.create') }}" class="btn btn-primary">Add</a>
                <button type="submit" class="btn btn-danger">Delete Selected</button>
            </form>
        </section>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#students-table').DataTable({
        "drawCallback": function(settings) {
            var api = this.api();
            var pageInfo = api.page.info();
            var startIndex = pageInfo.start;

            // Iterate over all rows in the table
            $('#students-table').find('tbody tr').each(function(index) {
                // Set the text of the first cell to the correct index
                $(this).find('td:nth-child(2)').text(startIndex + index + 1);
            });
        }
    });

    // Select or Deselect All Checkboxes
    $('#select-all').on('click', function() {
        $('input[name="selected_students[]"]').prop('checked', this.checked);
    });
});

function confirmBulkDelete() {
    const selectedStudents = $('input[name="selected_students[]"]:checked');
    if (selectedStudents.length > 0) {
        return confirm(`Are you sure you want to delete ${selectedStudents.length} student(s)?`);
    } else {
        alert('Please select at least one student to delete.');
        return false;
    }
}
</script>

<style>
    .dataTables_filter input {
        margin-bottom: 1rem;
    }

    .dataTables_length select {
        width: 70px;
        padding: 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        height: auto;
        text-align: center;
    }

    .dataTables_length select option {
        padding: 0.5rem;
    }
</style>

@endsection
