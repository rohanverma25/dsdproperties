@extends('admin.verifications.layout')

{{--
    LDA Plot Check (internal, 17 Nov 2026). Search by plot number, map pin or Google Maps link; the server asks LDA's GIS
    live (App\Services\LdaGis) and returns plot record + master plan + village + TOD + flags. Nothing is stored.
    Map overlays draw LDA's own layout / master plan images straight from gis.ldalucknow.in (internal use only).
--}}

@section('title', 'LDA Plot Check')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css">
<style>
#lpc-map { height: 72vh; min-height: 420px; border-radius: 10px; border: 1px solid #dee2e6; }
.lpc-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; }
.lpc-verdict { border-radius: 8px; padding: 10px 14px; font-weight: 700; margin-bottom: 12px; }
.lpc-verdict.v-green { background: #d1e7dd; color: #0f5132; }
.lpc-verdict.v-amber { background: #fff3cd; color: #664d03; }
.lpc-verdict.v-red   { background: #f8d7da; color: #842029; }
.lpc-kv { width: 100%; font-size: .9rem; }
.lpc-kv th { color: #6c757d; font-weight: 500; width: 42%; padding: 4px 8px 4px 0; vertical-align: top; }
.lpc-kv td { padding: 4px 0; font-weight: 600; color: #011f4b; }
.lpc-flag { font-size: .86rem; padding: 6px 10px; border-radius: 6px; margin-bottom: 6px; }
.lpc-flag.f-red { background: #fdecee; border-left: 4px solid #dc3545; }
.lpc-flag.f-amber { background: #fff8e1; border-left: 4px solid #ffc107; }
.lpc-flag.f-green { background: #edf7f0; border-left: 4px solid #198754; }
.lpc-flag.f-info { background: #eef4fb; border-left: 4px solid #0d6efd; }
.lpc-near { display: flex; flex-wrap: wrap; gap: 6px; }
.lpc-near button { font-size: .78rem; }
.lpc-src { font-size: .78rem; color: #6c757d; }
.lpc-tabs .nav-link { font-size: .88rem; padding: 6px 10px; }
.lpc-spinner { display: none; }
.lpc-busy .lpc-spinner { display: inline-block; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div>
        <h4>🗺️ LDA Plot Check</h4>
        <p class="page-subtitle">Live lookup in LDA's GIS: plot record, master plan land use, village, TOD zone. Internal use only. Nothing is stored.</p>
    </div>
    <a class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener"
       href="https://gis.ldalucknow.in/portal/apps/experiencebuilder/experience/?id=029800e8d7cb437aa668c1405dda18d3">Open LDA Sector Explorer ↗</a>
</div>

@if($gisDown)
    <div class="alert alert-warning">LDA's GIS server is not answering right now, so the scheme/sector list could not load. Map pin and Google Maps link may still work; try again in a few minutes.</div>
@endif

<div class="row g-3">
    <div class="col-lg-4">
        <div class="lpc-card mb-3">
            <ul class="nav nav-pills lpc-tabs mb-3" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#t-plot" type="button">Plot number</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#t-link" type="button">Google Maps link</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#t-pin" type="button">Map pin</button></li>
            </ul>
            <div class="tab-content">
                <form class="tab-pane fade show active" id="t-plot" data-mode="plot">
                    <label class="form-label small mb-1" for="lpc-scheme">Scheme</label>
                    <select class="form-select form-select-sm mb-2" id="lpc-scheme" required>
                        <option value="">Choose scheme…</option>
                        @foreach($sectors as $scheme => $list)
                            <option value="{{ $scheme }}">{{ ucwords(strtolower(trim($scheme))) }}</option>
                        @endforeach
                    </select>
                    <label class="form-label small mb-1" for="lpc-sector">Sector / Khand</label>
                    <select class="form-select form-select-sm mb-2" id="lpc-sector" required disabled><option value="">Choose scheme first</option></select>
                    <label class="form-label small mb-1" for="lpc-plot">Plot number</label>
                    <input class="form-control form-control-sm mb-3" id="lpc-plot" placeholder="e.g. 2/174" maxlength="30" required>
                    <button class="btn btn-primary btn-sm w-100" type="submit"><span class="spinner-border spinner-border-sm lpc-spinner"></span> Check plot</button>
                    <p class="small text-muted mt-2 mb-0">Covered now: Gomti Nagar, Kanpur Rd, Sitapur Rd, Raebareli Rd, Hardoi Rd, Aliganj, Anant Nagar, Jankipuram, Tikait Rai, townships. Newer schemes (Varun Vihar, Naimish Nagar, IT City…) are not in LDA GIS yet.</p>
                </form>
                <form class="tab-pane fade" id="t-link" data-mode="link">
                    <label class="form-label small mb-1" for="lpc-link">Google Maps link or coordinates</label>
                    <textarea class="form-control form-control-sm mb-3" id="lpc-link" rows="3" required
                              placeholder="https://maps.app.goo.gl/…  or  26.8560, 80.9930"></textarea>
                    <button class="btn btn-primary btn-sm w-100" type="submit"><span class="spinner-border spinner-border-sm lpc-spinner"></span> Check location</button>
                    <p class="small text-muted mt-2 mb-0">Paste the location the seller or dealer sent on WhatsApp.</p>
                </form>
                <div class="tab-pane fade" id="t-pin">
                    <p class="small mb-0">Click anywhere on the map to check that spot. Turn on <strong>LDA plot layout</strong> (top right of the map) to see plot lines first.</p>
                </div>
            </div>
        </div>

        <div id="lpc-result"></div>
    </div>

    <div class="col-lg-8">
        <div id="lpc-map"></div>
        <p class="lpc-src mt-2 mb-0">Map: © OpenStreetMap contributors · Satellite: Esri · LDA layers: gis.ldalucknow.in (Lucknow Development Authority).</p>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
(function () {
    const SECTORS = @json($sectors);
    const LOOKUP = @json(route('ver.admin.lda-plot-check.lookup'));
    const GIS = 'https://gis.ldalucknow.in/server/rest/services';
    const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
    const title = s => esc(String(s ?? '').toLowerCase().replace(/\b\w/g, c => c.toUpperCase()));

    // ---------- map
    const map = L.map('lpc-map', { zoomControl: true }).setView([26.8467, 80.9462], 12);
    const street = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '© OpenStreetMap' }).addTo(map);
    const sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { maxZoom: 19, attribution: 'Esri' });

    // LDA MapServer layers drawn tile by tile through its export endpoint (internal use).
    const ldaLayer = (service, opacity) => {
        const T = L.TileLayer.extend({ getTileUrl(c) {
            const size = 256, nw = map.options.crs.pointToLatLng(L.point(c.x * size, c.y * size), c.z),
                  se = map.options.crs.pointToLatLng(L.point((c.x + 1) * size, (c.y + 1) * size), c.z),
                  a = L.CRS.EPSG3857.project(nw), b = L.CRS.EPSG3857.project(se);
            return `${GIS}/${service}/MapServer/export?bbox=${a.x},${b.y},${b.x},${a.y}&bboxSR=3857&imageSR=3857&size=256,256&format=png32&transparent=true&f=image`;
        }});
        return new T('', { opacity, maxZoom: 20, attribution: 'LDA GIS' });
    };
    const layout = ldaLayer('LDAGIS/Sector_Layout', 0.85);
    const master = ldaLayer('LML_Proposed_Masterplan', 0.55);
    L.control.layers({ 'Street map': street, 'Satellite': sat },
                     { 'LDA plot layout (zoom in)': layout, 'LDA master plan (proposed)': master }, { collapsed: window.innerWidth < 768 }).addTo(map);

    let marker = null, shapes = L.layerGroup().addTo(map);
    const ringsToLatLng = rings => rings.map(r => r.map(([x, y]) => [y, x]));

    // ---------- scheme → sector dropdown
    const schemeSel = document.getElementById('lpc-scheme'), sectorSel = document.getElementById('lpc-sector');
    schemeSel.addEventListener('change', () => {
        const list = SECTORS[schemeSel.value] || [];
        sectorSel.innerHTML = '<option value="">Choose sector…</option>' + list.map(s =>
            `<option value="${esc(s.sector)}">${esc(s.label)} · ${s.n} records</option>`).join('');
        sectorSel.disabled = !list.length;
    });

    // ---------- lookups
    const resultBox = document.getElementById('lpc-result');
    let busyForm = null;
    async function lookup(params, form) {
        busyForm = form || null; if (busyForm) busyForm.classList.add('lpc-busy');
        resultBox.innerHTML = '<div class="lpc-card text-muted small">Asking LDA GIS…</div>';
        try {
            const res = await fetch(LOOKUP + '?' + new URLSearchParams(params), { headers: { 'Accept': 'application/json' } });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                const msg = data.error || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Something went wrong. Try again.');
                resultBox.innerHTML = `<div class="alert alert-warning small mb-0">${esc(msg)}</div>`; return;
            }
            if (data.choices) return showChoices(data.choices);
            if (data.no_location) { resultBox.innerHTML = `<div class="alert alert-info small">Plot found but LDA GIS has no map location for it.</div>`; return; }
            showReport(data);
        } catch (e) {
            resultBox.innerHTML = '<div class="alert alert-warning small mb-0">Could not reach our server. Check your internet and try again.</div>';
        } finally { if (busyForm) busyForm.classList.remove('lpc-busy'); }
    }

    document.getElementById('t-plot').addEventListener('submit', e => { e.preventDefault();
        lookup({ mode: 'plot', scheme: schemeSel.value, sector: sectorSel.value, plot: document.getElementById('lpc-plot').value }, e.target); });
    document.getElementById('t-link').addEventListener('submit', e => { e.preventDefault();
        lookup({ mode: 'link', link: document.getElementById('lpc-link').value }, e.target); });
    map.on('click', e => lookup({ mode: 'point', lat: e.latlng.lat.toFixed(7), lng: e.latlng.lng.toFixed(7) }));

    function showChoices(list) {
        resultBox.innerHTML = `<div class="lpc-card"><p class="small mb-2">More than one plot matches. Pick one:</p><div class="lpc-near">` +
            list.map(p => `<button class="btn btn-outline-primary btn-sm" data-lat="${p.lat}" data-lng="${p.lng}">${esc(p.plot_no)} · ${title(p.sector)}${p.size ? ' · ' + esc(p.size) : ''}</button>`).join('') +
            '</div></div>';
    }
    resultBox.addEventListener('click', e => {
        const b = e.target.closest('button[data-lat]'); if (!b) return;
        lookup({ mode: 'point', lat: b.dataset.lat, lng: b.dataset.lng });
    });

    const VLABEL = { green: '✅ Nothing alarming in LDA GIS at this spot', amber: '⚠️ Needs checking before buying', red: '⛔ Red flag in LDA records' };

    function showReport(r) {
        // map
        shapes.clearLayers();
        if (marker) marker.remove();
        marker = L.marker([r.lat, r.lng]).addTo(map);
        (r.nearby || []).forEach(p => p.rings && L.polygon(ringsToLatLng(p.rings), { color: '#6c757d', weight: 1, fillOpacity: 0.05 })
            .bindTooltip(`${p.plot_no || p.landuse_sub || ''} ${p.size ? '· ' + p.size : ''}`).addTo(shapes));
        if (r.plot && r.plot.rings) {
            const poly = L.polygon(ringsToLatLng(r.plot.rings), { color: '#FF5C00', weight: 3, fillOpacity: 0.25 }).addTo(shapes);
            map.fitBounds(poly.getBounds(), { maxZoom: 19, padding: [60, 60] });
        } else map.setView([r.lat, r.lng], Math.max(map.getZoom(), 17));

        const p = r.plot;
        const rows = [];
        const row = (k, v) => v ? rows.push(`<tr><th>${k}</th><td>${v}</td></tr>`) : null;
        if (p) {
            row('Scheme', title(p.scheme) + (p.sub_scheme ? ' · ' + title(p.sub_scheme) : ''));
            row('Sector', title(p.sector));
            row('Plot no.', esc(p.plot_no));
            row('Size', esc(p.size) + (p.dimensions ? ` (${esc(p.dimensions)})` : ''));
            row('Plot type', esc(p.type));
            row('Land use (layout)', esc(p.landuse) + (p.landuse_sub && p.landuse_sub !== p.landuse ? ' · ' + esc(p.landuse_sub) : ''));
            row('Allotment (LDA GIS)', esc(p.allotment) || '<span class="text-muted">not recorded</span>');
            row('LDA property ID', esc(p.pid));
            row('LDA code', esc(p.code));
            row('Road width', esc(p.road_width));
        } else row('LDA plot record', '<span class="text-danger">Not found at this point</span>');
        row('Master plan (proposed)', esc((r.masterplan || []).join(', ')) || '<span class="text-muted">none</span>');
        row('Existing land use', esc((r.existing || []).join(', ')));
        row('Village', r.village ? `${esc(r.village.en)} (${esc(r.village.hi)})${r.village.tehsil ? ', tehsil ' + esc(r.village.tehsil) : ''}` : '');
        row('LDA engineering zone', esc(r.zone));
        row('Metro TOD zone', r.tod ? 'Yes' : 'No');
        row('Inside Nagar Nigam limit', r.municipal ? 'Yes' : 'No');
        row('Coordinates', `${(+r.lat).toFixed(6)}, ${(+r.lng).toFixed(6)}`);

        const flags = (r.flags || []).map(([lvl, t]) => `<div class="lpc-flag f-${lvl}">${esc(t)}</div>`).join('');
        const near = (r.nearby || []).filter(n => n.plot_no && n.lat).map(n =>
            `<button class="btn btn-outline-secondary btn-sm" data-lat="${n.lat}" data-lng="${n.lng}">${esc(n.plot_no)}${n.size ? ' · ' + esc(n.size) : ''}</button>`).join('');

        resultBox.innerHTML = `<div class="lpc-card">
            <div class="lpc-verdict v-${r.verdict}">${VLABEL[r.verdict]}</div>
            <table class="lpc-kv mb-3"><tbody>${rows.join('')}</tbody></table>
            ${flags}
            ${near ? `<p class="small text-muted mt-3 mb-1">Wrong plot? Plots within 30 m:</p><div class="lpc-near mb-2">${near}</div>` : ''}
            <div class="d-flex flex-wrap gap-2 mt-3">
                <button class="btn btn-sm btn-dark" id="lpc-copy">Copy summary for report</button>
                <a class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener" href="https://www.google.com/maps?q=${r.lat},${r.lng}">Google Maps ↗</a>
            </div>
            <p class="lpc-src mt-3 mb-0">Source: LDA GIS (gis.ldalucknow.in), checked ${esc(r.checked_at)}. LDA does not publish when this data was last updated. This is a record check, not legal proof of title or ownership.</p>
        </div>`;

        document.getElementById('lpc-copy').addEventListener('click', ev => {
            const txt = [
                `LDA GIS check (gis.ldalucknow.in), ${r.checked_at}`,
                `Location: ${(+r.lat).toFixed(6)}, ${(+r.lng).toFixed(6)}`,
                p ? `Plot record: ${p.plot_no || '-'}, ${p.sector || ''}, ${p.scheme || ''}${p.sub_scheme ? ' (' + p.sub_scheme + ')' : ''}; size ${p.size || 'not recorded'}${p.dimensions ? ' (' + p.dimensions + ')' : ''}; land use ${p.landuse || '-'}; allotment status ${p.allotment || 'not recorded'}; LDA property ID ${p.pid || '-'}`
                  : 'Plot record: none found at this point in LDA GIS',
                `Master plan (proposed): ${(r.masterplan || []).join(', ') || 'none'}`,
                `Existing land use: ${(r.existing || []).join(', ') || '-'}`,
                r.village ? `Village: ${r.village.en} (${r.village.hi})` : '',
                `Metro TOD zone: ${r.tod ? 'Yes' : 'No'}; Nagar Nigam limit: ${r.municipal ? 'Yes' : 'No'}`,
                ...(r.flags || []).map(([l, t]) => `[${l.toUpperCase()}] ${t}`),
            ].filter(Boolean).join('\n');
            const btn = ev.currentTarget;
            navigator.clipboard.writeText(txt).then(() => { btn.textContent = 'Copied ✓'; setTimeout(() => btn.textContent = 'Copy summary for report', 1800); })
                .catch(() => { window.prompt('Copy this:', txt); });
        });
    }
})();
</script>
@endpush
