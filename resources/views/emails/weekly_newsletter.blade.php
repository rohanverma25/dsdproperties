{{-- Weekly newsletter email (English). Table layout + inline styles so Gmail/Outlook render it the same.
     The /news stories are in Hindi, so each campaign stores an English headline + summary per story ($c->itemFor()).
     Built by App\Mail\WeeklyNewsletter. --}}
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light">
<title>{{ $c->subject }}</title>
</head>
<body style="margin:0;padding:0;background:#eef2f7;">
@php $first = $stories->first(); @endphp
<div style="display:none;max-height:0;overflow:hidden;opacity:0;">{{ $stories->count() }} Lucknow property updates, {{ $weekLabel }}{{ $first ? ': ' . $c->itemFor($first)['title'] : '' }}</div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef2f7;">
<tr><td align="center" style="padding:24px 12px;">
  <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;background:#ffffff;border-radius:14px;overflow:hidden;font-family:Arial,Helvetica,'Nirmala UI',sans-serif;color:#1f2937;">
    {{-- Masthead --}}
    <tr><td style="background:#011f4b;padding:22px 26px;">
      <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#99d6d6;font-weight:bold;">DSD Properties · Weekly Report</div>
      <div style="font-size:24px;line-height:1.3;color:#ffffff;font-weight:bold;margin-top:6px;">Lucknow Real Estate This Week</div>
      <div style="font-size:14px;color:#cbd5e1;margin-top:4px;">{{ $weekLabel }} · {{ $stories->count() }} {{ $stories->count() === 1 ? 'update' : 'updates' }}</div>
    </td></tr>

    <tr><td style="padding:22px 26px 6px;font-size:15px;line-height:1.7;">
      Hi{{ $name ? ' ' . e($name) : '' }},<br>
      {!! $c->intro ? nl2br(e($c->intro)) : 'Here are this week\'s Lucknow property updates that matter if you are buying, selling or investing: LDA schemes, plots, registry and RERA. Every story is checked against the original report.' !!}
    </td></tr>

    {{-- Stories --}}
    @foreach($stories as $i => $s)
    @php $it = $c->itemFor($s); $url = $track($s->url . '?' . $utm . '&utm_content=story' . ($i + 1), 'story' . ($i + 1)); @endphp
    <tr><td style="padding:14px 26px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e2e8f0;border-radius:12px;">
        <tr><td style="padding:16px 18px;">
          <div style="font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#008080;font-weight:bold;">{{ $s->category_label }} · {{ $s->created_at->format('j M') }}</div>
          <a href="{{ $url }}" style="display:block;font-size:17px;line-height:1.45;color:#011f4b;font-weight:bold;text-decoration:none;margin:6px 0 8px;">{{ $it['title'] }}</a>
          <div style="font-size:14px;line-height:1.7;color:#4b5563;">{{ \Illuminate\Support\Str::limit($it['summary'], 230) }}</div>
          <a href="{{ $url }}" style="display:inline-block;margin-top:10px;font-size:14px;color:#FF5C00;font-weight:bold;text-decoration:none;">Read the full story →</a>
          <span style="font-size:12px;color:#94a3b8;">&nbsp;(article in Hindi)</span>
        </td></tr>
      </table>
    </td></tr>
    @endforeach

    @if($stories->isEmpty())
    <tr><td style="padding:14px 26px;font-size:15px;color:#4b5563;">No new updates this week.</td></tr>
    @endif

    {{-- Week page --}}
    <tr><td align="center" style="padding:10px 26px 6px;">
      <a href="{{ $track($weekUrl, 'week') }}" style="display:inline-block;background:#011f4b;color:#ffffff;font-size:15px;font-weight:bold;text-decoration:none;padding:12px 22px;border-radius:10px;">See all of this week's updates</a>
    </td></tr>

    {{-- Offer --}}
    <tr><td style="padding:18px 26px;">
      <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;">
        <tr><td style="padding:16px 18px;font-size:14px;line-height:1.7;color:#7c2d12;">
          <strong style="font-size:15px;color:#011f4b;">Buying a plot or flat in Lucknow?</strong><br>
          Get the papers checked before you pay: khatauni, registry chain, LDA and RERA records. <strong>₹5,000, PDF report in 48 hours.</strong><br>
          <a href="{{ $track(url('/services/property-verification-lucknow') . '?' . $utm . '&utm_content=verify', 'verify') }}" style="color:#FF5C00;font-weight:bold;">See what we check →</a>
          &nbsp;·&nbsp;
          <a href="{{ $track('https://wa.me/918595002933?text=' . rawurlencode('Hi, I read the DSD Properties weekly email. I would like to talk about a property.'), 'whatsapp') }}" style="color:#008080;font-weight:bold;">Chat on WhatsApp</a>
        </td></tr>
      </table>
    </td></tr>

    {{-- Language preference --}}
    <tr><td style="padding:0 26px 14px;font-size:13px;color:#4b5563;line-height:1.7;">
      Which language do you prefer for this email?
      <a href="{{ $prefEnglish }}" style="color:#008080;font-weight:bold;">English</a> ·
      <a href="{{ $prefHindi }}" style="color:#008080;font-weight:bold;">हिंदी (Hindi)</a>
    </td></tr>

    {{-- Footer --}}
    <tr><td style="padding:16px 26px 24px;border-top:1px solid #e2e8f0;font-size:12px;line-height:1.7;color:#6b7280;">
      You are receiving this because you contacted us or signed up on dsdproperties.in.<br>
      DSD Properties, Lucknow · <a href="{{ $track(url('/') . '?' . $utm . '&utm_content=footer', 'home') }}" style="color:#008080;">dsdproperties.in</a><br>
      Don't want these emails? <a href="{{ $unsubscribe }}" style="color:#6b7280;text-decoration:underline;">Unsubscribe</a> in one click.
    </td></tr>
  </table>
</td></tr>
</table>
@if($pixel)<img src="{{ $pixel }}" width="1" height="1" alt="" style="display:block;width:1px;height:1px;border:0;">@endif
</body>
</html>
