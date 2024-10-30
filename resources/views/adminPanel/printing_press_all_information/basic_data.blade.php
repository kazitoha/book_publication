@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section>
        <div class="card" id="sample-login">
            <form action="{{ route('admin.printing.press.filter.information') }}" method="POST">
                @csrf
                <div class="card-header">
                    <h4>Search Info</h4>
                </div>

                <div class="card-body pb-0">
                    <div class="form-row">
                        <!-- Email Input -->
                        <div class="form-group col-md-4">
                            <label for="printingPressSelect">Select Printing Press</label>
                            <select class="form-control form-select" id="printingPressSelect" name="printing_press_id">
                                <option selected disabled>Open this select menu</option>
                                @foreach ($all_printing_press as $printing_press)
                                    <option value="{{ $printing_press->id }}"
                                        {{ old('printing_press_id') == $printing_press->id ? 'selected' : '' }}>
                                        {{ $printing_press->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('printing_press_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="startDate">Start Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control" id="startDate" value="{{ old('start_date') }}"
                                    name="start_date">
                            </div>
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="endDate">End Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control" id="endDate" value="{{ old('end_date') }}"
                                    name="end_date">
                            </div>
                            @error('end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="card-footer pt-0">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Filter Data</h4>
                        <div class="d-flex align-items-center">
                            <!-- Print and PDF buttons -->
                            <div class="me-3">
                                <button class="btn btn-success"><i class="fas fa-file-pdf"></i> PDF</button>
                                <button class="btn btn-info me-2"><i class="fas fa-print"></i> Print</button>
                            </div>

                            <!-- Search form -->
                            <form class="d-flex ms-3">
                                <input type="text" class="form-control me-2" placeholder="Search...">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Press Name</th>
                                        <th>Total Books</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($bookStorages) && $bookStorages->isNotEmpty())
                                        @foreach ($bookStorages as $bookStorage)
                                            <tr>
                                                <td>{{ optional($bookStorage->printingPress)->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if (!empty($bookStorage->totalUnits))
                                                        {{ array_sum($bookStorage->totalUnits) }}
                                                        <!-- Assuming totalUnits is an array -->
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>{{ $bookStorage->created_at->format('Y-m-d') ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ url('admin/printing/press/infomation/' . $bookStorage->id . '/' . $start_date . '/' . $end_date) }}"
                                                        class="btn btn-outline-primary btn-sm">Detail</a>
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No data available for the selected
                                                filter.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>
@endsection
