# GSC fixes (17 Oct 2026): IGRSUP EN (115) snippet + index section + login correction; IGRSUP HI (120) login correction;
# Dakhil Kharij HI (119) and Dhara 80 HI (135): quick-answer box, new FAQs, vaad portal domain change, title/meta.
import json, re, sys

def load(pid):
    row = json.load(open(f'{pid}.row.json', encoding='utf8'))
    h0 = open(f'{pid}.html', encoding='utf8', newline='').read()
    assert h0 == row['content_html'], pid
    return row, h0.replace('\r\n', '\n')

class P:
    def __init__(self, pid):
        self.pid = pid; self.row, self.h = load(pid)
        self.sc = json.loads(self.row['seo_schema']) if self.row.get('seo_schema') else None
        self.title = self.row['title']; self.meta = self.row['meta_description']
    def rep(self, old, new, n=1):
        c = self.h.count(old)
        if c != n: sys.exit(f'ABORT {self.pid}: expected {n}, found {c}: {old[:80]!r}')
        self.h = self.h.replace(old, new)
    def insert_before(self, marker, block):
        assert self.h.count(marker) == 1, (self.pid, marker[:60]); self.h = self.h.replace(marker, block + marker)
    def insert_after(self, marker, block):
        assert self.h.count(marker) == 1, (self.pid, marker[:60]); self.h = self.h.replace(marker, marker + block)
    def faqpage(self):
        s = self.sc
        if s.get('@type') == 'FAQPage': return s
        for g in s.get('@graph', []):
            if g.get('@type') == 'FAQPage': return g
        sys.exit(f'ABORT {self.pid}: no FAQPage in schema')
    def schema_text(self, old, new):
        t = json.dumps(self.sc, ensure_ascii=False)
        o = json.dumps(old, ensure_ascii=False)[1:-1]; nw = json.dumps(new, ensure_ascii=False)[1:-1]
        if t.count(o) == 1: self.sc = json.loads(t.replace(o, nw)); return True
        return False
    def add_q(self, q, a):
        self.faqpage()['mainEntity'].append({'@type': 'Question', 'name': q, 'acceptedAnswer': {'@type': 'Answer', 'text': a}})
    def save(self):
        open(f'{self.pid}.new.html', 'w', encoding='utf8', newline='').write(self.h.replace('\n', '\r\n'))
        json.dump({'title': self.title, 'meta_description': self.meta, 'seo_schema': json.dumps(self.sc, ensure_ascii=False, indent=2)},
                  open(f'{self.pid}.fields.json', 'w', encoding='utf8'), ensure_ascii=False)
        print(self.pid, 'ok', len(self.title), 'title chars |', self.title)

def vaad_fix(p):
    parts = re.split(r'(<style.*?</style>|<script.*?</script>)', p.h, flags=re.S)
    n = sum(x.count('vaad.up.nic.in') for x in parts if not x.startswith(('<style', '<script')))
    p.h = ''.join(x if x.startswith(('<style', '<script')) else x.replace('vaad.up.nic.in', 'vaad.up.gov.in') for x in parts)
    t = json.dumps(p.sc, ensure_ascii=False); p.sc = json.loads(t.replace('vaad.up.nic.in', 'vaad.up.gov.in'))
    return n

BOX = '<div class="dsd-key-facts" style="background:#f0fdfa;border:1px solid rgba(0,128,128,0.25);border-left:4px solid #008080;border-radius:0 12px 12px 0;padding:16px 20px;margin:0 0 24px;">\n  <p style="margin:0 0 8px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>\n  <ul style="margin:0;padding-left:20px;">\n{items}  </ul>\n</div>\n'
LI = '    <li style="margin:5px 0;line-height:1.7;font-size:15px;color:#374151;">{}</li>\n'
def box(title, items): return '<!-- quick-answers -->\n' + BOX.format(title=title, items=''.join(LI.format(i) for i in items))

LOGIN_EN = 'When we checked igrsup.gov.in on 17 October 2026, the property search links opened a <strong>User Login</strong> page (user ID, password and captcha). If you do not have an account, use the <strong>Register Now</strong> option on the home page first.'
LOGIN_EN_PLAIN = 'When we checked igrsup.gov.in on 17 October 2026, the property search links opened a User Login page (user ID, password and captcha). If you do not have an account, use the Register Now option on the home page first.'

