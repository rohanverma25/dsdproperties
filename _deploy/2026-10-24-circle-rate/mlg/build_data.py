# Builds resources/data/circle-rates/lucknow-mohanlalganj.json from the hand-transcribed forms of the official DM rate list
# for SRO Mohanlalganj (RateList_232_01-08-2025.pdf, effective 01-08-2025, order 971 of 01.08.2025).
#   form2_src.txt (PDF pages 34-50): name|pargana (101 Mohanlalganj, 102 Nigohan)|plot <9 m|flat ordinary|flat premium
#   form4_src.txt (pages 60-86):     sr|pattern code   or   sr|9-12|12-18|18+|agri district|link|abadi|general|shop|office|godown
#   form3_src.txt (pages 51-59):     road|village|plot|agri lakh/ha|shop|office|godown   (village names matched to Form 2)
# The list has no V-codes and no urban/semi-urban/rural column. Form 2 and Form 4 share serial numbers.
# The rules pages are the district-wide ones (same order 971), so the construction rates match the other SROs.
import json, os, re

here = os.path.dirname(os.path.abspath(__file__))
lines = lambda f: [l.rstrip('\n') for l in open(os.path.join(here, f), encoding='utf-8') if l.strip() and not l.startswith('#')]
f2 = [l.split('|') for l in lines('form2_src.txt')]
en = lines('english_names.txt')
P = {
    'A': '3400 3600 3800 27 24 27 20 23000 22000 21500', 'B': '3700 3900 4100 29 26 29 21 23000 22000 21500',
    'C': '3200 3400 3600 26 22 26 18 23000 22000 21500', 'D': '4400 4800 5000 32 28 32 23 23000 22000 21500',
    'D2': '4400 4800 5000 33 29 33 23 23000 22000 21500', 'E': '6500 7000 7500 46 40 46 33 32000 29000 25000',
    'F': '7500 8000 8500 51 44 51 37 28000 26000 25000', 'G': '11000 12000 13000 95 80 95 64 36000 33000 30000',
    'H': '4600 5000 5500 32 29 32 26 23000 22000 21500',
}
# Form 2 plot rate (roads under 9 m) each pattern belongs to: a cheap cross-check that the code was read off the right row
BASE = {'A': 3200, 'B': 3500, 'C': 3000, 'D': 4000, 'D2': 4000, 'E': 6000, 'F': 7000, 'G': 10000, 'H': 4200}
f4 = {}
for l in lines('form4_src.txt'):
    p = l.split('|')
    if len(p) == 2:
        vals = P[p[1]].split()
        assert int(f2[int(p[0]) - 1][2]) == BASE[p[1]], ('pattern vs Form 2 plot rate', p, f2[int(p[0]) - 1])
    else:
        vals = p[1:]
    assert len(vals) == 10, p
    f4[int(p[0])] = vals
assert len(f2) == len(en) == len(f4) == 238, (len(f2), len(en), len(f4))
f3 = [l.split('|') for l in lines('form3_src.txt')]
assert len(f3) == 110

num = lambda x: None if x in ('', '-') else int(x)
PARGANA = {'101': 'मोहनलालगंज', '102': 'निगोहाँ'}
rows = []
for i, (a, e) in enumerate(zip(f2, en)):
    b = f4[i + 1]
    agri = None if b[3] == '-' else dict(zip(('district_road', 'link_road', 'near_abadi', 'general'), map(int, b[3:7])))
    rows.append({
        'sr': i + 1, 'list_sr': str(i + 1), 'hi': a[0], 'en': e, 'vcode': '-', 'ward': a[1], 'ward_name': PARGANA[a[1]] + ' परगना',
        'plot': {'lt9': int(a[2]), '9_12': int(b[0]), '12_18': int(b[1]), 'gt18': int(b[2])},
        'flat': {'ordinary': int(a[3]), 'premium': int(a[4])},
        'commercial': {'shop': int(b[7]), 'office': int(b[8]), 'godown': int(b[9])},
        'agri': agri, 'roads': [],
    })

