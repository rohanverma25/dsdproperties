
<script>
const ValuationComponent = (function () {

    // ── Locality data ──────────────────────────────────────────
    const LOCATIONS = [
        { name:'Hazratganj',            lat:26.8500, lng:80.9440, segment:'Premium',    price:'₹9,000 – ₹14,000/sqft',  min:9000,  max:14000 },
        { name:'Butler Colony',          lat:26.8610, lng:80.9580, segment:'Premium',    price:'₹10,000 – ₹15,000/sqft', min:10000, max:15000 },
        { name:'Vibhuti Khand',          lat:26.8650, lng:81.0020, segment:'Premium',    price:'₹8,000 – ₹11,000/sqft',  min:8000,  max:11000 },
        { name:'Gomti Nagar (Central)',  lat:26.8500, lng:80.9960, segment:'Premium',    price:'₹8,000 – ₹12,000/sqft',  min:8000,  max:12000 },
        { name:'Gomti Nagar Extension',  lat:26.8380, lng:81.0250, segment:'Premium',    price:'₹7,000 – ₹9,500/sqft',   min:7000,  max:9500  },
        { name:'Mahanagar',              lat:26.8770, lng:80.9540, segment:'Premium',    price:'₹7,500 – ₹10,000/sqft',  min:7500,  max:10000 },
        { name:'Nirala Nagar',           lat:26.8800, lng:80.9400, segment:'Premium',    price:'₹7,000 – ₹9,500/sqft',   min:7000,  max:9500  },
        { name:'New Hyderabad',          lat:26.8710, lng:80.9470, segment:'Premium',    price:'₹7,000 – ₹9,000/sqft',   min:7000,  max:9000  },
        { name:'Sushant Golf City',      lat:26.7750, lng:81.0150, segment:'Premium',    price:'₹6,500 – ₹8,500/sqft',   min:6500,  max:8500  },
        { name:'Ashiyana',               lat:26.7880, lng:80.9150, segment:'Premium',    price:'₹6,500 – ₹9,000/sqft',   min:6500,  max:9000  },
        { name:'Aliganj',                lat:26.9000, lng:80.9500, segment:'Upper Mid',  price:'₹5,500 – ₹7,500/sqft',   min:5500,  max:7500  },
        { name:'Vrindavan Yojna',        lat:26.7680, lng:80.9530, segment:'Upper Mid',  price:'₹5,000 – ₹7,000/sqft',   min:5000,  max:7000  },
        { name:'Amar Shaheed Path',      lat:26.8020, lng:81.0230, segment:'Upper Mid',  price:'₹5,500 – ₹7,500/sqft',   min:5500,  max:7500  },
        { name:'Faizabad Road',          lat:26.8800, lng:81.0600, segment:'Upper Mid',  price:'₹5,000 – ₹7,000/sqft',   min:5000,  max:7000  },
        { name:'Raebareli Road (PGI)',   lat:26.7550, lng:80.9350, segment:'Upper Mid',  price:'₹4,800 – ₹6,800/sqft',   min:4800,  max:6800  },
        { name:'Kursi Road',             lat:26.9100, lng:80.9200, segment:'Upper Mid',  price:'₹4,800 – ₹6,500/sqft',   min:4800,  max:6500  },
        { name:'Indira Nagar',           lat:26.8850, lng:80.9950, segment:'Upper Mid',  price:'₹5,000 – ₹7,000/sqft',   min:5000,  max:7000  },
        { name:'Krishna Nagar',          lat:26.8000, lng:80.9000, segment:'Upper Mid',  price:'₹4,800 – ₹6,800/sqft',   min:4800,  max:6800  },
        { name:'Telibagh',               lat:26.8000, lng:80.9500, segment:'Upper Mid',  price:'₹4,800 – ₹6,500/sqft',   min:4800,  max:6500  },
        { name:'Chinhat',                lat:26.8750, lng:81.0400, segment:'Upper Mid',  price:'₹5,000 – ₹7,200/sqft',   min:5000,  max:7200  },
        { name:'IIM Road',               lat:26.9210, lng:80.8920, segment:'Mid',        price:'₹4,200 – ₹6,200/sqft',   min:4200,  max:6200  },
        { name:'Jankipuram Extension',   lat:26.9380, lng:80.9520, segment:'Mid',        price:'₹4,000 – ₹5,800/sqft',   min:4000,  max:5800  },
        { name:'Sitapur Road',           lat:26.9400, lng:80.9000, segment:'Mid',        price:'₹4,000 – ₹5,500/sqft',   min:4000,  max:5500  },
        { name:'Balaganj',               lat:26.8300, lng:80.8700, segment:'Mid',        price:'₹3,800 – ₹5,200/sqft',   min:3800,  max:5200  },
        { name:'Thakurganj',             lat:26.8500, lng:80.8800, segment:'Mid',        price:'₹4,000 – ₹5,800/sqft',   min:4000,  max:5800  },
        { name:'Rajajipuram',            lat:26.8350, lng:80.8880, segment:'Mid',        price:'₹4,000 – ₹5,500/sqft',   min:4000,  max:5500  },
        { name:'Para',                   lat:26.8100, lng:80.8800, segment:'Mid',        price:'₹3,800 – ₹5,200/sqft',   min:3800,  max:5200  },
        { name:'Matiyari',               lat:26.8600, lng:81.0450, segment:'Mid',        price:'₹4,200 – ₹5,800/sqft',   min:4200,  max:5800  },
        { name:'South City',             lat:26.7800, lng:80.9400, segment:'Mid',        price:'₹4,500 – ₹6,000/sqft',   min:4500,  max:6000  },
        { name:'Engineering College Rd', lat:26.9150, lng:80.9400, segment:'Mid',        price:'₹4,800 – ₹6,500/sqft',   min:4800,  max:6500  },
        { name:'Sarojini Nagar',         lat:26.7600, lng:80.8800, segment:'Affordable', price:'₹3,500 – ₹5,000/sqft',   min:3500,  max:5000  },
        { name:'Alambagh',               lat:26.8220, lng:80.9050, segment:'Affordable', price:'₹3,800 – ₹5,200/sqft',   min:3800,  max:5200  },
        { name:'Kakori Road',            lat:26.8500, lng:80.7700, segment:'Affordable', price:'₹3,000 – ₹4,500/sqft',   min:3000,  max:4500  },
        { name:'Dubagga',                lat:26.8500, lng:80.8600, segment:'Affordable', price:'₹3,000 – ₹4,800/sqft',   min:3000,  max:4800  },
        { name:'Bijnor Road',            lat:26.7500, lng:80.8800, segment:'Affordable', price:'₹3,200 – ₹4,800/sqft',   min:3200,  max:4800  },
        { name:'Kisan Path Belt',        lat:26.8200, lng:81.0800, segment:'Affordable', price:'₹3,000 – ₹4,800/sqft',   min:3000,  max:4800  },
        { name:'Kamta',                  lat:26.8700, lng:81.0300, segment:'Affordable', price:'₹4,000 – ₹5,500/sqft',   min:4000,  max:5500  },
        { name:'Deva Road',              lat:26.8800, lng:81.0800, segment:'Affordable', price:'₹3,500 – ₹5,200/sqft',   min:3500,  max:5200  },
        { name:'LDA Colony',             lat:26.7800, lng:80.9000, segment:'Affordable', price:'₹3,800 – ₹5,500/sqft',   min:3800,  max:5500  },
        { name:'Transport Nagar',        lat:26.8100, lng:80.8900, segment:'Affordable', price:'₹3,500 – ₹5,000/sqft',   min:3500,  max:5000  },
        { name:'Mohanlalganj',           lat:26.6700, lng:81.0000, segment:'Budget',     price:'₹2,800 – ₹4,200/sqft',   min:2800,  max:4200  },
        { name:'Gosainganj',             lat:26.7200, lng:81.1200, segment:'Budget',     price:'₹2,500 – ₹3,800/sqft',   min:2500,  max:3800  },
        { name:'Banthra',                lat:26.6800, lng:80.8300, segment:'Budget',     price:'₹2,800 – ₹4,000/sqft',   min:2800,  max:4000  },
        { name:'Malihabad',              lat:26.9200, lng:80.7100, segment:'Budget',     price:'₹2,500 – ₹3,500/sqft',   min:2500,  max:3500  },
        { name:'Barabanki Rd Fringe',    lat:26.9000, lng:81.1100, segment:'Budget',     price:'₹2,800 – ₹4,000/sqft',   min:2800,  max:4000  },
        { name:'Kisan Path Outer',       lat:26.7800, lng:81.1000, segment:'Budget',     price:'₹2,800 – ₹4,200/sqft',   min:2800,  max:4200  },
        { name:'Outer Ring Rd West',     lat:26.9000, lng:80.7800, segment:'Budget',     price:'₹3,000 – ₹4,500/sqft',   min:3000,  max:4500  },
        { name:'Hardoi Road Fringe',     lat:26.8800, lng:80.8200, segment:'Budget',     price:'₹2,800 – ₹4,000/sqft',   min:2800,  max:4000  },
        { name:'Raebareli Rd Outer',     lat:26.7121, lng:80.9695, segment:'Budget',     price:'₹2,800 – ₹4,200/sqft',   min:2800,  max:4200  },
        { name:'Sultanpur Rd Outer',     lat:26.7400, lng:81.0800, segment:'Budget',     price:'₹3,000 – ₹4,500/sqft',   min:3000,  max:4500  }
    ];

    const SEG_COLOR = { Premium:'#ef4444', 'Upper Mid':'#f97316', Mid:'#22c55e', Affordable:'#3b82f6', Budget:'#8b5cf6' };
    const SEG_BG    = { Premium:'#fef2f2', 'Upper Mid':'#fff7ed', Mid:'#f0fdf4', Affordable:'#eff6ff', Budget:'#f5f3ff' };

    // ── Multipliers ────────────────────────────────────────────
    const FACING_MULT  = { East:1.06, North:1.04, West:1.00, South:0.97 };
    const FLOOR_MULT   = { G:1.00, 'G+1':1.03, 'G+2':1.05, 'G+3+':1.02 };
    const YEAR_MULT    = { '2025':1.10, '2024':1.08, '2023':1.06, '2020-2022':1.03, '2015-2019':0.97, '2010-2014':0.92, 'Older':0.85 };
    const AMENITY_BUMP = { kitchen:0.02, furnished:0.04, parking:0.03, garden:0.025 };

    // ── State ──────────────────────────────────────────────────
    let currentStep  = 1;
    let selectedType = null;
    let features     = [];
    let submissionData = {};

    // ── Open / Close ───────────────────────────────────────────
    function open() {
        document.getElementById('vc-backdrop').classList.add('vc-visible');
        document.getElementById('vc-modal').classList.add('vc-visible');
        document.body.style.overflow = 'hidden';
        if (window._initPlacesAutocomplete) window._initPlacesAutocomplete();
    }

    function close() {
        document.getElementById('vc-backdrop').classList.remove('vc-visible');
        document.getElementById('vc-modal').classList.remove('vc-visible');
        document.body.style.overflow = '';
        document.querySelectorAll('.pac-container').forEach(p => p.style.display = 'none');
        // Show progress header again for next open
        var ph = document.getElementById('vc-progress-header');
        if (ph) ph.style.display = '';
    }

    // ── Step navigation ────────────────────────────────────────
    function goToStep(step) {
        var prev = document.getElementById('vc-step-' + currentStep);
        if (prev) prev.classList.remove('vc-active');
        currentStep = step;
        var curr = document.getElementById('vc-step-' + currentStep);
        if (curr) curr.classList.add('vc-active');
        updateProgress();
        validateStep(step);
    }

    function updateProgress() {
        var dots = document.querySelectorAll('.vc-dot');
        dots.forEach(function(d, i) {
            d.classList.remove('vc-dot-active', 'vc-dot-done');
            if (i + 1 === currentStep) d.classList.add('vc-dot-active');
            else if (i + 1 < currentStep) d.classList.add('vc-dot-done');
        });
        var txt = document.getElementById('vc-progress-text');
        if (txt) txt.textContent = 'Step ' + currentStep + ' of 4';
    }

    // ── Validation ─────────────────────────────────────────────
    function validateStep(step) {
        if (step === 1) {
            var val = (document.getElementById('vc-address').value || '').trim();
            var btn = document.getElementById('vc-next-1');
            if (btn) btn.disabled = val.length < 5;
        }
        if (step === 2) {
            var btn2 = document.getElementById('vc-next-2');
            if (btn2) btn2.disabled = !selectedType;
        }
        if (step === 3) {
            var face = document.getElementById('vc-face').value;
            var area = document.getElementById('vc-area').value;
            var valid = face && area && parseInt(area) > 0;
            if (selectedType === 'house') {
                var rooms = document.getElementById('vc-rooms').value;
                var floor = document.getElementById('vc-floor').value;
                var year  = document.getElementById('vc-year').value;
                valid = valid && rooms && floor && year;
            }
            var btn3 = document.getElementById('vc-next-3');
            if (btn3) btn3.disabled = !valid;
        }
    }

    function validatePhone(input) {
        var val = input.value.replace(/\D/g, '');
        input.value = val;
        var err = document.getElementById('vc-phone-error');
        var btn = document.getElementById('vc-next-4');
        var valid = /^[6-9]\d{9}$/.test(val);
        if (err) err.classList.toggle('vc-visible', val.length > 0 && !valid);
        if (btn) btn.disabled = !valid;
    }

    function selectType(type, el) {
        selectedType = type;
        document.querySelectorAll('.vc-type-card').forEach(function(c) { c.classList.remove('vc-selected'); });
        el.classList.add('vc-selected');
        var hf = document.getElementById('vc-house-fields');
        if (hf) hf.style.display = type === 'house' ? 'block' : 'none';
        var t = document.getElementById('vc-step-3-title');
        if (t) t.textContent = type === 'house' ? 'House Details' : 'Plot Details';
        validateStep(2);
    }

    function toggleFeature(btn) {
        var feat = btn.getAttribute('data-feature');
        btn.classList.toggle('vc-tag-active');
        if (features.indexOf(feat) > -1) features = features.filter(function(f) { return f !== feat; });
        else features.push(feat);
    }

    // ── Valuation engine ───────────────────────────────────────
    function findLocality(address) {
        var addrLower = address.toLowerCase();
        var best = null, bestScore = 0;
        LOCATIONS.forEach(function(loc) {
            var nameLower = loc.name.toLowerCase();
            // exact match
            if (addrLower.indexOf(nameLower) > -1) {
                var score = nameLower.length;
                if (score > bestScore) { bestScore = score; best = loc; }
            }
        });
        // fallback: default to city average if not found
        if (!best) best = LOCATIONS.find(function(l) { return l.name === 'Gomti Nagar (Central)'; }) || LOCATIONS[3];
        return best;
    }

    function calcValuation(data) {
        var loc   = findLocality(data.address);
        var area  = parseInt(data.area) || 1000;
        var fMult = FACING_MULT[data.facing]  || 1.0;
        var flMult= data.type === 'house' ? (FLOOR_MULT[data.floor] || 1.0) : 1.0;
        var yMult = data.type === 'house' ? (YEAR_MULT[data.year]   || 0.95) : 1.0;
        var aMult = 1.0;
        (data.features || []).forEach(function(f) { aMult += (AMENITY_BUMP[f] || 0); });

        var totalMult = fMult * flMult * yMult * aMult;
        var minRate   = Math.round(loc.min * totalMult);
        var maxRate   = Math.round(loc.max * totalMult);
        var midRate   = Math.round((minRate + maxRate) / 2);

        var totalMin  = minRate * area;
        var totalMax  = maxRate * area;
        var totalMid  = midRate * area;

        return {
            locality:   loc,
            minRate:    minRate, maxRate: maxRate, midRate: midRate,
            totalMin:   totalMin, totalMax: totalMax, totalMid: totalMid,
            area:       area
        };
    }

    function formatCrore(n) {
        if (n >= 10000000) return '₹' + (n / 10000000).toFixed(2) + ' Cr';
        if (n >= 100000)   return '₹' + (n / 100000).toFixed(1) + ' L';
        return '₹' + n.toLocaleString('en-IN');
    }

    // ── Submit + AI loader ──────────────────────────────────────
    function submit() {
        // Collect all data
        submissionData = {
            address:  document.getElementById('vc-address').value,
            type:     selectedType,
            facing:   document.getElementById('vc-face').value,
            area:     document.getElementById('vc-area').value,
            rooms:    selectedType === 'house' ? document.getElementById('vc-rooms').value : null,
            floor:    selectedType === 'house' ? document.getElementById('vc-floor').value : null,
            year:     selectedType === 'house' ? document.getElementById('vc-year').value  : null,
            features: features.slice(),
            phone:    document.getElementById('vc-phone').value,
            timestamp: new Date().toISOString(),
            ua:       navigator.userAgent
        };

        // Log the submission
        logSubmission(submissionData);

        // Hide progress header during loader
        var ph = document.getElementById('vc-progress-header');
        if (ph) ph.style.display = 'none';

        // Show loader
        var loader = document.getElementById('vc-loader');
        loader.classList.add('vc-visible');

        // Animate steps
        var steps   = [1, 2, 3, 4];
        var delays  = [0, 900, 1800, 2700];
        var barPcts = [20, 45, 72, 95];

        steps.forEach(function(s, i) {
            setTimeout(function() {
                // Mark previous done
                if (i > 0) {
                    var prev = document.getElementById('vcls-' + steps[i-1]);
                    if (prev) { prev.classList.remove('active'); prev.classList.add('done'); prev.querySelector('.vc-ai-step-icon').textContent = '✅'; }
                }
                var el = document.getElementById('vcls-' + s);
                if (el) el.classList.add('active');
                var bar = document.getElementById('vc-loader-bar');
                if (bar) bar.style.width = barPcts[i] + '%';
            }, delays[i]);
        });

        // After all steps done, show report
        setTimeout(function() {
            var last = document.getElementById('vcls-4');
            if (last) { last.classList.remove('active'); last.classList.add('done'); last.querySelector('.vc-ai-step-icon').textContent = '✅'; }
            var bar = document.getElementById('vc-loader-bar');
            if (bar) bar.style.width = '100%';

            setTimeout(function() {
                loader.classList.remove('vc-visible');
                showReport(submissionData);
            }, 400);
        }, 3600);
    }

    // ── Build and show report ───────────────────────────────────
    function showReport(data) {
        var v = calcValuation(data);
        var loc = v.locality;
        var segColor = SEG_COLOR[loc.segment] || '#008080';
        var segBg    = SEG_BG[loc.segment]    || '#f0fdf4';

        // Segment meter position (Premium=90%, Upper Mid=75%, Mid=55%, Affordable=38%, Budget=20%)
        var meterMap = { Premium:90, 'Upper Mid':72, Mid:55, Affordable:38, Budget:20 };
        var meterPct = meterMap[loc.segment] || 50;

        // Build report HTML
        var html = '\
<div class="vc-report-header">\
  <div class="vc-report-badge"><div class="vc-report-badge-dot"></div>AI Valuation Report · DSD Properties</div>\
  <div class="vc-report-address">' + escHtml(data.address) + '</div>\
  <div class="vc-report-meta">' + capFirst(data.type) + ' · ' + parseInt(data.area).toLocaleString('en-IN') + ' sq ft' + (data.facing ? ' · ' + data.facing + ' Facing' : '') + '</div>\
</div>\
\
<div class="vc-report-price-block">\
  <div class="vc-report-price-label">Estimated Price Band</div>\
  <div class="vc-report-price-range">' + formatCrore(v.totalMin) + ' <span>–</span> ' + formatCrore(v.totalMax) + '</div>\
  <div style="margin-top:6px"><span class="vc-report-price-mid">📊 Mid Estimate: ' + formatCrore(v.totalMid) + '</span></div>\
  <div class="vc-report-meter">\
    <div class="vc-report-meter-track"><div class="vc-report-meter-fill" id="vc-meter-fill" style="width:0%"></div></div>\
    <div class="vc-report-meter-labels"><span>Budget</span><span>Mid</span><span>Premium</span></div>\
  </div>\
</div>\
\
<div class="vc-report-stats">\
  <div class="vc-report-stat">\
    <div class="vc-report-stat-label">Rate per Sq Ft</div>\
    <div class="vc-report-stat-value teal">₹' + v.minRate.toLocaleString('en-IN') + ' – ₹' + v.maxRate.toLocaleString('en-IN') + '</div>\
  </div>\
  <div class="vc-report-stat">\
    <div class="vc-report-stat-label">Plot / Built-up Area</div>\
    <div class="vc-report-stat-value">' + parseInt(data.area).toLocaleString('en-IN') + ' sq ft</div>\
  </div>\
  <div class="vc-report-stat">\
    <div class="vc-report-stat-label">Avg Rate</div>\
    <div class="vc-report-stat-value orange">₹' + v.midRate.toLocaleString('en-IN') + '/sqft</div>\
  </div>\
  <div class="vc-report-stat">\
    <div class="vc-report-stat-label">Data Quality</div>\
    <div class="vc-report-stat-value">' + (loc.segment === 'Premium' || loc.segment === 'Upper Mid' ? '🟢 High' : '🟡 Moderate') + '</div>\
  </div>\
</div>\
\
<div class="vc-report-segment">\
  <div class="vc-report-segment-dot" style="background:' + segColor + ';box-shadow:0 0 0 3px ' + segColor + '22"></div>\
  <div class="vc-report-segment-info">\
    <div class="vc-report-segment-name">' + escHtml(loc.name) + '</div>\
    <div class="vc-report-segment-desc">' + loc.price + '</div>\
  </div>\
  <span class="vc-report-segment-tag" style="background:' + segBg + ';color:' + segColor + ';border:1px solid ' + segColor + '33">' + loc.segment + '</span>\
</div>\
\
<div class="vc-report-note">\
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>\
  This is a data-based estimate, not a certified appraisal. Actual price depends on property condition, negotiation, floor, and current market timing.\
</div>\
\
<div class="vc-report-actions">\
  <button class="vc-btn vc-btn-primary" onclick="ValuationComponent.close()">\
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>\
    Done\
  </button>\
  <button class="vc-btn-outline" onclick="ValuationComponent.resetForm()">\
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4"/></svg>\
    Estimate Another Property\
  </button>\
</div>';

        document.getElementById('vc-report-content').innerHTML = html;

        // Hide all steps, show report
        document.querySelectorAll('.vc-step').forEach(function(s) { s.classList.remove('vc-active'); });
        document.getElementById('vc-step-report').classList.add('vc-active');

        // Animate meter bar after paint
        setTimeout(function() {
            var fill = document.getElementById('vc-meter-fill');
            if (fill) fill.style.width = meterPct + '%';
        }, 100);
    }

    // ── Reset ──────────────────────────────────────────────────
    function resetForm() {
        selectedType = null;
        features = [];
        // Clear all inputs
        ['vc-address','vc-area','vc-phone'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });
        ['vc-face','vc-rooms','vc-floor','vc-year'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });
        document.querySelectorAll('.vc-type-card').forEach(function(c) { c.classList.remove('vc-selected'); });
        document.querySelectorAll('.vc-tag').forEach(function(t) { t.classList.remove('vc-tag-active'); });
        document.getElementById('vc-house-fields').style.display = 'none';
        // Reset loader steps
        [1,2,3,4].forEach(function(i) {
            var el = document.getElementById('vcls-' + i);
            if (!el) return;
            el.classList.remove('active','done');
            var icons = ['📍','📊','🏠','✨'];
            el.querySelector('.vc-ai-step-icon').textContent = icons[i-1];
        });
        var bar = document.getElementById('vc-loader-bar');
        if (bar) bar.style.width = '0%';
        // Show progress header
        var ph = document.getElementById('vc-progress-header');
        if (ph) ph.style.display = '';
        goToStep(1);
    }

    // ── Data logging ────────────────────────────────────────────
    function logSubmission(data) {
        // 1. Console log (always)
        console.log('📋 DSD Valuation Submission:', data);

        // 2. localStorage log (persists across sessions)
        try {
            var logs = JSON.parse(localStorage.getItem('dsd_valuation_logs') || '[]');
            logs.push(data);
            // Keep last 100 entries
            if (logs.length > 100) logs = logs.slice(-100);
            localStorage.setItem('dsd_valuation_logs', JSON.stringify(logs));
            console.log('✅ Saved to localStorage. Total logs:', logs.length);
        } catch(e) { console.warn('localStorage error:', e); }

        // 3. Send to your Laravel backend
        // Uncomment and set your route when ready:
        /*
        fetch('/api/valuation-log', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify(data)
        }).then(function(r) { return r.json(); }).then(function(d) { console.log('✅ Server log saved', d); }).catch(function(e) { console.error('Server log failed', e); });
        */
    }

    // ── Helpers ─────────────────────────────────────────────────
    function escHtml(str) {
        return (str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
    function capFirst(str) {
        return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    }

    return { open, close, goToStep, validateStep, validatePhone, selectType, toggleFeature, submit, resetForm };

})();


