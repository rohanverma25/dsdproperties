# Change Saumitra Vihar expected rate to ~Rs 4,000/sq ft (user's market assessment) in posts 95 (EN) and 96 (HI).
import json, re, sys, html as H

RATE, SQFT, EXTRA = 4000, 10.7639, 1.08
NN = 'https://www.newsnationtv.com/states/uttar-pradesh/preparations-underway-for-8000-plots-in-lucknow-registration-for-three-major-residential-schemes-to-begin-during-navratri-12544292'
PAT = 'https://www.patrika.com/lucknow-news/awas-vikas-to-launch-new-jail-road-housing-scheme-on-holi-registrations-open-for-2000-plots-19428787'
FPJ = 'https://www.freepressjournal.in/business/saumitra-vihar-housing-scheme-in-lucknow-to-launch-next-month-2000-plots-on-offer-and-big-gains-for-farmers'
AU10 = 'https://www.amarujala.com/lucknow/saumitra-vihar-residential-scheme-to-be-launched-in-august-lucknow-news-c-13-lko1096-1821087-2026-07-10'
def A(u, t): return f'<a href="{u}" target="_blank" rel="noopener" style="color:#008080;font-weight:600;">{t}</a>'

def money(v, lang):
    if v >= 1e7: return f'₹{v / 1e7:.2f} ' + ('crore' if lang == 'en' else 'करोड़')
    return f'₹{v / 1e5:.2f} ' + ('lakh' if lang == 'en' else 'लाख')
def short(v): return f'₹{v / 1e7:.2f} Cr' if v >= 1e7 else f'₹{v / 1e5:.2f} L'

SIZES = [40.74, 60.59, 75, 122.23, 200, 300]

def run(pid, lang, edits, regex_edits, faqs):
    row = json.load(open(f'p{pid}.row.json', encoding='utf8'))
    h0 = open(f'p{pid}.html', encoding='utf8', newline='').read()
    assert h0 == row['content_html']
    h = h0.replace('\r\n', '\n')
    for old, new in edits:
        c = h.count(old)
        if c != 1: sys.exit(f'ABORT {pid}: {c}x {old[:80]!r}')
        h = h.replace(old, new)
    for pat, new in regex_edits:
        h, c = re.subn(pat, lambda m: new, h, flags=re.S)
        if c != 1: sys.exit(f'ABORT {pid}: regex {c}x {pat[:80]!r}')
    for q, new in faqs.items():
        k = h.find(f'<h3>{q}</h3>'); assert k > 0, q
        a = h.find('<p>', k); b = h.find('</p>', a) + 4
        h = h[:a] + '<p>' + new + '</p>' + h[b:]
    # price table rows
    unit = 'sq m' if lang == 'en' else 'वर्ग मीटर'
    for s in SIZES:
        a = s * SQFT * RATE
        pat = rf'(<td>{re.escape(str(s))} {unit}</td>\n<td>[\d,]+</td>\n<td>\d+</td>\n)<td>[^<]+</td>\n<td>[^<]+</td>'
        h, c = re.subn(pat, lambda m: m.group(1) + f'<td>{money(a, lang)}</td>\n<td>{money(a * EXTRA, lang)}</td>', h)
        if c != 1: sys.exit(f'ABORT {pid}: table row {s} {c}')
    # calculator: single rate, show one number when low == high
    h, c = re.subn(r'var LOW = \d+, HIGH = \d+, SQFT = 10\.7639, EXTRA = [\d.]+;', 'var LOW = 4000, HIGH = 4000, SQFT = 10.7639, EXTRA = 1.08;', h)
    assert c == 1
    old = '    function range(lo, hi) {\n'
    assert h.count(old) == 1
    h = h.replace(old, old + "      if (Math.abs(hi - lo) < 1) { return hi >= 10000000 ? '₹' + (lo / 10000000).toFixed(2) + ' Cr' : '₹' + (lo / 100000).toFixed(2) + ' L'; }\n")
    s75 = 75 * SQFT * RATE
    h, c = re.subn(r'(id="dsdCalcLand">)[^<]+(</span>)', lambda m: m.group(1) + short(s75) + m.group(2), h); assert c == 1
    h, c = re.subn(r'(id="dsdCalcAll">)[^<]+(</span>)', lambda m: m.group(1) + short(s75 * EXTRA) + m.group(2), h); assert c == 1
    vis = re.sub(r'<script.*?</script>|<style.*?</style>', '', h, flags=re.S)
    for bad in ['₹3,000–3,500', '₹3,000–₹3,500', '₹3,000 to ₹3,500', '₹2,500 से ₹3,000 प्रति', '+7%', '₹11–13', '₹13–15', '₹2.5–3K']:
        if bad in vis: sys.exit(f'ABORT {pid}: leftover {bad!r}')
    # schema: rebuild FAQPage answers from the FAQ HTML (questions must match)
    sc = json.loads(row['seo_schema'])
    fa = h[h.find('<div id="FAQs">'):]; fa = fa[:fa.find('</div>')]
    pairs = re.findall(r'<h3>(.*?)</h3>\s*<p>(.*?)</p>', fa, re.S)
    plain = lambda s: re.sub(r'\s+', ' ', H.unescape(re.sub(r'<[^>]+>', '', s))).strip()
    old_q = [q['name'] for q in sc['mainEntity']]
    if old_q == [plain(q) for q, _ in pairs]:
        sc['mainEntity'] = [{'@type': 'Question', 'name': plain(q), 'acceptedAnswer': {'@type': 'Answer', 'text': plain(a)}} for q, a in pairs]
        how = 'rebuilt'
    else:
        how = 'text-replaced'
        txt = json.dumps(sc, ensure_ascii=False)
        for old, new in SCHEMA_FALLBACK.get(pid, []):
            assert txt.count(old) == 1, old[:60]; txt = txt.replace(old, new)
        sc = json.loads(txt)
    open(f'p{pid}.new.html', 'w', encoding='utf8', newline='').write(h.replace('\n', '\r\n'))
    open(f'p{pid}.schema.json', 'w', encoding='utf8').write(json.dumps(sc, ensure_ascii=False, indent=2))
    print(pid, 'ok', len(h0), '->', len(h), 'schema', how, len(pairs))

