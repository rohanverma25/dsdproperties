{{--
    Shared circle-rate valuation + stamp duty engine (window.CRC), used by /lucknow-circle-rate and the stamp duty
    calculators (EN /tools/stamp-duty-calculator-lucknow, HI /tools/stamp-duty-calculator-lucknow-hindi), so both
    always give the same answer. Pure functions only: pages own their inputs, labels and rendering.

    Valuation follows the rules printed in the DM Lucknow मूल्यांकन सूची (see resources/data/circle-rates/*.json).
    Stamp duty checked against the official IGRSUP e-calculator (sale deed, Lucknow) on 25 Oct 2026:
      man 7%; woman 6% when the value is up to ₹1 crore (₹1,00,00,000 itself still gets 6%), 7% above;
      registration fee 1% with no upper limit. IGRSUP shows 2% of the duty separately as "development fee"
      (e.g. ₹50 lakh, man: 3,43,000 + 7,000) — the total is still 7%, which is what we show.
    The IGRSUP calculator has no joint-buyer option; for a man + woman joint deed we charge 7% (safe side) and
    tell the buyer some offices apply 6.5%.
--}}
<script>
window.CRC = (function () {
    // Lucknow pakka bigha = 3,025 gaj = 27,225 sq ft = 2,529.285 sq m (same as the site's area converter); 1 bigha = 20 biswa
    var SQFT = 10.7639, GAJ = 0.836127, BIGHA = 2529.285264, BISWA = BIGHA / 20, WOMAN_LIMIT = 1e7;

    function toSqm(v, unit) {
        return unit === 'sqft' ? v / SQFT : unit === 'gaj' ? v * GAJ : unit === 'bigha' ? v * BIGHA : unit === 'biswa' ? v * BISWA : v;
    }

    // Rule 17: plot rate applies up to 1,000 sq m; the area above that at 30% less
    function landValue(area, rate) { return area <= 1000 ? area * rate : 1000 * rate + (area - 1000) * rate * 0.7; }

    // Park facing +10%, road on more than one side +10%, both +20%
    function bump(park, corner) { return park && corner ? 0.20 : (park || corner) ? 0.10 : 0; }

    var WIDTHS = ['lt9', '9_12', '12_18', 'gt18'];

    // Road choices for a mohalla: road widths that have a rate, its own main-road segments, then the list's
    // "one rate for all mohallas" roads. Each: {v, kind: 'width'|'seg'|'gen', rate, name?}
    function roads(row, list) {
        var out = WIDTHS.filter(function (w) { return row.plot[w] != null; })
            .map(function (w) { return { v: w, kind: 'width', rate: row.plot[w] }; });
        row.roads.forEach(function (x, i) { out.push({ v: 'seg' + i, kind: 'seg', rate: x.plot, name: x.segment_en || x.segment }); });
        (list.general_roads || []).forEach(function (x, i) { out.push({ v: 'gen' + i, kind: 'gen', rate: x.plot, name: x.segment }); });
        return out;
    }
    function roadEntry(row, list, v) {
        if (v.indexOf('seg') === 0) return row.roads[+v.slice(3)];
        if (v.indexOf('gen') === 0) return list.general_roads[+v.slice(3)];
        return null;
    }
    function landRate(row, list, v) { var e = roadEntry(row, list, v); return e ? e.plot : row.plot[v]; }

    // o: {type: plot|flat|house|shop, row, list, road, area (sq m), park, corner, fcat, floor ('0'|'5'|'10'|'pent'),
    //     built (sq m), ctype, cls (0|1), age, use (shop|office|godown), sfloor (100|90|80|70), ac}
    // Returns {value, lines: [{k, ...numbers}], flags}. Pages turn each line kind into text.
    function value(o) {
        var r = o.row, rate = landRate(r, o.list, o.road), lines = [], v = 0, flags = {};
        if (o.type === 'plot') {
            var b = bump(o.park, o.corner), lv = landValue(o.area, rate);
            v = lv * (1 + b);
            lines.push({ k: 'land', area: o.area, rate: rate, amount: lv });
            if (o.area > 1000) flags.over1000 = true;
            if (b) lines.push({ k: 'bump', pct: b * 100, amount: lv * b });
        } else if (o.type === 'flat') {
            var crate = r.flat[o.fcat], cv = o.area * crate, share = o.area * 0.30, lv2 = share * rate;
            var reb = o.floor === '5' ? 0.05 : o.floor === '10' ? 0.10 : 0;
            v = (cv + lv2) * (1 - reb);
            lines.push({ k: 'flat_build', area: o.area, rate: crate, cat: o.fcat, amount: cv });
            lines.push({ k: 'flat_land', area: share, rate: rate, amount: lv2 });
            if (reb) lines.push({ k: 'floor_rebate', pct: reb * 100, amount: (cv + lv2) * reb });
            flags.landShare = true;
        } else if (o.type === 'house') {
            var b2 = bump(o.park, o.corner), lv3 = landValue(o.area, rate) * (1 + b2);
            var ct = o.list.construction_3floor[o.ctype], crate2 = ct[o.cls], life = ct[2], age = Math.max(0, o.age || 0);
            var cv2 = o.built * crate2, dep = 0;
            // No depreciation for 20 years; then value × age × 9 / (life × 10), never below 30% of the building
            if (age > 20) dep = Math.min(cv2 * age * 9 / (life * 10), cv2 * 0.70);
            v = lv3 + cv2 - dep;
            lines.push({ k: 'land', area: o.area, rate: rate, amount: lv3, pct: b2 * 100 });
            lines.push({ k: 'house_build', area: o.built, rate: crate2, amount: cv2 });
            if (dep) lines.push({ k: 'depreciation', age: age, life: life, amount: dep });
            flags.noDep = age <= 20;
        } else if (o.type === 'agri') {
            // Agricultural land (कृषक भूमि), rates in ₹ lakh per hectare. o.apos: 'district_road' | 'link_road' |
            // 'near_abadi' | 'general' | 'seg<i>' (a Form 3 road with an agri rate). o.aadj: '' | '40' | '30'.
            var segA = o.apos.indexOf('seg') === 0 ? r.roads[+o.apos.slice(3)] : null;
            var lakh = segA ? segA.agri : r.agri[o.apos], naRate = segA ? segA.plot : r.plot.lt9;
            var ha = o.area / 10000, adj = o.aadj === '40' ? 0.40 : o.aadj === '30' ? 0.30 : 0;
            var full = 0, part = 0;                                  // hectares at 100% and 70% of the non-agri rate
            // Rule 12(अ): villages classed urban — first 0.100 ha at the non-agri rate, next 0.050 ha at 70% of it
            if (r.category === 'Urban') { full = Math.min(ha, 0.10); part = Math.min(Math.max(ha - 0.10, 0), 0.05); }
            // Rule 12(ब): semi-urban villages, land on a road / kharanja or next to abadi — first 0.050 ha at the non-agri rate
            else if (r.category === 'Semi-urban' && o.apos !== 'general') full = Math.min(ha, 0.05);
            var rest = Math.max(ha - full - part, 0);
            if (full) lines.push({ k: 'agri_na', area: full * 10000, rate: naRate, pct: 100, amount: full * 10000 * naRate });
            if (part) lines.push({ k: 'agri_na', area: part * 10000, rate: naRate, pct: 70, amount: part * 10000 * naRate * 0.7 });
            var av = rest * lakh * 1e5;
            if (rest) lines.push({ k: 'agri', area: rest * 10000, ha: rest, lakh: lakh, amount: av });
            // Rules 13/14: land adjoining both a road and abadi +40%; 50–200 m from the abadi-adjoining gata +30%
            if (rest && adj) lines.push({ k: 'agri_adj', pct: adj * 100, amount: av * adj });
            v = (full * 10000 * naRate) + (part * 10000 * naRate * 0.7) + av * (1 + adj);
            flags.agriSmall = full + part > 0; flags.noCategory = !r.category; flags.naRateSeg = !!segA;
        } else {
            var re = roadEntry(r, o.list, o.road), seg = !!re;
            var srate = seg ? re[o.use] : (r.commercial ? r.commercial[o.use] : 0);
            var fpct = o.ac ? 100 : +o.sfloor, base = o.area * srate;
            v = base * fpct / 100 * (o.ac ? 1.2 : 1);
            lines.push({ k: 'carpet', area: o.area, rate: srate, use: o.use, seg: seg, amount: base });
            if (fpct !== 100) lines.push({ k: 'shop_floor', pct: fpct, amount: base * (100 - fpct) / 100 });
            if (o.ac) lines.push({ k: 'ac', amount: base * 0.2 });
        }
        return { value: v, lines: lines, flags: flags };
    }

    // buyer: 'm' man, 'f' woman, 'j' man + woman jointly. basis = higher of circle-rate value and sale price.
    function duty(basis, buyer) {
        var womanRate = buyer === 'f' && basis <= WOMAN_LIMIT;
        var rate = womanRate ? 0.06 : 0.07;
        var sd = Math.round(basis * rate), reg = Math.round(basis * 0.01);
        return {
            rate: rate, sd: sd, reg: reg, total: sd + reg,
            womanCapped: buyer === 'f' && basis > WOMAN_LIMIT,    // woman, but above ₹1 crore
            saving: womanRate ? Math.round(basis * 0.01) : 0,       // vs a man buying alone
            jointAlt: buyer === 'j' ? Math.round(basis * 0.065) : 0 // what an office applying 6.5% would charge
        };
    }

    // Agricultural rate choices for a village: its Form 4 columns that have a rate, then its Form 3 roads with an agri rate
    var AGRI_COLS = ['district_road', 'link_road', 'near_abadi', 'general'];
    function agriOptions(row) {
        var out = row.agri ? AGRI_COLS.filter(function (c) { return row.agri[c] != null; }).map(function (c) { return { v: c, lakh: row.agri[c] }; }) : [];
        row.roads.forEach(function (x, i) { if (x.agri) out.push({ v: 'seg' + i, lakh: x.agri, name: x.segment_en || x.segment }); });
        return out;
    }

    return { SQFT: SQFT, GAJ: GAJ, BIGHA: BIGHA, BISWA: BISWA, agriOptions: agriOptions, WOMAN_LIMIT: WOMAN_LIMIT, toSqm: toSqm, roads: roads, roadEntry: roadEntry,
             landRate: landRate, value: value, duty: duty };
})();
</script>