# ===================== 115 IGRSUP English =====================
p = P(115)
p.title = 'IGRSUP Property Search 2026: igrsup.gov.in Sampatti Vivaran Guide'
p.meta = 'Step-by-step igrsup.gov.in guide (2026): search Sampatti Vivaran, use the IGRSUP Index for deeds after Dec 2017, verify e-stamps and avoid 5 costly mistakes.'
p.rep('Key Facts (updated 16 October 2026)', 'Key Facts (updated 17 October 2026)')
p.rep('search shows registered sale deeds, mortgages and gift deeds — <strong>free, with no login</strong>.</li>',
      'search shows registered sale deeds, mortgages and gift deeds. ' + LOGIN_EN + '</li>')
p.rep('Note: IGRSUP property search does not require login or account creation — it is a public, free-to-use facility for all citizens.</p>',
      'Note: ' + LOGIN_EN + '</p>')
p.rep('The portal displays all registered transactions for that property. The service is completely free and does not require login.</p>',
      'The portal displays all registered transactions for that property. ' + LOGIN_EN_PLAIN + '</p>')
p.rep('Yes, basic property search on IGRSUP is completely free and does not require user registration or login. You only need',
      'Basic property search on IGRSUP has been free to use. ' + LOGIN_EN_PLAIN + ' After that, you only need')
for old, new in [
    ('The service is completely free and does not require login.', LOGIN_EN_PLAIN),
    ('Yes, basic property search on IGRSUP is completely free and does not require user registration or login. You only need', 'Basic property search on IGRSUP has been free to use. ' + LOGIN_EN_PLAIN + ' After that, you only need')]:
    print('  schema 115:', p.schema_text(old, new))
INDEX = '''<h2 id="igrsup-index" style="margin-top: 40px; font-size: 22px; color: #011f4b; font-weight: bold; border-left: 5px solid #FF5C00; padding-left: 15px;">IGRSUP Index Search — Deeds Registered After 5 December 2017</h2>
<p>If you do not have the khasra number or the property ID, use the <strong>IGRSUP Index</strong>. It lets you search deeds registered after <strong>5 December 2017</strong> by address details — tehsil, colony and mohalla name — instead of a property ID.</p>
<ul>
<li>Use it when you only know the locality, not the khasra number or property ID.</li>
<li>It covers deeds from 5 December 2017 onwards. For older deeds, use the Sampatti Vivaran search by khasra or property ID, or ask at the Sub-Registrar Office.</li>
<li>As with the main search, match the seller’s name and the khasra or plot details in the result with the documents you were given.</li>
</ul>
'''
p.insert_before('<h2 style="margin-top: 40px; font-size: 22px; color: #011f4b; font-weight: bold; border-left: 5px solid #FF5C00; padding-left: 15px;">Stamp Duty &amp; Registration Charges Lucknow 2026 (via IGRSUP)</h2>', INDEX)
Q1, A1 = 'What is the IGRSUP Index?', 'The IGRSUP Index is a search option for deeds registered after 5 December 2017. It lets you search by address details such as tehsil, colony and mohalla name, so you can find a deed even without the khasra number or property ID. For deeds registered before that date, use the Sampatti Vivaran search by khasra or property ID, or ask at the Sub-Registrar Office.'
Q2, A2 = 'Do I need to log in to search property on IGRSUP?', LOGIN_EN_PLAIN + ' Once logged in, choose rural or urban property and enter the district, tehsil, village and khasra number, or the district and property ID.'
p.insert_after('Selecting the wrong SRO is the most common cause of failed property searches and EC applications.</p>\n',
               f'<h3>{Q1}</h3>\n<p style="display: none;">{A1}</p>\n<h3>{Q2}</h3>\n<p style="display: none;">{A2}</p>\n')
p.add_q(Q1, A1); p.add_q(Q2, A2)
assert 'no login' not in p.h and 'does not require login' not in p.h
p.save()

# ===================== 120 IGRSUP Hindi =====================
p = P(120)
LOGIN_HI = '17 अक्टूबर 2026 को जाँचने पर igrsup.gov.in के सम्पत्ति खोज वाले लिंक पहले <strong>यूज़र लॉगिन</strong> पेज (यूज़र आईडी, पासवर्ड और कैप्चा) पर ले गए। अकाउंट न हो तो होम पेज पर <strong>Register Now</strong> से पहले रजिस्टर करें।'
LOGIN_HI_PLAIN = re.sub(r'</?strong>', '', LOGIN_HI)
p.rep('सेक्शन में रजिस्टर्ड बैनामा, रेहन और दानपत्र <strong>मुफ्त और बिना लॉगिन</strong> देखे जा सकते हैं।</li>',
      'सेक्शन में रजिस्टर्ड बैनामा, रेहन और दानपत्र देखे जा सकते हैं। ' + LOGIN_HI + '</li>')
