# Fact update of post 95 (English Saumitra Vihar) to match Hindi post 96 (16 Oct 2026). Keeps the ~Rs 4,000 price.
import json, re, sys, html as H

h0 = open('e95.html', encoding='utf8', newline='').read()
row = json.load(open('e95.row.json', encoding='utf8'))
assert row['content_html'] == h0
h = h0.replace('\r\n', '\n')

def rep(old, new, n=1):
    global h
    c = h.count(old)
    if c != n: sys.exit(f'ABORT: expected {n}, found {c}: {old[:90]!r}')
    h = h.replace(old, new)

def A(url, text):
    return f'<a href="{url}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{text}</a>'

AU25 = A('https://www.amarujala.com/lucknow/lottery-will-be-held-on-22nd-and-23rd-september-in-saumitra-vihar-scheme-located-in-mohanlalganj-lucknow-2025-09-22', 'Amar Ujala')
AU10 = A('https://www.amarujala.com/lucknow/saumitra-vihar-residential-scheme-to-be-launched-in-august-lucknow-news-c-13-lko1096-1821087-2026-07-10', 'Amar Ujala')
AU23 = A('https://www.amarujala.com/lucknow/three-new-housing-schemes-to-be-launched-soon-in-the-capital-lucknow-news-c-13-1-vns1028-1841432-2026-07-23', 'Amar Ujala')
ETV = A('https://www.etvbharat.com/hi/state/gift-of-plots-in-lucknow-on-august-15-saumitra-vihar-scheme-to-be-launched-providing-housing-to-1-lakh-people-ups26072803345', 'ETV Bharat')
NN = A('https://www.newsnationtv.com/states/uttar-pradesh/preparations-underway-for-8000-plots-in-lucknow-registration-for-three-major-residential-schemes-to-begin-during-navratri-12544292', 'News Nation')
FPJ = A('https://www.freepressjournal.in/business/saumitra-vihar-housing-scheme-in-lucknow-to-launch-next-month-2000-plots-on-offer-and-big-gains-for-farmers', 'Free Press Journal')
PAT = A('https://www.patrika.com/lucknow-news/awas-vikas-to-launch-new-jail-road-housing-scheme-on-holi-registrations-open-for-2000-plots-19428787', 'Patrika')
SECTORS = 'Sankalp, Sanket, Samved, Sanchit, Sambhav, Sabodh, Sambit and Sadeep'

# ---------- top ----------
rep('<p class="dsd-sourceline">Sources: Dainik Jagran (16 August 2026), UP Awas Vikas Parishad, UP RERA, Amar Ujala — compiled and cross-checked by DSD Properties. <strong>Last updated: 4 September 2026.</strong></p>',
    '<p class="dsd-sourceline">Sources: Amar Ujala, ETV Bharat, News Nation, Dainik Jagran, Free Press Journal, Patrika, UP Awas Vikas Parishad — compiled and cross-checked by DSD Properties. <strong>Last updated: 16 October 2026.</strong></p>')
rep('<span class="dsd-dot wait"></span> RERA applied 11 Aug 2026</span> <span class="dsd-ribbon-pill"><span class="dsd-dot done"></span> Farmer land registry done</span> <span class="dsd-ribbon-date">Checked 4 Sep 2026</span>',
    '<span class="dsd-dot wait"></span> RERA: final certificate pending</span> <span class="dsd-ribbon-pill"><span class="dsd-dot done"></span> Farmers have got their plots</span> <span class="dsd-ribbon-date">Checked 16 Oct 2026</span>')
rep('<div class="dsd-stat-item"><span class="dsd-stat-num sm">Land Pooling</span><span class="dsd-stat-label">First in UP</span></div>',
    '<div class="dsd-stat-item"><span class="dsd-stat-num">8</span><span class="dsd-stat-label">Sectors</span></div>')
rep('<h4>Where things stand — 4 September 2026</h4>', '<h4>Where things stand — 16 October 2026</h4>')
rep('<li><strong>Registration has not opened.</strong> There is no application link, no brochure and no price list for Saumitra Vihar on upavp.in yet.</li>',
    '<li><strong>Registration has not opened.</strong> On 16 October 2026 there was no application link, no brochure and no price list for Saumitra Vihar on upavp.in.</li>')
rep('<li><strong>The RERA application was filed on 11 August 2026.</strong> UP RERA has confirmed it received it and that document checking has now begun. <strong>The scheme is not RERA-approved yet</strong> — it is under review.</li>',
    f'<li><strong>The final RERA certificate is still pending.</strong> UPAVP applied to UP RERA on 11 August 2026 (Dainik Jagran). On 17 September 2026, {NN} reported that the scheme had RERA’s green signal and only the final certificate was left. Do not treat it as approved until the RERA number shows on up-rera.in.</li>\n'
    f'<li><strong>The launch date has slipped again.</strong> Parishad Secretary Dr Neeraj Shukla had spoken of a launch during Navratri ({NN}). The earlier August 2026 date also passed.</li>')
