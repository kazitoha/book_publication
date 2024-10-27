@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total Seller List (মোট বিক্রেতার তালিকা)</h4>
                        <div class="card-body" style="text-align: right;">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add
                                Seller (বিক্রেতা যোগ করুন)</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name (নাম)</th>
                                        <th>Email (ইমেইল)</th>
                                        <th>User Role (ব্যবহারকারীর ভূমিকা)</th>
                                        <th>Action (অ্যাকশন)</th>
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
                    <h5 class="modal-title" id="formModal">Add Seller (বিক্রেতা যোগ করুন)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Name (নাম)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone (ফোন)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter phone number" name="phone"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address (ঠিকানা)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter address" name="address"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Image (ছবি)</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="image">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email (ইমেইল)</label>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter email" name="email"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password (পাসওয়ার্ড)</label>
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
                    <h5 class="modal-title" id="editFormModal">Edit User (ব্যবহারকারী সম্পাদনা করুন)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group">
                            <label>Name (নাম)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter name" name="name"
                                    id="editUserName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone (ফোন)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter phone" name="phone"
                                    id="editUserPhone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address (ঠিকানা)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter address" name="address"
                                    id="editUserAddress" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>image (ইমেজ)</label>
                            <div class="input-group">
                                <input type="file" class="form-control" placeholder="Enter name" name="image"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email (ইমেইল)</label>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter email" name="email"
                                    id="editUserEmail" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password (পাসওয়ার্ড)</label>
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
                url: '{{ route('admin.get.seller.data') }}',
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
            const form = $('#userForm')[0]; // Get the form element
            const formData = new FormData(form); // Create a FormData object

            $.ajax({
                url: '{{ route('admin.selller.store') }}',
                method: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from setting Content-Type header
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('User created successfully!');
                    form.reset();
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


        function sellerEdit(id) {
            $.ajax({
                url: `{{ url('admin/get/seller/edit/data') }}/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#editUserId').val(data.id);
                    $('#editUserName').val(data.name);
                    $('#editUserPhone').val(data.phone);
                    $('#editUserAddress').val(data.address);
                    $('#editUserEmail').val(data.email);
                    s
                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching printing press data:', error);
                }
            });
        }

        function updateUser() {
            const form = $('#editUserForm')[0]; // Get the form element
            const id = $('#editUserId').val();
            const formData = new FormData(form); // Create a FormData object

            $.ajax({
                url: `{{ url('admin/seller/update/data') }}/${id}`,
                method: 'POST', // Use POST for file uploads
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from setting Content-Type header
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-HTTP-Method-Override': 'PUT' // To simulate PUT method
                },
                success: function(data) {
                    toastr.success('User info updated successfully!');
                    form.reset();
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
                        toastr.error('Error updating user.');
                        console.error('Error:', xhr);
                    }
                }
            });
        }




        function deleteSeller(id) {
            if (confirm('Are you sure you want to delete this User?')) {
                $.ajax({
                    url: `{{ url('admin/seller/delete') }}/${id}`,
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
