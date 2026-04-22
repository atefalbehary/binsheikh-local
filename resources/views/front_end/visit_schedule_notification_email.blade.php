<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Property Visit Request</title>
</head>
<body style="margin:0;padding:0;background:#050505;font-family:Arial,Helvetica,sans-serif;color:#f5f5f5;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#050505;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:760px;background:#050505;">
                    <tr>
                        <td align="center" style="padding:18px 20px 16px;">
                            @if(!empty($logoUrl))
                                <img src="{{ $logoUrl }}" alt="Bin Al Sheikh" style="max-width:180px;height:auto;border:0;display:block;margin:0 auto;">
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#d5b36a;color:#0c0c0c;padding:12px 20px;font-size:22px;font-weight:700;line-height:1.3;">
                            New Propety Visit Request
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:26px 22px 10px;font-size:18px;line-height:1.5;color:#f1f1f1;">
                            Dear Team,
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 22px 20px;font-size:17px;line-height:1.7;color:#f1f1f1;">
                            A new visit request has been submitted by an agent through the Bin Al Sheikh platform.
                            Please review the details below:
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 14px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #595959;border-radius:10px;overflow:hidden;">
                                <tr>
                                    <th align="center" style="width:50%;padding:14px 12px;font-size:18px;color:#d5b36a;border-right:1px solid #595959;border-bottom:1px solid #595959;font-weight:700;">Agent Details</th>
                                    <th align="center" style="width:50%;padding:14px 12px;font-size:18px;color:#d5b36a;border-bottom:1px solid #595959;font-weight:700;">Visit Request Details</th>
                                </tr>
                                <tr>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;border-right:1px solid #595959;border-bottom:1px solid #595959;">Agent Name: {{ $agentName }}</td>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;border-bottom:1px solid #595959;">Property Name / Project: {{ $projectName ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;border-right:1px solid #595959;border-bottom:1px solid #595959;">Email: {{ $email }}</td>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;border-bottom:1px solid #595959;">Unit Number: {{ $unitNumber ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;border-right:1px solid #595959;border-bottom:1px solid #595959;">Phone: {{ $phone }}</td>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;border-bottom:1px solid #595959;">Preffered Visit Date: {{ $visitDate }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;border-right:1px solid #595959;">&nbsp;</td>
                                    <td style="padding:14px 14px;font-size:16px;color:#f7f7f7;">Client Name( if available): {{ $clientName }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:24px 20px 16px;">
                            <a href="{{ $reviewUrl }}" style="display:inline-block;background:#d5b36a;color:#151515;text-decoration:none;font-weight:700;font-size:20px;line-height:1.2;padding:12px 30px;border-radius:12px;min-width:330px;text-align:center;">
                                Manage Visit Request
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 20px 24px;border-top:1px solid #3d3d3d;font-size:16px;line-height:1.5;color:#c6c6c6;">
                            This is an automated system notification - Bin Al Sheikh Real Estate
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
