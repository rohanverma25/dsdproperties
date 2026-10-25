{{--
    DSD Properties — Price Map Component
    File: resources/views/components/price-map.blade.php
    Usage: <x-price-map/>
--}}

<div class="pm">

    {{-- ── HEADER ── --}}
    <div class="pm__head">
        <div class="pm__head-left">
            <div class="pm__eyebrow">
                <span class="pm__live-dot"></span>
                Live Price Map
            </div>
            <h2 class="pm__title">Lucknow Property Prices — By Locality</h2>
            <p class="pm__sub">Click any pin to see the price band. Toggle heatmap to see price intensity across the city.</p>
        </div>
        <div class="pm__head-stats">
            <div class="pm__stat">
                <strong>50</strong>
                <span>Localities</span>
            </div>
            <div class="pm__stat-div"></div>
            <div class="pm__stat">
                <strong>5</strong>
                <span>Segments</span>
            </div>
            <div class="pm__stat-div"></div>
            <div class="pm__stat">
                <strong>Free</strong>
                <span>Always</span>
            </div>
        </div>
    </div>

    {{-- ── FILTER TOOLBAR ── --}}
    <div class="pm__toolbar">
        <div class="pm__filters" id="pmFilters">
            <button class="pm__filter active" data-seg="ALL">
                <span class="pm__fdot" style="background:linear-gradient(135deg,#ef4444,#f97316,#22c55e,#3b82f6,#8b5cf6)"></span>
                All Areas
            </button>
            <button class="pm__filter" data-seg="Premium">
                <span class="pm__fdot" style="background:#ef4444"></span>
                Premium
            </button>
            <button class="pm__filter" data-seg="Upper Mid">
                <span class="pm__fdot" style="background:#f97316"></span>
                Upper Mid
            </button>
            <button class="pm__filter" data-seg="Mid">
                <span class="pm__fdot" style="background:#22c55e"></span>
                Mid
            </button>
            <button class="pm__filter" data-seg="Affordable">
                <span class="pm__fdot" style="background:#3b82f6"></span>
                Affordable
            </button>
            <button class="pm__filter" data-seg="Budget">
                <span class="pm__fdot" style="background:#8b5cf6"></span>
                Budget
            </button>
        </div>
        {{-- <button class="pm__heatbtn" id="pmHeatBtn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3c-1.2 5.4-5 7-5 11a5 5 0 0 0 10 0c0-4-3.8-5.6-5-11zm0 15.5A2.5 2.5 0 0 1 9.5 16c0-1.8 1.5-3 2.5-5.5 1 2.5 2.5 3.7 2.5 5.5a2.5 2.5 0 0 1-2.5 2.5z"/></svg>
            Heatmap
        </button> --}}
    </div>

    {{-- ── MAP ── --}}
    <div class="pm__map-wrap">
        <div id="pm-map"></div>
        <div class="pm__loader" id="pmLoader">
            <div class="pm__spinner"></div>
            <span>Loading map…</span>
        </div>
    </div>

    {{-- ── LEGEND ── --}}
    <div class="pm__legend">
        <div class="pm__legend-title">Segments:</div>
        <div class="pm__legend-list">
            <div class="pm__legend-item">
                <span class="pm__ldot" style="background:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.18)"></span>
                <b>Premium</b> <em>₹6,500+</em>
            </div>
            <div class="pm__legend-item">
                <span class="pm__ldot" style="background:#f97316;box-shadow:0 0 0 3px rgba(249,115,22,.18)"></span>
                <b>Upper Mid</b> <em>₹4,800–6,500</em>
            </div>
            <div class="pm__legend-item">
                <span class="pm__ldot" style="background:#22c55e;box-shadow:0 0 0 3px rgba(34,197,94,.18)"></span>
                <b>Mid</b> <em>₹3,800–5,200</em>
            </div>
            <div class="pm__legend-item">
                <span class="pm__ldot" style="background:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.18)"></span>
                <b>Affordable</b> <em>₹3,000–4,500</em>
            </div>
            <div class="pm__legend-item">
                <span class="pm__ldot" style="background:#8b5cf6;box-shadow:0 0 0 3px rgba(139,92,246,.18)"></span>
                <b>Budget</b> <em>₹2,500–3,500</em>
            </div>
        </div>
        <div class="pm__legend-note">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#008080" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Based on listing data — actual prices vary
        </div>
    </div>

</div><!-- /pm -->