rep('<li><strong>Phase 1 will offer 2,092 residential plots</strong>, in six sizes from 40.74 sq m to 300 sq m, plus 169 commercial plots.</li>',
    f'<li><strong>Phase 1 will offer 2,092 residential plots and 169 commercial plots</strong> on about 200 acres, in sizes from 40.74 sq m to 300 sq m ({ETV}, 28 July 2026).</li>')
rep('<li><strong>Land transfer from farmers is complete.</strong> The registry of pooled land into the Parishad’s name has been done, and 192 farmers have already received developed plots through a lottery.</li>',
    f'<li><strong>Farmers have already got their plots.</strong> About 1,200 farmers gave around 130 acres, and a lottery of 1,122 plots was held for them on 22–23 September 2025 ({AU25}). The land mutation (dakhil-kharij) is also complete ({AU10}).</li>')
rep('The RERA application only went in on 11 August 2026 and is still being checked.', 'The final RERA certificate has not come through yet.')

# ---------- land pooling ----------
rep('<li><strong>The registry is complete.</strong> The land has been formally transferred into the Parishad’s name.</li>',
    f'<li><strong>The land mutation is complete.</strong> This was the step that held up the January 2025 launch ({AU10}).</li>')
rep('<li><strong>192 farmers have already received developed plots</strong> through a lottery draw.</li>',
    f'<li><strong>About 1,200 farmers gave around 130 acres</strong>, and a lottery of 1,122 developed plots was held for them on 22–23 September 2025. Farmers get back 25% of their land as developed plots ({AU25}).</li>')
rep('When land comes through pooling with everyone’s consent and the registry already done,', 'When land comes through pooling with everyone’s consent and the mutation already done,')

# ---------- facilities + layout caution ----------
i = h.find('<p>Here is what has been confirmed as part of the township plan:</p>'); j = h.find('<h2 id="status"', i); assert i > 0 and j > i
FAC = f'''<p>Here is what has been reported so far:</p>
<div class="dsd-zone-grid">
<div class="dsd-zone-card">
<h5>8 sectors</h5>
<p>{SECTORS} ({FPJ}, October 2025).</p>
</div>
<div class="dsd-zone-card">
<h5>Wide internal roads</h5>
<p>Roads 9, 12, 18 and 24 metres wide, on the pattern of the Vrindavan Yojana ({ETV}).</p>
</div>
<div class="dsd-zone-card">
<h5>Parks, lake and convention centre</h5>
<p>Parks and green space in every sector, plus a lake and a convention centre ({FPJ}, {PAT}).</p>
</div>
<div class="dsd-zone-card orange">
<h5>Commercial plots</h5>
<p>169 commercial plots in Phase 1 for shops, markets and daily needs ({ETV}).</p>
</div>
<div class="dsd-zone-card orange">
<h5>Educational plots</h5>
<p>Plots for schools and other educational use, alongside homes and shops ({FPJ}).</p>
</div>
<div class="dsd-zone-card">
<h5>Plots for lower income groups</h5>
<p>Plots for EWS and other lower income groups have been mentioned ({PAT}, February 2025). The final quota will come in the brochure.</p>
</div>
</div>
<div class="dsd-alert info">
<h4>One caution about the layout</h4>
<p>In July 2026, Parishad Chief Engineer DB Singh said the <strong>layout was being revised</strong> before the RERA application ({AU23}). So please do not rely on old layout maps going around online. The final layout will come with the brochure; until then, do not pay for any particular sector or plot — not even on the basis of this article.</p>
</div>
'''
h = h[:i] + FAC + h[j:]

# ---------- timeline ----------
def TL(cls, date, title, desc):
    return f'<div class="dsd-tl-item{cls}"><span class="dsd-tl-date">{date}</span>\n<p class="dsd-tl-title">{title}</p>\n<p class="dsd-tl-desc">{desc}</p>\n</div>\n'
rep('<p class="dsd-tl-desc">The scheme was to be launched at the Prayagraj Mahakumbh. It got delayed.</p>\n</div>\n',
    f'<p class="dsd-tl-desc">The scheme was to be launched at the Prayagraj Mahakumbh, but the land mutation was not complete, so it was delayed ({AU10}).</p>\n</div>\n'
    + TL(' done', '28 February 2025', 'Holi launch planned — did not happen', f'Reports spoke of 5,000 plots in the full scheme, 2,000 in the first phase, and ₹2,200–2,400 per sq ft ({PAT}).'))
