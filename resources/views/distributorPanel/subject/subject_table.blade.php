@foreach ($subjects as $subject)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $subject->classes->name }}</td>
        <td>{{ $subject->name }}</td>
        <td>
            <button class="btn btn-outline-primary" onclick="editSubmit({{ $subject->id }})" data-toggle="modal"
                data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button class="btn btn-outline-danger" onclick="deleteSubmit({{ $subject->id }})"><i class="fa fa-trash-o"
                    aria-hidden="true"></i></button>
        </td>
    </tr>
@endforeach
