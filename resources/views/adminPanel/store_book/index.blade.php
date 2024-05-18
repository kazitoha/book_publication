@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total Book Storage List</h4>
                        <div class="card-body" style="text-align: right;">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal">Storage Book</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Press name</th>
                                        <th>Subject name</th>
                                        <th>Total Book</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="storeBookTableBody"></tbody>

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
                    <h5 class="modal-title" id="formModal">Store Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bookStoreForm">
                        <div class="form-group">
                            <label>Printing Press</label>
                            <div class="input-group">
                                <select class="form-control" id="exampleFormControlSelect1" name="printingPressID">
                                    @foreach ($printingPress as $Press)
                                        <option value="{{ $Press->id }}">{{ $Press->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter subject" name="subject"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Total Book</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Enter total book" name="total_book"
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
                    <h5 class="modal-title" id="editFormModal">Edit Book Storage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editBookStoreForm">
                        <input type="hidden" name="id" id="editStorageId">
                        <div class="form-group">
                            <label>Printing Press</label>
                            <div class="input-group">
                                <select class="form-control" name="printingPressID" id="editPressId">
                                    @foreach ($printingPress as $Press)
                                        <option value="{{ $Press->id }}">{{ $Press->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter subject" name="subject"
                                    id="editSubjectName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Total Book</label>
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="Enter total book" name="total_book"
                                    id="editTotalBook" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary m-t-15 waves-effect"
                            onclick="editSubmitBook()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchBookStorageData() {
            $.ajax({
                url: '{{ route('admin.get.book.storage.data') }}',
                method: 'GET',
                success: function(response) {
                    $('#storeBookTableBody').html(response.html);
                },
                error: function(error) {
                    console.error('Error fetching book storage data:', error);
                }
            });
        }

        function submitForm() {
            const form = $('#bookStoreForm');
            $.ajax({
                url: '{{ route('admin.store.book.store') }}',
                method: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('Book quantity added successfully!');
                    form[0].reset();
                    $('#exampleModal').modal('hide');
                    fetchBookStorageData();
                },
                error: function(error) {
                    toastr.error('Error adding book quantity.');
                    console.error('Error:', error);
                }
            });
        }

        function editBookStorage(id) {
            $.ajax({
                url: `{{ url('admin/get/book/storage/edit/data') }}/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#editStorageId').val(data.id);
                    $('#editPressId').val(data.printing_press_id);
                    $('#editSubjectName').val(data.subject_name);
                    $('#editTotalBook').val(data.total_book);

                    // Ensure the correct printing press is selected
                    $('#editPressId').val(data.printing_press_id).trigger('change');

                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching printing press data:', error);
                }
            });
        }

        function editSubmitBook(){

            const form = $('#editBookStoreForm');
            const id = $('#editStorageId').val();

            $.ajax({
                url: `{{ url('admin/store/book/update/data') }}/${id}`,
                method: 'PUT',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('Printing press updated successfully!');
                    form[0].reset();
                    $('#editModal').modal('hide');
                    fetchBookStorageData();
                },
                error: function(error) {
                    toastr.error('Error updating printing press.');
                    console.error('Error:', error);
                }
            });
        }



        function deleteBookStorage(id) {
            if (confirm('Are you sure you want to delete this book storage?')) {
                $.ajax({
                    url: `{{ url('admin/store/book/delete') }}/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.error('Book storage deleted successfully!');
                        fetchBookStorageData();
                    },
                    error: function(error) {
                        toastr.error('Error deleting book storage.');
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
