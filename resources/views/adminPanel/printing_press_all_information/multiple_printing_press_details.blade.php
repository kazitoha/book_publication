<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Base styling */
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
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

        .right-align {
            text-align: right;
        }

        .header {
            color: #2a5d94;
            font-weight: bold;
        }

        /* Single border table styling */
        .bordered-table {
            border: 1px solid #2a5d94;
            padding: 10px;
            margin-top: 20px;
        }

        .bordered-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .bordered-table td {
            padding: 10px;
        }

        /* General table styling */
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 8px;
            vertical-align: top;
            border: 1px solid #2a5d94;
        }

        .invoice-box table tr.heading td {
            background: #2a5d94;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .invoice-box table tr.item td {
            text-align: center;
        }

        /* Totals table styling */
        .totals-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        /* New style for the Print Invoice button */
        #print-invoice {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            /* Change to your desired color */
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        /* Hover effect for the Print Invoice button */
        #print-invoice:hover {
            background-color: #388E3C;
            /* Darker shade for hover effect */
        }

        .totals-table td {
            padding: 8px;
            background: #d7e6f3;
            font-weight: bold;
            text-align: center;
            border: 1px solid #2a5d94;
        }

        .totals-table .total-value {
            font-weight: bold;
        }

        /* Print and PDF buttons */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 20px auto;
        }

        .print-button,
        .pdf-button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #2a5d94;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .print-button:hover,
        .pdf-button:hover {
            background-color: #1b3a57;
        }

        /* Print styles */
        /* Print styles */
        /* Print styles */
        @media print {

            /* Hide buttons during print */
            .print-button,
            .pdf-button {
                display: none;
                /* Hide the buttons when printing */
            }

            /* Set overall margin for the invoice box to reduce space */
            .invoice-box {
                margin: 0;
                /* No outer margin */
                padding: 0;
                /* No padding */
                border: none;
                /* No outer border */
                box-shadow: none;
                /* Remove shadow for clean output */
            }

            /* Adjust table styles for print */
            .invoice-box table {
                border-collapse: collapse;
                /* Ensure borders are collapsed */
                margin: 0;
                /* Remove margin from the table */
            }

            /* Reduce padding and border for cells */
            .invoice-box table td,
            .invoice-box table th {
                /* Target both table data and headers */
                border: 1px solid #2a5d94;
                /* Keep a thin border */
                padding: 2px;
                /* Reduced padding */
                margin: 0;
                /* Remove margin for the cells */
            }

            /* Header row styling */
            .invoice-box table tr.heading td {
                background: black;
                /* Header background */
                color: white;
                /* Header text color */
                font-weight: bold;
                /* Bold text for headers */
                text-align: center;
                /* Center align text */
            }

            /* Adjust font size for print */
            .invoice-box {
                font-size: 10px;
                /* Smaller font size for compactness */
            }

            /* Control row height */
            .invoice-box table tr {
                height: auto;
                /* Ensure no extra height is added */
            }

            /* Remove default page margin for print */
            @page {
                margin: 0;
                /* Set the margin for printed pages to zero */
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

        <span class="header">তৈরি হয়েছে: {{ now()->format('Y-m-d h:i A') }}</span>






        <table class="table table-bordered">

            <tbody>
                {{ dd($bookStorages) }}
                <tr>
                    <td>Printing Press Name :<b> {{ $details_about_printing_press[0]->printingPress->name }}</b></td>
                    <td>Address :<b> { { $details_about_printing_press[0]->printingPress->address }} </b></td>
                </tr>

                <tr>
                    <td>Filter Start Date : <b>{{ $start_date }}</b></td>
                    <td>Filter End Date : <b>{{ $end_date }}</b></td>
                </tr>

            </tbody>
        </table>













        <div style="padding-top: 50px">
            <table>
                <thead>
                    <tr>
                        <th>Press Name</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Total Books</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- "classNames" => array:1 [▶]
                    "subjectNames" => array:5 [▶]
                    "totalUnits" => array:5 [▶] --}}
                    {{--             
                    {{dd($details_about_printing_press)}} --}}
                    @foreach ($details_about_printing_press as $storage_details)
                        <tr>
                            <td>{{ optional($storage_details->printingPress)->name ?? 'N/A' }}</td>
                            <td>
                                @foreach ($storage_details->classNames as $classNames)
                                    {{ $classNames }}
                                @endforeach
                            </td>
                            <td>
                                @foreach ($storage_details->subjectNames as $index => $subjectNames)
                                    {!! $subjectNames . ' : ' . $storage_details->totalUnits[$index] . ' ' . '<br>' !!}
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
            // Get the element that you want to convert to PDF
            var invoiceElement = document.querySelector('.invoice-box');

            // Options for the PDF
            var opt = {
                margin: 1,
                filename: 'invoice_' + {{ $details_about_printing_press[0]->id }} + '.pdf',
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

            // Generate the PDF
            html2pdf()
                .from(invoiceElement)
                .set(opt)
                .save();
        });
    </script>

</body>

</html>
