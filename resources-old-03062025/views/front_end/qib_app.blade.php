<form id="paymentForm" method="POST" action="https://paymentapi.qib.com.qa/api/gateway/v2.0">
<!--<form id="paymentForm" method="POST" action="https://pg-uat.qib.com.qa/paymentgw-api/api/gateway/v2.0">-->
    <input type="hidden" name="action" value="capture" />
    <input type="hidden" name="gatewayId" value="{{ $gatewayId }}" />
    <input type="hidden" name="signatureFields" value="gatewayId,amount,referenceId" />
    <input type="hidden" name="signature" value="{{ $signature }}" />
    <input type="hidden" name="referenceId" value="{{ $referenceId }}" />
    <input type="hidden" name="amount" value="{{ $amount }}" />
    <input type="hidden" name="currency" value="QAR" />
    <input type="hidden" name="mode" value="LIVE" />
    <input type="hidden" name="description" value="Payment For Bin Al Sheikh" />
    <input type="hidden" name="returnUrl" value="{{ $returnUrl }}" />
    <input type="hidden" name="name" value="{{$user->name}}" />
    <input type="hidden" name="address" value="{{$user->name??'Test address'}}" />
    <input type="hidden" name="city" value="{{$user->city??'Test city'}}" />
    <input type="hidden" name="state" value="{{$user->state??'Test state'}}" />
    <input type="hidden" name="country" value="{{$country_id??'QA'}}" />
    <input type="hidden" name="phone" value="{{$user->phone??'123456'}}" />
    <input type="hidden" name="email" value="{{$user->email}}" />
    <input type="hidden" value="Submit" type="submit" />
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit the form when the page loads
        document.getElementById('paymentForm').submit();
    });
</script>
