<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inquiry Received – DSD Properties</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif; line-height:1.6; background-color:#f8f9fa; }
        table { border-collapse:collapse; }
        img { border:0; display:block; outline:none; text-decoration:none; }
        .email-wrapper { width:100%; background-color:#f8f9fa; padding:40px 0; }
        .email-container { max-width:600px; margin:0 auto; background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
        .email-header { background-color:#1a1a1a; padding:30px; text-align:center; border-bottom:3px solid #008080; }
        .email-logo img { max-width:160px; height:auto; margin:0 auto 15px; }
        .header-tagline { color:#a0a0a0; font-size:13px; margin:0; letter-spacing:0.5px; }
        .success-badge { background-color:#f0fdf4; border-left:4px solid #22c55e; padding:20px; }
        .success-text { color:#16a34a; font-size:16px; font-weight:600; margin:0; }
        .email-content { padding:35px 30px; }
        .greeting { font-size:24px; color:#1a1a1a; margin:0 0 15px; font-weight:600; }
        .message-text { color:#4b5563; font-size:15px; margin:0 0 25px; line-height:1.7; }
        .property-box { background-color:#f0fdfd; border:1.5px solid #008080; border-radius:8px; padding:18px 20px; margin:20px 0; }
        .property-title { font-size:16px; font-weight:700; color:#008080; margin:0 0 6px; }
        .property-meta { font-size:13px; color:#475569; margin:0; }
        .info-box { background-color:#f8f9fa; border:1px solid #e5e7eb; border-radius:6px; padding:20px; margin:25px 0; }
        .info-title { font-size:14px; font-weight:600; color:#6b7280; margin:0 0 15px; text-transform:uppercase; letter-spacing:0.5px; }
        .info-item { margin:10px 0; color:#1f2937; font-size:15px; display:flex; gap:10px; }
        .info-label { font-weight:600; color:#4b5563; min-width:70px; }
        .message-box { background-color:#fef3c7; border-left:4px solid #f59e0b; border-radius:4px; padding:18px; margin:25px 0; }
        .message-box-title { font-weight:600; color:#92400e; margin:0 0 10px; font-size:14px; }
        .message-box-content { color:#78350f; font-size:14px; line-height:1.6; margin:0; white-space:pre-wrap; }
        .next-steps { background-color:#eff6ff; border-left:4px solid #3b82f6; border-radius:4px; padding:20px; margin:25px 0; }
        .next-steps-title { font-size:16px; font-weight:600; color:#1e40af; margin:0 0 15px; }
        .next-steps-list { margin:0; padding-left:0; list-style:none; }
        .next-steps-list li { padding:8px 0 8px 28px; position:relative; color:#1e3a8a; font-size:14px; }
        .next-steps-list li:before { content:"→"; position:absolute; left:0; color:#3b82f6; font-weight:bold; font-size:16px; }
        .divider { height:1px; background-color:#e5e7eb; margin:25px 0; }
        .contact-info { background-color:#f8f9fa; border-radius:6px; padding:20px; margin:25px 0; }
        .contact-title { font-size:15px; font-weight:600; color:#1a1a1a; margin:0 0 15px; text-align:center; }
        .contact-item td { padding:8px; text-align:center; font-size:14px; }
        .contact-item a { color:#008080; text-decoration:none; font-weight:500; }
        .email-footer { background-color:#1a1a1a; padding:25px; text-align:center; }
        .footer-text { color:#a0a0a0; font-size:13px; margin:8px 0; }
        .footer-links { margin:15px 0; }
        .footer-link { color:#d1d5db; text-decoration:none; margin:0 10px; font-size:13px; }
        @media only screen and (max-width:600px) {
            .email-wrapper { padding:20px 0; }
            .email-content { padding:25px 20px; }
            .greeting { font-size:20px; }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <table role="presentation" class="email-container" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
        <tr>
            <td class="email-header">
                <div class="email-logo">
                    <img src="https://dsdproperties.in/public//images/logo.webp" alt="DSD Properties" />
                </div>
                <p class="header-tagline">LUCKNOW REAL ESTATE INTELLIGENCE</p>
            </td>
        </tr>
        <tr>
            <td class="success-badge">
                <p class="success-text">✅ Inquiry Received Successfully</p>
            </td>
        </tr>
        <tr>
            <td class="email-content">
                <h2 class="greeting">Thank You, {{ $data['name'] }}! 👋</h2>
                <p class="message-text">We've received your inquiry for the property listed below. The seller has been notified and will get in touch with you shortly.</p>

                <div class="property-box">
                    <div class="property-title">{{ $listing->title }}</div>
                    <div class="property-meta">{{ $listing->locality }}{{ $listing->address ? ', ' . $listing->address : '' }} &nbsp;·&nbsp; {{ $listing->getPriceDisplay() }}</div>
                </div>

                <div class="info-box">
                    <div class="info-title">Your Submission Details</div>
                    <div class="info-item"><span class="info-label">Name:</span><span>{{ $data['name'] }}</span></div>
                    <div class="info-item"><span class="info-label">Phone:</span><span>{{ $data['phone'] }}</span></div>
                    @if(!empty($data['email']))
                    <div class="info-item"><span class="info-label">Email:</span><span>{{ $data['email'] }}</span></div>
                    @endif
                </div>

                @if(!empty($data['message']))
                <div class="message-box">
                    <div class="message-box-title">Your Message</div>
                    <p class="message-box-content">{{ $data['message'] }}</p>
                </div>
                @endif

                <div class="next-steps">
                    <div class="next-steps-title">What Happens Next?</div>
                    <ul class="next-steps-list">
                        <li>The seller will be notified of your inquiry</li>
                        <li>You'll be contacted via phone or email within 24 hours</li>
                        <li>Feel free to WhatsApp us if you need immediate assistance</li>
                    </ul>
                </div>

                <div class="divider"></div>

                <div class="contact-info">
                    <div class="contact-title">Need Immediate Assistance?</div>
                    <table class="contact-grid" width="100%">
                        <tr class="contact-item"><td>📞 <a href="tel:+918595002933">+91 8595002933</a></td></tr>
                        <tr class="contact-item"><td>📧 <a href="mailto:dheer@dsdproperties.in">dheer@dsdproperties.in</a></td></tr>
                        <tr class="contact-item"><td>💬 <a href="https://wa.me/918595002933">WhatsApp Us</a></td></tr>
                    </table>
                </div>

                <p class="message-text" style="margin-top:25px;text-align:center;">
                    <strong>Thanks for choosing DSD Properties</strong><br>
                    <span style="color:#6b7280;font-size:14px;">Your Trusted Real Estate Partner in Lucknow</span>
                </p>
            </td>
        </tr>
        <tr>
            <td class="email-footer">
                <p class="footer-text" style="font-weight:600;color:#d1d5db;">DSD Properties</p>
                <p class="footer-text">128/LGE Sanjar Gold Complex, Near Kalindi Park,<br>Vrindavan Sector 2, Lucknow 226025</p>
                <div class="footer-links">
                    <a href="https://dsdproperties.in/" class="footer-link">Home</a>
                    <a href="https://dsdproperties.in/properties" class="footer-link">Properties</a>
                    <a href="https://dsdproperties.in/blog" class="footer-link">Articles</a>
                    <a href="https://dsdproperties.in/contact-us" class="footer-link">Contact</a>
                </div>
                <p class="footer-text" style="font-size:12px;margin-top:15px;">© {{ date('Y') }} DSD Properties. All rights reserved.</p>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
