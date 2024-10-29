@foreach ($bookStorages as $bookStorage)
    <tr class="{{ $loop->odd ? 'table-secondary' : 'table-light' }}">
        <td>{{ $loop->iteration }}</td>
        <td>{{ optional($bookStorage->printingPress)->name ?? 'N/A' }}</td>

        <!-- Display class -->
        <td>
            @if (!empty($bookStorage->classsNames))
                @foreach ($bookStorage->classsNames as $class)
                    <span style="padding: 1px">{{ $class }}</span><br>
                @endforeach
            @else
                N/A
            @endif
        </td>

        <!-- Display subjects -->
        <td>
            @if (!empty($bookStorage->subjectNames))
                @foreach ($bookStorage->subjectNames as $subject)
                    <span style="padding: 1px">{{ $subject }}</span><br>
                @endforeach
            @else
                N/A
            @endif
        </td>

        <!-- Display total units with alternating badge colors based on main loop iteration -->
        <td>
            @if (!empty($bookStorage->totalUnits))
                <div class="d-flex flex-column">
                    @php
                        $total_book = 0;
                    @endphp
                    @foreach ($bookStorage->totalUnits as $unit)
                        <span class="{{ $loop->parent->odd ? 'badge badge-success' : 'badge badge-info' }} my-1"
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
            {{ $total_book }}
        </td>

        <td>{{ $bookStorage->paid_amount }}</td>
        <td>{{ $bookStorage->unpaid_amount ?? 'N/A' }}</td>

        <td>
            <a href="{{ url('admin/book/storage/invoice/' . $bookStorage->id) }}" class="btn btn-outline-success">
                <i class="fa fa-print" aria-hidden="true"></i>
            </a>
            <button class="btn btn-outline-primary" onclick="editBookStorage({{ $bookStorage->id }})"
                data-toggle="modal" data-target="#editModal">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            </button>
            <button class="btn btn-outline-danger" onclick="deleteBookStorage({{ $bookStorage->id }})">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
            </button>
        </td>
    </tr>
@endforeach
