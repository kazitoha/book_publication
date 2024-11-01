@php
    $previousPrintingPressId = null; // Track the previous printing press ID
    $batchSerial = 1; // Initialize batch serial counter
@endphp

@foreach ($bookStorages as $batch => $batchGroup)
    @foreach ($batchGroup as $index => $batchInfo)
        <tr class="{{ $loop->parent->odd ? 'table-secondary' : 'table-light' }} ">
            <!-- Display batch serial number -->

            <!-- Display printing press name only for the first entry of the batch -->
            @if ($index === 0)
                <td rowspan="{{ count($batchGroup) }}">{{ $batchSerial }}</td> <!-- Displaying batch serial -->
                <td rowspan="{{ count($batchGroup) }}">
                    {{ findPrintingPressInfo($batchInfo->printing_press_id)->name }}
                    <br>
                    {{ $batchInfo->created_at->format('Y-m-d h:i A') }}
                </td>
            @endif

            <td style="padding: 10px; border: 1px solid #dddddd;">
                {{ findClassInformartion($batchInfo->class_id)->name }}
            </td>
            <td style="padding: 10px; border: 1px solid #dddddd;">
                {{ findSubjectInformartion($batchInfo->subject_id)->name }}
            </td>
            <td style="padding: 10px; border: 1px solid #dddddd;">
                {{ $batchInfo->total_unit }}
            </td>
            @if ($index === 0)
                <td rowspan="{{ count($batchGroup) }}">
                    {{ sumTotalUnitByBatchId($batchInfo->batch) }}
                </td>
                <td rowspan="{{ count($batchGroup) }}">
                    {{ $batchInfo->paid_amount }}
                </td>
                <td rowspan="{{ count($batchGroup) }}">
                    {{ $batchInfo->unpaid_amount }}
                </td>
                <td rowspan="{{ count($batchGroup) }}">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="{{ url('admin/book/storage/invoice/' . $batchInfo->batch) }}"
                            class="btn btn-outline-primary">
                            <i class="fa fa-print" aria-hidden="true"></i>
                        </a>
                    </div>
                </td>
            @endif
        </tr>
    @endforeach
    @php
        $batchSerial++; // Increment the batch serial counter after processing each batch group
    @endphp
@endforeach
