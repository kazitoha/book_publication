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
        @media print {

            .print-button,
            .pdf-button {
                display: none;
            }

            .invoice-box table td,
            .totals-table td,
            .bordered-table {
                border: 1px solid #2a5d94;
            }

            .invoice-box table tr.heading td {
                background: black;
                color: white;
                font-weight: bold;
                text-align: center;
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

        <!-- Invoice Header Section with Flex Alignment -->
        <div class="header-flex"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <span class="header">চালান #: <b>{{ convertEnglishToBangla($bookStorage->id) }}</b></span>
            <span class="header">তৈরি হয়েছে: {{ $bookStorage->created_at->format('d-M-Y') }}</span>
        </div>

        <div class="bordered-table">
            <h3>Details for {{ optional($bookStorage->printingPress)->name ?? 'N/A' }}</h3>
            <p>Total Books: {{ $bookStorage->total_book ?? 0 }}</p>
            <p>Created At: {{ $bookStorage->created_at->format('Y-m-d H:i:s') }}</p>
            <p>Classes: {{ implode(', ', $bookStorage->classsNames) ?? 'N/A' }}</p>
            <p>Subjects: {{ implode(', ', $bookStorage->subjectNames) ?? 'N/A' }}</p>

            <h4>Books in the selected date range:</h4>
            <table>
                <thead>
                    <tr>
                        <th>Press Name</th>
                        <th>Total Books</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookStoragesInRange as $book)
                        <tr>
                            <td>{{ optional($book->printingPress)->name ?? 'N/A' }}</td>
                            <td>{{ $book->total_book ?? 0 }}</td>
                            <td>{{ $book->created_at->format('Y-m-d') ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ dd($bookStoragesInRange) }}
            <table>
                <tr>
                    <td>
                        <span class="header">থেকে:</span><br>
                        নূরানী তা’লীমুল কুরআন বোর্ড বাংলাদেশ<br>
                        Tower, 24/B, Noorani, Block C Ring Rd,<br> Dhaka 1207
                    </td>
                    <td class="right-align">
                        <span class="header">প্রতি:</span><br>
                        {{ $bookStorage->printingPress->name }}<br>
                        {{ $bookStorage->printingPress->address }}
                    </td>
                </tr>
            </table>
        </div>

        {{ dd($bookStorage) }}
        <!-- Invoice Details -->
        <table cellpadding="0" cellspacing="0" style="margin-top: 20px;">
            <tr class="heading">
                <td>No.</td>
                <td>ক্লাসের নাম</td>
                <td>বিষয়ের নাম</td>
                <td>ইউনিট মূল্য</td>
                <td>মোট ইউনিট</td>
                <td>মোট</td>
            </tr>

            @foreach ($data['classes'] as $index => $class_id)
                <tr class="item">
                    <td>{{ convertEnglishToBangla($index + 1) }}</td>
                    <td>{{ $data['classNames'][$class_id] ?? 'N/A' }}</td>
                    <td>{{ $data['subjectNames'][$data['subjects'][$index]] ?? 'N/A' }}</td>
                    <td>{{ convertEnglishToBangla($data['unit_price'][$index]) }}</td>
                    <td>{{ convertEnglishToBangla($data['total_unit'][$index]) }}</td>
                    <td>{{ convertEnglishToBangla($data['unit_price'][$index] * $data['total_unit'][$index]) }}</td>
                </tr>
            @endforeach
        </table>

        <!-- Totals Table -->
        <table class="totals-table">
            <tr>
                <td>সাবটোটাল</td>
                <td>{{ convertEnglishToBangla(array_sum(array_map(function ($u, $t) {return $u * $t;},$data['unit_price'],$data['total_unit']))) }}
                    টাকা</td>
            </tr>
            <tr>
                <td>ট্যাক্স</td>
                <td>{{ convertEnglishToBangla(17) }} টাকা</td>
            </tr>
            <tr>
                <td>মোট</td>
                <td class="total-value">
                    {{ convertEnglishToBangla(array_sum(array_map(function ($u, $t) {return $u * $t;},$data['unit_price'],$data['total_unit'])) + 17) }}
                    টাকা</td>
            </tr>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script>
        document.getElementById('generate-pdf').addEventListener('click', function() {
            // Get the element that you want to convert to PDF
            var invoiceElement = document.querySelector('.invoice-box');

            // Options for the PDF
            var opt = {
                margin: 1,
                filename: 'invoice_' + {{ $bookStorage->id }} + '.pdf',
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