p.rep('<strong>खास बात: इसके लिए कोई अकाउंट या लॉगिन नहीं चाहिए।</strong></p>', '<strong>ध्यान दें:</strong> ' + LOGIN_HI + '</p>')
p.rep('कैप्चा भरकर सबमिट करें। यह सेवा पूरी तरह मुफ्त है और लॉगिन नहीं चाहिए।</p>', 'कैप्चा भरकर सबमिट करें। ' + LOGIN_HI_PLAIN + '</p>')
p.rep('हां, IGRSUP पर बेसिक प्रॉपर्टी सर्च बिल्कुल मुफ्त है और किसी रजिस्ट्रेशन या लॉगिन की जरूरत नहीं है।', 'IGRSUP पर बेसिक प्रॉपर्टी सर्च अब तक मुफ्त रही है। ' + LOGIN_HI_PLAIN)
for old, new in [('यह सेवा पूरी तरह मुफ्त है और लॉगिन नहीं चाहिए।', LOGIN_HI_PLAIN),
                 ('हां, IGRSUP पर बेसिक प्रॉपर्टी सर्च बिल्कुल मुफ्त है और किसी रजिस्ट्रेशन या लॉगिन की जरूरत नहीं है।', 'IGRSUP पर बेसिक प्रॉपर्टी सर्च अब तक मुफ्त रही है। ' + LOGIN_HI_PLAIN)]:
    print('  schema 120:', p.schema_text(old, new))
assert 'बिना लॉगिन' not in p.h
p.save()

# ===================== 119 Dakhil Kharij Hindi =====================
p = P(119)
p.title = 'Dakhil Kharij UP 2026: दाखिल खारिज क्या है, कितने दिन में, फीस व ऑनलाइन स्टेटस'
p.meta = 'दाखिल खारिज (नामांतरण) क्या है और UP में कितने दिन में होता है? 30 दिन का नियम, ₹200–2,500 फीस, vaad.up.gov.in पर ऑनलाइन आवेदन व स्टेटस — आसान हिंदी में पूरी प्रक्रिया।'
n = vaad_fix(p); print('  119 vaad links fixed:', n)
SRC119 = 'DSD Properties फील्ड रिसर्च — अप्रैल 2026</p>\n'
p.insert_after(SRC119, box('सीधे जवाब — दाखिल खारिज (UP), 17 अक्टूबर 2026', [
    '<strong>क्या है:</strong> रजिस्ट्री के बाद खतौनी में पुराने मालिक का नाम हटाकर नए मालिक का नाम दर्ज करना। इसे नामांतरण या म्यूटेशन भी कहते हैं (UP राजस्व संहिता 2006, धारा 34)।',
    '<strong>कितने दिन में होता है:</strong> गैर-विवादित मामले 30 दिन में निपटाने का नियम है (2025 से)। आपत्ति हो या कागज़ अधूरे हों, तो 90 दिन तक लग सकते हैं।',
    '<strong>रजिस्ट्री के कितने दिन बाद:</strong> रजिस्ट्री के 30–45 दिन बाद आवेदन करना ठीक रहता है। 90 दिन से ज़्यादा न टालें।',
    '<strong>फीस:</strong> सरकारी शुल्क ₹200 से ₹2,500, प्रॉपर्टी की कीमत के हिसाब से।',
    '<strong>ऑनलाइन आवेदन और स्टेटस:</strong> <strong>vaad.up.gov.in</strong> पर "ऑनलाइन आवेदन" में धारा "34" (नामांतरण) चुनें। स्टेटस भी इसी पोर्टल पर देखें, और आदेश के बाद खतौनी upbhulekh.gov.in पर जाँचें।',
    '<strong>पोर्टल का पता बदला है:</strong> पुराना vaad.up.nic.in अब vaad.up.gov.in पर शिफ्ट हो गया है (हमने 17 अक्टूबर 2026 को जाँचा)।']))
QD, AD = 'रजिस्ट्री के कितने दिन बाद दाखिल खारिज होता है?', 'रजिस्ट्री के 30–45 दिन बाद vaad.up.gov.in पर आवेदन करना सही रहता है, ताकि रजिस्ट्री का रिकॉर्ड सिस्टम में आ चुका हो। Amar Ujala के अनुसार नई RCCMS व्यवस्था में रजिस्ट्री के साथ ही नामांतरण का वाद अपने आप दर्ज हो जाता है। आवेदन के बाद गैर-विवादित मामलों को 30 दिन में निपटाने का नियम है। आवेदन को 90 दिन से ज़्यादा न टालें।'
p.insert_after('तो concerned Tehsildar office से follow-up करें।</p>\n', f'\n<h3>{QD}</h3>\n<p style="display:none">{AD}</p>\n')
p.add_q(QD, AD)
p.save()

