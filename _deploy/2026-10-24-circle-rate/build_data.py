# Builds resources/data/circle-rates/lucknow-sadar-pratham.json from the three hand-transcribed forms of the
# official DM rate list for SRO Sadar Pratham (RateList_227_01-08-2025.pdf, effective 01-08-2025).
#   form2.tsv  Form 2 / 5ख  (PDF pages 24–36): plot rate on roads under 9 m + flat construction rates
#   form3.tsv  Form 3       (pages 37–41): main-road segment rates (plot + commercial carpet)
#   form4.tsv  Form 4       (pages 42–59): plot rate by road width + commercial carpet rates
# Every row was read off a 2.4x render of the scan; the checks below must pass before writing.
import csv, json, os

here = os.path.dirname(os.path.abspath(__file__))
rd = lambda f: list(csv.reader(open(os.path.join(here, f), encoding='utf-8'), delimiter='\t'))
f2, f3, f4 = rd('form2.tsv'), rd('form3.tsv'), rd('form4.tsv')
en = [l.strip() for l in open(os.path.join(here, 'english_names.txt'), encoding='utf-8') if l.strip()]
assert len(f2) == len(f4) == len(en) == 162 and len(f3) == 49

rows = []
for i, (a, b) in enumerate(zip(f2, f4)):
    assert a[0] == b[0] == str(i + 1) and a[2] == b[3]
    rows.append({
        'sr': i + 1, 'hi': a[1], 'en': en[i], 'vcode': a[2], 'ward': a[3].zfill(3), 'ward_name': a[4],
        'plot': {'lt9': int(a[5]), '9_12': int(b[4]), '12_18': int(b[5]), 'gt18': int(b[6])},
        'flat': {'ordinary': int(a[6]), 'premium': int(a[7])},
        'commercial': {'shop': int(b[7]), 'office': int(b[8]), 'godown': int(b[9])},
        'roads': [],
    })

SEG_EN = {
    'ऐशबाग रोड नाका चैराहे से हैदरगंज चैराहे तक': 'Aishbagh Road, Naka crossing to Haidarganj crossing',
    'कैन्ट रोड़ कैसर बाग चैराहे से सदर रेलवे क्रासिंग तक': 'Cantt Road, Kaiserbagh crossing to Sadar railway crossing',
    'गुरू गोविन्द सिंह मार्ग हुसैनगंज चैराहे से नाका चैराहे तक': 'Guru Gobind Singh Marg, Husainganj crossing to Naka crossing',
    'चारबाग स्टेशन से अवध अस्पताल/श्रंगारनगर नहर तक': 'Charbagh station to Awadh Hospital / Shringar Nagar canal',
    'महात्मा गांधी मार्ग (इलाहाबाद बैंक से रेलवे क्रासिंग तक)': 'Mahatma Gandhi Marg, Allahabad Bank to railway crossing',
    'लाटूश रोड़/गौतम बुद्ध मार्ग कैसरबाग चैराहे से चारबाग तक': 'Latouche Road / Gautam Buddha Marg, Kaiserbagh crossing to Charbagh',
    'विधान सभा मार्ग, अशोक मार्ग स्टेशन रोड़': 'Vidhan Sabha Marg, Ashok Marg, Station Road',
    'श्रंगारनगर नहर से अम्बेडकर मैदान चैराहा तक बी.आई.पी. रोड़': 'VIP Road, Shringar Nagar canal to Ambedkar Maidan crossing',
    'सुभाष मार्ग मेडिकल कालेज चैराहे से चारबाग बस अड्डे तिराहे तक': 'Subhash Marg, Medical College crossing to Charbagh bus stand',
    'हजरतगंज चैराहे से कालीदास मार्ग चैराहे तक': 'Hazratganj crossing to Kalidas Marg crossing',
}
by_code = {}
for r in rows: by_code.setdefault(r['vcode'], []).append(r)
for s in f3:
    seg, name, code = s[1], s[2], s[3]
    targets = by_code[code]
    assert targets, s
    for t in targets:
        t['roads'].append({'segment': seg, 'segment_en': SEG_EN[seg], 'plot': int(s[4]), 'shop': int(s[5]), 'office': int(s[6]), 'godown': int(s[7])})

notes = {
    'कायमखेड़ा': 'The official list prints 9–12 m road ₹22,500 but 12–18 m ₹17,000 and 18 m+ ₹19,000. Shown exactly as printed; confirm with the sub-registrar office before you pay stamp duty.',
    'बरहा कालोनी': 'The official list prints the same rate (₹13,000) for 12–18 m and 18 m+ roads.',
}
for r in rows:
    if r['hi'] in notes: r['note'] = notes[r['hi']]

out = {
    'slug': 'sadar-pratham', 'sro': 'Sadar Pratham', 'sro_hi': 'सदर प्रथम', 'sro_code': '227', 'district': 'Lucknow',
    'effective': '2025-08-01', 'order': 'No. 971/Stamp Lipik, Office of the District Magistrate, Lucknow, dated 01.08.2025',
    'source': 'IGRSUP मूल्यांकन सूची, RateList_227_01-08-2025.pdf',
    'pdf': 'Lucknow-Circle-Rate-Sadar-Pratham-01-08-2025.pdf',
    'construction_3floor': {  # Form 5क, ₹/sq m covered area, first / second class, life in years
        'rcc': [18000, 15000, 80], 'rbc': [12000, 10000, 60], 'kadi': [6000, 5000, 50],
        'tin': [4500, 4000, 40], 'kachcha': [2500, 2000, 30]},
    'single_shop_construction': {'shop': 22000, 'office': 18000, 'godown': 14000},
    'rows': rows,
}
dst = os.path.join(here, '..', '..', 'resources', 'data', 'circle-rates')
os.makedirs(dst, exist_ok=True)
json.dump(out, open(os.path.join(dst, 'lucknow-sadar-pratham.json'), 'w', encoding='utf-8'), ensure_ascii=False, separators=(',', ':'))
print(len(rows), 'mohallas,', sum(len(r['roads']) for r in rows), 'road links')
