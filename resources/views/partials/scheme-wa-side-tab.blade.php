{{--
    Mobile-only WhatsApp side tab on the right edge (user, 26 Nov 2026), on the IT City, Wellness City
    and Varun Vihar posts; Saumitra Vihar posts + landing page added 26 Nov. Opens WhatsApp even on No-WhatsApp pages (Varun Vihar): the user asked
    for this button specifically. Add or remove a slug below to switch it on or off for a post.
--}}
@php
    $waTabSchemes = [
        'it-city-lucknow-lda-plots-guide-2026'        => 'IT City',
        'it-city-lucknow-lda-plots-guide-hindi-2026'  => 'IT City',
        'wellness-city-lucknow-lda-plots-guide-2026'  => 'Wellness City',
        'wellness-city-lucknow-lda-guide-hindi-2026'  => 'Wellness City',
        'varun-vihar-yojana-lucknow-lda-plots-guide-2026' => 'Varun Vihar',
        'varun-vihar-yojana-lucknow-hindi-2026'       => 'Varun Vihar',
        'saumitra-vihar-yojana-lucknow-2026'          => 'Saumitra Vihar',
        'saumitra-vihar-yojana-lucknow-hindi-2026'    => 'Saumitra Vihar',
        'property-in-saumitra-vihar'                  => 'Saumitra Vihar', // landing page pages/saumitra-vihar-yojna
    ];
    $waTabScheme = $waTabSchemes[$waTabSlug ?? ''] ?? null;
@endphp
@if($waTabScheme)
<a href="https://wa.me/{{ config('contact.wa') }}?text={{ rawurlencode('Hi, I want a plot in ' . $waTabScheme . ', Lucknow.') }}"
   class="dsd-wa-side-tab" target="_blank" rel="noopener" aria-label="WhatsApp us about {{ $waTabScheme }}"
   data-cta-kind="wa-side-tab">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    <span>WHATSAPP</span>
</a>
<style>
.dsd-wa-side-tab{display:none}
@media (max-width:767px){
  .dsd-wa-side-tab{
    display:flex;flex-direction:column;align-items:center;gap:10px;
    position:fixed;right:0;top:55%;transform:translateY(-50%);z-index:9990;
    background:#E8682A;color:#fff !important;text-decoration:none !important;
    padding:14px 9px;border-radius:12px 0 0 12px;
    box-shadow:-2px 3px 10px rgba(0,0,0,.25);
    font-family:'Poppins',Arial,sans-serif;font-weight:700;font-size:13px;letter-spacing:2.5px;line-height:1;
  }
  .dsd-wa-side-tab span{writing-mode:vertical-rl}
  .dsd-wa-side-tab:active{background:#cf5a20}
}
</style>
@endif
