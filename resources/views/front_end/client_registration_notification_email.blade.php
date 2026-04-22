<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Client Registration</title>
</head>
<body style="margin:0;padding:0;background:#050505;font-family:'Poppins',Arial,Helvetica,sans-serif;color:#f5f5f5;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#050505;padding:22px 0 26px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:980px;background:#050505;">
                    <tr>
                        <td style="padding:0 26px 16px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="top" style="width:30%;padding:0 18px 0 0;">
                                        <div style="font-size:63px;line-height:1.02;font-weight:700;letter-spacing:0.2px;color:#f7f7f7;">New Client</div>
                                        <div style="font-size:63px;line-height:1.02;font-weight:700;letter-spacing:0.2px;color:#f7f7f7;">Registration</div>
                                    </td>
                                    <td valign="top" style="width:50%;padding:12px 16px 0 0;font-size:16px;line-height:1.45;color:#f0f0f0;">
                                        Dear Team,<br><br>
                                        A new client has successfully registered on the Bin Al Sheikh platform.
                                        Please review the details below:
                                    </td>
                                    <td valign="top" align="right" style="width:20%;padding-top:4px;">
                                        @if(!empty($logoUrl))
                                            <img src="{{ $logoUrl }}" alt="Bin Al Sheikh" style="width:168px;max-width:168px;height:auto;border:0;display:block;">
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:4px 20px 0;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #b9964f;border-radius:12px;overflow:hidden;">
                                <tr>
                                    <td style="padding:14px 24px;font-size:20px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2c2c2c;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:180px;">Full Name</td>
                                                <td style="width:24px;text-align:center;">:</td>
                                                <td>{{ $fullName }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:20px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2c2c2c;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:180px;">Email</td>
                                                <td style="width:24px;text-align:center;">:</td>
                                                <td>{{ $email }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:20px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2c2c2c;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:180px;">Phone</td>
                                                <td style="width:24px;text-align:center;">:</td>
                                                <td>{{ $phone }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:20px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2c2c2c;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:180px;">Agent Name</td>
                                                <td style="width:24px;text-align:center;">:</td>
                                                <td>{{ $agentName }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:20px;line-height:1.35;color:#f8f8f8;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:180px;">Registration Date</td>
                                                <td style="width:24px;text-align:center;">:</td>
                                                <td>{{ $registrationDate }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" style="padding:26px 20px 0;font-size:15px;line-height:1.4;color:#bdbdbd;">
                            This is an automated system notification - Bin Al Sheikh Real Estate
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
