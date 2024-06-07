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
                                <div class="form-row" id="inputRow_1">
                                    <div class="col-md-12 mb-3">
                                        <label>Select a seller</label>
                                        <select class="form-control" onchange="fetchSellerUnpaidAmount($(this).val())"
                                            name="sellerID">
                                            <option value="" selected disabled>Select a seller</option>
                                            @foreach ($sellers as $seller)
                                                <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                            @endforeach
                                        </select>
                                        <span>Total Unpaid: <b id="sellerUnpaidAmount"></b></span>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label>Class</label>
                                        <select class="form-control" id="classSelect_1" name="classID[]"
                                            onchange="fetchSubjectsByClass(1)">
                                            <option value="" selected disabled>Select a class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Subject</label>
                                        <div class="input-group">
                                            <select class="form-control" id="subjectSelect_1" name="subjectID[]"
                                                onchange="fetchUnitPrice($(this).val(),1)">
                                                <option value="">Select a subject</option>
                                            </select>
                                        </div>
                                        <span>Per Unit Cost:<b id="perUnitCost_1"></b></span>
                                        <input type="hidden" name="purchase_price" id="perUnitPrice_1">
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Unit Price</label>
                                        <input type="text" class="form-control" name="unit_price[]" id="unitPrice_1"
                                            onkeyup="updateTotalAmount()" placeholder="Enter per unit price" required>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label>Total Unit</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="total_unit[]" id="totalUnit_1"
                                                onkeyup="updateTotalAmount()" placeholder="Enter total unit" required>
                                        </div>
                                    </div>

                                    <div class="col-md-1 mb-3 mt-2">
                                        <label></label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-primary"
                                                onclick="addInputField()"><i class="fa fa-plus"
                                                    aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div id="inputField">
                                    <!-- New input fields will be added here -->
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Paid Amount</label>
                                        <input type="text" class="form-control" id="paid" name="paid_amount"
                                            onkeyup="updateTotalAmount()" placeholder="Total paid amount" required>
                                        <span>Total amount: <b id="totalAmount">0.00</b></span>
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
                                        {{-- <th>Class</th>
                                        <th>Subject name</th> --}}
                                        {{-- <th>Total unit</th> --}}
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        let inputFieldCounter = 2;
        $(document).ready(function() {
            $('#sellForm')[0].reset();
            fetchBookStorageData();
        });



        function addInputField() {
            const inputFieldHTML = `
            <div class="form-row" id="inputRow_${inputFieldCounter}">
                <div class="col-md-2 mb-3">
                    <label>Class</label>
                    <select class="form-control" id="classSelect_${inputFieldCounter}" name="classID[]" onchange="fetchSubjectsByClass(${inputFieldCounter})">
                        <option value="" selected disabled>Select a class</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Subject</label>
                    <div class="input-group">
                        <select class="form-control" id="subjectSelect_${inputFieldCounter}" name="subjectID[]" onchange="fetchUnitPrice($(this).val(),${inputFieldCounter})">
                            <option value="">Select a subject</option>
                        </select>
                    </div>
                    <span>Per Unit Cost:<b id="perUnitCost_${inputFieldCounter}"></b></span>
                    <input type="hidden" name="purchase_price[]" id="perUnitPrice_${inputFieldCounter}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Unit Price</label>
                    <input type="text" class="form-control" name="unit_price[]" id="unitPrice_${inputFieldCounter}"
                        onkeyup="updateTotalAmount()" placeholder="Enter per unit price" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Total Unit</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="total_unit[]" id="totalUnit_${inputFieldCounter}"
                            onkeyup="updateTotalAmount()" placeholder="Enter total unit" required>
                    </div>
                </div>
                <div class="col-md-1 mb-3 mt-2">
                    <label></label>
                    <div class="input-group">
                        <button type="button" class="btn btn-outline-danger" onclick="removeInputField(${inputFieldCounter})"><i class="fa fa-minus" aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>`;
            $('#inputField').append(inputFieldHTML);
            inputFieldCounter++;
        }

        function removeInputField(counter) {
            $(`#inputRow_${counter}`).remove();
            updateTotalAmount();
        }

        function updateTotalAmount() {
            let total = 0;
            for (let i = 1; i < inputFieldCounter; i++) {
                const unitPrice = parseFloat($(`#unitPrice_${i}`).val()) || 0;
                const totalUnit = parseFloat($(`#totalUnit_${i}`).val()) || 0;
                total += unitPrice * totalUnit;
            }
            $('#totalAmount').text(total.toFixed(2));

            const paid = parseFloat($('#paid').val()) || 0;
            const unpaid = total - paid;
            $('#unpaid').val(unpaid.toFixed(2));
        }

        function fetchSubjectsByClass(counter) {
            const classId = $(`#classSelect_${counter}`).val();
            if (classId) {
                $.ajax({
                    url: `{{ url('admin/get/subjects') }}/${classId}`,
                    method: 'GET',
                    success: function(subjects) {
                        let options = '<option value="">Select a subject</option>';
                        subjects.forEach(subject => {
                            options += `<option value="${subject.id}">${subject.name}</option>`;
                        });
                        $(`#subjectSelect_${counter}`).html(options);
                    },
                    error: function(error) {
                        console.error('Error fetching subjects:', error);
                    }
                });
            } else {
                $(`#subjectSelect_${counter}`).html('<option value="">Select a subject</option>');
            }
        }

        function fetchUnitPrice(subjectId, counter) {
            $.ajax({
                url: `{{ url('admin/get/unit/price') }}/${subjectId}`,
                method: 'GET',
                success: function(data) {
                    $(`#perUnitCost_${counter}`).text(data.unit_price);
                    $(`#perUnitPrice_${counter}`).val(data.unit_price);
                },
                error: function(error) {
                    console.error('Error fetching subjects:', error);
                }
            });
        }

        function fetchSellerUnpaidAmount(sellerId) {
            $.ajax({
                url: `{{ url('admin/get/seller') }}/${sellerId}`,
                method: 'GET',
                success: function(data) {
                    $('#sellerUnpaidAmount').text(data.unpaid_amount);
                },
                error: function(error) {
                    console.error('Error fetching seller unpaid amount:', error);
                }
            });
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
                    $('#sellForm')[0].reset();
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
    </script>
@endsection
