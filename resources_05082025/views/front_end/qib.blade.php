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
    <input type="hidden" name="name" value="Irfan" />
    <input type="hidden" name="address" value="Pakidaruvil House" />
    <input type="hidden" name="city" value="Malappuram" />
    <input type="hidden" name="state" value="Kerala" />
    <input type="hidden" name="country" value="QA" />
    <input type="hidden" name="phone" value="9633049957" />
    <input type="hidden" name="email" value="mippkl@gmail.com" />
    <input type="hidden" value="Submit" type="submit" />
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit the form when the page loads
        document.getElementById('paymentForm').submit();
    });
</script>
