# Builds resources/data/circle-rates/lucknow-sarojini-nagar-dwitiya.json from the hand-transcribed forms of the official DM
# rate list for SRO Sarojini Nagar II (RateList_383_01-08-2025.pdf, effective 01-08-2025, order 971 of 01.08.2025).
#   form2_src.txt (PDF pages 27-35): name|ward code|ward name|plot <9 m|flat ordinary|flat premium
#   form4_src.txt (pages 42-50):     sr|9-12|12-18|18+|agri district|link|abadi|general|shop|office|godown
#   form3_src.txt (pages 36-41):     road|village (- = every mohalla on it)|plot|agri|shop|office|godown
# Category from Form 1 (pages 16-26): 52 urban, 59 semi-urban, 10 rural. No V-codes.
# Form 4 rows 1, 19 and 78 carry a "*" (clerical correction on the SRO's report) — values used as printed.
# Then run ../amend-2026-06/apply.py for the 04.06.2026 revision.
import json, os, re

here = os.path.dirname(os.path.abspath(__file__))
lines = lambda f: [l.rstrip('\n') for l in open(os.path.join(here, f), encoding='utf-8') if l.strip() and not l.startswith('#')]
f2 = [l.split('|') for l in lines('form2_src.txt')]
en = lines('english_names.txt')
f4 = {int(p[0]): p[1:] for p in (l.split('|') for l in lines('form4_src.txt'))}
f3 = [l.split('|') for l in lines('form3_src.txt')]
assert len(f2) == len(en) == len(f4) == 121, (len(f2), len(en), len(f4))
assert all(len(v) == 10 for v in f4.values()) and all(len(s) == 7 for s in f3)

RURAL = {'अमावां', 'ऐंन', 'गुदौली', 'तेरवा', 'दराबनगर बरकोता', 'नरायनपुर', 'नानमऊ', 'रामदासपुर', 'सहिजनपुर', 'सादुल्लानगर'}
URBAN = {'अनौरा', 'अमौसी', 'अली नगर सुनहरा', 'अवध विहार कालोनी', 'आजाद विहार कालोनी', 'आशियाना', 'कानपुर रोड योजना', 'कलिया खेड़ा',
         'कलिया खेड़ा (अनन्त नगर योजना)', 'कासिमपुर पकरी', 'किला मोहम्मदीनगर', 'कृष्णलोक कालोनी', 'गहरू', 'गौरी', 'गौरी बिहार', 'गुडौरा',
         'जयराजपुरी', 'ट्रान्सपोर्ट नगर', 'नारायनपुरी', 'नटकुर', 'नटकुर (एल्डिको शौर्य)', 'फर्रूखाबाद चिल्लावां', 'बेहसा', 'बरगवा (बारा बिरवा)',
         'बल्दी खेड़ा', 'बदाली खेड़ा', 'बापू नगर', 'बेहटवा', 'भदरूख', 'मदारी खेड़ा', 'मानस नगर', 'मान सरोवर योजना', 'मिश्रा पुरम कॉलोनी',
         'मीरानपुर पिनवट', 'मीरानपुर पिनवट (पार्थ रिपब्लिक)', 'मुरली नगर', 'राम विहार कालोनी', 'रहीमाबाद', 'रामगढ़ कालोनी', 'लिटरेसी हाऊस',
         'विष्णुलोक कॉलोनी', 'शारदा कैनाल कालोनी', 'शान्तिनगर', 'सालेहनगर', 'सरोजनी नगर', 'सरोसा भरोसा', 'सदरौना', 'सम्भरखेड़ा',
         'स्वपन लोक कालोनी', 'हनुमानपुरी', 'हिन्दनगर'}
names = [a[0] for a in f2]
assert URBAN <= set(names) and RURAL <= set(names), (URBAN - set(names), RURAL - set(names))
cats = ['Rural' if n in RURAL else 'Urban' if n in URBAN else 'Semi-urban' for n in names]
assert (cats.count('Urban'), cats.count('Semi-urban'), cats.count('Rural')) == (52, 59, 10), (cats.count('Urban'), cats.count('Semi-urban'))

