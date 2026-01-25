<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Template</title>
    <style>
        @page {
            margin: 120px 50px 80px 50px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }
        .header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 100px;
            padding: 10px 50px;
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .header-divider {
            border: none;
            border-top: 2px solid #c0a96e;
            margin: 0;
            width: 100%;
        }
        .footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 14px;
            color: #888;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px 40px;
            position: relative;
        }
        .watermark {
            position: absolute;
            opacity: 0.7;
            z-index: 0;
            width: 100%;
            height: 60%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .content {
            position: relative;
            z-index: 1;
        }
        .logo img {
            height: 80px;
        }
        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin: 40px 0;
            color: #333;
        }
        .property-name {
            text-align: center;
            font-size: 20px;
            color: #666;
            margin-bottom: 30px;
        }
        .property-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f8f8f8;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        thead {
            display: table-header-group;
        }
        tfoot {
            display: table-footer-group;
        }
        .payment-highlight {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Fixed Header - Will repeat on every page -->
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <img src="{{$logoBase64}}" alt="Bin Al Sheikh Real Estate Brokerage Logo">
            </div>
        </div>
        <hr class="header-divider">
    </div>

    <!-- Fixed Footer - Will repeat on every page -->
    <div class="footer">
        <p>www.bsbqa.com | +974 4001 1911 - +974 3066 6004</p>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Watermark Image -->
        <img class="watermark" src="{{$waterMarkBase64}}" alt="Watermark">

        <div class="content">
            <div class="title">Custom Payment Plan</div>
            <div class="property-name">{{ $property->name }}</div>

            <div class="property-details">
                <h3>Property Details</h3>
                <table>
                    <thead>
                    <tr>
                        <th>Unit Number</th>
                        <th>Gross Area</th>
                        <th>Size Net</th>
                        <th>Full Price</th>
                        <th>Management Fees</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $property->apartment_no }}</td>
                        <td>{{ $property->gross_area }}</td>
                        <td>{{ $property->area }} m2</td>
                        <td>{{ moneyFormat($full_price) }}</td>
                        <td>{{ moneyFormat($ser_amt) }}</td>
                        <td>{{ moneyFormat($total) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div>
                <h3>Custom Payment Terms</h3>
                <p><strong>Down Payment:</strong> {{ moneyFormat($down_payment) }} ({{ number_format($downPaymentPercentage, 2) }}%)</p>
                <p><strong>Payment Duration:</strong> {{ $rental_duration }} months</p>
            </div>

            <h3>Payment Schedule</h3>
            <table>
                <thead>
                <tr>
                    <th>Payment</th>
                    <th>Month</th>
                    <th>Amount</th>
                    <th>Percentage</th>
                </tr>
                </thead>
                <tbody>
                <tr class="payment-highlight">
                    <td>Down Payment</td>
                    <td>{{ date('M-y') }}</td>
                    <td>{{ moneyFormat($down_payment) }}</td>
                    <td>{{ number_format($downPaymentPercentage, 2) }}%</td>
                </tr>
                <tr class="payment-highlight">
                    <td>Management Fees</td>
                    <td>{{ date('M-y') }}</td>
                    <td>{{ moneyFormat($ser_amt) }}</td>
                    <td></td>
                </tr>
                @foreach($months as $mnth)
                    <tr>
                        <td>{{ $mnth['ordinal'] }} Installment</td>
                        <td>{{ $mnth['month'] }}</td>
                        <td>{{ moneyFormat($mnth['payment']) }}</td>
                        <td>{{ $mnth['total_percentage'] }}%</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>