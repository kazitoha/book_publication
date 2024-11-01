<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if ($print_type == 'single')
            Single
        @elseif($print_type == 'multiple')
            Multiple
        @endif
        | Invoice
    </title>
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border: 2px solid #1b3a57;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background: #ffffff;
        }

        .title {
            font-size: 25px;
            color: #1b3a57;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .header,
        .totals-table td {
            color: #2a5d94;
            font-weight: bold;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #2a5d94;
            text-align: center;
        }

        .heading th {
            background: #2a5d94;
            color: white;
        }

        /* Button Styling */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px auto;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            color: #fff;
        }

        .pdf-button {
            background-color: #2a5d94;
        }

        .pdf-button:hover,
        .print-button:hover {
            background-color: #1b3a57;
        }

        /* Print Styling */
        @media print {

            .button-container,
            .pdf-button {
                display: none;
            }

            .invoice-box {
                padding: 0;
                border: none;
                box-shadow: none;
                font-size: 10px;
            }

            th,
            td {
                padding: 2px;
                border: 1px solid #2a5d94;
            }
        }
    </style>
</head>

<body>
    <div class="button-container">
        <button id="generate-pdf" class="pdf-button">Download PDF</button>
        <button onclick="window.print()" class="print-button">Print Invoice</button>
    </div>
    <div class="invoice-box">
        <div class="title">নূরানী তা’লীমুল কুরআন বোর্ড বাংলাদেশ</div>
        <div class="header">তৈরি হয়েছে: {{ now()->format('Y-m-d h:i A') }}</div>

        <table>
            <tbody>
                @if ($print_type == 'single')
                    <tr>
                        <td>Printing Press Name:
                            <strong>{{ $details_about_printing_press[0]->printingPress->name ?? 'N/A' }}</strong>
                        </td>
                        <td>Address:
                            <strong>{{ $details_about_printing_press[0]->printingPress->address ?? 'N/A' }}</strong>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>Filter Start Date: <strong>{{ $start_date }}</strong></td>
                    <td>Filter End Date: <strong>{{ $end_date }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 30px;">
            <table>
                <thead>
                    <tr class="heading">
                        <th>Press Name</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Total Books</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details_about_printing_press as $storage_details)
                        <tr>
                            <td>{{ optional($storage_details->printingPress)->name ?? 'N/A' }}</td>
                            <td>
                                @foreach (decodeJsonData($storage_details->class_id) as $classId)
                                    {{ findClassInformartion($classId)->name }} <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach (decodeJsonData($storage_details->subject_id) as $index => $subjectId)
                                    {{ findSubjectInformartion($subjectId)->name }} :
                                    {{ $storage_details->totalUnits[$index] ?? 0 }} <br>
                                @endforeach
                            </td>
                            <td>{{ array_sum($storage_details->totalUnits) ?? 0 }}</td>
                            <td>{{ $storage_details->created_at->format('d-M-Y h:i A') ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('generate-pdf').addEventListener('click', function() {
            var invoiceElement = document.querySelector('.invoice-box');
            var opt = {
                margin: 1,
                filename: 'invoice_' + {{ $details_about_printing_press[0]->id ?? 0 }} + '.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in',
                    format: 'letter',
                    orientation: 'portrait'
                }
            };
            html2pdf().from(invoiceElement).set(opt).save();
        });
    </script>
</body>

</html>
