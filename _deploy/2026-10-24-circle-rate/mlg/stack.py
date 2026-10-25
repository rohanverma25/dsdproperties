# Render page ranges, crop the table area and stack several pages per image for reading.
import sys, fitz
from PIL import Image, ImageDraw
d = fitz.open('src/RateList_232_01-08-2025.pdf')
first, last, per, y0, y1, x0, x1, tag = int(sys.argv[1]), int(sys.argv[2]), int(sys.argv[3]), *map(float, sys.argv[4:8]), sys.argv[8]
pages = list(range(first, last + 1))
for g in range(0, len(pages), per):
    crops = []
    for p in pages[g:g + per]:
        pix = d[p - 1].get_pixmap(matrix=fitz.Matrix(2.0, 2.0))
        im = Image.frombytes('RGB', (pix.width, pix.height), pix.samples)
        w, h = im.size
        c = im.crop((int(w * x0), int(h * y0), int(w * x1), int(h * y1)))
        ImageDraw.Draw(c).text((4, 2), 'p%d' % p, fill='red')
        crops.append(c)
    W = max(c.width for c in crops); H = sum(c.height for c in crops)
    out = Image.new('RGB', (W, H), 'white'); y = 0
    for c in crops: out.paste(c, (0, y)); y += c.height
    out.save('mlg/%s_%03d.png' % (tag, pages[g])); print('mlg/%s_%03d.png' % (tag, pages[g]), out.size)
