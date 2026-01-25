<tr class="payment-row-highlight">
    <td>{{ __('messages.amount_due_at_booking') }}  <input type="hidden" id="total_rent_inp" value="{{moneyFormat($total_rent)}}"></td>
    <td>{{ date('M-y') }}</td>
    <td>{{ moneyFormat($down_payment) }}</td>
</tr>
@foreach($months as $key => $mnth)
<tr>
    <td>{{$mnth['ordinal']}} {{ __('messages.rent') }}</td>
    <td>{{$mnth['month']}}</td>
    <td>{{ moneyFormat($mnth['payment']) }}</td>
</tr>
@endforeach
