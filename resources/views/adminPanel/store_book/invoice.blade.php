<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;

        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background: #fff;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-box .flex-container .title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .right-align {
            text-align: right;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .td {
            style="text-align: center;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
 <table cellpadding="0" cellspacing="0"><tr class="information"><td colspan="2"><table><tr><td><div class="title"><h1>Book Store</h1></div></td><td class="right-align"><div>Invoice #: <b>{{ $id }}</b><br> Created: {{ $created }}<br> </div> </td> </tr> </table> </td> </tr> </table> <table style="padding-bottom: 20px;"> <tr class="heading"> <td>From</td> <td style="text-align: center">To</td> </tr> <tr class="item last"> <td>Book Store<br> 1234 Elm Street, Suite 567<br> City, State, ZIP</td> <td style="text-align: right"> {{ $printing_press_name }}<br> {{ $address }} </td> </tr> </table> <table cellpadding="0" cellspacing="0" style=" border: 1px solid rgb(212, 211, 211);"> <tr class="heading item"> <td style="text-align: center;">No.</td> <td style="text-align: center;">Press </td> <td style="text-align: center;">Class </td> <td style="text-align: center;">Subject</td> <td style="text-align: center;">unit Price</td> <td style="text-align: center;">Total unit</td> <td style="text-align: center;">Total</td> </tr> <tr class="details" bordar> <td style="text-align: center; border: 1px solid rgb(212, 211, 211);">1</td> <td style="text-align: center; border: 1px solid rgb(212, 211, 211);">{{ $printing_press_name }}</td> <td style="text-align: center; border: 1px solid rgb(212, 211, 211);">{{ $class_name }}</td> <td style="text-align: center; border: 1px solid rgb(212, 211, 211);">{{ $subject_name }}</td> <td style="text-align: center; border: 1px solid rgb(212, 211, 211);">{{ $unit_price }}</td> <td style="text-align: center; border: 1px solid rgb(212, 211, 211);">{{ $total_unit }}</td> <td style="text-align: center; border: 1px solid rgb(212, 211, 211);">{{ $unit_price * $total_unit }}</td> </tr> </table> <br> <table> <tr class="heading"> <td style="text-align: center;">Description</td> <td style="text-align: center">Price</td> </tr> <tr class="item last"> <td style="text-align: center;">Subtotal</td> <td style="text-align: center"> {{ $unit_price * $total_unit }} Tk. </td> </tr> <tr class="item last" style="text-align: center;"> <td>Tax</td> <td style="text-align: center" style="text-align: center;">17 Tk.</td> </tr> <tr class="total"> <td></td> <td >Total: <b style="text-align: center;">{{ $unit_price * $total_unit + 17 }} Tk</b></td> </tr> </table> </div> </body> </html>
