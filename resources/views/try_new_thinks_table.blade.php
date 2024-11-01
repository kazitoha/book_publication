<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>

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
        <div class="header " style="text-align: right">তৈরি হয়েছে: {{ now()->format('Y-m-d h:i A') }}</div>
        <div style="margin-top: 30px;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr class="heading" style="background-color: #f2f2f2;">
                        <th style="padding: 10px; border: 1px solid #dddddd;">Class</th>
                        <th style="padding: 10px; border: 1px solid #dddddd;">Subject</th>
                        <th style="padding: 10px; border: 1px solid #dddddd;">Units</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $printing_press_id = null;
                        $batch_id = null;
                    @endphp
                    @foreach ($batchs as $batch => $batchGroup)
                        <tr>
                            <td colspan="2" style="background-color: #e0e0e0; font-weight: bold; padding: 10px;">
                                {{ findPrintingPressInfo($batchGroup[0]->printing_press_id)->name }}
                            </td>
                            <td colspan="2" style="background-color: #e0e0e0; font-weight: bold; padding: 10px;">
                                {{ $batchGroup[0]->created_at->format('Y-m-d h:i A') }}
                            </td>
                        </tr>
                        @foreach ($batchGroup as $batchInfo)
                            <tr>
                                <td style="padding: 10px; border: 1px solid #dddddd;">
                                    {{ findClassInformartion($batchInfo->class_id)->name }}</td>
                                <td style="padding: 10px; border: 1px solid #dddddd;">
                                    {{ findSubjectInformartion($batchInfo->subject_id)->name }}</td>
                                <td style="padding: 10px; border: 1px solid #dddddd;">{{ $batchInfo->total_unit }}</td>
                                <!-- Show individual total unit -->
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" style="font-weight: bold; padding: 10px; border-top: 2px solid #dddddd;">
                                Total Unit :</td>
                            <td colspan="2" style="font-weight: bold; padding: 10px; border-top: 2px solid #dddddd;">
                                {{ sumTotalUnitByBatchId($batch) }}</td>
                            <!-- Empty cell for alignment -->
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
