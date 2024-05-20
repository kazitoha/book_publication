
@foreach($classes as $class)
<tr>
    {{-- {{dd($bookStorage)}} --}}
    <td>{{ $loop->iteration }}</td>
    <td>{{ $class->name }}</td>
    <td>
        <button class="btn btn-outline-primary" onclick="editSubmit({{ $class->id }})" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
        <button class="btn btn-outline-danger" onclick="deleteSubmit({{ $class->id }})"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
    </td>
</tr>

@endforeach

