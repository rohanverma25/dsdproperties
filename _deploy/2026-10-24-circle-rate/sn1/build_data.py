# Builds resources/data/circle-rates/lucknow-sarojini-nagar.json from the hand-transcribed forms of the official DM rate list
# for SRO Sarojini Nagar (I) (RateList_367_01-08-2025.pdf, effective 01-08-2025, order 971 of 01.08.2025).
#   form2_src.txt (PDF pages 33-46): name|ward code|ward name|plot <9 m|flat ordinary|flat premium
#   form4_src.txt (pages 54-64):     sr|9-12|12-18|18+|agri district|link|abadi|general|shop|office|godown
#   form3_src.txt (pages 47-53):     road|-|plot|agri|shop|office|godown  (all 28 rows apply to every mohalla on the road)
# Category from Form 1 (pages 16-32): 102 urban, 19 semi-urban (SEMI below), 1 rural (Memaura). No V-codes.
# Then run ../amend-2026-06/apply.py for the 04.06.2026 revision.
import json, os

here = os.path.dirname(os.path.abspath(__file__))
lines = lambda f: [l.rstrip('\n') for l in open(os.path.join(here, f), encoding='utf-8') if l.strip() and not l.startswith('#')]
f2 = [l.split('|') for l in lines('form2_src.txt')]
en = lines('english_names.txt')
f4 = {int(p[0]): p[1:] for p in (l.split('|') for l in lines('form4_src.txt'))}
f3 = [l.split('|') for l in lines('form3_src.txt')]
assert len(f2) == len(en) == len(f4) == 122 and len(f3) == 28, (len(f2), len(en), len(f4), len(f3))
assert all(len(v) == 10 for v in f4.values())

SEMI = {'अहमदपुर उर्फ कमलापुर', 'एल्डिको इम्पीरिया', 'कल्ली पूरब', 'खटोला', 'चन्द्रावल', 'नूरनगर भदरसा', 'नीवां', 'जैतीखेडा',
        'धावापुर', 'परवर पूरब', 'परवर पश्चिम', 'बीबीपुर', 'भागूखेडा', 'मखदूमपुर कैथी', 'माती', 'रतौली', 'बिरुरा',
        'शाहपुर मझगवां', 'सरैयॉ'}
RURAL = {'मेमौरा'}
names = {a[0] for a in f2}
assert SEMI <= names and RURAL <= names, (SEMI - names, RURAL - names)

num = lambda x: None if x in ('', '-') else int(x)
rows = []
for i, (a, e) in enumerate(zip(f2, en)):
    b = f4[i + 1]
    agri = None if b[3] == '-' else dict(zip(('district_road', 'link_road', 'near_abadi', 'general'), map(int, b[3:7])))
    rows.append({
        'sr': i + 1, 'list_sr': str(i + 1), 'hi': a[0], 'en': e, 'vcode': '-', 'ward': a[1], 'ward_name': a[2],
        'category': 'Rural' if a[0] in RURAL else 'Semi-urban' if a[0] in SEMI else 'Urban',
        'plot': {'lt9': int(a[3]), '9_12': int(b[0]), '12_18': int(b[1]), 'gt18': int(b[2])},
        'flat': {'ordinary': int(a[4]), 'premium': int(a[5])},
        'commercial': {'shop': int(b[7]), 'office': int(b[8]), 'godown': int(b[9])},
        'agri': agri, 'roads': [],
    })
general = [{'segment': s[0], 'listed_for': 'उक्त रोड पर पड़ने वाले समस्त राजस्व ग्राम/मोहल्ले', 'plot': int(s[2]), 'agri': num(s[3]),
            'shop': int(s[4]), 'office': int(s[5]), 'godown': int(s[6])} for s in f3]

same = 'The official list prints the same ₹2,500 for roads under 9 m (Form 2) and 9–12 m (Form 4). Shown as printed.'
notes = {
    'पिपरौली': 'The official list prints the office carpet rate as ₹3,50,000/sq m (shop ₹40,000, godown ₹30,000). This is almost certainly a typo for ₹35,000; confirm at the sub-registrar office.',
    'शान्तिनगर': 'The official list prints this mohalla’s ward code as 0207 (all others have 3 digits). Shown as printed.',
    'रतौली': same, 'शाहपुर मझगवां': same, 'सरैयॉ': same,
}
for r in rows:
    if r['hi'] in notes: r['note'] = notes[r['hi']]

out = {
    'slug': 'sarojini-nagar', 'sro': 'Sarojini Nagar', 'sro_hi': 'सरोजनीनगर', 'sro_code': '367', 'district': 'Lucknow',
    'effective': '2025-08-01', 'order': 'No. 971/Stamp Lipik, Office of the District Magistrate, Lucknow, dated 01.08.2025',
    'source': 'IGRSUP मूल्यांकन सूची, RateList_367_01-08-2025.pdf',
    'pdf': 'Lucknow-Circle-Rate-Sarojini-Nagar-01-08-2025.pdf',
    'construction_3floor': {'rcc': [18000, 15000, 80], 'rbc': [12000, 10000, 60], 'kadi': [6000, 5000, 50],
                            'tin': [4500, 4000, 40], 'kachcha': [2500, 2000, 30]},
    'single_shop_construction': {'shop': 22000, 'office': 18000, 'godown': 14000},
    'general_roads': general,
    'rows': rows,
}
dst = os.path.join(here, '..', '..', '..', 'resources', 'data', 'circle-rates')
json.dump(out, open(os.path.join(dst, 'lucknow-sarojini-nagar.json'), 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
print(len(rows), 'mohallas,', len(general), 'general roads,', sum(1 for r in rows if r['agri']), 'with agri rates')
