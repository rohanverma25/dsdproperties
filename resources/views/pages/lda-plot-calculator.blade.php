@extends('layouts.user-app')

{{--
    LDA plot cost calculator (built 22 Oct 2026).
    All rates are ₹ per sq m. Anant Nagar Phase 5 (allotted 5–6 Oct 2026) uses the Phase 4 rate, because LDA
    never published a separate Phase 5 rate. Wellness City (₹5,100/sq ft, Amar Ujala) and IT City (₹4,500/sq ft,
    the user's expected rate) were added 26 Oct 2026 before public registration opened.
    Figures and terms come from news reports of the LDA booklets. Update SCHEMES below when a new phase opens.
--}}
@section('title', 'LDA Plot Cost Calculator 2026 — Varun Vihar, Naimish Nagar, Anant Nagar, Wellness City, IT City')
@section('meta_description', 'Calculate the full cost of an LDA plot in Lucknow: price by size in sq m, 5% registration deposit, lump-sum discount (6% / 5% / 4%), 36-instalment EMI at 9.7% and 12% freehold charge. Varun Vihar, Naimish Nagar, Anant Nagar, Wellness City and IT City.')
@section('meta_keywords', 'LDA plot calculator, LDA plot price calculator, Varun Vihar plot price, Naimish Nagar plot price, LDA registration amount, LDA installment calculator, Anant Nagar plot price, Wellness City plot price, IT City plot price, LDA plot cost Lucknow 2026')

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebApplication",
  "name": "LDA Plot Cost Calculator",
  "url": "{{ url('/lda-plot-calculator') }}",
  "applicationCategory": "FinanceApplication",
  "operatingSystem": "Any",
  "offers": { "@type": "Offer", "price": "0", "priceCurrency": "INR" },
  "publisher": { "@type": "Organization", "name": "DSD Properties", "url": "https://dsdproperties.in" }
}
</script>
<style>
.lpc{--n:#011f4b;--t:#008080;--o:#FF5C00;--g:#64748b;--line:#e5e9f0;--soft:#f6f8fb;max-width:1080px;margin:0 auto;padding:28px 16px 56px;color:#1f2937}
.lpc h1{font-size:clamp(1.6rem,4vw,2.3rem);font-weight:800;color:var(--n);line-height:1.2;margin:0 0 8px;text-wrap:balance}
.lpc .sub{color:var(--g);font-size:15px;line-height:1.7;margin:0 0 22px;max-width:720px}
.lpc-grid{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1.15fr);gap:22px;align-items:start}
@media(max-width:860px){.lpc-grid{grid-template-columns:1fr}}
.lpc-box{background:#fff;border:1px solid var(--line);border-radius:18px;padding:22px;box-shadow:0 10px 30px rgba(1,31,75,.06)}
.lpc-label{display:block;font-size:12px;font-weight:700;letter-spacing:.05em;text-transform:uppercase;color:var(--g);margin:0 0 7px}
.lpc-field{margin-bottom:18px}
.lpc select{width:100%;padding:12px 14px;border:1.5px solid var(--line);border-radius:11px;background:var(--soft);font:inherit;font-size:15px;color:var(--n);font-weight:600}
.lpc select:focus{outline:none;border-color:var(--t);background:#fff}
.lpc-seg{display:flex;gap:6px;flex-wrap:wrap}
.lpc-seg button{flex:1;min-width:0;padding:10px 8px;border:1.5px solid var(--line);border-radius:10px;background:#fff;font:inherit;font-size:13.5px;font-weight:600;color:#334155;cursor:pointer}
.lpc-seg button.on{border-color:var(--t);background:#effaf9;color:var(--n)}
.lpc-seg button:focus-visible,.lpc select:focus-visible{outline:2px solid var(--t);outline-offset:2px}
.lpc-meta{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:4px}
.lpc-meta div{background:var(--soft);border-radius:10px;padding:10px 12px;font-size:12.5px;color:var(--g)}
.lpc-meta strong{display:block;font-size:15px;color:var(--n)}
.lpc-closed{background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:14px 16px;font-size:14px;line-height:1.65;color:#7c2d12}
.lpc-price{background:linear-gradient(135deg,#011f4b,#035e6b);color:#fff;border-radius:16px;padding:20px 22px;margin-bottom:16px}
.lpc-price small{font-size:12px;letter-spacing:.06em;text-transform:uppercase;opacity:.8}
.lpc-price .big{font-size:clamp(2rem,6vw,2.8rem);font-weight:800;line-height:1.1;margin:4px 0 6px;font-variant-numeric:tabular-nums}
.lpc-price p{margin:0;font-size:13.5px;opacity:.9}
.lpc-row{display:flex;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px dashed var(--line);font-size:14.5px}
.lpc-row:last-child{border-bottom:0}
.lpc-row span:last-child{font-weight:700;color:var(--n);font-variant-numeric:tabular-nums;white-space:nowrap}
.lpc-row.tot{border-top:2px solid var(--n);border-bottom:0;margin-top:4px;padding-top:12px;font-size:15.5px}
.lpc-row.tot span:last-child{color:var(--o)}
.lpc-row.save span:last-child{color:#059669}
.lpc-plans{display:grid;grid-template-columns:1fr 1fr;gap:14px}
@media(max-width:560px){.lpc-plans{grid-template-columns:1fr}}
.lpc-plan{border:1px solid var(--line);border-radius:14px;padding:14px 16px}
.lpc-plan h3{margin:0 0 4px;font-size:15.5px;color:var(--n)}
.lpc-plan .hint{font-size:12.5px;color:var(--g);margin:0 0 8px}
.lpc-plan.best{border-color:#10b98155;background:#f0fdf4}
.lpc-cta{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:16px}
@media(max-width:560px){.lpc-cta{grid-template-columns:1fr}}
.lpc-cta a{display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;border-radius:12px;font-weight:700;font-size:14.5px;text-decoration:none;text-align:center}
.lpc-cta .wa{background:#25D366;color:#fff}.lpc-cta .vf{background:var(--o);color:#fff}
.lpc-step{display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;border-radius:50%;background:var(--n);color:#fff;font-size:11px;font-weight:800;margin-right:7px;vertical-align:1px;letter-spacing:0}
.lpc-badge{display:inline-block;margin-top:10px;background:rgba(255,255,255,.16);border-radius:999px;padding:4px 11px;font-size:12px;font-weight:700}
.lpc-save{display:flex;align-items:center;gap:10px;background:#ecfdf5;border:1px solid #a7f3d0;color:#065f46;border-radius:12px;padding:11px 14px;font-size:14px;line-height:1.5;margin:0 0 14px}
.lpc-save strong{color:#047857}
.lpc-tbl tbody tr{cursor:pointer}.lpc-tbl tbody tr:hover td{background:#f0fdfa}
.lpc-tbl tr.sel td{background:#effaf9;font-weight:700;color:var(--n)}
.lpc-cta .fb{display:flex;align-items:center;justify-content:center;gap:8px;padding:13px;border-radius:12px;background:#fff;color:var(--n);border:1.5px solid var(--line);cursor:pointer;font:inherit;font-weight:700;font-size:14.5px}
.lpc-cta .fb:hover{border-color:var(--t);color:var(--t)}
.lpc-fb{margin-top:14px;border:1px solid var(--line);border-radius:16px;padding:18px;background:#fff}
.lpc-fb h3{margin:0 0 4px;font-size:16px;color:var(--n)}.lpc-fb>p{margin:0 0 12px;font-size:13.5px;color:var(--g)}
.lpc-fb .chips{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:10px}
.lpc-fb .chips button{border:1.5px solid var(--line);background:var(--soft);border-radius:999px;padding:7px 12px;font:inherit;font-size:12.5px;font-weight:600;color:#334155;cursor:pointer}
.lpc-fb .chips button.on{border-color:var(--t);background:#effaf9;color:var(--n)}
.lpc-fb textarea,.lpc-fb input[type=text],.lpc-fb input[type=tel]{width:100%;box-sizing:border-box;padding:11px 12px;border:1.5px solid var(--line);border-radius:10px;background:var(--soft);font:inherit;font-size:16px;margin-bottom:10px}
.lpc-fb textarea:focus,.lpc-fb input:focus{outline:none;border-color:var(--t);background:#fff}
.lpc-fb .two{display:grid;grid-template-columns:1fr 1fr;gap:10px}@media(max-width:560px){.lpc-fb .two{grid-template-columns:1fr}}
.lpc-fb .send{width:100%;padding:12px;border:0;border-radius:10px;background:var(--n);color:#fff;font:inherit;font-weight:700;font-size:14.5px;cursor:pointer}
.lpc-fb .send:disabled{opacity:.6}
.lpc-fb .err{color:#dc2626;font-size:12.5px;margin:-4px 0 10px;display:none}
.lpc-fb .ok{background:#ecfdf5;color:#065f46;border-radius:10px;padding:12px;font-size:14px;display:none}
.lpc-notes{margin:28px 0 0;font-size:13.5px;color:#475569;line-height:1.75}
.lpc-notes h2{font-size:20px;color:var(--n);margin:0 0 10px}
.lpc-notes ul{padding-left:20px;margin:0 0 14px}
.lpc-tbl{width:100%;border-collapse:collapse;font-size:14px;min-width:460px}
.lpc-tbl th{background:var(--n);color:#fff;text-align:left;padding:9px 10px}
.lpc-tbl td{padding:9px 10px;border-bottom:1px solid var(--line);font-variant-numeric:tabular-nums}
</style>
@endpush

@section('content')
<div class="lpc">
    <h1>LDA Plot Cost Calculator</h1>
    <p class="sub">Pick a scheme and a plot size to see the full cost: plot price, registration deposit, lump-sum discount, instalment EMI and freehold charge. Sizes and rates are in square metres. Prices are in lakh (L) and crore (Cr).</p>

    <div class="lpc-grid">
        {{-- Inputs --}}
        <div class="lpc-box">
            <div class="lpc-field">
                <label class="lpc-label" for="lpc-scheme"><span class="lpc-step">1</span>LDA scheme</label>
                <select id="lpc-scheme"></select>
            </div>

            <div id="lpc-open">
                <div class="lpc-field">
                    <label class="lpc-label" for="lpc-size"><span class="lpc-step">2</span>Plot size (sq m)</label>
                    <select id="lpc-size"></select>
                </div>
                <div class="lpc-field">
                    <span class="lpc-label"><span class="lpc-step">3</span>Your category</span>
                    <div class="lpc-seg" id="lpc-cat">
                        <button type="button" class="on" data-v="0.05">General (5% deposit)</button>
                        <button type="button" data-v="0.025">Reserved (2.5%)</button>
                    </div>
                </div>
                <div class="lpc-field">
                    <span class="lpc-label"><span class="lpc-step">4</span>If you pay in full, within</span>
                    <div class="lpc-seg" id="lpc-days">
                        <button type="button" class="on" data-v="0.06">45 days (6% off)</button>
                        <button type="button" data-v="0.05">60 days (5%)</button>
                        <button type="button" data-v="0.04">90 days (4%)</button>
                    </div>
                </div>
                <div class="lpc-meta" id="lpc-meta"></div>
            </div>

            <div id="lpc-none" class="lpc-closed" hidden></div>
        </div>

        {{-- Results --}}
        <div id="lpc-results">
            <div class="lpc-price">
                <small>Estimated plot price</small>
                <div class="big" id="r-price">—</div>
                <p id="r-line">—</p>
                <p id="r-basis" style="margin-top:6px;font-size:12.5px;opacity:.8" hidden></p>
                <span class="lpc-badge" id="r-badge"></span>
            </div>

            <div class="lpc-save" id="r-save"></div>

            <div class="lpc-box" style="margin-bottom:14px">
                <div class="lpc-row"><span>Registration booklet</span><span>₹1,100</span></div>
                <div class="lpc-row"><span id="r-deplbl">Registration deposit (5%)</span><span id="r-dep">—</span></div>
                <div class="lpc-row"><span>Freehold charge (12%, paid at registry)</span><span id="r-fh">—</span></div>
            </div>

            <div class="lpc-plans">
                <div class="lpc-plan best">
                    <h3>Pay in full</h3>
                    <p class="hint" id="r-lsHint">Discount 6% · lump-sum payers are drawn first in the lottery</p>
                    <div class="lpc-row save"><span>Discount</span><span id="r-disc">—</span></div>
                    <div class="lpc-row"><span>Balance after deposit</span><span id="r-lsBal">—</span></div>
                    <div class="lpc-row tot"><span>Total cost</span><span id="r-lsTot">—</span></div>
                </div>
                <div class="lpc-plan">
                    <h3>36 monthly instalments</h3>
                    <p class="hint">9.7% interest on the balance after the deposit</p>
                    <div class="lpc-row"><span>Monthly EMI</span><span id="r-emi">—</span></div>
                    <div class="lpc-row"><span>Total interest</span><span id="r-int">—</span></div>
                    <div class="lpc-row tot"><span>Total cost</span><span id="r-instTot">—</span></div>
                </div>
            </div>

            <div class="lpc-cta">
                <a class="vf" id="r-wa" href="{{ url('/services/property-verification-lucknow') }}" data-cta-kind="verify">Get the papers checked (₹5,000)</a>
                <button type="button" class="fb" id="fb-open">💬 Give feedback</button>
            </div>

            {{-- Feedback: posts to the existing enquiry endpoint, so it lands in the form_submissions inbox --}}
            <form class="lpc-fb" id="lpc-fb" hidden novalidate>
                @csrf
                <x-honeypot form-id="calc" />
                <input type="hidden" name="page_url" value="{{ url('/lda-plot-calculator') }}">
                <input type="hidden" name="suggestion" id="fb-suggestion">
                <h3>Something wrong or missing?</h3>
                <p>Tell us what to fix or add. We read every message and reply on WhatsApp.</p>
                <div class="chips" id="fb-chips">
                    <button type="button">Price looks wrong</button>
                    <button type="button">Add another scheme</button>
                    <button type="button">Hard to use</button>
                    <button type="button">Change wording</button>
                    <button type="button">Other</button>
                </div>
                <label class="lpc-label" for="fb-text">Your feedback</label>
                <textarea id="fb-text" rows="3" maxlength="900" placeholder="For example: please add 100 sq m plots in Naimish Nagar"></textarea>
                <div class="err" id="fb-text-err">Pick an option or write a few words.</div>
                <div class="two">
                    <div><label class="lpc-label" for="fb-name">Name</label><input type="text" id="fb-name" name="name" autocomplete="name" maxlength="100"></div>
                    <div><label class="lpc-label" for="fb-mobile">WhatsApp number</label><input type="tel" id="fb-mobile" name="mobile" inputmode="numeric" maxlength="10" autocomplete="tel"></div>
                </div>
                <div class="err" id="fb-id-err">Enter your name and a 10-digit mobile number so we can reply.</div>
                <button type="submit" class="send" id="fb-send">Send feedback</button>
                <div class="ok" id="fb-ok">Thank you! Your feedback has reached us. We'll reply on WhatsApp if we need more details.</div>
            </form>
        </div>
    </div>

    <div class="lpc-notes">
        <h2>How the numbers are worked out</h2>
        <ul>
            <li><strong>Plot price</strong> = size in sq m × the scheme rate per sq m. Example: a 112.5 sq m plot in Varun Vihar at ₹30,139/sq m comes to about ₹33.9 L.</li>
            <li><strong>Anant Nagar Phase 5</strong> uses ₹44,731/sq m, the latest rate LDA published for the scheme (Phase 4). <strong>Wellness City</strong> and <strong>IT City</strong> are not open to the public yet: Wellness City uses the rate reported by Amar Ujala and IT City uses our expected rate, so treat both as planning figures.</li>
            <li><strong>Registration deposit</strong> is 5% of the plot price, or 2.5% for reserved categories. The booklet costs ₹1,100.</li>
            <li><strong>Pay in full</strong>: 6% off within 45 days of allotment, 5% within 60 days and 4% within 90 days. We apply the discount to the plot price.</li>
            <li><strong>Instalments</strong>: 36 monthly instalments at 9.7% interest. The EMI shown is a standard reducing-balance estimate; LDA's allotment letter gives the exact schedule.</li>
            <li><strong>Freehold charge</strong>: 12% of the plot price, paid at the time of registry.</li>
            <li><strong>Not included:</strong> extra charges for corner or park-facing plots, stamp duty and registration fee at the registry, and any GST or maintenance. If you cancel your registration, LDA deducts 20%.</li>
            <li>Eligibility: 18 or older, with no earlier LDA allotment. Apply only on <a href="https://registration.ldalucknow.in" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">registration.ldalucknow.in</a>.</li>
        </ul>

        <h2>Plot sizes and prices</h2>
        <div style="overflow-x:auto;margin-bottom:14px"><table class="lpc-tbl" id="lpc-tbl"></table></div>

        <p>Sources: Amar Ujala (24 Sep and 19 Oct 2026), ETV Bharat (25 Sep 2026) and Zee Business, reporting the LDA registration booklets for Varun Vihar and Naimish Nagar; Amar Ujala and ETV Bharat (Aug–Oct 2026) on Anant Nagar Phase 5; Amar Ujala on the Wellness City rate. These are estimates for planning. Always check the final figures in the LDA booklet and allotment letter. Scheme guides:
            <a href="{{ url('/blog/varun-vihar-yojana-lucknow-lda-plots-guide-2026') }}" style="color:#008080;font-weight:600;">Varun Vihar</a> ·
            <a href="{{ url('/blog/naimish-nagar-yojana-lucknow-lda-plots-guide-2026') }}" style="color:#008080;font-weight:600;">Naimish Nagar</a> ·
            <a href="{{ url('/blog/anant-nagar-yojana-lucknow-lda-2026') }}" style="color:#008080;font-weight:600;">Anant Nagar</a> ·
            <a href="{{ url('/blog/wellness-city-lucknow-lda-plots-guide-2026') }}" style="color:#008080;font-weight:600;">Wellness City</a> ·
            <a href="{{ url('/blog/it-city-lucknow-lda-plots-guide-2026') }}" style="color:#008080;font-weight:600;">IT City</a> ·
            <a href="{{ url('/lda-schemes') }}" style="color:#008080;font-weight:600;">all LDA schemes</a>.
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    // Rates are ₹ per sq m. Varun Vihar (₹2,800), Naimish Nagar (₹3,800), Wellness City (₹5,100) and IT City (₹4,500)
    // were reported per sq ft and are converted at 10.7639 sq ft per sq m, rounded to the rupee.
    // sizes: [plot size in sq m, number of plots or null when LDA has not published counts].
    // Schemes without `closes` are not open for registration; `status` and `basis` explain where the rate comes from.
    var SCHEMES = [
        { key: 'varun', name: 'Varun Vihar Yojana (Agra Expressway)', rate: 30139, closes: '2026-10-24',
          guide: '/blog/varun-vihar-yojana-lucknow-lda-plots-guide-2026',
          sizes: [[112.5, 1517], [162, 460], [200, 612], [288, 68], [300, 81], [450, 109]] },
        { key: 'naimish', name: 'Naimish Nagar Yojana (Sitapur Road)', rate: 40903, closes: '2026-10-24',
          guide: '/blog/naimish-nagar-yojana-lucknow-lda-plots-guide-2026',
          sizes: [[72, 197], [112.5, 524], [162, 520], [200, 299], [288, 103], [450, 30]] },
        { key: 'anant', name: 'Anant Nagar Yojana Phase 5 (Mohan Road)', rate: 44731, tag: 'allotted',
          guide: '/blog/anant-nagar-yojana-lucknow-lda-2026',
          sizes: [[112.5, 425], [162, 12], [200, 23]],
          status: 'Phase 5 (Aashish Khand) allotted by lottery on 5–6 Oct 2026',
          basis: '₹44,731/sq m is LDA’s latest published Anant Nagar rate (Phase 4). LDA did not publish the Phase 5 rate separately, so check your allotment letter.' },
        { key: 'wellness', name: 'Wellness City (Sultanpur Road)', rate: 54896, tag: 'not open yet',
          guide: '/blog/wellness-city-lucknow-lda-plots-guide-2026',
          sizes: [[35, null], [45, null], [72, null], [128, null], [162, null], [200, null], [288, null]],
          status: 'Public registration not open yet',
          basis: 'Rate as reported by Amar Ujala. Plot sizes are LDA’s announced categories; the final price, plot count and terms will be in the LDA booklet.' },
        { key: 'itcity', name: 'IT City (Sultanpur Road)', rate: 48438, tag: 'not open yet',
          guide: '/blog/it-city-lucknow-lda-plots-guide-2026',
          sizes: [[35, null], [72, null], [128, null], [162, null], [200, null], [288, null]],
          status: 'Public registration not open yet',
          basis: 'Expected rate (DSD estimate): LDA has not published a public-sale rate yet. Plot sizes are those LDA gave landowners in land pooling.' }
    ];

    var $ = function (id) { return document.getElementById(id); };
    function inr(n) { return Math.round(n).toLocaleString('en-IN'); }
    function money(n) {
        if (n >= 1e7) return '₹' + (n / 1e7).toFixed(2) + ' Cr';
        if (n >= 1e5) return '₹' + (n / 1e5).toFixed(2) + ' L';
        return '₹' + inr(n);
    }
    function sqm(v) { return (v % 1 ? v.toFixed(1) : v) + ' sq m'; }
    function closed(s) { return s.closes && new Date() > new Date(s.closes + 'T23:59:59+05:30'); }
    function pick(groupId) { var b = document.querySelector('#' + groupId + ' button.on'); return parseFloat(b.getAttribute('data-v')); }

    var schemeSel = $('lpc-scheme'), sizeSel = $('lpc-size');
    SCHEMES.forEach(function (s, i) {
        var o = document.createElement('option'); o.value = i;
        o.textContent = s.name + (!s.sizes.length ? ' — no plots open' : s.tag ? ' — ' + s.tag : closed(s) ? ' — registration closed' : '');
        schemeSel.appendChild(o);
    });

    function fillSizes() {
        var s = SCHEMES[schemeSel.value];
        sizeSel.innerHTML = '';
        s.sizes.forEach(function (z, i) {
            var o = document.createElement('option'); o.value = i;
            o.textContent = sqm(z[0]) + '  ·  ' + money(z[0] * s.rate) + (z[1] ? '  ·  ' + z[1].toLocaleString('en-IN') + ' plots' : '');
            sizeSel.appendChild(o);
        });
        $('lpc-open').hidden = !s.sizes.length;
        $('lpc-results').hidden = !s.sizes.length;
        $('lpc-none').hidden = !!s.sizes.length;
        if (!s.sizes.length) {
            $('lpc-none').innerHTML = s.none + '<br><br><a href="' + s.guide + '" style="color:#008080;font-weight:700;">Read the scheme guide →</a>';
        }
        renderTable();
        calc();
    }

    function renderTable() {
        var s = SCHEMES[schemeSel.value];
        if (!s.sizes.length) { $('lpc-tbl').innerHTML = '<tr><td>' + s.none + '</td></tr>'; return; }
        var h = '<thead><tr><th>Plot size</th><th>Plots</th><th>Price (approx.)</th><th>5% deposit</th></tr></thead><tbody>';
        s.sizes.forEach(function (z, i) {
            var p = z[0] * s.rate;
            h += '<tr data-i="' + i + '" title="Tap to calculate this size"><td>' + sqm(z[0]) + '</td><td>' + (z[1] ? z[1].toLocaleString('en-IN') : '—') + '</td><td>' + money(p) + '</td><td>' + money(p * 0.05) + '</td></tr>';
        });
        $('lpc-tbl').innerHTML = h + '</tbody>';
        $('lpc-tbl').querySelectorAll('tbody tr').forEach(function (tr) {
            tr.addEventListener('click', function () {
                sizeSel.value = tr.getAttribute('data-i'); calc();
                $('lpc-results').scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }
    function markRow() {
        $('lpc-tbl').querySelectorAll('tbody tr').forEach(function (tr) {
            tr.classList.toggle('sel', tr.getAttribute('data-i') === String(sizeSel.value));
        });
    }

    function calc() {
        var s = SCHEMES[schemeSel.value];
        if (!s.sizes.length) return;
        var z = s.sizes[sizeSel.value] || s.sizes[0];
        var price = z[0] * s.rate;
        var depPct = pick('lpc-cat'), discPct = pick('lpc-days');
        var dep = price * depPct, fh = price * 0.12;

        $('r-price').textContent = money(price);
        $('r-line').textContent = sqm(z[0]) + ' × ₹' + inr(s.rate) + '/sq m' +
            (!s.closes ? ' · ' + s.status : closed(s) ? ' · registration closed on 24 Oct 2026' : ' · registration closes 24 Oct 2026');
        $('r-basis').textContent = s.basis || '';
        $('r-basis').hidden = !s.basis;
        $('r-deplbl').textContent = 'Registration deposit (' + (depPct * 100) + '%)';
        $('r-dep').textContent = money(dep);
        $('r-fh').textContent = money(fh);

        var disc = price * discPct;
        $('r-lsHint').textContent = 'Discount ' + (discPct * 100) + '% · lump-sum payers are drawn first in the lottery';
        $('r-disc').textContent = '− ' + money(disc);
        $('r-lsBal').textContent = money(price - disc - dep);
        $('r-lsTot').textContent = money(price - disc + fh + 1100);

        var P = price - dep, r = 0.097 / 12, n = 36;
        var emi = P * r / (1 - Math.pow(1 + r, -n)), interest = emi * n - P;
        $('r-emi').textContent = money(emi);
        $('r-int').textContent = money(interest);
        $('r-instTot').textContent = money(price + interest + fh + 1100);

        var lsTotal = price - disc + fh + 1100, instTotal = price + interest + fh + 1100;
        $('r-save').innerHTML = '💰 <span>Paying in full within ' + { 0.06: 45, 0.05: 60, 0.04: 90 }[discPct] +
            ' days saves about <strong>' + money(instTotal - lsTotal) + '</strong> compared with 36 instalments.</span>';
        var days = s.closes ? Math.ceil((new Date(s.closes + 'T23:59:59+05:30') - new Date()) / 864e5) : 0;
        $('r-badge').textContent = s.tag === 'allotted' ? 'Allotted · for allottees planning payment'
            : !s.closes ? 'Registration not open yet · for planning'
            : closed(s) ? 'Registration closed · for allottees planning payment'
            : (days <= 1 ? '⏰ Last day to register' : '⏰ ' + days + ' days left to register');
        markRow();

    }

    ['lpc-cat', 'lpc-days'].forEach(function (g) {
        document.querySelectorAll('#' + g + ' button').forEach(function (b) {
            b.addEventListener('click', function () {
                document.querySelectorAll('#' + g + ' button').forEach(function (x) { x.classList.remove('on'); });
                b.classList.add('on'); calc();
            });
        });
    });
    schemeSel.addEventListener('change', fillSizes);
    sizeSel.addEventListener('change', calc);

    $('lpc-meta').innerHTML = '';
    function meta() {
        var s = SCHEMES[schemeSel.value];
        if (!s.sizes.length) return;
        var total = s.sizes.reduce(function (a, z) { return a + (z[1] || 0); }, 0);
        $('lpc-meta').innerHTML = '<div><strong>₹' + inr(s.rate) + '/sq m</strong>rate</div><div><strong>' +
            (total ? total.toLocaleString('en-IN') + ' plots' : s.sizes.length + ' plot sizes') + '</strong>' +
            (s.tag === 'allotted' ? 'allotted 5–6 Oct 2026' : !s.closes ? 'registration not open yet' : closed(s) ? 'registration closed 24 Oct' : 'open till 24 Oct 2026') + '</div>';
    }
    schemeSel.addEventListener('change', meta);
    fillSizes(); meta();

    // ── Feedback ──
    var fb = $('lpc-fb'), chosen = '';
    $('fb-open').addEventListener('click', function () {
        fb.hidden = !fb.hidden;
        if (!fb.hidden) { fb.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
    });
    document.querySelectorAll('#fb-chips button').forEach(function (b) {
        b.addEventListener('click', function () {
            document.querySelectorAll('#fb-chips button').forEach(function (x) { x.classList.remove('on'); });
            b.classList.add('on'); chosen = b.textContent;
        });
    });
    fb.addEventListener('submit', function (e) {
        e.preventDefault();
        var text = $('fb-text').value.trim(), name = $('fb-name').value.trim(), mob = $('fb-mobile').value.trim();
        var okText = chosen || text.length >= 3, okId = name.length >= 2 && /^[6-9]\d{9}$/.test(mob);
        $('fb-text-err').style.display = okText ? 'none' : 'block';
        $('fb-id-err').style.display = okId ? 'none' : 'block';
        if (!okText || !okId) return;
        var s = SCHEMES[schemeSel.value], z = s.sizes[sizeSel.value];
        $('fb-suggestion').value = ('[LDA calculator feedback] ' + (chosen ? chosen + ': ' : '') + (text || '-') +
            ' | Viewing: ' + s.name + (z ? ', ' + sqm(z[0]) : '')).slice(0, 1000);
        var btn = $('fb-send'); btn.disabled = true; btn.textContent = 'Sending…';
        fetch(@json(route('blog.feedback.store')), {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': fb.querySelector('input[name="_token"]').value, 'Accept': 'application/json' },
            body: new FormData(fb)
        }).then(function (r) { return r.json(); }).then(function (d) {
            if (d.success) {
                btn.hidden = true; $('fb-ok').style.display = 'block';
                if (typeof window.gtag === 'function') window.gtag('event', 'calculator_feedback', { feedback_type: chosen || 'text' });
            } else {
                btn.disabled = false; btn.textContent = 'Send feedback';
                if (d.message) $('fb-id-err').textContent = d.message;
                $('fb-id-err').style.display = 'block';
            }
        }).catch(function () { btn.disabled = false; btn.textContent = 'Try again'; });
    });
})();
</script>
@endpush
