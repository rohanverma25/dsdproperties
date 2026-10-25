# Builds resources/data/circle-rates/lucknow-sadar-dwitiya.json from the hand-transcribed forms of the official
# DM rate list for SRO Sadar Dwitiya (RateList_228_01-08-2025.pdf, effective 01-08-2025, order 971 of 01.08.2025).
#   form2.tsv  (PDF pages 39-79): sr, name, vcode, ward, ward name, U/S/R, plot <9 m, flat ordinary, flat premium
#   form4.tsv  (pages 118-173):   vcode, name, plot 9-12 / 12-18 / 18 m+, agri lakh/ha (district road, link road,
#                                 next to abadi, general), shop, office, godown
#   form3.tsv  (pages 80-117):    sr, road segment, mohalla, vcode, plot, agri lakh/ha, shop, office, godown
# Row 88 does not exist in the printed Form 3 (87 is followed by 89).
import csv, json, os

here = os.path.dirname(os.path.abspath(__file__))
rd = lambda f: list(csv.reader(open(os.path.join(here, f), encoding='utf-8'), delimiter='\t'))
f2, f3, f4 = rd('form2.tsv'), rd('form3.tsv'), rd('form4.tsv')
en = [l.strip() for l in open(os.path.join(here, 'english_names.txt'), encoding='utf-8') if l.strip()]
assert len(f2) == len(en) == 277 and len(f4) == 276 and len(f3) == 127
num = lambda x: None if x in ('', '-') else int(x)
CAT = {'U': 'Urban', 'S': 'Semi-urban', 'R': 'Rural'}

f4k = {r[0]: r for r in f4}
rows = []
for i, (a, e) in enumerate(zip(f2, en)):
    key = a[2] + ('S' if 'शालीमार' in a[1] else '')
    b = f4k.get(key)
    agri = None
    if b and b[5] != '-':
        agri = {'district_road': int(b[5]), 'link_road': int(b[6]), 'near_abadi': int(b[7]), 'general': int(b[8])}
    rows.append({
        'sr': i + 1, 'list_sr': a[0], 'hi': a[1], 'en': e, 'vcode': a[2], 'ward': a[3] or '-', 'ward_name': a[4],
        'category': CAT[a[5]],
        'plot': {'lt9': int(a[6]), '9_12': num(b[2]) if b else None, '12_18': num(b[3]) if b else None, 'gt18': num(b[4]) if b else None},
        'flat': {'ordinary': int(a[7]), 'premium': int(a[8])},
        'commercial': {'shop': num(b[9]), 'office': num(b[10]), 'godown': num(b[11])} if b else None,
        'agri': agri, 'roads': [],
    })

by_code = {}
for r in rows: by_code.setdefault(r['vcode'], []).append(r)
general = []
KISAN = {'अनौरा': '1103', 'धावाँ': '1086', 'नरेन्द्री': '1117', 'लौलाई': '1063', 'जुग्गौर': '1092', 'सिकन्दरपुर खुर्द': '1068',
         'मेहौरा': '1112', 'देवारिया': '1108', 'गोपरामऊ': '1049', 'मौरा': '1054', 'लालनगर': '1061', 'सराय प्रेमराज': '1079', 'जेहटा': '1052'}
for s in f3:
    entry = {'segment': s[1], 'listed_for': s[2], 'plot': int(s[4]), 'agri': num(s[5]),
             'shop': int(s[6]), 'office': int(s[7]), 'godown': int(s[8])}
    if s[3] != '-':
        targets = [r for r in by_code[s[3]] if 'शालीमार' not in r['hi'] and '(' not in r['hi']] or by_code[s[3]]
    elif s[1].startswith('किसान पथ'):
        targets = []
        for v in [x.strip() for x in s[2].split(',')]:
            targets += [r for r in by_code[KISAN[v]] if '(' not in r['hi']]
    else:
        general.append(entry); continue
    assert targets, s
    for t in targets: t['roads'].append(entry)

notes = {
    'निशातगंज': 'The official list prints the ordinary flat rate as ₹3,000/sq m (premium ₹32,500). This looks like a printing error for ₹30,000; confirm at the sub-registrar office.',
    'रायपुर': 'The official list prints 12–18 m road ₹10,500 but 18 m+ ₹9,500. Shown exactly as printed.',
    'अल्लूनगरडिगुरिया': 'The official list prints 12–18 m road ₹10,500 but 18 m+ ₹9,700. Shown exactly as printed.',
    'ऋषि उद्यान (जुग्गौर)': 'The official list prints road under 9 m ₹10,000 but 9–12 m ₹9,000. Shown exactly as printed.',
    'हलवासिया रोड': 'The official list prints lower flat rates here (₹25,000 / ₹27,500) than nearby Hazratganj mohallas. Shown exactly as printed.',
}
for r in rows:
    if r['hi'] in notes: r['note'] = notes[r['hi']]
    if r['vcode'] == '1082': r['note'] = 'Form 4 of the official list has no road-width rates for this entry (V-code 1082); only the rate for roads under 9 m is given.'

out = {
    'slug': 'sadar-dwitiya', 'sro': 'Sadar Dwitiya', 'sro_hi': 'सदर द्वितीय', 'sro_code': '228', 'district': 'Lucknow',
    'effective': '2025-08-01', 'order': 'No. 971/Stamp Lipik, Office of the District Magistrate, Lucknow, dated 01.08.2025',
    'source': 'IGRSUP मूल्यांकन सूची, RateList_228_01-08-2025.pdf',
    'pdf': 'Lucknow-Circle-Rate-Sadar-Dwitiya-01-08-2025.pdf',
    'construction_3floor': {'rcc': [18000, 15000, 80], 'rbc': [12000, 10000, 60], 'kadi': [6000, 5000, 50],
                            'tin': [4500, 4000, 40], 'kachcha': [2500, 2000, 30]},
    'single_shop_construction': {'shop': 22000, 'office': 18000, 'godown': 14000},
    'general_roads': general,
    'rows': rows,
}
dst = os.path.join(here, '..', '..', '..', 'resources', 'data', 'circle-rates')
json.dump(out, open(os.path.join(dst, 'lucknow-sadar-dwitiya.json'), 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
print(len(rows), 'mohallas,', sum(len(r['roads']) for r in rows), 'road links,', len(general), 'general roads')
