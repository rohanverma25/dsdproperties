# Add a verification CTA box right after the Key Facts box in IGRSUP guides 115 (EN) and 120 (HI).
import sys
BOX = '''<!-- verify-cta -->
<div class="dsd-verify-cta" style="background:#fff7ed;border:1px solid #fed7aa;border-left:4px solid #FF5C00;border-radius:0 12px 12px 0;padding:16px 20px;margin:0 0 24px;">
  <p style="margin:0 0 6px;font-weight:700;color:#011f4b;font-size:16px;">{title}</p>
  <p style="margin:0 0 12px;line-height:1.7;font-size:15px;color:#374151;">{body}</p>
  <p style="margin:0 0 8px;">{{{{CONSULTATION_BUTTON:{button}}}}}</p>
  <p style="margin:0;font-size:13px;text-align:center;"><a href="https://dsdproperties.in/services/property-verification-lucknow" style="color:#008080;font-weight:600;">{link}</a></p>
</div>
'''
TXT = {
 115: dict(title='IGRSUP shows registry history only',
           body='Before paying token money, get a full verification: IGRSUP, khatauni, LDA and encumbrance — <strong>₹5,000 for residential plots and flats, PDF report in 48 hours</strong>.',
           button='Get Property Verified — ₹5,000', link='See what we check →'),
 120: dict(title='IGRSUP सिर्फ़ रजिस्ट्री का इतिहास दिखाता है',
           body='टोकन मनी देने से पहले पूरी जाँच कराएँ: IGRSUP, खतौनी, LDA और भार-मुक्त प्रमाणपत्र (Encumbrance) — <strong>आवासीय प्लॉट और फ़्लैट के लिए ₹5,000, 48 घंटे में PDF रिपोर्ट</strong>।',
           button='प्रॉपर्टी वेरिफिकेशन कराएँ — ₹5,000', link='देखें हम क्या-क्या जाँचते हैं →'),
}
for pid, t in TXT.items():
    h0 = open(f'{pid}.html', encoding='utf8', newline='').read()
    h = h0.replace('\r\n', '\n')
    if 'verify-cta' in h: sys.exit(f'ABORT {pid}: already has box')
    k = h.find('<div class="dsd-key-facts"'); e = h.find('</ul>\n</div>\n', k)
    assert k > 0 and e > k and h.count('<div class="dsd-key-facts"') == 1, pid
    e += len('</ul>\n</div>\n')
    h = h[:e] + BOX.format(**t) + h[e:]
    assert h.count('{{CONSULTATION_BUTTON:' + t['button'] + '}}') == 1
    open(f'{pid}.new.html', 'w', encoding='utf8', newline='').write(h.replace('\n', '\r\n'))
    print(pid, 'ok')
