<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Payment Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #222;
            margin-bottom: 5px;
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
        .payment-highlight {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Property Payment Plan</h1>
        <p>{{ $property->name }}</p>
    </div>

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
                    <td>{{ moneyFormat($property->price) }}</td>
                    <td>{{ moneyFormat($ser_amt) }}</td>
                    <td>{{ moneyFormat($total) }}</td>
                </tr>
            </tbody>
        </table>
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
                <td>{{ $settings->advance_perc }}%</td>
            </tr>
            <tr class="payment-highlight">
                <td>Management Fees</td>
                <td>{{ date('M-y') }}</td>
                <td>{{ moneyFormat($ser_amt) }}</td>
                <td></td>
            </tr>
            @foreach($months as $key => $mnth)
            <tr>
                <td>{{ $mnth['ordinal'] }} Installment</td>
                <td>{{ $mnth['month'] }}</td>
                <td>{{ moneyFormat($mnth['payment']) }}</td>
                <td>{{ $mnth['total_percentage'] }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This document is for informational purposes only and does not constitute a binding agreement.</p>
        <p>Generated on {{ date('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html> 