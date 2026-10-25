
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>CodeBaseCoders Introduction</title>
</head>
<body style="margin:0; padding:0; background-color:#f6f7f9; font-family: Arial, Helvetica, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; padding:40px; border-radius:6px; border:1px solid #eaeaea;">
          
          <!-- Header -->
          <tr>
            <td style="font-size:16px; color:#333333; line-height:1.6;">
              <p style="margin-top:0;">Hi {{ ucwords(strtolower($lead->name ?? 'there')) }},</p>
              
              {!! $content !!}
              <p style="margin-bottom:0;">
                Best regards,<br>
                <strong>CodeBaseCoders</strong>
              </p>

              <!-- Footer -->
              <p style="margin-top:8px; font-size:14px;">
                🌐 <a href="https://codebasecoders.com" style="color:#1a73e8; text-decoration:none;">https://codebasecoders.com</a><br>
                📧 <a href="mailto:sales@codebasecoders.com" style="color:#1a73e8; text-decoration:none;">sales@codebasecoders.com</a>
              </p>
              <hr style="margin:20px 0; border:none; border-top:1px solid #ddd;">

              <p style="font-size:12px; color:#777;">
              You’re receiving this email because we believe our services may be relevant to your business.<br>
              If you’d prefer not to receive future emails from us, simply reply with <a href="https://dsdproperties.in/unsubscribe?email={{ urlencode($lead->email ?? '') }}" target="_blank"><strong>“unsubscribe”</strong></a> and we’ll remove you from our list.
              </p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
