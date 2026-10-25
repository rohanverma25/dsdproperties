# Verification CTA box (same design as posts 115/120) for 17 buyer-intent posts.
import re, sys
BOX = '''<!-- verify-cta -->
<div class="dsd-verify-cta" style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #FF5C00;border-radius:0 12px 12px 0;padding:16px 20px;margin:0 0 24px;">
  <p style="margin:0 0 6px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>
  <p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">{body}</p>
  <p style="margin:0 0 8px;">{{{{CONSULTATION_BUTTON:{button}}}}}</p>
  <p style="margin:0;font-size:13px;text-align:center;"><a href="https://dsdproperties.in/services/property-verification-lucknow" style="color:#008080;font-weight:600;">{link}</a></p>
</div>
'''
EN = dict(button='Get Property Verified — ₹5,000', link='See what we check →', price='<strong>₹5,000 for residential plots and flats, PDF report in 48 hours</strong>')
HI = dict(button='प्रॉपर्टी वेरिफिकेशन कराएँ — ₹5,000', link='देखें हम क्या-क्या जाँचते हैं →', price='<strong>आवासीय प्लॉट और फ़्लैट के लिए ₹5,000, 48 घंटे में PDF रिपोर्ट</strong>')
def en(t, b): return dict(EN, title=t, body=b + ' — ' + EN['price'] + '.')
def hi(t, b): return dict(HI, title=t, body=b + ' — ' + HI['price'] + '।')

ONLINE = 'Portals show the name on record. Encumbrance, tehsil and court records still need a physical check before you pay token money'
DHARA = ('कृषि या जिला पंचायत की ज़मीन खरीद रहे हैं?', 'पैसा देने से पहले धारा 80 का आदेश, खतौनी में मालिक, LDA या जिला पंचायत की मंज़ूरी और कोर्ट केस जाँच लें')
ZP_HI = ('जिला पंचायत क्षेत्र में प्लॉट खरीद रहे हैं?', 'पैसा देने से पहले जिला पंचायत की मंज़ूरी, RERA, खतौनी में मालिक और कोर्ट केस जाँच लें')
TXT = {
 43:  en('Buying or selling inherited property?', 'The buyer will want proof that the varasat entry is done and every legal heir has agreed. We check the khatauni, registry chain, encumbrance and court records'),
 116: en("Mutation shows the owner's name, not the full history", 'Before you buy, also check the registry chain, encumbrance, LDA status and court cases. We do all of it'),
 37:  en('Online records are only the first check', ONLINE),
 131: en('LDA online records are only the first check', ONLINE),
 80:  en('Not on the list does not mean the plot is safe', 'Before buying in any colony, check the LDA approval, khatauni owner, encumbrance and court cases'),
 77:  en('Buying land that was converted from agriculture?', 'Check the Section 80 order, the khatauni owner, LDA or Zila Panchayat approval and court cases before you pay'),
 133: en('An approved map is only one check', 'Before you buy, also confirm the owner, the registry chain, encumbrance and court cases'),
 70:  en('Not sure who approved the plot?', 'We confirm LDA or Zila Panchayat approval at source, plus the khatauni owner, encumbrance and court cases'),
 102: en('Verify the property before you pay stamp duty', 'Stamp duty is not refunded if the deal goes wrong. Check the owner, registry chain, encumbrance, LDA status and court cases first'),
 84:  hi('विरासत की प्रॉपर्टी बेच या खरीद रहे हैं?', 'खरीदार देखेगा कि वरासत दर्ज है और सभी वारिसों की सहमति है। हम खतौनी, रजिस्ट्री की पूरी चेन, भार-मुक्त प्रमाणपत्र (Encumbrance) और कोर्ट केस जाँचते हैं'),
 119: hi('दाखिल खारिज सिर्फ़ मालिक का नाम दिखाता है', 'खरीदने से पहले रजिस्ट्री की चेन, भार-मुक्त प्रमाणपत्र (Encumbrance), LDA स्थिति और कोर्ट केस भी जाँचें। हम यह सब करते हैं'),
 135: hi(*DHARA), 151: hi(*DHARA),
 81:  hi('लिस्ट में नाम नहीं, तो भी प्लॉट सुरक्षित हो, ज़रूरी नहीं', 'किसी भी कॉलोनी में खरीदने से पहले LDA की मंज़ूरी, खतौनी में मालिक, भार-मुक्त प्रमाणपत्र (Encumbrance) और कोर्ट केस जाँचें'),
 71:  hi('प्लॉट किसने मंज़ूर किया, पक्का नहीं?', 'हम LDA या जिला पंचायत की मंज़ूरी सीधे दफ़्तर से जाँचते हैं, साथ में खतौनी, भार-मुक्त प्रमाणपत्र (Encumbrance) और कोर्ट केस भी'),
 152: hi(*ZP_HI), 153: hi(*ZP_HI),
}
SKIP = re.compile(r'table of contents|what you will learn', re.I)
for pid, t in TXT.items():
    h0 = open(f'{pid}.before.html', encoding='utf8', newline='').read()
    crlf = '\r\n' in h0
    h = h0.replace('\r\n', '\n')
    if 'verify-cta' in h: sys.exit(f'ABORT {pid}: already has box')
    mask = re.sub(r'<(style|script)\b.*?</\1>', lambda m: ' ' * len(m.group(0)), h, flags=re.S)
    k = mask.find('<div class="dsd-key-facts"')
    if k >= 0:
        e = mask.find('</ul>\n</div>\n', k); assert e > k, pid
        pos, how = e + len('</ul>\n</div>\n'), 'after key facts'
    else:
        h2 = [m for m in re.finditer(r'<h2\b[^>]*>(.*?)</h2>', mask, re.S) if not SKIP.search(re.sub('<[^>]+>', '', m.group(1)))]
        pos, how = h2[1].start(), 'before h2: ' + re.sub('<[^>]+>', '', h2[1].group(1)).strip()[:50]
    new = h[:pos] + BOX.format(**t) + ('\n' if not h[pos-1:pos] == '\n' else '') + h[pos:]
    assert new.count('{{CONSULTATION_BUTTON:' + t['button'] + '}}') == 1 and new.count('<!-- verify-cta -->') == 1
    if crlf: new = new.replace('\n', '\r\n')
    open(f'{pid}.new.html', 'w', encoding='utf8', newline='').write(new)
    print(pid, how, '| context:', repr(h[max(0,pos-80):pos].replace('\n',' ')[-80:]))
