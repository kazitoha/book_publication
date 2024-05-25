@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Low Storage Alert</h4><br>
                        <span class="text-danger">( The products are shown in this list which quantity is below 10 )</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Total Unit</th>
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







    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            fetchData();
        });

        function fetchData() {
            $.ajax({
                url: '{{ route('admin.storage.data') }}',
                method: 'GET',
                success: function(response) {
                    $('#TableBody').html(response.html);
                },
                error: function(error) {
                    console.error('Error fetching class data:', error);
                }
            });
        }


    </script>
@endsection