SCHEMA_FALLBACK = {}

# ---------------- Hindi (96) ----------------
HI_FAQ_PRICE = 'हमारा अनुमान है कि सरकारी लॉटरी करीब ₹4,000 प्रति वर्ग फुट (लगभग ₹43,000 प्रति वर्ग मीटर) की दर पर खुलेगी — यह DSD Properties का बाज़ार आकलन है। इस आधार पर 75 वर्ग मीटर का प्लॉट करीब ₹32.29 लाख और 300 वर्ग मीटर का प्लॉट करीब ₹1.29 करोड़ का होगा — स्टाम्प ड्यूटी और रजिस्ट्री से पहले। UPAVP ने अभी आधिकारिक रेट लिस्ट जारी नहीं की है। ख़बरों में दर इससे कम बताई गई थी: फरवरी 2025 में ₹2,200–2,400 और सितंबर 2026 में ₹2,500–3,000 प्रति वर्ग फुट।'
HI_PRICE_P = f'<p>हमारा अनुमान है कि सरकारी लॉटरी <strong>करीब ₹4,000 प्रति वर्ग फुट</strong> (लगभग ₹43,000 प्रति वर्ग मीटर) की दर पर खुलेगी। यह DSD Properties का बाज़ार आकलन है: LDA की नई योजनाओं में दर ₹2,800 (वरुण विहार) से ₹3,800 (नैमिष नगर) प्रति वर्ग फुट तय हुई है ({A(NN, "न्यूज़ नेशन")}), और इस इलाके में ज़मीन के दाम लगातार बढ़े हैं।</p>'
run(96, 'hi', [
    ('<span class="dsd-stat-num sm">₹2,500–3,000</span><span class="dsd-stat-label">प्रति वर्ग फुट (अनुमानित)</span>', '<span class="dsd-stat-num sm">~₹4,000</span><span class="dsd-stat-label">प्रति वर्ग फुट (अपेक्षित)</span>'),
    ('अनुमानित दर पर सबसे छोटे प्लॉट करीब <strong>₹11–13 लाख</strong> के बैठते हैं।', 'अपेक्षित दर पर सबसे छोटे प्लॉट करीब <strong>₹17.5 लाख</strong> के बैठते हैं।'),
    ('<li>UPAVP ने अभी तक <strong>आधिकारिक रेट लिस्ट जारी नहीं की है</strong>। ऊपर दी गई दर ख़बरों में आया अनुमान है।</li>', '<li>UPAVP ने अभी तक <strong>आधिकारिक रेट लिस्ट जारी नहीं की है</strong>। ऊपर दी गई ₹4,000 की दर हमारा आकलन है, घोषित दर नहीं।</li>'),
    ('<li>अनुमान समय के साथ बदले हैं:', '<li>ख़बरों में आए अनुमान समय के साथ बढ़ते गए हैं:'),
    ('गणना ₹2,500–₹3,000 प्रति वर्ग फुट पर की गई है।', 'गणना करीब ₹4,000 प्रति वर्ग फुट पर की गई है।'),
    ('<th>₹2,500/वर्ग फुट पर</th>\n<th>₹3,000/वर्ग फुट पर</th>', '<th>₹4,000/वर्ग फुट पर</th>\n<th>स्टाम्प ड्यूटी + रजिस्ट्रेशन (~8%) के साथ</th>'),
    ('<td>₹2,500–3,000 प्रति वर्ग फुट की दर अनुमान है</td>', '<td>करीब ₹4,000 प्रति वर्ग फुट अपेक्षित (DSD बाज़ार आकलन)</td>'),
    ('<li>सबसे छोटे प्लॉट करीब ₹11–13 लाख के — शुरुआत के लिए कम कीमत</li>', '<li>सबसे छोटे प्लॉट करीब ₹17.5 लाख के — लखनऊ में शुरुआत के लिए वाजिब</li>'),
    ('और ख़बरों में अनुमान ₹2,200 से बढ़कर ₹3,000 तक पहुँचा है', 'और अनुमान ₹2,200 से बढ़कर अब करीब ₹4,000 तक पहुँच गया है'),
    ('(ख़बरों में ₹2,500–₹3,000 प्रति वर्ग फुट का अनुमान है)', '(अपेक्षित दर करीब ₹4,000 प्रति वर्ग फुट)'),
], [
    (r'<li><strong>अनुमानित दर: ₹2,500–₹3,000 प्रति वर्ग फुट</strong>.*?</li>',
     f'<li><strong>अपेक्षित लॉटरी दर: करीब ₹4,000 प्रति वर्ग फुट</strong> (लगभग ₹43,000 प्रति वर्ग मीटर) — यह DSD Properties का बाज़ार आकलन है। सितंबर 2026 की ख़बरों में दर इससे कम, ₹2,500–3,000 बताई गई थी ({A(NN, "न्यूज़ नेशन")})। UPAVP ने अभी दर घोषित नहीं की है।</li>'),
    (r'<p>ख़बरों में आई अनुमानित दर <strong>₹2,500 से ₹3,000 प्रति वर्ग फुट</strong>.*?</p>', HI_PRICE_P),
    (r'<p style="font-size: 13px; color: #64748b; margin-top: -8px;">ये सिर्फ़ ज़मीन की कीमत है.*?</p>',
     '<p style="font-size: 13px; color: #64748b; margin-top: -8px;">पहला कॉलम सिर्फ़ ज़मीन की कीमत है। दूसरे में पुरुष खरीदार के लिए 7% स्टाम्प ड्यूटी और 1% रजिस्ट्रेशन फीस जोड़ी गई है। कॉर्नर या पार्क-फेसिंग जैसे लोकेशन चार्ज अलग से लगेंगे।</p>'),
], {
    'सौमित्र विहार में प्लॉट की कीमत कितनी होगी?': HI_FAQ_PRICE,
})

