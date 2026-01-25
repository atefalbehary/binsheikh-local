<!DOCTYPE html>
<html lang="ar-en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }
        .header-divider {
            border: none;
            border-top: 2px solid #c0a96e;
            margin: 0;
            width: 100%;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px 40px;
            position: relative;
        }
        .watermark {
            position: fixed;
            opacity: 0.7;
            width: 100%;
            height: 60%;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .content {
            position: relative;
            z-index: 1;
        }
        .logo {
            text-align: center;
            width: 100%;
        }
        .logo img {
            height: 80px;
            margin: 0 auto; /* This centers the image horizontally */
        }
        .title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin: 40px 0;
            color: #333;
        }
        .property-name {
            text-align: left;
            font-size: 12px;
            color: #ff0000; /* Red color */
            font-weight: bold;
        }
        .note-ar {
            text-align: right;
            font-size: 12px;
            color: #ff0000; /* Red color */
            font-weight: bold;
            margin-bottom: 30px;
            direction: rtl;  font-family: Arial, sans-serif;
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
            background-color: #00337C;
            color: white;
        }
        tr {
            page-break-inside: avoid;
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
        .first-schedule-page {
            page-break-before: always;
            padding-top: 20px;
        }
        .continued-schedule-page {
            page-break-before: always;
            padding-top: 20px;
        }
        .schedule-table {
            margin-top: 0;
        }
        .schedule-title {
            margin-bottom: 15px;
        }
        .footer {
            position: fixed;
            bottom: -40px;
            text-align: center !important;
            left: 0;
            right: 0;
            width: 100%;
            height: auto;
            background-color: #003366;
            color: white;
            font-family: Arial, sans-serif;
            padding: 10px 0;
            border: none; /* Ensure no outer border */
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border: none; /* Remove table border */
        }
        .footer-table td {
            padding: 5px 10px;
            vertical-align: top;
            border-right: 1px solid rgba(255,255,255,0.2);
            border-top: none; /* Remove top border */
            border-bottom: none; /* Remove bottom border */
            border-left: none; /* Remove left border */
        }
        .footer-table td:last-child {
            border-right: none; /* Remove right border for last cell */
        }
        .footer-table tr {
            border: none; /* Remove row borders */
        }
        .handover-row {
            background-color: #FFFF00 !important; /* Yellow */
        }
        .management-row {
            background-color: #ADD8E6 !important; /* Light blue */
        }
    </style>
</head>
<body>
<!-- Watermark Image - Will repeat on every page -->
<img class="watermark" src="{{$waterMarkBase64}}" alt="Watermark">

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
    <table class="footer-table">
        <tr>
            <!-- First Column -->
            <td width="33%" style="text-align: center">
                <div style="font-weight: bold; margin-bottom: 5px;">www.bsbqa.com</div>
            </td>

            <!-- Second Column -->
            <td width="33%" style="text-align: center">
                <div style="font-weight: bold;">License No: 182</div>
                <div style="font-weight: bold;">CR: 155731</div>
            </td>

            <!-- Third Column -->
            <td width="34%" style="text-align: center;">
                <div style="font-weight: bold;">+974 4001 1911</div>
                <div style="font-weight: bold;">+974 3066 6004</div>
            </td>
        </tr>
    </table>
{{--    <p>www.bsbqa.com | +974 4001 1911 - +974 3066 6004</p>--}}
</div>

<!-- Main Content -->
<div class="container">
    <div class="content">
        <div class="title">{{$payment_plan}}</div>
        <div class="property-name">{{ $payment_note_en_part1 }}</div>
        <div style="text-align: center;font-size: 12px;  color: #ff0000;font-weight: bold;">{{ $payment_note_en_part2 }}</div>
{{--        <div class="note-ar">{{ $payment_note_ar }}</div>--}}

        <div class="property-details">
            <h3>Property Details</h3>
            <table>
                <thead>
                <tr>
                    <th>Project </th>
                    <th>Unit Number</th>
                    <th>Floor Number</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$project}}</td>
                    <td>{{ $property->apartment_no }}</td>
                    <td>{{ $property->floor_no }}</td>
                </tr>
                </tbody>
            </table>
            <table>
                <thead>
                <tr>
                    <th>Gross Area</th>
                    <th>Size Net</th>
                    <th>Balcony Size</th>
                    <th>Handover</th>
                    <th>Installment</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $property->gross_area }} m2</td>
                    <td>{{ $property->area }} m2</td>
                    <td>{{ $property->balcony_size }} m2</td>
                    <td>{{ moneyFormat((float)$hand_over_amount, 2, '.', ',')  }}</td>
                    <td>{{$duration }}</td>
                </tr>
                </tbody>
            </table>
            <table>
                <thead>
                <tr>
                    <th>Full Price</th>
                    <th>Management Fees</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ moneyFormat((float)$full_price, 2, '.', ',')}}</td>
                    <td>{{ moneyFormat((float)$ser_amt, 2, '.', ',')}}</td>
                    <td>{{ moneyFormat((float)$total, 2, '.', ',')}}</td>
                    <td>{{ date('d-M-y') }}</td>
                </tr>
                </tbody>
            </table>
        </div>

