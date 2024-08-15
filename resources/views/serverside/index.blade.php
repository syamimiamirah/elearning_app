@extends('layouts.app')

@section('content')
<div class="container p-10">
    <div class="mx-auto sm:px-6 lg:px-8">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight mb-6">List of Students</h1>
        <section class="bg-white p-6 rounded-lg shadow-md pb-10">
            <a href="javascript:void(0)" class="btn btn-primary mb-3" onClick="add()">Add Student</a>
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

<div class="modal fade" id="student-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="StudentModal"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="StudentForm" name="StudentForm" class="form-horizontal" method="POST">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" id="id" name="id">
                    <div class="form-group mb-4">
                        <label for="name" class="col-sm-2 control-label">Student Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control rounded-md border-gray-300" id="name" name="name" placeholder="e.g. Nur Aisyah" required="">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="matric_no">Matric No</label>
                                <input type="text" class="form-control rounded-md border-gray-300" id="matric_no" name="matric_no" placeholder="e.g. A20EC0226" value="{{ old('matric_no')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control rounded-md border-gray-300" id="dob" name="dob" value="{{ old('dob')}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-12">
                            <textarea class="form-control rounded-md border-gray-300" id="address" name="address" placeholder="e.g. 123 Main St" required=""></textarea>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="faculty">Faculty</label>
                            <select class="form-control" id="faculty" name="faculty" value="{{ old('faculty')}}">
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
                                <input type="text" class="form-control rounded-md border-gray-300" id="phone_no" name="phone" placeholder="e.g. 0123456789" value="{{ old('phone')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success" id="btn-save">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'name', name: 'name' },
            { data: 'matric_no', name: 'matric_no' },
            { data: 'dob', name: 'dob' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },
            { data: 'faculty', name: 'faculty' },
            {
            data: 'id',
            name: 'action',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
                return `
                    <div style="display: flex; gap: 5px;">
                    <a href="javascript:void(0)" data-id="${data}" class="btn btn-warning editBtn">Edit</a>
                    <a href="javascript:void(0)" data-id="${data}" class="btn btn-danger deleteBtn">Delete</a>
                    </div>
                `;
            }
        }
        ],
        pageLength: 10
    });

    // $('#StudentForm').submit(function(e) {
    //     e.preventDefault();
    //     var formData = new FormData(this);
    //     var student_id = $('#id').val();
    //     var url =  "{{ route('serverside.store') }}";
    //     var method = 'POST';

    //     $.ajax({
    //         type: method,
    //         url: url,
    //         data: formData,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         success: (data) => {
    //             $("#student-modal").modal('hide');
    //             var oTable = $('#students-table').DataTable();
    //             oTable.ajax.reload();
    //             alert(data.success);
    //         },
    //         error: function(data) {
    //             console.log('Error:', data);
    //             alert('An error occurred while saving the student. Please try again.');
    //         }
    //     });
    // });


    $('#StudentForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        var student_id = $('#id').val();
        var url = student_id 
            ? "{{ route('serverside.update', ':id') }}".replace(':id', student_id) 
            : "{{ route('serverside.store') }}";
        
        var method = student_id ? 'POST' : 'POST';

        if (student_id) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            type: method,
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $("#student-modal").modal('hide');
                var oTable = $('#students-table').DataTable();
                oTable.ajax.reload();
                alert(data.success);
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                alert('An error occurred while saving the student. Please try again.');
            }
        });
    });




    
    $('body').on('click', '.editBtn', function() {
        var student_id = $(this).data('id');
        $.ajax({
            url: 'serverside/' + student_id + '/edit',
            type: 'GET',
            success: function(data) { // Inspect the data in the console
                if (data.error) {
                    alert(data.error);
                } else {
                    $('#StudentModal').html("Edit Student");
                    $('#student-modal').modal('show');
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#matric_no').val(data.matric_no);
                    $('#dob').val(data.dob);
                    $('#address').val(data.address);
                    $('#phone_no').val(data.phone);
                    $('#faculty').val(data.faculty);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching student data:', status, error);
            }
        });
    });


});

$(document).on('click', '.deleteBtn', function() {
    var student_id = $(this).data('id');
    if (confirm("Are you sure you want to delete this student?")) {
        $.ajax({
            type: 'DELETE',
            url: "{{ route('serverside.destroy', ':id') }}".replace(':id', student_id),
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                var oTable = $('#students-table').DataTable();
                oTable.ajax.reload();
                alert(data.success);
            },
            error: function(xhr, status, error) {
                console.log('Error:', xhr.responseText);
                alert('An error occurred while deleting the student. Please try again.');
            }
        });
    }
});


    // Define the add function outside of the $(document).ready() block to make it accessible globally.
    function add() {
        $('#StudentForm').trigger("reset");
        $('#StudentModal').html("Add Student");
        $('#student-modal').modal('show');
        $('#id').val('');
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
