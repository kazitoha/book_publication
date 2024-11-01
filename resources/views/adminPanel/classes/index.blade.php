@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total Class List</h4>
                        <div class="card-body" style="text-align: right;">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">Add Class</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead><tr>
                                        <th>#</th>
                                        <th>name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="TableBody"></tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="storeForm">

                        <div class="form-group">
                            <label>Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter class name" name="name"
                                    required>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary m-t-15 waves-effect"
                            onclick="submitForm()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editFormModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFormModal">Edit Classes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" name="id" id="editId">

                        <div class="form-group">
                            <label>Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter class name" name="name"
                                    id="editName" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary m-t-15 waves-effect"
                            onclick="updateSubmit()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchData();
        });

        function fetchData() {
            $.ajax({
                url: '{{ route('admin.get.class.data') }}',
                method: 'GET',
                success: function(response) {
                    $('#TableBody').html(response.html);
                },
                error: function(error) {
                    console.error('Error fetching class data:', error);
                }
            });
        }

        function submitForm() {
            const form = $('#storeForm');
            $.ajax({
                url: '{{ route('admin.class.store') }}',
                method: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('Class added successfully!');
                    form[0].reset();
                    $('#exampleModal').modal('hide');
                    fetchData();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation error
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages += errors[key][0] + '\n';
                            }
                        }
                        toastr.error(errorMessages);
                    } else {
                        // Other errors
                        toastr.error('Error creating.');
                        console.error('Error:', xhr);
                    }
                }
            });
        }

        function editSubmit(id) {
            $.ajax({
                url: `{{ url('admin/get/class/edit/data') }}/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#editId').val(data.id);
                    $('#editName').val(data.name);

                    // Ensure the correct printing press is selected
                    // $('#editPressId').val(data.printing_press_id).trigger('change');

                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching press data:', error);
                }
            });
        }

        function updateSubmit(){

            const form = $('#editForm');
            const id = $('#editId').val();

            $.ajax({
                url: `{{ url('admin/class/update/data') }}/${id}`,
                method: 'PUT',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('Data updated successfully!');
                    form[0].reset();
                    $('#editModal').modal('hide');
                    fetchData();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation error
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (let key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessages += errors[key][0] + '\n';
                            }
                        }
                        toastr.error(errorMessages);
                    } else {
                        // Other errors
                        toastr.error('Error creating.');
                        console.error('Error:', xhr);
                    }
                }
            });
        }



        function deleteSubmit(id) {
            if (confirm('Are you sure ?')) {
                $.ajax({
                    url: `{{ url('admin/class/delete') }}/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.error('Data deleted successfully!');
                        fetchData();
                    },
                    error: function(error) {
                        toastr.error('Error deleting Data.');
                        console.error('Error:', error);
                    }
                });
            }
        }


    </script>
@endsection