// ── Google Places Autocomplete ─────────────────────────────────
(function () {
    var _autocomplete = null;

    function initPlacesAutocomplete() {
        if (_autocomplete) return;
        if (!window.google || !google.maps || !google.maps.places) {
            setTimeout(initPlacesAutocomplete, 400);
            return;
        }
        var input = document.getElementById('vc-address');
        if (!input) return;

        _autocomplete = new google.maps.places.Autocomplete(input, {
            bounds: new google.maps.LatLngBounds(
                new google.maps.LatLng(26.70, 80.80),
                new google.maps.LatLng(27.05, 81.12)
            ),
            strictBounds: false,
            componentRestrictions: { country: 'in' },
            fields: ['formatted_address', 'name'],
            types: ['geocode', 'establishment']
        });

        _autocomplete.addListener('place_changed', function () {
            var place = _autocomplete.getPlace();
            if (place && place.formatted_address) input.value = place.formatted_address;
            else if (place && place.name) input.value = place.name;
            ValuationComponent.validateStep(1);
        });

        console.log('✅ Places Autocomplete ready');
    }

    window._initPlacesAutocomplete = initPlacesAutocomplete;

    window.addEventListener('load', function () {
        var _orig = window.pmInitMap;
        window.pmInitMap = function () {
            if (typeof _orig === 'function') _orig.apply(this, arguments);
            initPlacesAutocomplete();
        };
        if (window.google && window.google.maps && window.google.maps.places) {
            initPlacesAutocomplete();
        }
    });
})();
</script>