i = h.find('<div class="dsd-tl-item done"><span class="dsd-tl-date">2025 to 2026</span>'); j = h.find('<div class="dsd-tl-item"><span class="dsd-tl-date">Coming next</span>', i); assert i > 0 and j > i
h = h[:i] + (
    TL(' done', '22–23 September 2025', 'Plot lottery for farmers', f'A lottery of 1,122 developed plots was held for about 1,200 farmers who gave their land ({AU25}).')
    + TL(' done', '26 October 2025', '1 November 2025 target — did not happen', f'Reports described a first phase of about 200 acres and named the 8 sectors ({FPJ}).')
    + TL(' done', '10 July 2026', 'August 2026 launch announced', f'About 2,200 plots in the first phase, at around ₹2,500 per sq ft ({AU10}).')
    + TL(' done', '23 July 2026', 'Layout revised', f'The layout was revised before the RERA application ({AU23}).')
    + TL(' done', '11 August 2026', 'RERA application filed', 'UPAVP submitted the registration application on the UP RERA portal (Dainik Jagran, 16 August 2026).')
    + TL(' active', '17 September 2026', 'Navratri launch planned', f'RERA green signal reported, with only the final certificate pending; registration for about 2,000 plots to follow ({NN}). As of 16 October 2026, registration had not opened.')
) + h[j:]

# ---------- status table ----------
rep('<td>Around 560 acres collected with consent</td>', '<td>About 130 acres from around 1,200 farmers (Amar Ujala, September 2025)</td>')
rep('<td>Land registry to Parishad</td>', '<td>Land mutation (dakhil-kharij)</td>')
rep('<td>Formally transferred into UPAVP’s name</td>', '<td>Complete (Amar Ujala, July 2026)</td>')
rep('<td>192 farmers allotted developed plots by lottery</td>', '<td>Lottery of 1,122 plots on 22–23 September 2025</td>')
rep('<td><span class="dsd-badge wait">Applied — under review</span></td>\n<td>Filed 11 August 2026, documents being checked</td>',
    '<td><span class="dsd-badge wait">Final certificate pending</span></td>\n<td>Applied 11 August 2026; green signal reported in September</td>')

# ---------- eligibility ----------
i = h.find('<p>Two conditions have been reported for this scheme:</p>'); j = h.find('<p><strong>Documents to keep', i); assert i > 0 and j > i
h = h[:i] + '''<div class="dsd-alert info">
<h4>Eligibility rules are not out yet</h4>
<p>UPAVP has not released the eligibility rules for Saumitra Vihar yet. Many websites list conditions such as "resident of UP" or "age 18 to 55", but we could not find any official source for them. Income limits, rules about owning a house already, reservation categories and the application fee will all come in the brochure. So please do not rule yourself in or out until it is out.</p>
</div>
''' + h[j:]

# ---------- investment ----------
rep('<li>Land registry into the Parishad’s name is already complete</li>', '<li>The land mutation is already complete</li>')
rep('<li>192 farmers have already got their plots, so the model has worked in practice</li>', '<li>A lottery of 1,122 plots has already been held for about 1,200 farmers, so the model has worked in practice</li>')
rep('<li>Roads, green belts, lakes and 169 commercial plots are part of the plan</li>', '<li>Roads up to 24 metres wide, parks, a lake and 169 commercial plots are part of the plan</li>')
rep('<li>RERA is only applied for, not approved — filed 11 August 2026</li>', '<li>The final RERA certificate has not come yet — the application was filed on 11 August 2026</li>')
rep('<li>Registration has not opened, and the January 2025 date already passed</li>', '<li>Registration has not opened; the January 2025, Holi 2025, November 2025 and August 2026 dates have all passed</li>\n<li>The layout is being revised, so sector and plot positions are not final</li>')
rep('Clean land with consent, registry done, government seller, big project.', 'Clean land with consent, mutation done, government seller, big project.')

# ---------- FAQ ----------
def faq(q, new):
    global h
    k = h.find(f'<h3>{q}</h3>'); assert k > 0, q
    a = h.find('<p>', k); b = h.find('</p>', a) + 4
    h = h[:a] + '<p>' + new + '</p>' + h[b:]
