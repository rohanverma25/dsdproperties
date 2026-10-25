<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Data Management</title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css" rel="stylesheet">

    <style>
        body { background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); margin-bottom: 1.5rem; }
        .card-header { background-color: #fff; border-bottom: 1px solid #e2e8f0; font-weight: 600; }
        .chart-container { position: relative; height: 300px; width: 100%; }
        .filter-label { font-size: 0.85rem; font-weight: 600; color: #64748b; margin-bottom: 0.25rem; }
        /* Select2 Tweaks */
        .select2-container .select2-selection--single { height: 38px !important; border: 1px solid #ced4da; }
        .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px !important; }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px !important; }
    </style>
</head>
<body class="p-3">

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary fw-bold">Analytics Dashboard</h3>
        <div>
            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-sm">
                Total Filtered: <span id="filtered_count_display" class="fw-bold text-primary">0</span>
            </span>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body bg-white rounded">
            <div class="row g-3">
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">Country (IN/US)</label>
                    <select id="filter_country" class="form-select select2">
                        <option value="">All Countries</option>
                        @foreach($countries as $country) <option value="{{ $country }}">{{ $country }}</option> @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">State (India Only)</label>
                    <select id="filter_region" class="form-select select2">
                        <option value="">All States</option>
                        @foreach($regions as $region) <option value="{{ $region }}">{{ $region }}</option> @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">City (Famous + UP)</label>
                    <select id="filter_city" class="form-select select2">
                        <option value="">All Cities</option>
                        @foreach($cities as $city) <option value="{{ $city }}">{{ $city }}</option> @endforeach
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">Date Range</label>
                    <select id="filter_date" class="form-select select2">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="last_week">Last Week</option>
                        <option value="last_month">Last Month</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Lead Trends</span>
                    <div class="btn-group btn-group-sm" role="group">
                        <input type="radio" class="btn-check" name="chart_view" id="view_day" value="day" checked>
                        <label class="btn btn-outline-primary" for="view_day">Daily</label>

                        <input type="radio" class="btn-check" name="chart_view" id="view_month" value="month">
                        <label class="btn btn-outline-primary" for="view_month">Monthly</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">Top Countries</div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="countryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Detailed Lead Data</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="locations_table" class="table table-hover table-bordered nowrap w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>IP Address</th>
                            <th>Page URL</th> <th>City</th>
                            <th>Region</th>
                            <th>Country</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Date-wise Summary (Sortable by Date & Count)</div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="summary_table" class="table table-striped table-bordered w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Total Leads</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── URL Traffic Heatmap ── --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="fw-bold">📊 Page URL Daily Traffic</span>
            <div class="d-flex align-items-center gap-2">
                <select id="heatmap_days" class="form-select form-select-sm" style="width:auto;">
                    <option value="7">Last 7 days</option>
                    <option value="14">Last 14 days</option>
                    <option value="30" selected>Last 30 days</option>
                    <option value="60">Last 60 days</option>
                    <option value="90">Last 90 days</option>
                </select>
                <button id="reload_heatmap" class="btn btn-sm btn-outline-primary">↻ Refresh</button>
                <span class="badge bg-secondary" id="heatmap_url_count"></span>
            </div>
        </div>
        <div class="card-body p-0">
            <div id="heatmap_loading" class="text-center py-4 text-muted">Loading heatmap…</div>
            <div id="heatmap_container" style="overflow-x:auto;display:none;max-height:600px;overflow-y:auto;">
                <table id="heatmap_table" class="table table-bordered table-sm mb-0" style="font-size:12px;border-collapse:separate;border-spacing:0;"></table>
            </div>
            <div class="px-3 py-2 border-top" style="font-size:11px;color:#94a3b8;">
                ↑ going up (last 7d vs prev 7d) &nbsp;·&nbsp; ↓ going down &nbsp;·&nbsp; – no change &nbsp;·&nbsp; cells coloured by visit intensity
            </div>
        </div>
    </div>

    <div>
        <h3>Valuation Leads</h3>
        <p>Total Valuation Leads: <b>{{ $valuation_leads->count() }}</b></p>
       <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Whatsapp</th>
            <th>Address</th>
            <th>Locality</th>
            <th>Type</th>
            <th>Area</th>
            <th>BHK</th>
            <th>Floor</th>
            <th>Year</th>
            <th>Min Price</th>
            <th>Max Price</th>
            <th>Mid Price</th>
            <th>Device</th>
            <th>Source</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($valuation_leads as $lead)
        @php
            $data = $lead->form_data ?? [];
            $valuation = $data['valuation'] ?? [];

            // Detect device
            $ua = $data['ua'] ?? '';
            $device = 'Desktop';
            if(stripos($ua, 'mobile') !== false) $device = 'Mobile';
            if(stripos($ua, 'iphone') !== false) $device = 'iPhone';

            // Extract source page
            $source = $data['page_url'] ?? '';
            
            // Highlight premium leads
            $isPremium = ($valuation['midTotal'] ?? 0) > 5000000;
        @endphp

        <tr style="{{ $isPremium ? 'background:#e6ffed;' : '' }}">
            <td>{{ $lead->id }}</td>

            <!-- WhatsApp Click -->
            <td>
                @if(!empty($lead->whatsapp_no))
                    @php
                        $message = "Hi 👋\n\n*Dheer this side from DSD Properties.*\n\nThanks for using our AI price estimation tool.\n\nCould you share your quick *feedback*? It helps us improve accuracy 🙏\n\nAlso, are you planning to *buy or sell property in Lucknow* right now?\n\nI can guide you with best options 👍";
                    @endphp

                    <a href="https://wa.me/{{ $lead->whatsapp_no }}?text={{ urlencode($message) }}" target="_blank">
                        {{ $lead->whatsapp_no }}
                    </a>
                @else
                    -
                @endif
            </td>

            <td>{{ $data['address'] ?? '-' }}</td>
            <td>{{ $valuation['localityName'] ?? '-' }}</td>
            <td>{{ ucfirst($data['type'] ?? '-') }}</td>
            <td>{{ $data['area'] ?? '-' }} sqft</td>

            <td>{{ $data['bhk'] ?? '-' }}</td>
            <td>{{ $data['flatFloor'] ?? ($data['floor'] ?? '-') }}</td>
            <td>{{ $data['flatYear'] ?? ($data['year'] ?? '-') }}</td>

         <td>
    ₹{{ ($valuation['minTotal'] ?? 0) >= 10000000 
        ? round($valuation['minTotal'] / 10000000, 2) . ' Cr' 
        : (($valuation['minTotal'] ?? 0) >= 100000 
            ? round($valuation['minTotal'] / 100000, 2) . ' Lakh' 
            : number_format($valuation['minTotal'] ?? 0)
        ) 
    }}
    <small style="color:#666;">
        (₹{{ preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", substr(($valuation['minTotal'] ?? 0), 0, -3)) . ',' . substr(($valuation['minTotal'] ?? 0), -3) }})
    </small>
</td>

<td>
    ₹{{ ($valuation['maxTotal'] ?? 0) >= 10000000 
        ? round($valuation['maxTotal'] / 10000000, 2) . ' Cr' 
        : (($valuation['maxTotal'] ?? 0) >= 100000 
            ? round($valuation['maxTotal'] / 100000, 2) . ' Lakh' 
            : number_format($valuation['maxTotal'] ?? 0)
        ) 
    }}
    <small style="color:#666;">
        (₹{{ preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", substr(($valuation['maxTotal'] ?? 0), 0, -3)) . ',' . substr(($valuation['maxTotal'] ?? 0), -3) }})
    </small>
</td>

<td>
    <strong>
        ₹{{ ($valuation['midTotal'] ?? 0) >= 10000000 
            ? round($valuation['midTotal'] / 10000000, 2) . ' Cr' 
            : (($valuation['midTotal'] ?? 0) >= 100000 
                ? round($valuation['midTotal'] / 100000, 2) . ' Lakh' 
                : number_format($valuation['midTotal'] ?? 0)
            ) 
        }}
        <small style="color:#666;">
            (₹{{ preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", substr(($valuation['midTotal'] ?? 0), 0, -3)) . ',' . substr(($valuation['midTotal'] ?? 0), -3) }})
        </small>
    </strong>
</td>

            <!-- Device -->
            <td>{{ $device }}</td>

            <!-- Source Page -->
            <td>
                @if(!empty($source))
                    <a href="{{ $source }}" target="_blank">View</a>
                @else
                    -
                @endif
            </td>

            <td>{{ $lead->created_at->format('d M Y, h:i A') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    
    // 1. Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // 2. Main DataTable Configuration
    var table = $('#locations_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('locations.data') }}",
            data: function (d) {
                d.country = $('#filter_country').val();
                d.region = $('#filter_region').val();
                d.city = $('#filter_city').val();
                d.date_range = $('#filter_date').val();
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'ip', name: 'ip'},
            {data: 'page', name: 'page'}, // Sorting works automatically
            {data: 'city', name: 'city'},
            {data: 'region', name: 'region'},
            {data: 'country', name: 'country'},
            {data: 'created_at', name: 'created_at'},
        ],
        dom: "<'row mb-2'<'col-md-6'l><'col-md-6 text-end'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        buttons: [
            { extend: 'csv', className: 'btn btn-sm btn-outline-secondary' },
            { extend: 'excel', className: 'btn btn-sm btn-outline-secondary' },
            { extend: 'pdf', className: 'btn btn-sm btn-outline-secondary' }
        ],
        lengthMenu: [[10, 50, 100, 500, -1], [10, 50, 100, 500, "All"]],
        pageLength: 10,
        order: [[6, 'desc']], // Default sort by Date
        drawCallback: function(settings) {
            // Update Filtered Count Badge
            $('#filtered_count_display').text(settings.json.recordsFiltered);
        }
    });

    // 3. Date-wise Summary Table (Client-side sorting/paging is sufficient for daily rows)
    var summaryTable = $('#summary_table').DataTable({
        ajax: {
            url: "{{ route('locations.summary') }}",
            data: function (d) {
                // Pass filters to summary table as well
                d.country = $('#filter_country').val();
                d.region = $('#filter_region').val();
                d.city = $('#filter_city').val();
                d.date_range = $('#filter_date').val();
            }
        },
        columns: [
            { data: 'date' },
            { data: 'total_leads' }
        ],
        order: [[0, 'desc']], // Sort by Date by default
        dom: 'tp' // Only Table and Pagination
    });

    // 4. Filter Event Listeners (Triggers both tables and charts)
    $('.select2').on('change', function() {
        table.draw();        // Reload Main Table
        summaryTable.ajax.reload(); // Reload Summary Table
        loadCharts();        // Reload Charts
    });

    // 5. Charts Configuration
    var trendCtx = document.getElementById('trendChart').getContext('2d');
    var countryCtx = document.getElementById('countryChart').getContext('2d');
    var trendChart, countryChart;

    function loadCharts() {
        var viewMode = $('input[name="chart_view"]:checked').val(); // day or month

        $.ajax({
            url: "{{ route('locations.charts') }}",
            method: 'GET',
            data: {
                country: $('#filter_country').val(),
                region: $('#filter_region').val(),
                city: $('#filter_city').val(),
                date_range: $('#filter_date').val(),
                group_by: viewMode
            },
            success: function(response) {
                // --- Trend Chart ---
                var labels = response.time_data.map(item => item.date);
                var counts = response.time_data.map(item => item.count);
                
                if(trendChart) trendChart.destroy();
                trendChart = new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Leads',
                            data: counts,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });

                // --- Country Chart ---
                var cLabels = response.countries.map(item => item.country);
                var cCounts = response.countries.map(item => item.total);

                if(countryChart) countryChart.destroy();
                countryChart = new Chart(countryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: cLabels,
                        datasets: [{
                            data: cCounts,
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
                        }]
                    },
                    options: { maintainAspectRatio: false }
                });
            }
        });
    }

    // Chart Granularity Toggle Event
    $('input[name="chart_view"]').change(function(){
        loadCharts();
    });

    // Initial Load
    loadCharts();

    // ── URL Heatmap ──
    function heatColor(val, max) {
        if (val === 0) return { bg: '#f8fafc', fg: '#cbd5e1' };
        var r = val / max;
        if (r < 0.10) return { bg: '#dcfce7', fg: '#374151' };
        if (r < 0.25) return { bg: '#86efac', fg: '#374151' };
        if (r < 0.45) return { bg: '#4ade80', fg: '#fff' };
        if (r < 0.70) return { bg: '#22c55e', fg: '#fff' };
        return { bg: '#15803d', fg: '#fff' };
    }

    function buildHeatmap(rows, days) {
        // Build date list (oldest → newest)
        var dates = [];
        var now = new Date();
        for (var i = days - 1; i >= 0; i--) {
            var d = new Date(now);
            d.setDate(d.getDate() - i);
            dates.push(d.toISOString().split('T')[0]);
        }

        // Build url → date → count map
        var urlMap = {};
        rows.forEach(function(r) {
            if (!urlMap[r.page]) urlMap[r.page] = {};
            urlMap[r.page][r.date] = parseInt(r.visits);
        });

        // Sort URLs by total desc
        var urlList = Object.keys(urlMap).sort(function(a, b) {
            var sa = dates.reduce(function(s,d){ return s+(urlMap[a][d]||0); }, 0);
            var sb = dates.reduce(function(s,d){ return s+(urlMap[b][d]||0); }, 0);
            return sb - sa;
        });

        $('#heatmap_url_count').text(urlList.length + ' URLs');

        // Max value for colour scale
        var maxVal = 1;
        rows.forEach(function(r){ if (parseInt(r.visits) > maxVal) maxVal = parseInt(r.visits); });

        var stickyTh = 'position:sticky;top:0;z-index:12;background:#f1f5f9;white-space:nowrap;padding:6px 8px;';
        var stickyUrl = 'position:sticky;top:0;left:0;z-index:13;background:#f1f5f9;min-width:230px;padding:6px 8px;';
        var stickyTot = 'position:sticky;top:0;right:0;z-index:12;background:#e2e8f0;padding:6px 8px;text-align:center;';

        // Header
        var html = '<thead><tr>';
        html += '<th style="' + stickyUrl + '">Page URL</th>';
        dates.forEach(function(d) {
            var p = d.split('-');
            html += '<th style="' + stickyTh + 'min-width:44px;text-align:center;">' + p[2] + '/' + p[1] + '</th>';
        });
        html += '<th style="' + stickyTot + 'min-width:55px;">Total</th>';
        html += '</tr></thead><tbody>';

        var dateTotals = {};
        dates.forEach(function(d){ dateTotals[d] = 0; });
        var grandTotal = 0;

        urlList.forEach(function(url) {
            var urlTotal = dates.reduce(function(s,d){ return s+(urlMap[url][d]||0); },0);
            grandTotal += urlTotal;

            // Trend: last 7d vs prev 7d
            var last7 = 0, prev7 = 0, half = Math.min(7, Math.floor(days/2));
            for (var i = dates.length - half; i < dates.length; i++) last7 += (urlMap[url][dates[i]]||0);
            for (var i = Math.max(0, dates.length - half*2); i < dates.length - half; i++) prev7 += (urlMap[url][dates[i]]||0);
            var trendSym, trendClr;
            if      (last7 > prev7) { trendSym = '↑'; trendClr = '#16a34a'; }
            else if (last7 < prev7) { trendSym = '↓'; trendClr = '#dc2626'; }
            else                    { trendSym = '–'; trendClr = '#94a3b8'; }

            var disp = url.length > 55 ? url.substring(0,52)+'…' : url;

            html += '<tr>';
            html += '<td style="position:sticky;left:0;z-index:5;background:#fff;white-space:nowrap;padding:5px 8px;" title="'+url+'">';
            html += '<span style="font-weight:700;color:'+trendClr+';margin-right:5px;">'+trendSym+'</span>';
            html += '<a href="'+url+'" target="_blank" style="color:#1e293b;text-decoration:none;font-size:11.5px;">'+disp+'</a>';
            html += '</td>';

            dates.forEach(function(d) {
                var cnt = urlMap[url][d] || 0;
                dateTotals[d] += cnt;
                var c = heatColor(cnt, maxVal);
                html += '<td style="text-align:center;background:'+c.bg+';color:'+c.fg+';padding:4px 2px;">'+(cnt||'')+'</td>';
            });

            html += '<td style="text-align:center;font-weight:700;background:#e2e8f0;position:sticky;right:0;">'+urlTotal+'</td>';
            html += '</tr>';
        });

        // Footer totals row
        html += '</tbody><tfoot><tr style="background:#e2e8f0;font-weight:700;">';
        html += '<td style="position:sticky;left:0;background:#e2e8f0;padding:5px 8px;">Daily Total</td>';
        dates.forEach(function(d){
            html += '<td style="text-align:center;padding:4px 2px;">'+(dateTotals[d]||'')+'</td>';
        });
        html += '<td style="text-align:center;position:sticky;right:0;background:#cbd5e1;">'+grandTotal+'</td>';
        html += '</tr></tfoot>';

        $('#heatmap_table').html(html);
        $('#heatmap_loading').hide();
        $('#heatmap_container').show();
    }

    function loadHeatmap() {
        var days = parseInt($('#heatmap_days').val());
        $('#heatmap_loading').show().text('Loading…');
        $('#heatmap_container').hide();
        $('#heatmap_url_count').text('');
        $.getJSON('{{ route('locations.url-stats') }}', { days: days }, function(rows) {
            buildHeatmap(rows, days);
        }).fail(function(xhr){ $('#heatmap_loading').text('Error loading data. Status: ' + xhr.status); });
    }

    $('#reload_heatmap, #heatmap_days').on('click change', function(e){
        if (e.type === 'click' && this.id !== 'reload_heatmap') return;
        loadHeatmap();
    });

    loadHeatmap();
});
</script>
</body>
</html>