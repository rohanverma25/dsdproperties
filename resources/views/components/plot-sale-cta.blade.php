{{--
    Plot sales + verification CTA (30 Oct 2026 focus: Saumitra Vihar, IT City, Wellness City, ₹5,000 verification).
    The three plot cards open WhatsApp directly (hot leads); verification goes to its service page.
    Redesigned 31 Oct 2026: each scheme is its own coloured card with its own line and button text.
    GA4 counts the wa.me clicks as whatsapp_click / generate_lead via partials/ga4.
    Usage: @include('components.plot-sale-cta', ['focus' => 'it-city', 'from' => 'news-story'])
           focus:  saumitra | it-city | wellness | null — that scheme's card is shown first.
           verify: false hides the verification strip (the /news sidebar has its own box).
           plain:  true draws white cards with a coloured edge instead of gradients (the /news list page).
--}}
@php
    $wa = '918595002933';
    $from = $from ?? 'news';
    $verify = $verify ?? true;
    $plain = $plain ?? false;
    $schemes = [
        'saumitra' => [
            'name'  => 'Saumitra Vihar',
            'badge' => 'Awas Vikas · RERA approved',
            'line'  => '2,000+ plots in phase 1',
            'btn'   => 'Get plot details',
            'msg'   => 'Hi, I want to buy a plot in Saumitra Vihar. Please share available plot sizes and rates.',
        ],
        'it-city' => [
            'name'  => 'IT City',
            'badge' => 'LDA scheme',
            'line'  => 'Farmer-quota plots and land-pooling land',
            'btn'   => 'Ask rates & sizes',
            'msg'   => 'Hi, I want to buy a plot in IT City Lucknow. Please share available plots and rates.',
        ],
        'wellness' => [
            'name'  => 'Wellness City',
            'badge' => 'LDA scheme',
            'line'  => 'Available plots and rates in the new scheme',
            'btn'   => 'Check availability',
            'msg'   => 'Hi, I want to buy a plot in Wellness City Lucknow. Please share which plots are available.',
        ],
    ];
    $focus = $focus ?? null;
    if ($focus && isset($schemes[$focus])) {
        $schemes = [$focus => $schemes[$focus]] + $schemes;
    }
@endphp
<div class="psc{{ $plain ? ' psc--plain' : '' }}">
    <div class="psc__head">
        <p class="psc__kicker">Buy a Plot</p>
        <p class="psc__title">Looking to buy a plot?</p>
        <p class="psc__text">Pick a scheme and chat with us directly on WhatsApp.</p>
    </div>
    <div class="psc__list">
        @foreach($schemes as $key => $s)
            <a class="psc__card psc__card--{{ $key }}{{ $key === $focus ? ' psc__card--focus' : '' }}" target="_blank" rel="noopener" data-cta-kind="buy-plot-{{ $key }}"
               href="https://wa.me/{{ $wa }}?text={{ rawurlencode($s['msg'].' (from dsdproperties.in '.$from.')') }}">
                <span class="psc__tags">
                    <span class="psc__badge">{{ $s['badge'] }}</span>
                    @if($key === $focus)<span class="psc__ribbon">In this story</span>@endif
                </span>
                <span class="psc__name">{{ $s['name'] }}</span>
                <span class="psc__line">{{ $s['line'] }}</span>
                <span class="psc__btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.28-.2-.57-.35zM12.05 21.8h-.01a9.87 9.87 0 01-5.03-1.38l-.36-.22-3.74.99 1-3.65-.24-.37a9.86 9.86 0 01-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 012.89 6.99c0 5.45-4.44 9.88-9.88 9.88zm8.41-18.3A11.82 11.82 0 0012.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 005.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.9 0-3.18-1.24-6.17-3.48-8.41z"/></svg>
                    {{ $s['btn'] }}
                    <span class="psc__arrow" aria-hidden="true">→</span>
                </span>
            </a>
        @endforeach
    </div>
    @if($verify)
    <a class="psc__verify" href="{{ url('/services/property-verification-lucknow') }}" data-cta-kind="verify">
        <span class="psc__vicon" aria-hidden="true">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M12 3l7 3v6c0 4.2-3 7.7-7 9-4-1.3-7-4.8-7-9V6l7-3z"/><path d="M9 12l2 2 4-4"/></svg>
        </span>
        <span class="psc__vtext">Buying elsewhere? Full check before you buy for <strong>₹5,000</strong></span>
        <span class="psc__vgo" aria-hidden="true">→</span>
    </a>
    @endif
    <p class="psc__note">Independent resale service; not affiliated with LDA or Awas Vikas.</p>
</div>