<style>
/* ──────────────────────────────────────────
   PM = Price Map
   Scoped so nothing leaks to parent page
────────────────────────────────────────── */
.pm {
    font-family: 'Poppins', sans-serif;
    background: var(--card-bg, #ffffff);
    border: 1.5px solid rgba(0, 128, 128, .16);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 32px rgba(0, 0, 0, .07);
    /* NO margin here — parent section handles spacing */
}

/* ── Header ── */
.pm__head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    padding: 24px 24px 0;
    flex-wrap: wrap;
}

.pm__eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #008080;
    margin-bottom: 8px;
}
.pm__live-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: #4ade80; flex-shrink: 0;
    animation: pmPulse 2s infinite;
}
@keyframes pmPulse {
    0%,100% { box-shadow: 0 0 0 2px rgba(74,222,128,.3); }
    50%      { box-shadow: 0 0 0 5px rgba(74,222,128,.08); }
}

.pm__title {
    font-size: clamp(1rem, 2.2vw, 1.3rem);
    font-weight: 800;
    color: var(--text-primary, #111827);
    margin: 0 0 6px;
    line-height: 1.2;
}
.pm__sub {
    font-size: .78rem;
    color: var(--text-tertiary, #9ca3af);
    margin: 0;
    line-height: 1.65;
    max-width: 480px;
}

.pm__head-stats {
    display: flex;
    align-items: center;
    flex-shrink: 0;
    background: var(--bg-secondary, #f9fafb);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 12px;
    padding: 10px 4px;
    gap: 0;
}
.pm__stat { text-align: center; padding: 0 18px; }
.pm__stat strong { display: block; font-size: 1.1rem; font-weight: 800; color: #FF5C00; line-height: 1.1; }
.pm__stat span   { font-size: 9px; text-transform: uppercase; letter-spacing: .8px; color: var(--text-tertiary, #9ca3af); }
.pm__stat-div    { width: 1px; height: 28px; background: var(--border-color, #e5e7eb); flex-shrink: 0; }

/* ── Toolbar ── */
.pm__toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px 24px;
    border-top: 1px solid var(--border-color, #f0f0f0);
    border-bottom: 1px solid var(--border-color, #f0f0f0);
    background: var(--bg-secondary, #fafafa);
    flex-wrap: wrap;
    margin-top: 16px;
}

.pm__filters {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.pm__filter {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 99px;
    border: 1.5px solid var(--border-color, #e5e7eb);
    background: var(--card-bg, #fff);
    color: var(--text-secondary, #4b5563);
    font-family: 'Poppins', sans-serif;
    font-size: .76rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
    line-height: 1;
}
.pm__filter:hover {
    border-color: #008080;
    color: #008080;
    background: rgba(0,128,128,.04);
}
.pm__filter.active {
    background: #011f4b;
    border-color: #011f4b;
    color: #fff;
}
.pm__fdot {
    width: 8px; height: 8px;
    border-radius: 50%; flex-shrink: 0;
    display: block;
}

/* ── Map wrapper ── */
.pm__map-wrap {
    position: relative;
    margin: 16px 20px 0;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid rgba(0,128,128,.12);
    /* Explicit height so Google Maps renders correctly */
    height: 520px;
}
#pm-map {
    width: 100%;
    height: 100%;
    display: block;
}

/* Loader overlay */
.pm__loader {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: var(--card-bg, #fff);
    font-size: .82rem;
    font-weight: 500;
    color: var(--text-tertiary, #9ca3af);
    z-index: 10;
    transition: opacity .4s ease;
}
.pm__loader.hide { opacity: 0; pointer-events: none; }
.pm__spinner {
    width: 34px; height: 34px;
    border: 3px solid var(--border-color, #e5e7eb);
    border-top-color: #008080;
    border-radius: 50%;
    animation: pmSpin .75s linear infinite;
}
@keyframes pmSpin { to { transform: rotate(360deg); } }

/* ── Legend ── */
.pm__legend {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px 16px;
    padding: 14px 24px 18px;
    margin-top: 12px;
    border-top: 1px solid var(--border-color, #f0f0f0);
}
.pm__legend-title {
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-tertiary, #9ca3af);
    flex-shrink: 0;
}
.pm__legend-list {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    flex: 1;
}
.pm__legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .75rem;
    color: var(--text-secondary, #4b5563);
    white-space: nowrap;
}
.pm__legend-item b  { font-weight: 600; }
.pm__legend-item em { font-style: normal; color: var(--text-tertiary, #9ca3af); font-size: .7rem; }
.pm__ldot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; display: block; }
.pm__legend-note {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .7rem;
    color: var(--text-tertiary, #9ca3af);
    white-space: nowrap;
    margin-left: auto;
}

/* ── Responsive ── */
@media (max-width: 860px) {
    .pm__head-stats { display: none; }
}
@media (max-width: 640px) {
    .pm__head    { padding: 18px 16px 0; }
    .pm__toolbar { padding: 10px 16px; gap: 8px; }
    .pm__map-wrap { margin: 12px 12px 0; height: 380px; border-radius: 10px; }
    .pm__legend  { padding: 12px 16px 16px; }
    .pm__legend-note { display: none; }
    .pm__legend-item em { display: none; }
    .pm__filter  { font-size: .7rem; padding: 5px 10px; }
}
@media (max-width: 440px) {
    .pm__filter  { padding: 5px 8px; gap: 4px; font-size: .68rem; }
}
</style>

<script>
(function () {
    var pmMap, pmMarkers = [];   // declared here: markers were pushed into an undefined array
    // ─── Segment colours — 5 distinct, clearly different colours ───
    const SEG_COLOR = {
        'Premium':   '#ef4444',   // vivid red
        'Upper Mid': '#f97316',   // orange
        'Mid':       '#22c55e',   // green
        'Affordable':'#3b82f6',   // blue
        'Budget':    '#8b5cf6'    // purple  ← was dark blue before, now clearly purple
    };

    const SEG_BG = {
        'Premium':   '#fef2f2',
        'Upper Mid': '#fff7ed',
        'Mid':       '#f0fdf4',
        'Affordable':'#eff6ff',
        'Budget':    '#f5f3ff'
    };

    const SEG_WEIGHT = {
        'Premium': 5, 'Upper Mid': 4, 'Mid': 3, 'Affordable': 2, 'Budget': 1
    };

    // ─── Clean map style — light, minimal, readable ───
    const MAP_STYLE = [
        { featureType:'all',     elementType:'labels.icon',   stylers:[{visibility:'off'}] },
        { featureType:'poi',     elementType:'all',           stylers:[{visibility:'off'}] },
        { featureType:'transit', elementType:'all',           stylers:[{visibility:'off'}] },
        { featureType:'landscape',         elementType:'geometry', stylers:[{color:'#f2f1ec'}] },
        { featureType:'water',             elementType:'geometry', stylers:[{color:'#b8d4e8'}] },
        { featureType:'water',             elementType:'labels.text.fill', stylers:[{visibility:'off'}] },
        { featureType:'road',              elementType:'geometry',          stylers:[{color:'#ffffff'}] },
        { featureType:'road',              elementType:'geometry.stroke',   stylers:[{color:'#e8e4dc'}] },
        { featureType:'road.highway',      elementType:'geometry',          stylers:[{color:'#f0e4cc'}] },
        { featureType:'road.highway',      elementType:'geometry.stroke',   stylers:[{color:'#ddd0b8'}] },
        { featureType:'road',              elementType:'labels.text.fill',  stylers:[{color:'#999990'}] },
        { featureType:'road',              elementType:'labels.text.stroke',stylers:[{color:'#ffffff'}] },
        { featureType:'road.highway',      elementType:'labels.text.fill',  stylers:[{color:'#888880'}] },
        { featureType:'administrative',    elementType:'geometry.stroke',   stylers:[{color:'#d0ccc4'}] },
        // FIX: neighborhood labels were dark navy — now light grey
        { featureType:'administrative.neighborhood', elementType:'labels.text.fill',  stylers:[{color:'#b0b0a8'}] },
        { featureType:'administrative.neighborhood', elementType:'labels.text.stroke',stylers:[{color:'#ffffff'}] },
        { featureType:'administrative.locality',     elementType:'labels.text.fill',  stylers:[{color:'#888880'}] },
        { featureType:'administrative.locality',     elementType:'labels.text.stroke',stylers:[{color:'#ffffff'}] },
        { featureType:'administrative.land_parcel',  elementType:'labels',            stylers:[{visibility:'off'}] },
        { featureType:'administrative',              elementType:'labels.text.fill',  stylers:[{color:'#a0a098'}] },
        { featureType:'administrative',              elementType:'labels.text.stroke',stylers:[{color:'#ffffff'}] },
    ];

    const LOCATIONS = [
        // Premium
        { name:'Hazratganj',            lat:26.8500, lng:80.9440, segment:'Premium',    price:'₹9,000 – ₹14,000/sqft' },
        { name:'Butler Colony',          lat:26.8610, lng:80.9580, segment:'Premium',    price:'₹10,000 – ₹15,000/sqft' },
        { name:'Vibhuti Khand',          lat:26.8650, lng:81.0020, segment:'Premium',    price:'₹8,000 – ₹11,000/sqft' },
        { name:'Gomti Nagar (Central)',  lat:26.8500, lng:80.9960, segment:'Premium',    price:'₹8,000 – ₹12,000/sqft' },
        { name:'Gomti Nagar Extension',  lat:26.8380, lng:81.0250, segment:'Premium',    price:'₹7,000 – ₹9,500/sqft' },
        { name:'Mahanagar',              lat:26.8770, lng:80.9540, segment:'Premium',    price:'₹7,500 – ₹10,000/sqft' },
        { name:'Nirala Nagar',           lat:26.8800, lng:80.9400, segment:'Premium',    price:'₹7,000 – ₹9,500/sqft' },
        { name:'New Hyderabad',          lat:26.8710, lng:80.9470, segment:'Premium',    price:'₹7,000 – ₹9,000/sqft' },
        { name:'Sushant Golf City',      lat:26.7750, lng:81.0150, segment:'Premium',    price:'₹6,500 – ₹8,500/sqft' },
        { name:'Ashiyana (Sector I–M)',  lat:26.7880, lng:80.9150, segment:'Premium',    price:'₹6,500 – ₹9,000/sqft' },
        // Upper Mid
        { name:'Aliganj',                lat:26.9000, lng:80.9500, segment:'Upper Mid',  price:'₹5,500 – ₹7,500/sqft' },
        { name:'Vrindavan Yojna',        lat:26.7680, lng:80.9530, segment:'Upper Mid',  price:'₹5,000 – ₹7,000/sqft' },
        { name:'Amar Shaheed Path',      lat:26.8020, lng:81.0230, segment:'Upper Mid',  price:'₹5,500 – ₹7,500/sqft' },
        { name:'Faizabad Road',          lat:26.8800, lng:81.0600, segment:'Upper Mid',  price:'₹5,000 – ₹7,000/sqft' },
        { name:'Raebareli Rd (PGI)',     lat:26.7550, lng:80.9350, segment:'Upper Mid',  price:'₹4,800 – ₹6,800/sqft' },
        { name:'Kursi Road',             lat:26.9100, lng:80.9200, segment:'Upper Mid',  price:'₹4,800 – ₹6,500/sqft' },
        { name:'Indira Nagar (A–Block)', lat:26.8850, lng:80.9950, segment:'Upper Mid',  price:'₹5,000 – ₹7,000/sqft' },
        { name:'Krishna Nagar',          lat:26.8000, lng:80.9000, segment:'Upper Mid',  price:'₹4,800 – ₹6,800/sqft' },
        { name:'Telibagh',               lat:26.8000, lng:80.9500, segment:'Upper Mid',  price:'₹4,800 – ₹6,500/sqft' },
        { name:'Chinhat (Highway Belt)', lat:26.8750, lng:81.0400, segment:'Upper Mid',  price:'₹5,000 – ₹7,200/sqft' },
        // Mid
        { name:'IIM Road',               lat:26.9210, lng:80.8920, segment:'Mid',        price:'₹4,200 – ₹6,200/sqft' },
        { name:'Jankipuram Extension',   lat:26.9380, lng:80.9520, segment:'Mid',        price:'₹4,000 – ₹5,800/sqft' },
        { name:'Sitapur Road',           lat:26.9400, lng:80.9000, segment:'Mid',        price:'₹4,000 – ₹5,500/sqft' },
        { name:'Balaganj',               lat:26.8300, lng:80.8700, segment:'Mid',        price:'₹3,800 – ₹5,200/sqft' },
        { name:'Thakurganj',             lat:26.8500, lng:80.8800, segment:'Mid',        price:'₹4,000 – ₹5,800/sqft' },
        { name:'Rajajipuram',            lat:26.8350, lng:80.8880, segment:'Mid',        price:'₹4,000 – ₹5,500/sqft' },
        { name:'Para',                   lat:26.8100, lng:80.8800, segment:'Mid',        price:'₹3,800 – ₹5,200/sqft' },
        { name:'Matiyari',               lat:26.8600, lng:81.0450, segment:'Mid',        price:'₹4,200 – ₹5,800/sqft' },
        { name:'South City',             lat:26.7800, lng:80.9400, segment:'Mid',        price:'₹4,500 – ₹6,000/sqft' },
        { name:'Engineering College Rd', lat:26.9150, lng:80.9400, segment:'Mid',        price:'₹4,800 – ₹6,500/sqft' },
        // Affordable
        { name:'Sarojini Nagar',         lat:26.7600, lng:80.8800, segment:'Affordable', price:'₹3,500 – ₹5,000/sqft' },
        { name:'Alambagh (Interior)',    lat:26.8220, lng:80.9050, segment:'Affordable', price:'₹3,800 – ₹5,200/sqft' },
        { name:'Kakori Road',            lat:26.8500, lng:80.7700, segment:'Affordable', price:'₹3,000 – ₹4,500/sqft' },
        { name:'Dubagga',               lat:26.8500, lng:80.8600, segment:'Affordable', price:'₹3,000 – ₹4,800/sqft' },
        { name:'Bijnor Road',            lat:26.7500, lng:80.8800, segment:'Affordable', price:'₹3,200 – ₹4,800/sqft' },
        { name:'Kisan Path Belt',        lat:26.8200, lng:81.0800, segment:'Affordable', price:'₹3,000 – ₹4,800/sqft' },
        { name:'Kamta',                  lat:26.8700, lng:81.0300, segment:'Affordable', price:'₹4,000 – ₹5,500/sqft' },
        { name:'Deva Road',              lat:26.8800, lng:81.0800, segment:'Affordable', price:'₹3,500 – ₹5,200/sqft' },
        { name:'LDA Colony (Kanpur Rd)', lat:26.7800, lng:80.9000, segment:'Affordable', price:'₹3,800 – ₹5,500/sqft' },
        { name:'Transport Nagar Ext.',   lat:26.8100, lng:80.8900, segment:'Affordable', price:'₹3,500 – ₹5,000/sqft' },
        // Budget
        { name:'Mohanlalganj',           lat:26.6700, lng:81.0000, segment:'Budget',     price:'₹2,800 – ₹4,200/sqft' },
        { name:'Gosainganj',             lat:26.7200, lng:81.1200, segment:'Budget',     price:'₹2,500 – ₹3,800/sqft' },
        { name:'Banthra (Airport Belt)', lat:26.6800, lng:80.8300, segment:'Budget',     price:'₹2,800 – ₹4,000/sqft' },
        { name:'Malihabad',              lat:26.9200, lng:80.7100, segment:'Budget',     price:'₹2,500 – ₹3,500/sqft' },
        { name:'Barabanki Rd Fringe',    lat:26.9000, lng:81.1100, segment:'Budget',     price:'₹2,800 – ₹4,000/sqft' },
        { name:'Kisan Path Outer Zone',  lat:26.7800, lng:81.1000, segment:'Budget',     price:'₹2,800 – ₹4,200/sqft' },
        { name:'Outer Ring Rd West',     lat:26.9000, lng:80.7800, segment:'Budget',     price:'₹3,000 – ₹4,500/sqft' },
        { name:'Hardoi Road Fringe',     lat:26.8800, lng:80.8200, segment:'Budget',     price:'₹2,800 – ₹4,000/sqft' },
        { name:'Raebareli Rd Outer',     lat:26.7121, lng:80.9695, segment:'Budget',     price:'₹2,800 – ₹4,200/sqft' },
        { name:'Sultanpur Rd Outer',     lat:26.7400, lng:81.0800, segment:'Budget',     price:'₹3,000 – ₹4,500/sqft' }
    ];

    window.pmInitMap = function () {
        const loader = document.getElementById('pmLoader');

        pmMap = new google.maps.Map(document.getElementById('pm-map'), {
            zoom: 11,
            center: { lat: 26.8467, lng: 80.9462 },
            mapTypeControl:     false,
            streetViewControl:  false,
            fullscreenControl:  true,
            fullscreenControlOptions: { position: google.maps.ControlPosition.TOP_RIGHT },
            zoomControl:        true,
            zoomControlOptions: { position: google.maps.ControlPosition.TOP_RIGHT },
            scaleControl:       false,
            styles:             MAP_STYLE
        });

        // Add all markers with a staggered drop animation
        LOCATIONS.forEach((loc, i) => {
            setTimeout(() => addMarker(loc), i * 18);
        });

        // Heatmap layer
        // pmHeatmap = new google.maps.visualization.HeatmapLayer({
        //     data: LOCATIONS.map(l => ({
        //         location: new google.maps.LatLng(l.lat, l.lng),
        //         weight:   SEG_WEIGHT[l.segment] || 1
        //     })),
        //     radius: 52,
        //     gradient: [
        //         'rgba(0,0,0,0)',
        //         'rgba(139,92,246,0.6)',
        //         'rgba(59,130,246,0.7)',
        //         'rgba(34,197,94,0.8)',
        //         'rgba(249,115,22,0.9)',
        //         'rgba(239,68,68,1)',
        //         'rgba(185,28,28,1)'
        //     ],
        //     map: null
        // });

        // Filter buttons
        document.querySelectorAll('.pm__filter').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.pm__filter').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const seg = this.dataset.seg;
                pmMarkers.forEach(m => m.setVisible(seg === 'ALL' || m._seg === seg));
            });
        });

        // Heatmap toggle
        // document.getElementById('pmHeatBtn').addEventListener('click', function () {
        //     pmHeatOn = !pmHeatOn;
        //     this.classList.toggle('active', pmHeatOn);
        //     pmHeatmap.setMap(pmHeatOn ? pmMap : null);
        //     // When heatmap on: shrink + dim markers so heatmap is visible
        //     pmMarkers.forEach(m => {
        //         const ic = m.getIcon();
        //         ic.scale        = pmHeatOn ? 6  : 11;
        //         ic.fillOpacity  = pmHeatOn ? 0.3 : 0.92;
        //         ic.strokeWeight = pmHeatOn ? 1.5 : 2.5;
        //         m.setIcon(ic);
        //     });
        // });

        // Hide loader
        google.maps.event.addListenerOnce(pmMap, 'idle', () => {
            if (loader) loader.classList.add('hide');
        });
        // Fallback
        setTimeout(() => { if (loader) loader.classList.add('hide'); }, 3000);
    };

    function addMarker(loc) {
        const color = SEG_COLOR[loc.segment] || '#8b5cf6';

        const marker = new google.maps.Marker({
            position:  { lat: loc.lat, lng: loc.lng },
            map:        pmMap,
            title:      loc.name,
            _seg:       loc.segment,
            animation:  google.maps.Animation.DROP,
            icon: {
                path:         google.maps.SymbolPath.CIRCLE,
                scale:        11,
                fillColor:    color,
                fillOpacity:  0.92,
                strokeColor:  '#ffffff',
                strokeWeight: 2.5
            }
        });

        const iw = new google.maps.InfoWindow({
            maxWidth: 230,
            content: `
<div style="font-family:'Poppins',-apple-system,sans-serif;padding:2px;min-width:180px">
  <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px">
    <span style="width:10px;height:10px;border-radius:50%;background:${color};flex-shrink:0;box-shadow:0 0 0 3px ${color}30;display:block"></span>
    <strong style="font-size:13px;color:#111827;line-height:1.2">${loc.name}</strong>
  </div>
  <span style="display:inline-block;padding:3px 10px;border-radius:99px;background:${SEG_BG[loc.segment]||'#f9fafb'};color:${color};font-size:11px;font-weight:700;margin-bottom:10px">${loc.segment}</span>
  <div style="background:#f8fafc;border-radius:8px;padding:8px 12px;border:1px solid #e5e7eb">
    <div style="font-size:9px;text-transform:uppercase;letter-spacing:.8px;color:#9ca3af;margin-bottom:3px">Price Band</div>
    <div style="font-size:14px;font-weight:800;color:#011f4b;font-family:'Courier New',monospace">${loc.price}</div>
  </div>
  <div style="font-size:10px;color:#9ca3af;margin-top:8px;line-height:1.5">Listing-based estimate. Actual prices vary.</div>
</div>`
        });

        marker.addListener('click', () => {
            pmMarkers.forEach(m => m._iw && m._iw.close());
            iw.open(pmMap, marker);
            marker.setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(() => marker.setAnimation(null), 600);
        });

        marker._iw = iw;
        pmMarkers.push(marker);
    }
})();
</script>

<!-- In price-map.blade.php — change this line -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAIrA0YRspz_UGlpWuNR1_LXX_8DfHWdj4&libraries=places&callback=pmInitMap&loading=async">
</script>