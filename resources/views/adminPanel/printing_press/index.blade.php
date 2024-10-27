@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Printing Press List (প্রিন্টিং প্রেসের তালিকা)</h4>
                        <div class="card-body" style="text-align: right;">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add
                                Printing Press (প্রিন্টিং প্রেস যোগ করুন)</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name (নাম)</th>
                                        <th>Address (ঠিকানা)</th>
                                        <th>Action (অ্যাকশন)</th>
                                    </tr>
                                </thead>
                                <tbody id="printingPressTableBody"></tbody>

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
                    <h5 class="modal-title" id="formModal">Add Printing Press (প্রিন্টিং প্রেস যোগ করুন)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="printingPressForm">
                        <div class="form-group">
                            <label>Name (নাম)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Printing press name" name="name"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address (ঠিকানা)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Printing press address"
                                    name="address" required>
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
                    <h5 class="modal-title" id="editFormModal">Edit Printing Press</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editPrintingPressForm">
                        <input type="hidden" name="id" id="editPressId">
                        <div class="form-group">
                            <label>Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Printing press name" name="name"
                                    id="editPressName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Printing press address"
                                    name="address" id="editPressAddress" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary m-t-15 waves-effect"
                            onclick="submitEditForm()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>











    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        $(document).ready(function() {
            fetchPrintingPresses();
        });


        function submitForm() {
            // Get the form element
            const form = $('#printingPressForm');

            // Send the form data using jQuery AJAX
            $.ajax({
                url: '{{ route('admin.printing.store') }}', // Ensure this is the correct URL
                method: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(data) {
                    toastr.success('Printing press added successfully!');
                    form[0].reset();
                    $('#exampleModal').modal('hide');
                    fetchPrintingPresses()
                },
                error: function(error) {
                    // Handle error
                    console.error('Error:', error);
                }
            });
        }



        function fetchPrintingPresses() {
            $.ajax({
                url: '{{ route('admin.get.printing.press.data') }}', // Update with your API endpoint
                method: 'GET',
                success: function(response) {
                    // Clear existing table rows
                    $('#printingPressTableBody').empty();

                    // Iterate through each printing press in the response and append a row to the table
                    response.forEach(function(printingPress, index) {
                        var row = `
                        <tr>
                            <td scope="row">${index + 1}</td>
                            <td>${printingPress.name}</td>
                            <td>${printingPress.address}</td>
                            <td>

                              <button class="btn btn-outline-primary" onclick="editPrintingPress(${printingPress.id})" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                              <button class="btn btn-outline-danger" onclick="deletePrintingPress(${printingPress.id})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                            </td>

                        </tr>
                    `;
                        $('#printingPressTableBody').append(row);
                    });
                },
                error: function(error) {
                    console.error('Error fetching printing presses:', error);
                }
            });
        }

        // Call the fetchPrintingPresses function when the page loads
        $(document).ready(function() {
            fetchPrintingPresses();
        });


        function editPrintingPress(id) {
            $.ajax({
                url: `{{ url('admin/get/printing/press/edit/data') }}/${id}`,
                method: 'GET',
                success: function(data) {
                    $('#editPressId').val(data.id);
                    $('#editPressName').val(data.name);
                    $('#editPressAddress').val(data.address);
                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.error('Error fetching printing press data:', error);
                }
            });
        }

        function submitEditForm() {
            const form = $('#editPrintingPressForm');
            const id = $('#editPressId').val();

            $.ajax({
                url: `{{ url('admin/printing/press/update/data') }}/${id}`,
                method: 'PUT',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    toastr.success('Printing press updated successfully!');
                    form[0].reset();
                    $('#editModal').modal('hide');
                    fetchPrintingPresses();
                },
                error: function(error) {
                    toastr.error('Error updating printing press.');
                    console.error('Error:', error);
                }
            });
        }

        function deletePrintingPress(id) {
            if (confirm('Are you sure you want to delete this printing press?')) {
                $.ajax({
                    url: `{{ url('admin/printing/press/delete') }}/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.error('Printing press deleted successfully!');
                        fetchPrintingPresses();
                    },
                    error: function(error) {
                        toastr.error('Error deleting printing press.');
                        console.error('Error deleting printing press:', error);
                    }
                });
            }
        }
    </script>
@endsection