# Form 3 spells some village names differently from Form 2; match on a normalised key, with aliases for the rest
def key(s):
    s = s.replace('़', '').replace('ँ', 'ं').replace('ॉं', 'ॉ').replace('ॉ', 'ा').replace('ठ्ठ', 'ट्ठ')
    return re.sub(r'[\s\.]', '', s)
ALIAS = {'कासिमपुर बिरूहा': 'कासिमपुर विरूहा', 'मुअज्जमनगर': 'मोअज्जमनगर', 'सरायकरोरा': 'सरायेकरोरा', 'अनौया खरगापुर': 'अनैया खरगापुर',
         'ख्वासखेडा': 'खवास खेड़ा', 'धरमंगदखेडा': 'धरमंगदत खेडा', 'धरमावतखेडा': 'धरमावत खेड़ा', 'मगहुवॉं': 'मगहुवा', 'भौदरी': 'भौंदरी',
         'दूल्हापुर हुसौनाबाद': 'दुल्हापुर हुसौनाबाद', 'सरथुआ': 'सरथुवा', 'सोनई कंजेहरा': 'सौनई कजेंहरा', 'शिवढरा': 'शिवढ़रा',
         'हरिकंश गढी': 'हरिकँशगढी', 'शहजादेपुर': 'शाहजादेपुर', 'रसूलपुर आशिकअली': 'रसूलपुर आशिक अली', 'भटटी बरकत नगर': 'भट्ठी बरकतनगर', 'चॉंद सराय': 'चॉंद सरांय', 'चॉद सराय': 'चॉंद सरांय'}
by_key = {}
for r in rows: by_key.setdefault(key(r['hi']), []).append(r)
for s in f3:
    v = ALIAS.get(s[1], s[1])
    t = by_key.get(key(v), [])
    t = [r for r in t if '(' not in r['en'] or key(r['hi']) == key(v)]
    assert len(t) == 1, ('Form 3 village not matched once', s, [r['hi'] for r in t])
    t[0]['roads'].append({'segment': s[0], 'listed_for': s[1], 'plot': int(s[2]), 'agri': num(s[3]),
                          'shop': int(s[4]), 'office': int(s[5]), 'godown': int(s[6])})

notes = {
    'सलौली': 'The official list prints road 9–12 m ₹4,700 but 12–18 m ₹4,100 (18 m+ ₹5,500). Shown exactly as printed; ₹5,100 was probably meant.',
    'हरिहरपुर पटसा': 'The official list prints road 18 m+ ₹2,800, lower than 12–18 m ₹3,400. Shown exactly as printed.',
    'पूरनपुर': 'The official list prints ₹5,800/sq m for roads under 9 m but ₹6,300 for 9–12 m; agricultural rates here are higher than nearby villages. Shown as printed.',
}
for r in rows:
    if r['hi'] in notes: r['note'] = notes[r['hi']]

out = {
    'slug': 'mohanlalganj', 'sro': 'Mohanlalganj', 'sro_hi': 'मोहनलालगंज', 'sro_code': '232', 'district': 'Lucknow',
    'effective': '2025-08-01', 'order': 'No. 971/Stamp Lipik, Office of the District Magistrate, Lucknow, dated 01.08.2025',
    'source': 'IGRSUP मूल्यांकन सूची, RateList_232_01-08-2025.pdf',
    'pdf': 'Lucknow-Circle-Rate-Mohanlalganj-01-08-2025.pdf',
    'construction_3floor': {'rcc': [18000, 15000, 80], 'rbc': [12000, 10000, 60], 'kadi': [6000, 5000, 50],
                            'tin': [4500, 4000, 40], 'kachcha': [2500, 2000, 30]},
    'single_shop_construction': {'shop': 22000, 'office': 18000, 'godown': 14000},
    'general_roads': [],
    'rows': rows,
}
dst = os.path.join(here, '..', '..', '..', 'resources', 'data', 'circle-rates')
json.dump(out, open(os.path.join(dst, 'lucknow-mohanlalganj.json'), 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
print(len(rows), 'villages,', sum(len(r['roads']) for r in rows), 'road links,', sum(1 for r in rows if r['agri']), 'with agri rates')