# ---------------- English (95) ----------------
EN_PRICE_P = f'<p>We expect the government lottery to open at <strong>about ₹4,000 per square foot</strong>, roughly <strong>₹43,000 per sq m</strong>. This is DSD Properties’ market assessment. LDA’s newest schemes are priced between ₹2,800 (Varun Vihar) and ₹3,800 (Naimish Nagar) per sq ft ({A(NN, "News Nation")}), and land prices in this belt have kept rising.</p>'
EN_FAQ_PRICE = 'We expect the government lottery to open at about ₹4,000 per square foot, roughly ₹43,000 per sq m. This is DSD Properties’ market assessment. On that basis a 75 sq m plot would cost about ₹32.29 lakh and a 300 sq m plot about ₹1.29 crore, before stamp duty and registration. UPAVP has not released an official price list yet. News reports had put the rate lower: ₹2,200–2,400 in February 2025 and ₹2,500–3,000 in September 2026.'
run(95, 'en', [
    ('<span class="dsd-stat-num sm">₹3,000–3,500</span><span class="dsd-stat-label">Per Sq Ft (expected)</span>', '<span class="dsd-stat-num sm">~₹4,000</span><span class="dsd-stat-label">Per Sq Ft (expected)</span>'),
    ('<li><strong>Expected land rate: ₹3,000–₹3,500 per square foot</strong> (roughly ₹32,300–₹37,700 per square metre). This is an estimate, not a published rate.</li>',
     f'<li><strong>Expected lottery rate: about ₹4,000 per square foot</strong> (roughly ₹43,000 per square metre), based on DSD Properties’ market assessment. News reports in September 2026 put it lower, at ₹2,500–3,000 ({A(NN, "News Nation")}). UPAVP has not published a rate yet.</li>'),
    ('At the expected rate, the smallest ones work out to around <strong>₹13 lakh</strong>.', 'At the expected rate, the smallest ones work out to around <strong>₹17.5 lakh</strong>.'),
    ('<p>The expected land rate is <strong>₹3,000 to ₹3,500 per square foot</strong>. In square metre terms that is roughly <strong>₹32,300 to ₹37,700 per sq m</strong>.</p>', EN_PRICE_P),
    ('<li>UPAVP has <strong>not released an official price list</strong> yet. The rate above is an estimate reported in the news.</li>', '<li>UPAVP has <strong>not released an official price list</strong> yet. The ₹4,000 figure above is our estimate, not a published rate.</li>'),
    ('<li>Older reports (and earlier versions of this guide) put the rate at around <strong>₹25,000–₹26,000 per sq m, about ₹2,300–₹2,400 per sq ft</strong>. That was the earlier working estimate; the figure has since been revised upward. Please go by the newer range.</li>',
     f'<li>News estimates have risen over time: <strong>₹2,200–2,400</strong> in February 2025 ({A(PAT, "Patrika")}), <strong>₹2,200–2,700</strong> in October 2025 ({A(FPJ, "Free Press Journal")}), <strong>about ₹2,500</strong> in July 2026 ({A(AU10, "Amar Ujala")}) and <strong>₹2,500–3,000 per sq ft</strong> in September 2026 ({A(NN, "News Nation")}).</li>'),
    ('adds about 7% for stamp duty and registration in Uttar Pradesh. Worked out at ₹3,000–₹3,500 per sq ft.', 'adds about 8% for stamp duty (7% for a male buyer) and the 1% registration fee in Uttar Pradesh. Worked out at about ₹4,000 per sq ft.'),
    ('<span class="dsd-cc-label">Approx all-in (+7%)</span>', '<span class="dsd-cc-label">Approx all-in (+8%)</span>'),
    ('<th>At ₹3,000/sq ft</th>\n<th>At ₹3,500/sq ft</th>', '<th>At ₹4,000/sq ft</th>\n<th>With stamp duty + registration (~8%)</th>'),
    ('<td>Rate of ₹3,000–3,500 per sq ft is an estimate</td>', '<td>About ₹4,000 per sq ft expected (DSD market estimate)</td>'),
    ('<li>Smallest plots work out to around ₹13–15 lakh — a low entry point</li>', '<li>Smallest plots work out to around ₹17.5 lakh — a reasonable entry point in Lucknow</li>'),
    ('<li>No official price list yet — every rate you see is an estimate, and the estimate has already moved up once</li>', '<li>No official price list yet — the expected rate has risen from ₹2,200 in early reports to about ₹4,000 today</li>'),
    ('the expected rate has already been revised upward once to ₹3,000–₹3,500 per sq ft,', 'the expected rate has kept rising and is now about ₹4,000 per sq ft,'),
    ('<p style="font-size: 13px; color: #64748b; margin-top: -8px;">These are land cost only, worked out from the expected rate. Registry, stamp duty and any location charges will be extra.</p>',
     '<p style="font-size: 13px; color: #64748b; margin-top: -8px;">The first column is land cost only. The second adds 7% stamp duty (male buyer) and the 1% registration fee. Location charges such as corner or park-facing will be extra.</p>'),
], [], {
    'What will a plot in Saumitra Vihar cost?': EN_FAQ_PRICE,
})
