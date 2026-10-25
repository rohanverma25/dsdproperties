@php
    /**
     * Admin notification for every public form submission.
     *
     * Reads the normalised payload from App\Support\LeadNotifier, so newsletter
     * rows (email only, no name or phone) render as happily as a full enquiry.
     *
     * DARK MODE — why this template looks the way it does.
     * Gmail's Android client runs its own colour inversion and it is not
     * negotiable: it flips near-white surfaces and near-black text, leaves
     * mid-tone colours alone, and *cannot* touch a `background-image`. An
     * earlier version used dark navy/green panels with white text built on
     * linear-gradients — Gmail darkened the text but left the gradients, so the
     * headline rendered dark-on-dark. So:
     *   - no linear-gradient anywhere, ever; solid `background-color` only
     *   - no large dark panel with light text; surfaces stay near-white so the
     *     client flips surface and text together
     *   - accents are mid-tone (#0f766e, #1faa54) and survive inversion as-is
     *   - buttons carry a mid-tone fill, never white-on-dark
     * The @media block below then styles the dark theme properly for the
     * clients that do honour it (Apple Mail, Outlook, iOS Gmail).
     */
    $name      = $data['full_name']    ?? null;
    $email     = $data['email']        ?? null;
    $rawPhone  = $data['phone_number'] ?? null;
    $message   = $data['message']      ?? null;
    $formLabel = $data['form_label']   ?? 'Website Form';
    $sourceKey = $data['source_form']  ?? null;

    $phone   = $rawPhone ? preg_replace('/\D/', '', $rawPhone) : null;
    $waPhone = $phone ? (strlen($phone) === 10 ? '91' . $phone : $phone) : null;
    $waUrl   = null;

    if ($waPhone) {
        $waUrl = 'https://wa.me/' . $waPhone . '?text=' . rawurlencode(
            'Hi' . ($name ? ' ' . explode(' ', $name)[0] : '') . ', thanks for reaching out to DSD Properties. '
            . "I'm following up on your enquiry."
        );
    }

    $sourcePage   = !empty($data['page_url'])     ? $data['page_url']     : null;
    $referrerPage = !empty($data['referrer_url']) ? $data['referrer_url'] : null;
    $ip           = $data['ip_address']   ?? null;
    $submittedAt  = $data['submitted_at'] ?? now();
    $submissionId = $data['submission_id'] ?? null;

    // A one-word urgency read: a submission that captured a phone number is
    // actionable today; a newsletter signup is not. Shown as the header badge.
    $isActionable = (bool) $phone;

    // Deep-link into the admin inbox, pre-searched for this person.
    $adminSearch = $email ?: ($rawPhone ?: $name);
    $adminUrl    = $adminSearch ? route('admin.enquiries.index', ['q' => $adminSearch]) : null;

    $stamp = \Illuminate\Support\Carbon::parse($submittedAt)->timezone('Asia/Kolkata');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="color-scheme" content="light dark">
  <meta name="supported-color-schemes" content="light dark">
  <title>New Lead — DSD Properties</title>
  <style>
    :root { color-scheme: light dark; supported-color-schemes: light dark; }

    /* Clients that honour the media query get a hand-tuned dark theme.
       Gmail Android ignores this and does its own inversion — the light-first
       markup in the body is what keeps that case readable. */
    @media (prefers-color-scheme: dark) {
      .d-page   { background-color:#0d1420 !important; }
      .d-card   { background-color:#161f2e !important; }
      .d-band   { background-color:#1b2637 !important; }
      .d-soft   { background-color:#1b2637 !important; }
      .d-bd     { border-color:#2c3a4f !important; }
      .d-h1     { color:#ffffff !important; }
      .d-txt    { color:#dbe3ec !important; }
      .d-mut    { color:#9aa8ba !important; }
      .d-faint  { color:#7a8798 !important; }
      .d-accent { color:#5eead4 !important; }
      .d-quote  { background-color:#1b2637 !important; border-left-color:#2dd4bf !important; }
      .d-hot    { background-color:#3a2412 !important; border-color:#8a4a12 !important; color:#ffb27a !important; }
      .d-cool   { background-color:#122a3a !important; border-color:#1d5170 !important; color:#7dd3fc !important; }
    }
    /* Outlook.com's hook. */
    [data-ogsc] .d-page   { background-color:#0d1420 !important; }
    [data-ogsc] .d-card   { background-color:#161f2e !important; }
    [data-ogsc] .d-band   { background-color:#1b2637 !important; }
    [data-ogsc] .d-soft   { background-color:#1b2637 !important; }
    [data-ogsc] .d-bd     { border-color:#2c3a4f !important; }
    [data-ogsc] .d-h1     { color:#ffffff !important; }
    [data-ogsc] .d-txt    { color:#dbe3ec !important; }
    [data-ogsc] .d-mut    { color:#9aa8ba !important; }
    [data-ogsc] .d-faint  { color:#7a8798 !important; }
    [data-ogsc] .d-accent { color:#5eead4 !important; }
    [data-ogsc] .d-quote  { background-color:#1b2637 !important; border-left-color:#2dd4bf !important; }
    [data-ogsc] .d-hot    { background-color:#3a2412 !important; border-color:#8a4a12 !important; color:#ffb27a !important; }
    [data-ogsc] .d-cool   { background-color:#122a3a !important; border-color:#1d5170 !important; color:#7dd3fc !important; }

    @media only screen and (max-width:620px) {
      .sp-pad  { padding:22px 18px !important; }
      .sp-cell { display:block !important; width:100% !important; padding:0 0 10px 0 !important; }
      .sp-btn  { display:block !important; text-align:center !important; margin:0 0 10px 0 !important; }
      .sp-h1   { font-size:22px !important; }
    }
  </style>
</head>
<body class="d-page" style="margin:0;padding:0;background-color:#eef1f6;font-family:'Segoe UI',Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<div style="display:none;max-height:0;overflow:hidden;opacity:0;">
  {{ $formLabel }} · {{ $name ?: $email }}{{ $rawPhone ? ' · ' . $rawPhone : '' }}{{ $message ? ' · ' . \Illuminate\Support\Str::limit($message, 90) : '' }}
</div>

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="d-page" style="background-color:#eef1f6;padding:32px 16px;">
<tr><td align="center">

  <table width="600" cellpadding="0" cellspacing="0" role="presentation" class="d-card" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:14px;">

    <!-- ── ACCENT BAR — a mid-tone strip survives inversion untouched ── -->
    <tr>
      <td style="background-color:#0f766e;height:5px;line-height:5px;font-size:0;border-radius:14px 14px 0 0;">&nbsp;</td>
    </tr>

    <!-- ── HEADER ── -->
    <tr>
      <td class="d-band sp-pad" style="background-color:#f5f8fc;padding:26px 36px 24px;">

        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:#6b7c93;">DSD Properties</td>
            <td align="right">
              @if($isActionable)
                <span class="d-hot" style="display:inline-block;background-color:#fff1e6;border:1px solid #f7c9a4;border-radius:20px;padding:5px 12px;font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#b5480a;">🔥 Call-ready lead</span>
              @else
                <span class="d-cool" style="display:inline-block;background-color:#e8f4fd;border:1px solid #a9d3f0;border-radius:20px;padding:5px 12px;font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#0b5c8a;">✉️ Email-only</span>
              @endif
            </td>
          </tr>
        </table>

        <div class="d-h1 sp-h1" style="margin-top:16px;font-size:26px;font-weight:800;color:#0b1f3a;line-height:1.25;letter-spacing:-0.4px;">
          {{ $name ?: ($email ?: 'New submission') }}
        </div>
        <div class="d-mut" style="margin-top:7px;font-size:13px;color:#5d6e85;">
          via <strong class="d-txt" style="color:#0b1f3a;font-weight:700;">{{ $formLabel }}</strong>
          · {{ $stamp->format('d M Y, h:i A') }} IST
        </div>

        <!-- Contact strip: white cards, dark text — inverts cleanly as a pair -->
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-top:18px;">
          <tr>
            <td width="50%" class="sp-cell" style="padding-right:6px;vertical-align:top;">
              <div class="d-card d-bd" style="background-color:#ffffff;border:1px solid #dce5f0;border-radius:10px;padding:11px 14px;">
                <div class="d-mut" style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:4px;">Phone</div>
                @if($rawPhone)
                  <a href="tel:+{{ $waPhone }}" class="d-h1" style="font-size:15px;font-weight:700;color:#0b1f3a;text-decoration:none;">{{ $rawPhone }}</a>
                @else
                  <span class="d-faint" style="font-size:14px;font-weight:600;color:#9aa6b6;">Not provided</span>
                @endif
              </div>
            </td>
            <td width="50%" class="sp-cell" style="padding-left:6px;vertical-align:top;">
              <div class="d-card d-bd" style="background-color:#ffffff;border:1px solid #dce5f0;border-radius:10px;padding:11px 14px;">
                <div class="d-mut" style="font-size:9px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:4px;">Email</div>
                @if($email)
                  <a href="mailto:{{ $email }}" class="d-accent" style="font-size:13px;font-weight:600;color:#0f766e;text-decoration:none;word-break:break-all;">{{ $email }}</a>
                @else
                  <span class="d-faint" style="font-size:14px;font-weight:600;color:#9aa6b6;">Not provided</span>
                @endif
              </div>
            </td>
          </tr>
        </table>

      </td>
    </tr>

    <!-- ── BODY ── -->
    <tr>
      <td class="d-card sp-pad" style="background-color:#ffffff;padding:26px 36px;">

        @if($message)
        <div class="d-quote" style="background-color:#f6f9fc;border-left:4px solid #0f766e;border-radius:0 10px 10px 0;padding:16px 18px;margin-bottom:24px;">
          <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:7px;">Their message</div>
          <div class="d-txt" style="font-size:14px;color:#1f2937;line-height:1.7;white-space:pre-wrap;">{{ $message }}</div>
        </div>
        @endif

        <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:9px;">Submission details</div>
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="d-soft d-bd" style="background-color:#f6f9fc;border:1px solid #e1e8f0;border-radius:12px;margin-bottom:24px;">
          @php
            $rows = [
              ['Form',         $formLabel . ($sourceKey ? ' (' . $sourceKey . ')' : '')],
              ['Submitted on', $sourcePage],
              ['Came from',    $referrerPage ?: 'Direct visit — no referring page'],
              ['IP address',   $ip],
              ['Reference',    $submissionId ? '#' . $submissionId : null],
            ];
            $rows = array_values(array_filter($rows, fn ($r) => !empty($r[1])));
          @endphp
          @foreach($rows as $i => [$label, $value])
            <tr>
              <td class="d-bd" style="padding:10px 16px;border-top:{{ $i === 0 ? '0' : '1px' }} solid #e6ecf4;width:120px;vertical-align:top;">
                <span class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;color:#7c8aa0;">{{ $label }}</span>
              </td>
              <td class="d-bd" style="padding:10px 16px 10px 0;border-top:{{ $i === 0 ? '0' : '1px' }} solid #e6ecf4;font-size:13px;word-break:break-word;">
                @if(\Illuminate\Support\Str::startsWith($value, 'http'))
                  <a href="{{ $value }}" class="d-accent" style="color:#0f766e;text-decoration:none;">{{ $value }}</a>
                @else
                  <span class="d-txt" style="color:#1f2937;">{{ $value }}</span>
                @endif
              </td>
            </tr>
          @endforeach
        </table>

        <!-- Actions. Mid-tone fills only — Gmail leaves these alone. -->
        @if($waUrl)
        <div class="d-soft d-bd" style="background-color:#f1faf6;border:1px solid #bfe6d5;border-radius:12px;padding:20px;">
          <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.8px;text-transform:uppercase;color:#4b7f68;margin-bottom:5px;">Reply directly</div>
          <div class="d-h1" style="font-size:18px;font-weight:800;color:#0b3a2a;line-height:1.3;">
            Reach {{ $name ? explode(' ', $name)[0] : 'this lead' }} now
          </div>
          <div class="d-mut" style="font-size:12px;color:#5c8976;margin-top:5px;">Pre-filled WhatsApp message · one tap</div>
          <div style="margin-top:16px;">
            <a href="{{ $waUrl }}" class="sp-btn" style="display:inline-block;background-color:#1faa54;color:#ffffff;font-size:14px;font-weight:700;padding:13px 26px;border-radius:9px;text-decoration:none;">Open WhatsApp&nbsp;→</a>
            &nbsp;
            <a href="tel:+{{ $waPhone }}" class="sp-btn" style="display:inline-block;background-color:#0f766e;color:#ffffff;font-size:14px;font-weight:700;padding:13px 24px;border-radius:9px;text-decoration:none;">Call now</a>
          </div>
        </div>
        @elseif($email)
        <div class="d-soft d-bd" style="background-color:#eff7fe;border:1px solid #bcdcf5;border-radius:12px;padding:20px;">
          <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.8px;text-transform:uppercase;color:#4a7a9b;margin-bottom:5px;">No phone number given</div>
          <div class="d-h1" style="font-size:17px;font-weight:800;color:#0b2f4a;line-height:1.35;">Email is the only way to reach them</div>
          <div style="margin-top:16px;">
            <a href="mailto:{{ $email }}" class="sp-btn" style="display:inline-block;background-color:#1668a8;color:#ffffff;font-size:14px;font-weight:700;padding:13px 26px;border-radius:9px;text-decoration:none;">Reply by email&nbsp;→</a>
          </div>
        </div>
        @endif

        @if($adminUrl)
        <div style="margin-top:18px;text-align:center;">
          <a href="{{ $adminUrl }}" class="d-faint" style="font-size:12px;color:#8492a6;text-decoration:underline;">Open in the admin inbox</a>
        </div>
        @endif

      </td>
    </tr>

    <!-- ── FOOTER ── -->
    <tr>
      <td class="d-band d-bd sp-pad" style="background-color:#f5f8fc;border-radius:0 0 14px 14px;border-top:1px solid #e6ecf4;padding:16px 36px;">
        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
          <tr>
            <td class="d-faint" style="font-size:11px;color:#8492a6;line-height:1.6;">
              ⚡ Contact this lead as soon as possible.<br>
              Sent automatically by <a href="https://dsdproperties.in" class="d-accent" style="color:#0f766e;text-decoration:none;">dsdproperties.in</a>
            </td>
            <td align="right" class="d-faint" style="font-size:11px;color:#a8b3c2;white-space:nowrap;">
              {{ $stamp->format('d M Y') }}
            </td>
          </tr>
        </table>
      </td>
    </tr>

  </table>
</td></tr>
</table>

</body>
</html>