num = lambda x: None if x in ('', '-') else int(x)
rows = []
for i, (a, e) in enumerate(zip(f2, en)):
    b = f4[i + 1]
    agri = None if b[3] == '-' else dict(zip(('district_road', 'link_road', 'near_abadi', 'general'), map(int, b[3:7])))
    rows.append({
        'sr': i + 1, 'list_sr': str(i + 1), 'hi': a[0], 'en': e, 'vcode': '-', 'ward': a[1], 'ward_name': a[2], 'category': cats[i],
        'plot': {'lt9': int(a[3]), '9_12': int(b[0]), '12_18': int(b[1]), 'gt18': int(b[2])},
        'flat': {'ordinary': int(a[4]), 'premium': int(a[5])},
        'commercial': {'shop': int(b[7]), 'office': int(b[8]), 'godown': int(b[9])},
        'agri': agri, 'roads': [],
    })

def key(s): return re.sub(r'[\s\.\(\)]', '', s.replace('़', '').replace('ॉ', 'ा'))
ALIAS = {'ट्रांसपोर्ट नगर': 'ट्रान्सपोर्ट नगर', 'हिन्द नगर': 'हिन्दनगर', 'शान्ती नगर': 'शान्तिनगर', 'किसुनपुर कौड़िया': 'किशनपुर कौडिया',
         'सरायं शहजादी': 'सराय शहजादी', 'तेज कृष्ण खेड़ा': 'तेजकृष्ण खेड़ा', 'मौन्दा': 'मौंदा', 'हरदोइया लालनगर': 'हरदोईया लाल नगर',
         'भौंकापुर': 'भौकापुर', 'खान्डेदेव': 'खाण्डेदेव', 'मिरानपुर पिनवट': 'मीरानपुर पिनवट'}
by_key = {}
for r in rows: by_key.setdefault(key(r['hi']), []).append(r)
general = []
for s in f3:
    entry = {'segment': s[0], 'listed_for': s[1], 'plot': int(s[2]), 'agri': num(s[3]), 'shop': int(s[4]), 'office': int(s[5]), 'godown': int(s[6])}
    if s[1] == '-':
        entry['listed_for'] = 'उक्त रोड पर पड़ने वाले समस्त राजस्व ग्राम/मोहल्ले'; general.append(entry); continue
    t = by_key.get(key(ALIAS.get(s[1], s[1])), [])
    t = [r for r in t if '(' not in r['hi']] or t     # the plain village, not the named colony inside it
    assert t, ('Form 3 village not found', s[1])
    for r in t: r['roads'].append(dict(entry))         # कानपुर रोड योजना is listed under two wards: both get it

notes = {
    'बरगवा (बारा बिरवा)': 'On the Kanpur Road segment (Shringar Nagar/Awadh Hospital to the municipal limit) the list prints office ₹87,000/sq m while every other mohalla on that segment has ₹80,000. Shown as printed.',
    'अनौरा': 'Form 4 marks this row with * : corrected for a clerical error on the sub-registrar’s report.',
    'किला मोहम्मदीनगर': 'Form 4 marks this row with * : corrected for a clerical error on the sub-registrar’s report.',
    'मदारपुर': 'Form 4 marks this row with * : corrected for a clerical error on the sub-registrar’s report.',
}
for r in rows:
    if r['hi'] in notes: r['note'] = notes[r['hi']]

out = {
    'slug': 'sarojini-nagar-dwitiya', 'sro': 'Sarojini Nagar II', 'sro_hi': 'सरोजनीनगर द्वितीय', 'sro_code': '383', 'district': 'Lucknow',
    'effective': '2025-08-01', 'order': 'No. 971/Stamp Lipik, Office of the District Magistrate, Lucknow, dated 01.08.2025',
    'source': 'IGRSUP मूल्यांकन सूची, RateList_383_01-08-2025.pdf',
    'pdf': 'Lucknow-Circle-Rate-Sarojini-Nagar-II-01-08-2025.pdf',
    'construction_3floor': {'rcc': [18000, 15000, 80], 'rbc': [12000, 10000, 60], 'kadi': [6000, 5000, 50],
                            'tin': [4500, 4000, 40], 'kachcha': [2500, 2000, 30]},
    'single_shop_construction': {'shop': 22000, 'office': 18000, 'godown': 14000},
    'general_roads': general,
    'rows': rows,
}
dst = os.path.join(here, '..', '..', '..', 'resources', 'data', 'circle-rates')
json.dump(out, open(os.path.join(dst, 'lucknow-sarojini-nagar-dwitiya.json'), 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
print(len(rows), 'mohallas,', sum(len(r['roads']) for r in rows), 'road links,', len(general), 'general roads,', sum(1 for r in rows if r['agri']), 'with agri')
