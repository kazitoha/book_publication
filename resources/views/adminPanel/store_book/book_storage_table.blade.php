@foreach ($bookStorages as $storage)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $storage->batch }}</td>
        <td>{{ $storage->class_ids }}</td>
        <td>{{ $storage->subject_ids }}</td>
        <td>{{ $storage->total_records }}</td>
        <td>{{ $storage->total_price }}</td>
    </tr>
@endforeach
