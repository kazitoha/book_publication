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
    </style>
</head>

<body>
    <div class="invoice-box">

        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <div class="title">
                                    <h1>Book Store</h1>
                                </div>
                            </td>
                            <td class="right-align">
                                <div>
                                    Invoice #:<b> {{ $id }}</b><br>
                                    Created: {{ $created }} <br>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <table style=" padding-bottom: 20px;">
            <tr class="heading">
                <td>From</td>
                <td style="text-align: center">To</td>
            </tr>
            <tr class="item last">
                <td>Book Store<br>
                    1234 Elm Street, Suite 567<br>
                    City, State, ZIP</td>
                <td style="text-align: right">{{ $seller_name }}<br>
                    {{ $seller_address }}
                </td>
            </tr>
        </table>


        <table cellpadding="0" cellspacing="0" >
            <tr class="heading">
                <td>No.</td>
                <td>Class name</td>
                <td>Subject name</td>
                <td>Unit Price</td>
                <td>Total Unit</td>
                <td>Total</td>
            </tr>
            <tr class="details">
                <td>{{$id}}</td>
                <td>{{$class_name}}</td>
                <td>{{$subject_name}}</td>
                <td>{{$unit_price}}</td>
                <td>{{$total_unit}}</td>
                <td>{{$unit_price * $total_unit}}</td>
            </tr>
        </table>
        <br>

        <table>
            <tr class="heading">
                <td>Description</td>
                <td style="text-align: center">Price</td>
            </tr>
            <tr class="item last">
                <td>Subtotal</td>
                <td style="text-align: center">{{$unit_price * $total_unit}} Tk.</td>
            </tr>
            <tr class="item last">
                <td>Tax </td>
                <td style="text-align: center">17 Tk.</td>
            </tr>
            <tr class="total">
                <td></td>
                <td>Total: {{($unit_price * $total_unit)+17}} Tk</td>
            </tr>
        </table>
    </div>
</body>

</html>