# ===================== 135 Dhara 80 Hindi =====================
p = P(135)
p.title = 'Dhara 80 UP 2026: धारा 80 क्या है, कृषि भूमि आवासीय कैसे करें, ऑनलाइन आवेदन व स्टेटस'
p.meta = 'धारा 80 क्या है? UP में कृषि भूमि को आवासीय करने का तरीका — vaad.up.gov.in पर ऑनलाइन आवेदन, सर्कल रेट का 2% शुल्क, 45 दिन में SDM आदेश और स्टेटस चेक। आसान हिंदी में।'
n = vaad_fix(p); print('  135 vaad links fixed:', n)
p.insert_after('यूपी कैबिनेट अध्यादेश 24 मार्च 2026, इलाहाबाद हाईकोर्ट, IGRSUP</p>\n', box('सीधे जवाब — धारा 80 (UP), 17 अक्टूबर 2026', [
    '<strong>धारा 80 क्या है:</strong> UP राजस्व संहिता 2006 का वह प्रावधान जिसके तहत SDM कृषि भूमि को गैर-कृषि (आवासीय या व्यावसायिक) घोषित करते हैं। यह पुरानी धारा 143 की जगह लागू है।',
    '<strong>ऑनलाइन आवेदन:</strong> <strong>vaad.up.gov.in</strong> पर "ऑनलाइन आवेदन" में धारा "80" (कृषक से अकृषक) चुनें। निवेश मित्र (niveshmitra.up.nic.in) के single window से भी आवेदन का विकल्प है।',
    '<strong>फीस:</strong> आम तौर पर सर्कल रेट का 2%, सरकारी चालान से — किसी एजेंट को नहीं।',
    '<strong>कितने दिन में:</strong> आवेदन से SDM आदेश तक 45 दिन की समय-सीमा है।',
    '<strong>स्टेटस कैसे चेक करें:</strong> vaad.up.gov.in पर "गैर कृषिक भूमि (धारा-80) हेतु आवेदन की स्थिति जानें" पर क्लिक करें। आदेश के 2–3 हफ्ते बाद upbhulekh.gov.in की खतौनी में "गैर-कृषि" लिखा दिखना चाहिए।',
    '<strong>LDA/UPAVP की अप्रूव्ड कॉलोनी:</strong> 24 मार्च 2026 के अध्यादेश के बाद, जहाँ नक्शा स्वीकृत है वहाँ धारा 80 deemed approved मानी जाती है। गाँव और ज़िला पंचायत क्षेत्र में अलग आदेश अब भी ज़रूरी है।']))
old_chk = 'चल रहे application का status Nivesh Mitra dashboard पर भी देखा जा सकता है।'
new_chk = 'चल रहे आवेदन का status vaad.up.gov.in पर "गैर कृषिक भूमि (धारा-80) हेतु आवेदन की स्थिति जानें" से, या Nivesh Mitra dashboard पर देखा जा सकता है।'
p.rep(old_chk, new_chk)
print('  schema 135 check:', p.schema_text(old_chk, new_chk))
QO, AO = 'धारा 80 का ऑनलाइन आवेदन कहाँ करें? (Dhara 80 online)', 'राजस्व विभाग के पोर्टल vaad.up.gov.in पर जाएँ, "ऑनलाइन आवेदन" में धारा "80" (कृषक से अकृषक) चुनें, खतौनी, खसरा, रजिस्ट्री और आधार जैसे दस्तावेज़ अपलोड करें। निवेश मित्र (niveshmitra.up.nic.in) के single window से भी आवेदन का विकल्प है। पुराना पता vaad.up.nic.in अब vaad.up.gov.in पर शिफ्ट हो गया है। आवेदन का स्टेटस vaad.up.gov.in पर "गैर कृषिक भूमि (धारा-80) हेतु आवेदन की स्थिति जानें" से देखें।'
p.insert_before('  <li class="faq-li-class">\n    <h4>143 land conversion charges कितने हैं?</h4>',
                f'  <li class="faq-li-class">\n    <h4>{QO}</h4>\n    <p style="display:none;">{AO}</p>\n  </li>\n')
p.add_q(QO, AO)
p.save()
