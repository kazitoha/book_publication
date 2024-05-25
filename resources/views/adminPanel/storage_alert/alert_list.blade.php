
@foreach($lowStockAlert as $lowStock)
<tr>
    {{-- {{dd($bookStorage)}} --}}
    <td>{{ $loop->iteration }}</td>
    <td>{{ $lowStock->classes->name }}</td>
    <td>{{ $lowStock->name }}</td>
    <td>{{ $lowStock->total_unit }}</td>
</tr>

@endforeach

