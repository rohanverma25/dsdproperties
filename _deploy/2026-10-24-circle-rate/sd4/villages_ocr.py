# OCR the revenue-village column (2nd column) of the SRO 230 khasra annexure and print the names found per page.
import os, re, sys
import fitz, numpy as np
from rapidocr_onnxruntime import RapidOCR
here = os.path.dirname(os.path.abspath(__file__))
doc = fitz.open(os.path.join(here, '..', 'src', 'RateList_230_01-12-2025.pdf'))
ocr = RapidOCR()
for i in range(len(doc)):
    pix = doc[i].get_pixmap(matrix=fitz.Matrix(2.5, 2.5))
    img = np.frombuffer(pix.samples, dtype=np.uint8).reshape(pix.height, pix.width, pix.n)[:, :, :3]
    w = img.shape[1]
    col = img[:, int(w * 0.13):int(w * 0.25)]          # राजस्व ग्राम column
    res, _ = ocr(col)
    names = [t for b, t, c in (res or []) if re.search(r'[ऀ-ॿ]', t) and c > 0.5]
    print(i + 1, ' | '.join(names))
