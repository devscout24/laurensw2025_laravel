<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Query</title>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f7; color:#333;">
    <table role="presentation" style="width:100%; border-collapse:collapse; background-color:#f4f4f7;">
        <tr>
            <td align="center" style="padding:20px;">
                <table role="presentation"
                    style="max-width:600px; width:100%; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">

                    <!-- Header -->
                    <tr>
                        <td align="center"
                            style="background:#2563eb; padding:20px; color:#ffffff; font-size:20px; font-weight:bold;">
                            📩 New Customer Query
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; font-size:15px; line-height:1.6; color:#333;">
                            <p style="margin:0 0 15px;">Hello Admin,</p>
                            <p style="margin:0 0 15px;">You have received a new customer query. Below are the details:
                            </p>

                            <table role="presentation" style="width:100%; border-collapse:collapse; margin:20px 0;">
                                <tr>
                                    <td style="padding:8px; font-weight:bold; width:120px;">Name:</td>
                                    <td style="padding:8px; background:#f9fafb; border-radius:4px;">{{ $client->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px; font-weight:bold;">Email:</td>
                                    <td style="padding:8px; background:#f9fafb; border-radius:4px;">{{ $client->email }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px; font-weight:bold;">Phone:</td>
                                    <td style="padding:8px; background:#f9fafb; border-radius:4px;">{{ $client->phone }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px; font-weight:bold; vertical-align:top;">Message:</td>
                                    <td style="padding:8px; background:#f9fafb; border-radius:4px;">
                                        {{ $client->message }}</td>
                                </tr>
                            </table>

                            <p style="margin:20px 0 0;">Best Regards,<br><strong>Your Website</strong></p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background:#f1f5f9; padding:15px; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} Polar Traveler. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
