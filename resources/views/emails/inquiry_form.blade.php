@php
    /**
     * The visitor's thank-you email. Sent from App\Support\LeadNotifier whenever
     * a public form carried an email address — contact-us, blog sidebar, the
     * exit-intent popup and the newsletter box all arrive here.
     *
     * Newsletter signups have no name, phone or message, so every field is
     * optional and the copy switches to a subscription welcome.
     *
     * DARK MODE — the same rules as emails/admin_inquiry.blade.php, for the same
     * reason. Gmail on Android runs its own inversion, ignores the media query
     * and cannot repaint a `background-image`; a dark panel with light text ends
     * up dark-on-dark. So: no gradients, near-white surfaces with dark text, and
     * mid-tone fills (#0f766e, #1faa54) for anything that must keep its colour.
     * The @media block is for the clients that do honour it.
     */
    $name    = $data['full_name']    ?? null;
    $phone   = $data['phone_number'] ?? null;
    $email   = $data['email']        ?? null;
    $message = $data['message']      ?? null;

    $isNewsletter = ($data['source_form'] ?? null) === 'newsletter';
    $firstName    = $name ? explode(' ', trim($name))[0] : null;

    $waUrl  = 'https://wa.me/918595002933';
    $site   = 'https://dsdproperties.in';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>{{ $isNewsletter ? "You're subscribed" : 'Thank you' }} — DSD Properties</title>
    <style>
        :root { color-scheme: light dark; supported-color-schemes: light dark; }

        body { margin:0; padding:0; -webkit-font-smoothing:antialiased; }
        table { border-collapse:collapse; }
        img { border:0; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic; }
        a { text-decoration:none; }

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
            .d-ok     { background-color:#0f2a1c !important; border-color:#1f7a4d !important; }
            .d-ok-t   { color:#6ee7a8 !important; }
            .d-quote  { background-color:#1b2637 !important; border-left-color:#2dd4bf !important; }
            .d-ghost  { background-color:#161f2e !important; border-color:#5eead4 !important; color:#5eead4 !important; }
        }
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
        [data-ogsc] .d-ok     { background-color:#0f2a1c !important; border-color:#1f7a4d !important; }
        [data-ogsc] .d-ok-t   { color:#6ee7a8 !important; }
        [data-ogsc] .d-quote  { background-color:#1b2637 !important; border-left-color:#2dd4bf !important; }
        [data-ogsc] .d-ghost  { background-color:#161f2e !important; border-color:#5eead4 !important; color:#5eead4 !important; }

        @media only screen and (max-width:620px) {
            .sp-pad  { padding:24px 20px !important; }
            .sp-cell { display:block !important; width:100% !important; padding:0 0 10px 0 !important; }
            .sp-btn  { display:block !important; text-align:center !important; margin:0 0 10px 0 !important; }
            .sp-h1   { font-size:23px !important; }
        }
    </style>
</head>
<body class="d-page" style="margin:0;padding:0;background-color:#eef1f6;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">

<div style="display:none;max-height:0;overflow:hidden;opacity:0;">
    @if($isNewsletter)
        You're on the list — honest Lucknow property intelligence, no spam.
    @else
        We've got your enquiry and will reply within one working day.
    @endif
</div>

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="d-page" style="background-color:#eef1f6;padding:32px 16px;">
<tr><td align="center">

<table width="600" cellpadding="0" cellspacing="0" role="presentation" class="d-card" style="max-width:600px;width:100%;background-color:#ffffff;border-radius:14px;">

    <!-- ── ACCENT BAR ── -->
    <tr>
        <td style="background-color:#0f766e;height:5px;line-height:5px;font-size:0;border-radius:14px 14px 0 0;">&nbsp;</td>
    </tr>

    <!-- ── HEADER ── -->
    <tr>
        <td class="d-band sp-pad" align="center" style="background-color:#f5f8fc;padding:28px 36px 24px;">
            {{-- The logo is a light mark, so it needs a dark ground. That ground
                 is the mid-tone brand teal, not near-black: Gmail Android flips
                 near-black to white and a white logo would vanish, while a
                 mid-tone fill is left alone. --}}
            <div style="background-color:#0f766e;border-radius:10px;padding:14px 18px;display:inline-block;">
                <img src="{{ $site }}/public//images/logo.webp" alt="DSD Properties" width="150" style="display:block;max-width:150px;height:auto;">
            </div>
            <div class="d-mut" style="margin-top:14px;font-size:11px;font-weight:700;letter-spacing:2.2px;text-transform:uppercase;color:#5d6e85;">
                Lucknow Real Estate Intelligence
            </div>
        </td>
    </tr>

    <!-- ── CONFIRMATION ── -->
    <tr>
        <td class="sp-pad" style="padding:22px 36px 0;">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="d-ok d-bd" style="background-color:#f0fdf4;border:1px solid #bbe8cd;border-radius:10px;">
                <tr>
                    <td style="padding:13px 18px;">
                        <span class="d-ok-t" style="font-size:14px;font-weight:700;color:#15803d;">
                            @if($isNewsletter)
                                ✓ You're subscribed
                            @else
                                ✓ Enquiry received
                            @endif
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- ── BODY ── -->
    <tr>
        <td class="d-card sp-pad" style="background-color:#ffffff;padding:24px 36px 8px;">

            <h1 class="d-h1 sp-h1" style="margin:0 0 12px;font-size:26px;font-weight:800;color:#0b1f3a;line-height:1.25;letter-spacing:-0.4px;">
                Thank you{{ $firstName ? ', ' . $firstName : '' }}.
            </h1>

            <p class="d-txt" style="margin:0 0 20px;font-size:15px;line-height:1.7;color:#3f4a5a;">
                @if($isNewsletter)
                    You're on the list. From here you'll get the same honest, data-driven
                    read on the Lucknow market that we give our paying clients — what's
                    actually selling, which approvals are real, and where the risk sits.
                    No spam, and you can unsubscribe from any email.
                @else
                    We've received your enquiry and a real person from our team is
                    reading it — not an autoresponder queue. We'll come back to you
                    <strong class="d-h1" style="color:#0b1f3a;">within one working day</strong>
                    with a straight answer.
                @endif
            </p>

            @if(!$isNewsletter && ($name || $phone || $email || $message))
            <!-- What they sent -->
            <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:9px;">What you sent us</div>
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="d-soft d-bd" style="background-color:#f6f9fc;border:1px solid #e1e8f0;border-radius:12px;margin-bottom:22px;">
                @php
                    $rows = array_values(array_filter([
                        ['Name',  $name],
                        ['Phone', $phone],
                        ['Email', $email],
                    ], fn ($r) => !empty($r[1])));
                @endphp
                @foreach($rows as $i => [$label, $value])
                <tr>
                    <td class="d-bd" style="padding:10px 16px;border-top:{{ $i === 0 ? '0' : '1px' }} solid #e6ecf4;width:76px;vertical-align:top;">
                        <span class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;color:#7c8aa0;">{{ $label }}</span>
                    </td>
                    <td class="d-bd" style="padding:10px 16px 10px 0;border-top:{{ $i === 0 ? '0' : '1px' }} solid #e6ecf4;">
                        <span class="d-txt" style="font-size:14px;color:#1f2937;word-break:break-word;">{{ $value }}</span>
                    </td>
                </tr>
                @endforeach
            </table>
            @endif

            @if($message)
            <div class="d-quote" style="background-color:#f6f9fc;border-left:4px solid #0f766e;border-radius:0 10px 10px 0;padding:16px 18px;margin-bottom:22px;">
                <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:7px;">Your message</div>
                <div class="d-txt" style="font-size:14px;color:#1f2937;line-height:1.7;white-space:pre-wrap;">{{ $message }}</div>
            </div>
            @endif

            @unless($isNewsletter)
            <!-- What happens next -->
            <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:10px;">What happens next</div>
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:24px;">
                @foreach([
                    ['1', 'We read it properly', 'An advisor goes through your requirement — no call-centre script.'],
                    ['2', 'We reply within a working day', 'By phone or email, whichever suits you. Tell us if one is easier.'],
                    ['3', 'You get a straight answer', 'Including when the honest answer is that a property is not worth it.'],
                ] as $step)
                <tr>
                    <td width="30" valign="top" style="padding:0 12px 14px 0;">
                        <div style="width:26px;height:26px;background-color:#0f766e;border-radius:13px;color:#ffffff;font-size:13px;font-weight:700;text-align:center;line-height:26px;">{{ $step[0] }}</div>
                    </td>
                    <td valign="top" style="padding:0 0 14px;">
                        <div class="d-h1" style="font-size:14px;font-weight:700;color:#0b1f3a;line-height:1.4;">{{ $step[1] }}</div>
                        <div class="d-mut" style="font-size:13px;color:#5d6e85;line-height:1.6;margin-top:2px;">{{ $step[2] }}</div>
                    </td>
                </tr>
                @endforeach
            </table>
            @endunless

            <!-- Need us sooner -->
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="d-soft d-bd" style="background-color:#f1faf6;border:1px solid #bfe6d5;border-radius:12px;margin-bottom:24px;">
                <tr>
                    <td class="sp-pad" style="padding:20px;">
                        <div class="d-h1" style="font-size:17px;font-weight:800;color:#0b3a2a;line-height:1.3;">
                            @if($isNewsletter) Have a property question already? @else Need us sooner? @endif
                        </div>
                        <div class="d-mut" style="font-size:13px;color:#5c8976;margin-top:5px;line-height:1.6;">
                            WhatsApp is the fastest way to reach us — usually within the hour.
                        </div>
                        <div style="margin-top:16px;">
                            <a href="{{ $waUrl }}" class="sp-btn" style="display:inline-block;background-color:#1faa54;color:#ffffff;font-size:14px;font-weight:700;padding:13px 24px;border-radius:9px;">WhatsApp us</a>
                            &nbsp;
                            <a href="tel:+918595002933" class="sp-btn" style="display:inline-block;background-color:#0f766e;color:#ffffff;font-size:14px;font-weight:700;padding:13px 24px;border-radius:9px;">+91 85950 02933</a>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- Services -->
            <div class="d-mut" style="font-size:10px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#7c8aa0;margin-bottom:10px;">How we can help</div>
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin-bottom:8px;">
                <tr>
                    @foreach([
                        ['🛡️', 'Property Verification', 'Title, approvals and encumbrance checked before you pay. From ₹5,000.', $site . '/contact-us'],
                        ['🎯', 'Property Advisory',    'What to buy, what to avoid, what it is really worth. First call free.', $site . '/contact-us'],
                    ] as $i => $svc)
                    <td width="50%" class="sp-cell" valign="top" style="padding:{{ $i === 0 ? '0 6px 0 0' : '0 0 0 6px' }};">
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation" class="d-card d-bd" style="background-color:#ffffff;border:1px solid #e1e8f0;border-radius:12px;">
                            <tr><td style="padding:16px;">
                                <div style="font-size:22px;line-height:1;">{{ $svc[0] }}</div>
                                <div class="d-h1" style="font-size:15px;font-weight:700;color:#0b1f3a;margin-top:8px;">{{ $svc[1] }}</div>
                                <div class="d-mut" style="font-size:12.5px;color:#5d6e85;line-height:1.6;margin-top:5px;">{{ $svc[2] }}</div>
                                <a href="{{ $svc[3] }}" class="d-accent" style="display:inline-block;margin-top:10px;font-size:12.5px;font-weight:700;color:#0f766e;">Enquire →</a>
                            </td></tr>
                        </table>
                    </td>
                    @endforeach
                </tr>
            </table>

            <!-- Explore -->
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin:14px 0 4px;">
                <tr>
                    @foreach([
                        ['🏛️', 'RERA Projects', $site . '/rera-approved-projects-lucknow'],
                        ['🏗️', 'LDA Schemes',   $site . '/lda-schemes'],
                    ] as $i => $link)
                    <td width="50%" class="sp-cell" valign="top" style="padding:{{ $i === 0 ? '0 6px 0 0' : '0 0 0 6px' }};">
                        <a href="{{ $link[2] }}" class="d-soft d-bd d-accent" style="display:block;background-color:#f6f9fc;border:1px solid #e1e8f0;border-radius:10px;padding:13px 16px;font-size:13.5px;font-weight:700;color:#0f766e;">
                            {{ $link[0] }}&nbsp; {{ $link[1] }} →
                        </a>
                    </td>
                    @endforeach
                </tr>
            </table>

            <!-- Read while you wait -->
            <div style="text-align:center;margin:22px 0 4px;">
                <a href="{{ $site }}/blog" class="d-ghost" style="display:inline-block;background-color:#ffffff;border:1px solid #0f766e;color:#0f766e;font-size:13.5px;font-weight:700;padding:11px 24px;border-radius:9px;">Read our Lucknow market articles</a>
            </div>

        </td>
    </tr>

    <!-- ── SIGN-OFF ── -->
    <tr>
        <td class="d-card sp-pad" style="background-color:#ffffff;padding:22px 36px 26px;">
            <div class="d-bd" style="border-top:1px solid #e6ecf4;padding-top:20px;">
                <div class="d-txt" style="font-size:14px;color:#3f4a5a;line-height:1.7;">
                    Talk soon,<br>
                    <strong class="d-h1" style="color:#0b1f3a;">The DSD Properties team</strong>
                </div>
                <div class="d-mut" style="font-size:13px;color:#5d6e85;margin-top:10px;">
                    📧 <a href="mailto:dheer@dsdproperties.in" class="d-accent" style="color:#0f766e;font-weight:600;">dheer@dsdproperties.in</a>
                    &nbsp;·&nbsp;
                    📞 <a href="tel:+918595002933" class="d-accent" style="color:#0f766e;font-weight:600;">+91 85950 02933</a>
                </div>
            </div>
        </td>
    </tr>

    <!-- ── FOOTER ── -->
    <tr>
        <td class="d-band d-bd sp-pad" align="center" style="background-color:#f5f8fc;border-top:1px solid #e6ecf4;border-radius:0 0 14px 14px;padding:22px 36px 26px;">

            <div class="d-h1" style="font-size:13px;font-weight:700;color:#0b1f3a;">DSD Properties</div>
            <div class="d-mut" style="font-size:12px;color:#5d6e85;line-height:1.6;margin-top:6px;">
                128/LGE Sanjar Gold Complex, Near Kalindi Park,<br>
                Vrindavan Sector 2, Lucknow 226025
            </div>

            <div style="margin:14px 0 4px;font-size:12.5px;">
                @foreach([
                    ['Home', $site . '/'], ['About', $site . '/about'], ['Articles', $site . '/blog'],
                    ['RERA', $site . '/rera-approved-projects-lucknow'], ['LDA', $site . '/lda-schemes'],
                    ['Contact', $site . '/contact-us'],
                ] as $i => $f)
                    @if($i > 0)<span class="d-faint" style="color:#b6c0cd;">·</span>@endif
                    <a href="{{ $f[1] }}" class="d-accent" style="color:#0f766e;font-weight:600;padding:0 5px;">{{ $f[0] }}</a>
                @endforeach
            </div>

            <div class="d-faint" style="font-size:11px;color:#8492a6;margin-top:14px;line-height:1.6;">
                © {{ date('Y') }} DSD Properties. All rights reserved.<br>
                @if($isNewsletter)
                    {{-- The /unsubscribe route only clears rows in the legacy `leads`
                         table, not `form_submissions` newsletter rows, so linking it
                         here would dead-end on "email not found". Reply-to works
                         today; swap in a real link once that route handles these. --}}
                    You're receiving this because you subscribed on dsdproperties.in.
                    To stop, reply to this email with "unsubscribe".
                @else
                    You're receiving this because you submitted a form on dsdproperties.in.
                @endif
            </div>

        </td>
    </tr>

</table>

</td></tr>
</table>

</body>
</html>
