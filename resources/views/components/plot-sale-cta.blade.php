{{--
    Plot sales + verification CTA (30 Oct 2026 focus: Saumitra Vihar, IT City, Wellness City, ₹5,000 verification).
    The three plot buttons open WhatsApp directly (hot leads); verification goes to its service page.
    GA4 counts the wa.me clicks as whatsapp_click / generate_lead via partials/ga4.
    Usage: @include('components.plot-sale-cta', ['focus' => 'it-city', 'from' => 'news-story'])
           focus: saumitra | it-city | wellness | null — that scheme's button is shown first.
--}}
@php
    $wa = '918595002933';
    $from = $from ?? 'news';
    $schemes = [
        'saumitra' => ['name' => 'सौमित्र विहार', 'en' => 'Saumitra Vihar'],
        'it-city'  => ['name' => 'आईटी सिटी',     'en' => 'IT City Lucknow'],
        'wellness' => ['name' => 'वेलनेस सिटी',    'en' => 'Wellness City Lucknow'],
    ];
    $focus = $focus ?? null;
    if ($focus && isset($schemes[$focus])) {
        $schemes = [$focus => $schemes[$focus]] + $schemes;
    }
@endphp
<div class="psc">
    <p class="psc__kicker">Buy a Plot</p>
    <p class="psc__title">प्लॉट खरीदना है? सीधे WhatsApp करें</p>
    <p class="psc__text">इन तीन योजनाओं में उपलब्ध प्लॉट, साइज़ और रेट की जानकारी के लिए।</p>
    <div class="psc__list">
        @foreach($schemes as $key => $s)
            <a class="psc__wa{{ $key === $focus ? ' psc__wa--focus' : '' }}" target="_blank" rel="noopener" data-cta-kind="buy-plot-{{ $key }}"
               href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Hi, I want to buy a plot in '.$s['en'].'. Please share available plots and rates. (from dsdproperties.in '.$from.')') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.17.2-.35.22-.64.08-.3-.15-1.26-.46-2.39-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.6.13-.14.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.21 3.07c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.7.63.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2-1.41.25-.7.25-1.29.18-1.41-.08-.13-.28-.2-.57-.35zM12.05 21.8h-.01a9.87 9.87 0 01-5.03-1.38l-.36-.22-3.74.99 1-3.65-.24-.37a9.86 9.86 0 01-1.51-5.26c0-5.45 4.44-9.88 9.89-9.88 2.64 0 5.12 1.03 6.99 2.9a9.83 9.83 0 012.89 6.99c0 5.45-4.44 9.88-9.88 9.88zm8.41-18.3A11.82 11.82 0 0012.05 0C5.5 0 .16 5.34.16 11.89c0 2.1.55 4.14 1.59 5.95L.06 24l6.3-1.65a11.88 11.88 0 005.68 1.45h.01c6.55 0 11.89-5.34 11.89-11.9 0-3.18-1.24-6.17-3.48-8.41z"/></svg>
                <span>{{ $s['name'] }} में प्लॉट खरीदें</span>
                <span class="psc__arrow">→</span>
            </a>
        @endforeach
    </div>
    <div class="psc__verify">
        <p class="psc__vtext">कहीं और प्लॉट या फ्लैट ले रहे हैं? खरीदने से पहले <strong>₹5,000</strong> में पूरी जाँच करवाएँ।</p>
        <a class="psc__vbtn" href="{{ url('/services/property-verification-lucknow') }}" data-cta-kind="verify">प्रॉपर्टी जाँच बुक करें →</a>
    </div>
    <p class="psc__note">स्वतंत्र रीसेल सेवा; LDA या आवास विकास से संबद्ध नहीं।</p>
</div>

@once
<style>
    .psc { background:#fff; border:2px solid #25D366; border-radius:14px; padding:20px; font-family:'Mukta','Plus Jakarta Sans',sans-serif; }
    .psc__kicker { font-size:.68rem; font-weight:800; letter-spacing:.14em; text-transform:uppercase; color:#128C7E; margin:0 0 4px; }
    .psc__title { font-size:1.12rem; font-weight:800; color:#011f4b; line-height:1.35; margin:0 0 6px; }
    .psc__text { font-size:.86rem; line-height:1.6; color:#4b5563; margin:0 0 14px; }
    .psc__list { display:flex; flex-direction:column; gap:8px; }
    .psc__wa { display:flex; align-items:center; gap:10px; background:#25D366; color:#fff !important; font-weight:700;
               font-size:.95rem; padding:11px 14px; border-radius:10px; text-decoration:none !important; transition:background .15s; }
    .psc__wa:hover { background:#1ebe5a; }
    .psc__wa--focus { background:#128C7E; font-size:1rem; padding:13px 14px; }
    .psc__arrow { margin-left:auto; }
    .psc__verify { margin-top:14px; padding-top:14px; border-top:1px dashed #d1d5db; }
    .psc__vtext { font-size:.86rem; line-height:1.6; color:#374151; margin:0 0 10px; }
    .psc__vbtn { display:block; text-align:center; background:#FF5C00; color:#fff !important; font-weight:700; font-size:.92rem;
                 padding:10px 14px; border-radius:10px; text-decoration:none !important; }
    .psc__vbtn:hover { opacity:.9; }
    .psc__note { font-size:.72rem; color:#9ca3af; margin:12px 0 0; }
</style>
@endonce
