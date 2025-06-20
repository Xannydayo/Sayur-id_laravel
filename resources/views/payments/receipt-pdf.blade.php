<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt #{{ $payment->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            color: #888;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
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

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                Sayur.id
                            </td>

                            <td>
                                Receipt #: {{ $payment->id }}<br>
                                Order #: {{ $payment->order->order_number }}<br>
                                Created: {{ $payment->created_at->format('d M Y H:i') }}<br>
                                Status: {{ ucfirst($payment->status) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Customer Information:<br>
                                {{ $payment->order->user->name }}<br>
                                {{ $payment->order->user->email }}<br>
                                {{ $payment->order->shipping_phone }}
                            </td>

                            <td>
                                Shipping Address:<br>
                                {{ $payment->order->shipping_address }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td>Amount</td>
            </tr>

            <tr class="details">
                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>

            @php
                $product_total = 0;
                foreach ($payment->order->products as $product) {
                    $product_total += $product->pivot->quantity * $product->pivot->price;
                }
                $shipping_cost = $payment->order->getCourierPrice();
            @endphp

            @foreach ($payment->order->products as $product)
            <tr class="item {{ $loop->last ? 'last' : '' }}">
                <td>{{ $product->pivot->quantity }} x {{ $product->name }}</td>
                <td>Rp {{ number_format($product->pivot->price * $product->pivot->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            <tr class="total">
                <td>Product Total:</td>
                <td>Rp {{ number_format($product_total, 0, ',', '.') }}</td>
            </tr>

            @if ($payment->order->courier)
            <tr class="total">
                <td>Shipping ({{ $payment->order->courier }}):</td>
                <td>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr class="total">
                <td></td>
                <td>Grand Total: Rp {{ number_format($payment->order->total_amount, 0, ',', '.') }}</td>
            </tr>

            @if ($payment->payment_details)
            <tr class="details">
                <td colspan="2">
                    <br>
                    <strong>Payment Notes:</strong><br>
                    {{ $payment->payment_details }}
                </td>
            </tr>
            @endif
        </table>
    </div>
</body>
</html> 