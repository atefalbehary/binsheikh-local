<tr class="payment-row-highlight">
    <td>{{ __('messages.down_payment') }}</td>
    <td>{{ date('M-y') }}</td>
    <td>{{ moneyFormat($down_payment) }}</td>
    <td>{{$downPaymentPercentage}}%</td>
</tr>
<tr class="payment-row-highlight">
    <td>{{ __('messages.management_fees') }}</td>
    <td>{{ date('M-y') }}</td>
    <td>{{ moneyFormat($ser_amt) }}</td>
    <td></td>
</tr>
@foreach($months as $key => $mnth)
<tr>
    <td>{{$mnth['ordinal']}} {{ __('messages.installment') }}</td>
    <td>{{$mnth['month']}}</td>
    <td>{{ moneyFormat($mnth['payment']) }}</td>
    <td>{{$mnth['total_percentage']}}%</td>
</tr>
@endforeach