faq('Has Saumitra Vihar registration opened?', 'No, not yet. As of 16 October 2026 there is no registration link, brochure or price list on upavp.in. Several launch dates have passed: January 2025 (Mahakumbh), Holi 2025, November 2025 and August 2026. In September 2026 the Parishad Secretary spoke of a launch during Navratri (News Nation). Public registration will open only after the final RERA certificate is issued. Keep checking upavp.in, and please do not pay anyone claiming to book a plot before the official window opens.')
faq('Is Saumitra Vihar RERA approved?', 'Not yet. UPAVP applied to UP RERA on 11 August 2026 (Dainik Jagran). A News Nation report on 17 September 2026 said the scheme had RERA’s green signal and only the final certificate was pending, but as of 16 October 2026 the approval is not complete. When the brochure comes out, take the RERA number from it and check it yourself on up-rera.in before applying. Anyone telling you today that this scheme is already RERA registered is giving you wrong information.')
faq('Who can apply for a Saumitra Vihar plot?', 'UPAVP has not released the eligibility rules for Saumitra Vihar yet. Some websites list conditions such as "resident of UP" or "age 18 to 55", but there is no official source for them. Income limits, rules about existing property, reservation categories and the application fee will come in the brochure. So please wait for the official brochure before assuming whether you qualify.')
faq('What makes the land pooling model here different?', 'In normal land acquisition, the government issues a notice and fixes compensation whether the farmer agrees or not, which often leads to court cases and stalled projects. In land pooling, farmers give their land willingly and get 25% of it back as developed plots. Saumitra Vihar is the first land pooling scheme in Uttar Pradesh. About 1,200 farmers gave around 130 acres, and a lottery of 1,122 plots was held for them on 22–23 September 2025 (Amar Ujala). The land mutation is also complete. For buyers, this means much lower risk of a land dispute surfacing later.')
faq('How many sectors does Saumitra Vihar have?', f'Saumitra Vihar is planned in 8 sectors: {SECTORS} (Free Press Journal, October 2025). Each sector is planned with parks and green space. The layout was revised before the RERA application and the final sector-wise layout is not out yet, so please do not choose or pay for a plot in a particular sector until the brochure comes out.')
faq('Is Saumitra Vihar a good investment in 2026?', 'The basics are strong. It is a government scheme, the land came through consent-based pooling so dispute risk is low, the land mutation is done, and the project is large at 560 acres. On the other side, the final RERA certificate is still pending, registration has not opened, there is no official price list (the expected rate is about ₹4,000 per sq ft), and several launch dates have already passed. Treat this as a 3 to 5 year investment. Apply through the official lottery when it opens, pay only the official rate, and do not give money to anyone before the brochure exists.')

# ---------- FAQ script: follow the site-wide accordion ----------
rep('''      function toggle() {
        var open = h.classList.toggle('active');
        h.setAttribute('aria-expanded', open ? 'true' : 'false');
        panel.style.display = open ? 'block' : 'none';
      }
      h.addEventListener('click', toggle);''',
'''      function toggle() {
        Array.prototype.forEach.call(heads, function (x) {
          var o = x.classList.contains('faq-open');
          x.classList.toggle('active', o);
          x.setAttribute('aria-expanded', o ? 'true' : 'false');
        });
      }
      h.addEventListener('click', function () { setTimeout(toggle, 0); });''')
rep('''          e.preventDefault();
          toggle();''', '''          e.preventDefault();
          h.click();''')

# ---------- checks ----------
vis = re.sub(r'<script.*?</script>|<style.*?</style>', '', h, flags=re.S)
for bad in ['192 farmers', '4 September 2026', '18 and 55 years', 'has not been published yet', 'Applied — under review', '~₹4,000']:
    if bad == '~₹4,000':
        assert bad in vis
    elif bad in vis:
        sys.exit(f'ABORT leftover {bad!r}')
assert h.count('svmap-wrap') >= 2 and 'LOW = 4000' in h

sc = json.loads(row['seo_schema'])
fa = h[h.find('<div id="FAQs">'):]; fa = fa[:fa.find('</div>')]
pairs = re.findall(r'<h3>(.*?)</h3>\s*<p>(.*?)</p>', fa, re.S)
plain = lambda s: re.sub(r'\s+', ' ', H.unescape(re.sub(r'<[^>]+>', '', s))).strip()
assert [q['name'] for q in sc['mainEntity']] == [plain(q) for q, _ in pairs], 'FAQ questions differ'
sc['mainEntity'] = [{'@type': 'Question', 'name': plain(q), 'acceptedAnswer': {'@type': 'Answer', 'text': plain(a)}} for q, a in pairs]
open('e95.new.html', 'w', encoding='utf8', newline='').write(h.replace('\n', '\r\n'))
open('e95.schema.json', 'w', encoding='utf8').write(json.dumps(sc, ensure_ascii=False, indent=2))
print('ok', len(pairs), 'faqs')
