{{-- resources/views/partials/book_storage_table.blade.php --}}
@foreach($bookStorages as $bookStorage)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ optional($bookStorage->printingPress)->name ?? 'N/A' }}</td>
    <td>{{ optional($bookStorage->classes)->name ?? 'N/A' }}</td>
    <td>{{ optional($bookStorage->subject)->name ?? 'N/A' }}</td>
    <td>
        <div class="badge badge-success">{{ $bookStorage->total_unit }}</div>
    </td>
    <td>{{ $bookStorage->paid_amount }}</td>
    <td>{{ $bookStorage->unpaid_amount ?? 'N/A' }}</td> <!-- Assuming unpaid_amount is a field in your StoreBook model -->
    <td>
        <a href="{{ url('admin/book/storage/invoice/' . $bookStorage->id) }}" class="btn btn-outline-success">
            <i class="fa fa-print" aria-hidden="true"></i>
        </a>
        <button class="btn btn-outline-primary" onclick="editBookStorage({{ $bookStorage->id }})" data-toggle="modal" data-target="#editModal">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        </button>
        <button class="btn btn-outline-danger" onclick="deleteBookStorage({{ $bookStorage->id }})">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
        </button>
    </td>
</tr>
@endforeach

