<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Property Inquiry</title>
</head>
<body style="font-family:Arial,sans-serif;font-size:15px;color:#1f2937;background:#f8f9fa;padding:30px 0;">
<table width="600" cellspacing="0" cellpadding="0" border="0" align="center" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);">
    <tr>
        <td style="background:#1a1a1a;padding:24px;text-align:center;border-bottom:3px solid #008080;">
            <p style="color:#fff;font-size:20px;font-weight:700;margin:0;">🔥 New Property Inquiry</p>
            <p style="color:#a0a0a0;font-size:13px;margin:6px 0 0;">DSD Properties – Admin Notification</p>
        </td>
    </tr>
    <tr>
        <td style="padding:28px 30px;">

            <p style="margin:0 0 20px;font-size:15px;color:#374151;">A buyer has submitted an inquiry for the following property:</p>

            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f0fdfd;border:1.5px solid #008080;border-radius:8px;margin-bottom:24px;">
                <tr>
                    <td style="padding:16px 20px;">
                        <p style="font-size:17px;font-weight:700;color:#008080;margin:0 0 6px;">{{ $listing->title }}</p>
                        <p style="font-size:13px;color:#475569;margin:0;">
                            {{ $listing->locality }}{{ $listing->address ? ', ' . $listing->address : '' }}
                            &nbsp;·&nbsp; {{ $listing->getPriceDisplay() }}
                            &nbsp;·&nbsp; {{ ucfirst($listing->transaction_type) }}
                        </p>
                        <p style="margin:10px 0 0;">
                            <a href="https://dsdproperties.in/properties/{{ $listing->slug }}" style="color:#008080;font-size:13px;">View Listing →</a>
                        </p>
                    </td>
                </tr>
            </table>

            <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f8f9fa;border:1px solid #e5e7eb;border-radius:6px;margin-bottom:24px;">
                <tr><td style="padding:16px 20px;">
                    <p style="font-size:13px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin:0 0 14px;">Buyer Details</p>
                    <p style="margin:8px 0;"><strong>Name:</strong> {{ $data['name'] }}</p>
                    <p style="margin:8px 0;"><strong>Phone:</strong> <a href="tel:{{ $data['phone'] }}" style="color:#008080;">{{ $data['phone'] }}</a></p>
                    <p style="margin:8px 0;"><strong>Email:</strong>
                        @if(!empty($data['email']))
                            <a href="mailto:{{ $data['email'] }}" style="color:#008080;">{{ $data['email'] }}</a>
                        @else
                            <span style="color:#9ca3af;">Not provided</span>
                        @endif
                    </p>
                    @if(!empty($data['message']))
                    <p style="margin:14px 0 0;"><strong>Message:</strong></p>
                    <p style="background:#fef3c7;border-left:4px solid #f59e0b;border-radius:4px;padding:12px;color:#78350f;font-size:14px;margin:8px 0 0;white-space:pre-wrap;">{{ $data['message'] }}</p>
                    @endif
                </td></tr>
            </table>

            <p style="font-size:13px;color:#6b7280;margin:0 0 6px;"><strong>Time:</strong> {{ now()->format('d M Y, h:i A') }}</p>
            <p style="font-size:13px;color:#6b7280;margin:0 0 20px;"><strong>IP:</strong> {{ request()->ip() }}</p>

            @php
                $wa = "New Property Inquiry:%0A"
                    . "Property: " . $listing->title . "%0A"
                    . "Name: " . $data['name'] . "%0A"
                    . "Phone: " . $data['phone'] . "%0A"
                    . "Email: " . ($data['email'] ?? 'N/A') . "%0A"
                    . "Message: " . ($data['message'] ?? 'N/A');
            @endphp

            <p>
                <a href="https://wa.me/918595002933?text={{ $wa }}" target="_blank"
                   style="display:inline-block;background:#25D366;color:#fff;padding:12px 22px;border-radius:6px;text-decoration:none;font-weight:600;font-size:14px;">
                    💬 Send to Team WhatsApp
                </a>
            </p>

            <p style="margin-top:20px;color:#dc2626;font-weight:600;">⚡ Action Required: Contact this lead ASAP</p>
        </td>
    </tr>
    <tr>
        <td style="background:#1a1a1a;padding:18px;text-align:center;">
            <p style="color:#a0a0a0;font-size:12px;margin:0;">© {{ date('Y') }} DSD Properties · Internal Admin Notification</p>
        </td>
    </tr>
</table>
</body>
</html>
