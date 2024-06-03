@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sell Book</h4>
                        </div>
                        <form id="sellForm">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12 mb-3">
                                        <label>Select a seller</label>
                                        <select class="form-control" id="selectSeller" name="sellerID">
                                            <option value="" selected disabled>Select a seller</option>
                                            @foreach ($sellers as $seller)
                                                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                            @endforeach
                                        </select>
                                        <span>Total Unpaid: <b id="sellerUnpaidAmount"></b></span>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label>Class</label>
                                        <select class="form-control" id="classSelect" name="classID">
                                            <option value="" selected disabled>Select a class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>


                                    </div>


                                    <div class="col-md-4 mb-3" id="subjectGroup" style="display: none;">
                                        <label>Subject</label>
                                        <div class="input-group">
                                            <select class="form-control" id="subjectSelect" name="subjectID">
                                                <option value="">Select a subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span>Per Unit Cost:<b id="perUnitCost"></b></span>
                                        <input type="hidden" name="purchase_price" id="preUnitPrice">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Unit Price</label>
                                        <input type="text" class="form-control" name="unit_price" id="unitPrice"
                                            onkeyup="totalUnitPrice()" placeholder="Enter per unit price" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Total Unit</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="total_unit" id="totalAmount"
                                                onkeyup="totalUnitPrice()" placeholder="Enter total unit" required>
                                        </div>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Paid Amount</label>
                                        <input type="text" class="form-control" id="paid" name="paid_amount"
                                            onkeyup="totalUnitPrice()" placeholder="Total paid amount" required>
                                        <span>Total ammount: <b id="total"></b></span>

                                        <input type="hidden" class="form-control" id="unpaid" name="unpaid_amount"
                                            placeholder="Un-paid amount" required>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <button type="button" onclick="submitForm()" class="btn btn-primary">Sell It</button>
                            </div>
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </section>




    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total Book Storage List</h4>
                        <div class="card-body" style="text-align: right;">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Press name</th>
                                        <th>Class</th>
                                        <th>Subject name</th>
                                        <th>Total unit</th>
                                        <th>Paid amount</th>
                                        <th>Unpaid amount</th>
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
                                <select class="form-control" id="printingPressSelect" name="printingPressID">
                                    @foreach ($printingPress as $Press)
                                        <option value="{{ $Press->id }}">{{ $Press->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Class</label>
                            <div class="input-group">
                                <select class="form-control" id="editclassSelect" name="classID">
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <div class="input-group">
                                <select class="form-control" id="editSubjectSelect" name="subjectID">
                                    <option value="" disabled>Select a subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Total Book</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="editTotalBook"
                                    placeholder="Enter total book" name="total_book" required>
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
        $(document).ready(function() {
            fetchBookStorageData();
            $('#sellForm')[0].reset();
            $('#subjectGroup').hide();

            $('#classSelect').on('change', function() {
                const classId = $(this).val();
                if (classId) {
                    $('#subjectGroup').show();
                    fetchSubjectsByClass(classId, '#subjectSelect');
                } else {
                    $('#subjectGroup').hide();
                    $('#subjectSelect').val(''); // Reset subject dropdown
                }
            });

            $('#editclassSelect').on('change', function() {
                const classId = $(this).val();
                if (classId) {
                    fetchSubjectsByClass(classId, '#editSubjectSelect');
                }
            });
        });

        function fetchSubjectsByClass(classId, selectElementId) {
            $.ajax({
                url: `{{ url('admin/get/subjects') }}/${classId}`,
                method: 'GET',
                success: function(subjects) {
                    let options = '<option value="">Select a subject</option>';
                    subjects.forEach(subject => {
                        options += `<option value="${subject.id}">${subject.name}</option>`;
                    });
                    $(selectElementId).html(options);
                },
                error: function(error) {
                    console.error('Error fetching subjects:', error);
                }
            });
        }

        function totalUnitPrice() {
            var totalAmount = $('#totalAmount').val();
            var unitPrice = $('#unitPrice').val();

            var total = totalAmount * unitPrice;
            $('#total').text(total);

            var paid = $('#paid').val();
            var unpaid = total - paid;

            $('#unpaid').val(unpaid);
        }

        function fetchBookStorageData() {
            $.ajax({
                url: '{{ route('admin.get.sell.data') }}',
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
            const form = $('#sellForm');
            $.ajax({
                url: '{{ route('admin.sell.store') }}',
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

        function editBookStorage(id) {
            $.ajax({
                url: `{{ url('admin/get/book/storage/edit/data') }}/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#editStorageId').val(data.id);
                    $('#printingPressSelect').val(data.printing_press_id);
                    $('#editclassSelect').val(data.class_id);
                    $('#editSubjectSelect').val(data.subject_id);
                    $('#editTotalBook').val(data.total_book);

                    $('#printingPressSelect').val(data.printing_press_id).trigger('change');
                    $('#editclassSelect').val(data.class_id).trigger('change');
                    $('#editSubjectSelect').val(data.subject_id).trigger('change');
                    $('#editTotalBook').val(data.total_book).trigger('change');

                    // Show the modal
                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching book storage data:', error);
                }
            });
        }

        function editSubmitBook() {
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

        //fetch seller
        $('#selectSeller').change(function() {
            const sellerId = $(this).val();
            $.ajax({
                url: `{{ url('admin/get/seller') }}/${sellerId}`,
                method: 'GET',
                success: function(data) {
                    $('#sellerUnpaidAmount').text(data.unpaid_amount);
                },
                error: function(error) {
                    console.error('Error fetching subjects:', error);
                }
            });
        });

        $('#subjectSelect').change(function() {
            const unitPrice = $(this).val();
            $.ajax({
                url: `{{ url('admin/get/unit/price') }}/${unitPrice}`,
                method: 'GET',
                success: function(data) {
                    $('#perUnitCost').text(data.unit_price);
                    $('#preUnitPrice').val(data.unit_price);
                },
                error: function(error) {
                    console.error('Error fetching subjects:', error);
                }
            });
        });
    </script>
@endsection
