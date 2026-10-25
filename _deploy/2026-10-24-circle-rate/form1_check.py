# Form 1 (index, PDF pages 14-23) lists serial, name, ward and V-code independently of the rate forms.
# OCR its numbers and check that every serial has the same ward + V-code as form2.tsv.
import csv, os, re
import fitz, numpy as np
from rapidocr_onnxruntime import RapidOCR
here = os.path.dirname(os.path.abspath(__file__))
f2 = {int(r[0]): (r[3].zfill(3), r[2]) for r in csv.reader(open(os.path.join(here, 'form2.tsv'), encoding='utf-8'), delimiter='\t')}
ocr = RapidOCR(); doc = fitz.open(os.path.join(here, 'src', 'RateList_227_01-08-2025.pdf'))
seen = {}
for i in range(13, 26):
    pix = doc[i].get_pixmap(matrix=fitz.Matrix(3, 3).prerotate(-90))
    img = np.frombuffer(pix.samples, dtype=np.uint8).reshape(pix.height, pix.width, pix.n)[:, :, :3]
    res, _ = ocr(img)
    toks = sorted(((sum(p[1] for p in b) / 4, min(p[0] for p in b), t.replace(' ', '')) for b, t, c in (res or []) if re.fullmatch(r'\d{1,4}', t.replace(' ', ''))))
    rows, cur = [], []
    for t in toks:
        if cur and abs(t[0] - cur[-1][0]) > 18: rows.append(cur); cur = []
        cur.append(t)
    if cur: rows.append(cur)
    for r in rows:
        n = [t[2] for t in sorted(r, key=lambda t: t[1])]
        v = [x for x in n if re.fullmatch(r'0\d{3}', x)]
        w = [x for x in n if re.fullmatch(r'0\d{2}', x)]
        if v and w: seen.setdefault((w[0], v[-1]), 0); seen[(w[0], v[-1])] += 1
miss = [(sr, wv) for sr, wv in f2.items() if wv not in seen]
print('form1 ward+vcode pairs found:', len(seen), '| form2 rows not confirmed by form1:', miss)
