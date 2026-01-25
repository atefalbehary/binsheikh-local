<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification - Bin Al Sheikh</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 500px; margin: 30px auto; background: #ffffff; padding: 20px; border-radius: 10px;
                     box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center; }
        .header { font-size: 20px; font-weight: bold; color: #333; margin-bottom: 20px; }
        .otp-code { font-size: 24px; font-weight: bold; color: #007bff; padding: 10px 20px; background: #f1f1f1;
                    display: inline-block; margin: 15px 0; border-radius: 5px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; }
        .company-name { font-size: 18px; font-weight: bold; color: #007bff; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">Your OTP Code for Login</div>

    {{-- <p>Hello,</p> --}}
    <p>Use the following OTP to complete your login process for <span class="company-name">Bin Al Sheikh</span>.
       This OTP is valid for 10 minutes.</p>

    <div class="otp-code">{{ $otp }}</div>

    <p>If you did not request this code, please ignore this email.</p>

    <div class="footer">
        Need help? Contact our support team.<br>
        &copy; {{ date('Y') }} Bin Al Sheikh, All rights reserved.
    </div>
</div>

</body>
</html>
