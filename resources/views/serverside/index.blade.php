@extends('layouts.app')

@section('content')
<div class="container p-10">
    <div class="mx-auto sm:px-6 lg:px-8">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-6">List of Students</h1>
        <section class="bg-white p-6 rounded-lg shadow-md pb-10">
            <a href="{{ route('serverside.create') }}" class="btn btn-primary mb-3">Add Student</a>
            <table id="students-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Matric No</th>
                        <th>Date of Birth</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Faculty</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </section>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#students-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('serverside.data') }}",
        columns: [
            {
                data: null,
                name: 'id',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row + 1; // This gives row number starting from 1
                }
            },
            { data: 'name', name: 'name' },
            { data: 'matric_no', name: 'matric_no' },
            { data: 'dob', name: 'dob' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },
            { data: 'faculty', name: 'faculty' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10
    });
});
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
