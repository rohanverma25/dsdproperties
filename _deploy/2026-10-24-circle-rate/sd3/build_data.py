# Builds resources/data/circle-rates/lucknow-sadar-tritiya.json from the hand-transcribed forms of the official
# DM rate list for SRO Sadar Tritiya (RateList_229_01-08-2025.pdf, effective 01-08-2025, order 971 of 01.08.2025).
#   form2_src.txt (PDF pages 41-60): name|vcode|ward key|plot <9 m|flat class (A 29000/32000, B 30000/32500, C 32000/34000)
#   form4_src.txt (pages 75-99):     vcode|9-12|12-18|18 m+|shop,office,godown or X/Y/Z/N|agri lakh/ha (district, link, abadi, general)
#   form3_src.txt (pages 61-74):     road (or @key)|mohalla|vcode|plot|shop,office,godown ; rows 114-121 have no mohalla = general roads
# Also writes form2/3/4.tsv in the same layout as the other SROs, for the OCR check.
import json, os, subprocess, sys

here = os.path.dirname(os.path.abspath(__file__))
subprocess.run([sys.executable, os.path.join(here, 'gen_f2.py')], check=True)
lines = lambda f: [l.rstrip('\n') for l in open(os.path.join(here, f), encoding='utf-8') if l.strip()]
f2 = [l.split('\t') for l in lines('form2.tsv')]
en = lines('english_names.txt')
COM = {'X': '50500,43500,37500', 'Y': '48000,42000,36000', 'Z': '58000,48000,38500', 'N': '86500,70000,54000'}
f4 = []
for l in lines('form4_src.txt'):
    p = l.split('|')
    f4.append(p[:4] + COM.get(p[4], p[4]).split(',') + ((p[5].split(',')) if len(p) > 5 else ['-'] * 4))
keys, f3 = {}, []
for l in lines('form3_src.txt'):
    if l.startswith('@'):
        k, v = l[1:].split('=', 1); keys[k] = v; continue
    seg, moh, vc, plot, com = l.split('|')
    f3.append([keys.get(seg, seg), moh, vc, plot] + com.split(','))
assert len(f2) == len(en) == len(f4) == 243 and len(f3) == 121, (len(f2), len(en), len(f4), len(f3))
for a, b in zip(f2, f4):
    assert a[2] == b[0], (a, b)          # Form 2 and Form 4 serials carry the same V-code
assert len({a[2] for a in f2}) == 243    # V-codes are unique in this SRO

# TSVs in the shared layout (form4: vcode, name, 9-12, 12-18, 18+, agri x4, shop, office, godown)
w = lambda f, rows: open(os.path.join(here, f), 'w', encoding='utf-8').write('\n'.join('\t'.join(map(str, r)) for r in rows) + '\n')
w('form4.tsv', [[b[0], a[1]] + b[1:4] + b[7:11] + b[4:7] for a, b in zip(f2, f4)])
w('form3.tsv', [[i + 1, s[0], s[1], s[2], s[3], '-', s[4], s[5], s[6]] for i, s in enumerate(f3)])

num = lambda x: None if x in ('', '-') else int(x)
rows, by_code = [], {}
for i, (a, b, e) in enumerate(zip(f2, f4, en)):
    agri = None if b[7] == '-' else dict(zip(('district_road', 'link_road', 'near_abadi', 'general'), map(int, b[7:11])))
    r = {'sr': i + 1, 'list_sr': a[0], 'hi': a[1], 'en': e, 'vcode': a[2], 'ward': a[3], 'ward_name': a[4], 'category': 'Urban',
         'plot': {'lt9': int(a[6]), '9_12': int(b[1]), '12_18': int(b[2]), 'gt18': int(b[3])},
         'flat': {'ordinary': int(a[7]), 'premium': int(a[8])},
         'commercial': {'shop': int(b[4]), 'office': int(b[5]), 'godown': int(b[6])},
         'agri': agri, 'roads': []}
    rows.append(r); by_code[a[2]] = r

general = []
for s in f3:
    entry = {'segment': s[0], 'listed_for': s[1], 'plot': int(s[3]), 'agri': None,
             'shop': int(s[4]), 'office': int(s[5]), 'godown': int(s[6])}
    if s[2] == '-':
        general.append(entry); continue
    t = by_code[s[2]]
    if entry not in t['roads']:          # Form 3 rows 16 and 17 are the same printed twice
        t['roads'].append(entry)

notes = {
    '0176': 'The official list prints road 9–12 m ₹30,000 but 12–18 m ₹25,500 and 18 m+ ₹26,500. Shown exactly as printed.',
    '0164': 'The official list prints road 9–12 m ₹30,000 but 12–18 m ₹25,500 and 18 m+ ₹26,500. Shown exactly as printed.',
    '0157': 'The official list prints road 9–12 m ₹30,000 but 12–18 m ₹25,500 and 18 m+ ₹26,500. Shown exactly as printed.',
    '0108': 'The official list prints shop ₹48,000 with office ₹43,500 and godown ₹37,500. Shown exactly as printed.',
}
for r in rows:
    if r['vcode'] in notes: r['note'] = notes[r['vcode']]

out = {
    'slug': 'sadar-tritiya', 'sro': 'Sadar Tritiya', 'sro_hi': 'सदर तृतीय', 'sro_code': '229', 'district': 'Lucknow',
    'effective': '2025-08-01', 'order': 'No. 971/Stamp Lipik, Office of the District Magistrate, Lucknow, dated 01.08.2025',
    'source': 'IGRSUP मूल्यांकन सूची, RateList_229_01-08-2025.pdf',
    'pdf': 'Lucknow-Circle-Rate-Sadar-Tritiya-01-08-2025.pdf',
    'construction_3floor': {'rcc': [18000, 15000, 80], 'rbc': [12000, 10000, 60], 'kadi': [6000, 5000, 50],
                            'tin': [4500, 4000, 40], 'kachcha': [2500, 2000, 30]},
    'single_shop_construction': {'shop': 22000, 'office': 18000, 'godown': 14000},
    'general_roads': general,
    'rows': rows,
}
dst = os.path.join(here, '..', '..', '..', 'resources', 'data', 'circle-rates')
json.dump(out, open(os.path.join(dst, 'lucknow-sadar-tritiya.json'), 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
print(len(rows), 'mohallas,', sum(len(r['roads']) for r in rows), 'road links,', len(general), 'general roads')