@once
<style>
    .psc { background:#fff; border:1px solid #e5e7eb; border-radius:18px; padding:20px; font-family:'Plus Jakarta Sans',sans-serif;
           box-shadow:0 10px 30px -18px rgba(15,31,92,.35); }
    .psc__head { margin-bottom:14px; }
    .psc__kicker { display:inline-block; font-family:'Plus Jakarta Sans',sans-serif; font-size:.64rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase;
                   color:#128C7E; background:#e7f8f2; border-radius:999px; padding:3px 10px; margin:0 0 8px; }
    .psc__title { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.2rem; font-weight:700; color:#0b1e5b; line-height:1.3; margin:0 0 2px; }
    .psc__text { font-size:.9rem; line-height:1.5; color:#6b7280; margin:0; }

    .psc__list { display:grid; grid-template-columns:repeat(auto-fit,minmax(210px,1fr)); gap:10px; }
    .psc__card { position:relative; display:flex; flex-direction:column; gap:2px; padding:14px 16px 14px; border-radius:14px; overflow:hidden;
                 color:#fff !important; text-decoration:none !important; transition:transform .18s, box-shadow .18s; isolation:isolate; }
    .psc__card::after { content:''; position:absolute; right:-28px; top:-28px; width:110px; height:110px; border-radius:50%;
                        background:rgba(255,255,255,.12); z-index:-1; }
    .psc__card:hover { transform:translateY(-2px); box-shadow:0 12px 24px -12px rgba(0,0,0,.45); }
    .psc__card--saumitra { background:linear-gradient(135deg,#6d28d9 0%,#4338ca 100%); }
    .psc__card--it-city  { background:linear-gradient(135deg,#0369a1 0%,#0891b2 100%); }
    .psc__card--wellness { background:linear-gradient(135deg,#047857 0%,#0d9488 100%); }
    .psc__card--focus    { box-shadow:0 0 0 3px #fff, 0 0 0 5px #FF5C00; }
    .psc__tags { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:6px; }
    .psc__ribbon { font-size:.7rem; font-weight:700; background:#FF5C00; color:#fff; border-radius:999px; padding:2px 9px; }
    .psc__badge { font-size:.7rem; font-weight:600; background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.25);
                  border-radius:999px; padding:1px 9px; }
    .psc__name { font-family:'Plus Jakarta Sans',sans-serif; font-size:1.18rem; font-weight:700; line-height:1.3; }
    .psc__line { font-size:.86rem; line-height:1.45; color:rgba(255,255,255,.85); margin-bottom:10px; }
    .psc__btn { display:flex; align-items:center; gap:8px; margin-top:auto; background:#fff; border-radius:10px; padding:8px 12px;
                font-size:.88rem; font-weight:700; }
    .psc__card--saumitra .psc__btn { color:#4338ca; }
    .psc__card--it-city  .psc__btn { color:#0369a1; }
    .psc__card--wellness .psc__btn { color:#047857; }
    .psc__btn svg { color:#25D366; flex-shrink:0; }
    .psc__arrow { margin-left:auto; transition:transform .18s; }
    .psc__card:hover .psc__arrow { transform:translateX(3px); }

    .psc__verify { display:flex; align-items:center; gap:10px; margin-top:12px; padding:11px 14px; border-radius:12px;
                   background:linear-gradient(135deg,#fff4ec,#ffe7d6); border:1px solid #fed7aa; color:#7c2d12 !important; text-decoration:none !important; }
    .psc__verify:hover { border-color:#FF5C00; }
    .psc__vicon { display:flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:9px; background:#FF5C00; color:#fff; flex-shrink:0; }
    .psc__vtext { font-size:.86rem; line-height:1.45; }
    .psc__vtext strong { color:#c2410c; }
    .psc__vgo { margin-left:auto; font-weight:800; color:#FF5C00; }
    .psc__note { font-size:.72rem; color:#9ca3af; margin:12px 0 0; }

    /* Plain variant: white cards, a thin coloured edge, green WhatsApp button text */
    .psc--plain { box-shadow:none; }
    .psc--plain .psc__kicker { background:none; padding:0; color:#64748b; }
    .psc--plain .psc__list { grid-template-columns:minmax(0,1fr); gap:8px; }
    .psc--plain .psc__card { background:#fff; color:#0f172a !important; border:1px solid #e5e7eb; border-left:4px solid var(--psc-c); padding:12px 14px; }
    .psc--plain .psc__card::after { display:none; }
    .psc--plain .psc__card:hover { box-shadow:none; border-color:var(--psc-c); }
    .psc--plain .psc__card--saumitra { --psc-c:#6d28d9; }
    .psc--plain .psc__card--it-city  { --psc-c:#0369a1; }
    .psc--plain .psc__card--wellness { --psc-c:#047857; }
    .psc--plain .psc__badge { background:none; border:none; padding:0; color:#64748b; }
    .psc--plain .psc__name { font-size:1.05rem; }
    .psc--plain .psc__line { color:#64748b; margin-bottom:8px; }
    .psc--plain .psc__btn { background:none; padding:0; color:#128C7E !important; }
    .psc--plain .psc__verify { background:#fff; border-color:#e5e7eb; color:#0f172a !important; }
    .psc--plain .psc__verify:hover { border-color:#FF5C00; }
</style>
@endonce
