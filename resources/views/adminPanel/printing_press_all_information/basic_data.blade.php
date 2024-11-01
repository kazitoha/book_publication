@extends('adminPanel/navbar')

@section('adminpanel-navbar')
    <section>
        <div class="card" id="sample-login">
            <form action="{{ route('admin.printing.press.filter.information') }}" method="POST">
                @csrf
                <div class="card-header">
                    <h4>Search Info</h4>
                </div>

                <input type="hidden" name="print" value="1">


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
                            @if (isset($bookStorages))
                                <form action="{{ route('admin.get.print.press.infomation') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="print_type" value="multiple">
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">

                                    <div class="me-3">
                                        <button class="btn btn-primary me-2"><i class="fas fa-print"></i> Print</button>
                                    </div>
                                </form>
                            @endif
                            @if (isset($bookStorages))
                                <form class="d-flex ms-3" action="{{ route('admin.search.from.filtered.data') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                                    <input type="text" class="form-control me-2" name="search" placeholder="Search...">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </form>
                            @endif

                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Press Name</th>
                                        <th>Class Name</th>
                                        <th>Subject Name</th>
                                        <th>Units</th>
                                        <th>Total Book</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($bookStorages))
                                        @php
                                            $currentPrintingPressId = null;
                                        @endphp
                                        @foreach ($bookStorages as $bookStorage)
                                            @if ($currentPrintingPressId !== $bookStorage->printing_press_id)
                                                @php
                                                    $currentPrintingPressId = $bookStorage->printing_press_id;
                                                @endphp
                                                <tr class="table-light">
                                                    <td colspan="7">
                                                        <strong>{{ $bookStorage->printingPress->name }}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr class="{{ $loop->odd ? 'table-secondary' : 'table-light' }}">
                                                <td></td> <!-- Empty cell for Press Name -->
                                                <td>
                                                    @foreach (decodeJsonData($bookStorage->class_id) as $class)
                                                        <span
                                                            style="padding: 1px">{{ findClassInformartion($class)->name }}</span><br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach (decodeJsonData($bookStorage->subject_id) as $subject)
                                                        <span
                                                            style="padding: 1px">{{ findSubjectInformartion($subject)->name }}</span><br>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if (!empty($bookStorage->total_unit))
                                                        <div class="d-flex flex-column">
                                                            @php $total_book = 0; @endphp
                                                            @foreach (decodeJsonData($bookStorage->total_unit) as $unit)
                                                                <span
                                                                    class="{{ $loop->parent->odd ? 'badge badge-success' : 'badge badge-info' }} my-1"
                                                                    style="padding: 1px">
                                                                    @php
                                                                        echo $unit;
                                                                        $total_book += $unit;
                                                                    @endphp
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ sumJsonData($bookStorage->total_unit) }}
                                                </td>
                                                <td>
                                                    {{ $bookStorage->created_at->format('d-M-Y') }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.get.print.press.infomation') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="print_type" value="single">
                                                        <input type="hidden" name="book_storage_id"
                                                            value="{{ $bookStorage->id }}">
                                                        <input type="hidden" name="printing_press_id"
                                                            value="{{ $bookStorage->printing_press_id }}">
                                                        <input type="hidden" name="start_date"
                                                            value="{{ $start_date }}">
                                                        <input type="hidden" name="end_date"
                                                            value="{{ $end_date }}">

                                                        <div class="card-footer pt-0">
                                                            <button type="submit"
                                                                class="btn btn-outline-{{ $loop->odd ? 'success' : 'info' }}">Details</button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No data available for the selected
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
