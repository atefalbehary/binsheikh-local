<tr class="payment-row-highlight">
    <td>{{ __('messages.down_payment') }}</td>
    <td>{{$downPaymentPercentage}}%</td>

{{--    <td>{{ date('M-y') }}</td>--}}
    <td>{{ moneyFormat($down_payment) }}</td>
    <td>{{ moneyFormat($down_payment) }}</td>
    <td>{{$downPaymentPercentage}}%</td>

</tr>
@foreach($months as $key => $mnth)
<tr>
{{--    <td>{{$mnth['ordinal']}} {{ __('messages.installment') }}</td>--}}
    <td>{{$mnth['month']}}</td>
    <td>{{$mnth['percentage']}}%</td>
    <td>{{ moneyFormat($mnth['payment']) }}</td>
    <td>{{ moneyFormat($mnth['total_payment']) }}</td>
    <td>{{$mnth['total_percentage']}}%</td>
</tr>
@endforeach
<tr class="payment-row-highlight">
    <td>{{ __('messages.handover_amount') }}</td>
    <td>{{number_format((float)$handOverPaymentPercentage, 2) . '%'}}</td>
    <td>{{ moneyFormat($handover_amount) }}</td>
    <td></td>
    <td>100%</td>
</tr>
<tr class="payment-row-highlight">
    <td>{{ __('messages.management_fees') }}</td>
    <td>{{number_format((float)$ser_percentage, 2) . '%'}}</td>
    <td>{{ moneyFormat($ser_amt) }}</td>
    <td></td>
    <td></td>
</tr>
