createSell{{-- resources/views/partials/book_storage_table.blade.php --}}
@foreach ($booksInSeller as $bookInSeller)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $bookInSeller->seller->name }}</td>
        {{-- <td>{{ $bokInSeller->class->name }} </td> --}}
        {{-- <td>{{ $bookInSeller->subject->name }}</td> --}}
        {{-- <td>
            <div class="badge badge-info">{{ $bookInSeller->total_unit }}</div>
        </td> --}}
        <td>{{ $bookInSeller->paid_amount }}</td>
        <td>{{ $bookInSeller->unpaid_amount }}</td>
        <td>
            <a href="{{ route('admin.sell.invoice', ['id' => $bookInSeller->id]) }}" class="btn btn-outline-success">
                <i class="fa fa-print" aria-hidden="true"></i>
            </a>
            <button class="btn btn-outline-primary" onclick="editUser({{ $bookInSeller->id }})" data-toggle="modal"
                data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button class="btn btn-outline-danger" onclick="deleteUser({{ $bookInSeller->id }})"><i
                    class="fa fa-trash-o" aria-hidden="true"></i></button>
        </td>
    </tr>
@endforeach
