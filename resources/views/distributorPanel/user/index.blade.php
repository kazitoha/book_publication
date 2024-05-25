@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total User List</h4>
                        <div class="card-body" style="text-align: right;">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add
                                User</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody"></tbody>

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
                    <h5 class="modal-title" id="formModal">Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="form-group">
                            <label>Role</label>
                            <div class="input-group">
                                <select class="form-control" name="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter email" name="email"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Enter password" name="password"
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
                    <h5 class="modal-title" id="editFormModal">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        <input type="hidden" name="id" id="editUserId">

                        <div class="form-group">
                            <label>Role</label>
                            <div class="input-group">
                                <select class="form-control" name="role_id" id="editRoleId">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter name" name="name"
                                    id="editUserName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter email" name="email"
                                    id="editUserEmail" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Enter password" name="password"
                                    id="editUserPassword" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary m-t-15 waves-effect"
                            onclick="updateUser()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function fetchBookStorageData() {
            $.ajax({
                url: '{{ route('admin.get.user.data') }}',
                method: 'GET',
                success: function(response) {
                    $('#userTableBody').html(response.html);
                },
                error: function(error) {
                    console.error('Error fetching book storage data:', error);
                }
            });
        }

        function submitForm() {
            const form = $('#userForm');
            $.ajax({
                url: '{{ route('admin.user.store') }}',
                method: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('User Create successfully!');
                    form[0].reset();
                    $('#exampleModal').modal('hide');
                    fetchBookStorageData();
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
                        toastr.error('Error creating user.');
                        console.error('Error:', xhr);
                    }
                }
            });
        }

        function editUser(id) {
            $.ajax({
                url: `{{ url('admin/get/user/edit/data') }}/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#editUserId').val(data.id);
                    $('#editRoleId').val(data.role_id);
                    $('#editUserName').val(data.name);
                    $('#editUserEmail').val(data.email);

                    // Ensure the correct printing press is selected
                    $('#editRoleId').val(data.role_id).trigger('change');

                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching printing press data:', error);
                }
            });
        }

        function updateUser() {

            const form = $('#editUserForm');
            const id = $('#editUserId').val();

            $.ajax({
                url: `{{ url('admin/user/update/data') }}/${id}`,
                method: 'PUT',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('User info updated successfully!');
                    form[0].reset();
                    $('#editModal').modal('hide');
                    fetchBookStorageData();
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
                        toastr.error('Error creating user.');
                        console.error('Error:', xhr);
                    }
                }
            });
        }



        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this User?')) {
                $.ajax({
                    url: `{{ url('admin/user/delete') }}/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.error('User deleted successfully!');
                        fetchBookStorageData();
                    },
                    error: function(error) {
                        toastr.error('Error deleting.');
                        console.error('Error:', error);
                    }
                });
            }
        }

        $(document).ready(function() {
            fetchBookStorageData();
        });
    </script>
@endsection
