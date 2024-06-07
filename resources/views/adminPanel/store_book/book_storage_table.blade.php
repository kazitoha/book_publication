{{-- resources/views/partials/book_storage_table.blade.php --}}
@foreach($bookStorages as $bookStorage)
<tr>
    {{-- {{dd($bookStorage)}} --}}
    <td>{{ $loop->iteration }}</td>
    <td>{{ $bookStorage->printingPress->name }}</td>
    <td>{{ $bookStorage->classes->name }}</td>
    <td>{{ $bookStorage->subject->name }}</td>
    <td><div class="badge badge-success">{{ $bookStorage->total_unit }}</div></td>
    <td>{{ $bookStorage->paid_amount }}</td>
    <td>{{ $bookStorage->unpaid_amount }}</td>
    <td>
        <a href="{{ url('admin/book/storage/invoice') }}/{{$bookStorage->id}}" class="btn btn-outline-success">
            <i class="fa fa-print" aria-hidden="true"></i>
         </a>
        <button class="btn btn-outline-primary" onclick="editBookStorage({{ $bookStorage->id }})" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
        <button class="btn btn-outline-danger" onclick="deleteBookStorage({{ $bookStorage->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
    </td>
</tr>

@endforeach