{{--        <div>--}}
{{--            <h3>{{$payment_term}}</h3>--}}
{{--            <p><strong>Down Payment:</strong> {{ moneyFormat($down_payment) }} ({{ number_format($downPaymentPercentage, 2) }}%)</p>--}}
{{--            <p><strong>Payment Duration:</strong> {{ $rental_duration }} months</p>--}}
{{--        </div>--}}

        <!-- Payment Schedule Sections -->
        @php
            // Combine all payment rows

 $allRows[] = [
    'month' => 'Down Payment',
    'payment' => $down_payment,
    'total_payment' => $down_payment,
    'percentage' => number_format($downPaymentPercentage, 2) . '%',
    'total_percentage' => number_format($downPaymentPercentage, 2) . '%',
    'highlight' => true
];

            // Add all installment rows
            foreach($months as $mnth) {
                $allRows[] = [
                    'month' => $mnth['month'],
                    'percentage' => $mnth['percentage']. '%',
                    'payment' => $mnth['payment'],
                    'total_payment' => $mnth['total_payment'],
                    'total_percentage' => $mnth['total_percentage'] . '%',
                    'highlight' => false
                ];
            }

$allRows[] = [
    'month' => 'Handover Payment',
    'payment' => $hand_over_amount,
    'percentage' => number_format((float)$hand_over_percentage, 2) . '%',
    'total_payment' => $full_price,
    'total_percentage' => '100%',
    'highlight' => true,
    'row_class' => 'handover-row'  // Add this line
];
$allRows[] = [
    'month' => 'Management Fees',
    'payment' => $ser_amt,
    'percentage' => number_format((float)$managment_fees_percentage, 2) . '%' ,
     'total_payment' => 'empty_value',
    'total_percentage' => '',
    'highlight' => true,
     'row_class' => 'management-row'  // Add this line
];

            // Calculate rows per page (adjust based on your content height)
            $rowsPerPage = 17;
            $totalPages = ceil(count($allRows) / $rowsPerPage);
        @endphp

            <!-- First Payment Schedule Page -->
        <div class="first-schedule-page">
            <h3 class="schedule-title">Payment Schedule</h3>
            <table class="schedule-table">
                <thead>
                <tr>
                    <th>Timeline</th>
                    <th>Monthly%</th>
                    <th>Payment</th>
                    <th>Total Accumulated</th>
                    <th>Total%</th>
                </tr>
                </thead>
                <tbody>
                @for($i = 0; $i < min($rowsPerPage, count($allRows)); $i++)
                    <tr @if($allRows[$i]['highlight']) class="payment-highlight" @endif>
                        <td>{{ $allRows[$i]['month'] }}</td>
                        <td>{{ $allRows[$i]['percentage'] }}</td>
                        <td>{{ moneyFormat($allRows[$i]['payment'], 2, '.', ',') }}</td>
                        <td>{{ moneyFormat($allRows[$i]['total_payment'], 2, '.', ',') }}</td>
                        <td>{{ $allRows[$i]['total_percentage'] }}</td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>

        <!-- Continued Payment Schedule Pages -->
        @for($page = 1; $page < $totalPages; $page++)
            <div class="continued-schedule-page">
                <h3 class="schedule-title"></h3>
                <table class="schedule-table">
                    <thead>
                    <tr>
                        <th>Timeline</th>
                        <th>Monthly%</th>
                        <th>Payment</th>
                        <th>Total Accumulated</th>
                        <th>Total%</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = $page * $rowsPerPage; $i < min(($page + 1) * $rowsPerPage, count($allRows)); $i++)
                        <tr @if($allRows[$i]['highlight']) class="payment-highlight" @endif>
                            <td @if($allRows[$i]['highlight']) class="{{ $allRows[$i]['row_class'] ?? '' }}" @endif>{{ $allRows[$i]['month'] }}</td>
                            <td>{{ $allRows[$i]['percentage'] }}</td>
                            <td>{{ moneyFormat($allRows[$i]['payment'], 2, '.', ',') }}</td>
                            <td>{{ moneyFormat($allRows[$i]['total_payment'], 2, '.', ',') }}</td>
                            <td>{{ $allRows[$i]['total_percentage'] }}</td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        @endfor
    </div>
</div>
</body>
</html>
