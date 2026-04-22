<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Agent Registration</title>
</head>
<body style="margin:0;padding:0;background:#050505;font-family:Arial,Helvetica,sans-serif;color:#f5f5f5;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#050505;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:960px;background:#050505;">
                    <tr>
                        <td style="padding:0 26px 14px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td valign="top" style="font-size:0;">
                                        <div style="display:inline-block;vertical-align:top;width:58%;min-width:260px;padding-top:10px;">
                                            <div style="font-size:52px;line-height:1.02;font-weight:700;color:#f7f7f7;">New Agent</div>
                                            <div style="font-size:52px;line-height:1.02;font-weight:700;color:#f7f7f7;">Registration</div>
                                        </div>
                                        <div style="display:inline-block;vertical-align:top;width:42%;min-width:220px;text-align:right;">
                                            @if(!empty($logoUrl))
                                                <img src="{{ $logoUrl }}" alt="Project Logo" style="max-width:165px;max-height:130px;height:auto;border:0;display:inline-block;">
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 26px 10px;font-size:36px;line-height:1.35;color:#f1f1f1;">
                            Dear Team,
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 26px 24px;font-size:37px;line-height:1.32;color:#f1f1f1;">
                            A new agent has successfully registered on the Bin Al Sheikh platform.<br>
                            Please review the details below:
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 20px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #d5b36a;border-radius:12px;overflow:hidden;">
                                <tr>
                                    <td style="padding:14px 24px;font-size:36px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2a2a2a;">Full Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $fullName }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:36px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2a2a2a;">Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:36px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2a2a2a;">Phone&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $phone }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:36px;line-height:1.35;color:#f8f8f8;border-bottom:1px solid #2a2a2a;">Agency&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $agency }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 24px;font-size:36px;line-height:1.35;color:#f8f8f8;">Registration Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $registrationDate }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:26px 20px 16px;">
                            <a href="{{ $reviewUrl }}" style="display:inline-block;background:#d5b36a;color:#1b1b1b;text-decoration:none;font-weight:700;font-size:41px;line-height:1.15;padding:12px 34px;border-radius:14px;min-width:445px;text-align:center;">
                                Review Agent Profile
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:6px 20px 0;font-size:35px;line-height:1.35;color:#bdbdbd;">
                            This is an automated system notification - Bin Al Sheikh Real Estate
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
