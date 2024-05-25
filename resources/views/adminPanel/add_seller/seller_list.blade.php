@foreach ($users as $user)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <div class="badge @if ($user->roles->name == 'Admin') badge-success @else badge-info @endif">
                {{ $user->roles->name }}</div>
        </td>
        <td>
            <button class="btn btn-outline-primary" onclick="sellerEdit({{ $user->id }})" data-toggle="modal"
                data-target="#editModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
            <button class="btn btn-outline-danger" onclick="deleteSeller({{ $user->id }})"><i class="fa fa-trash-o"
                    aria-hidden="true"></i></button>
        </td>
    </tr>
@endforeach
