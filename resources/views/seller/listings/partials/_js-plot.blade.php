{{-- Plot-segment table for site / colony listings. Expects: $draftData --}}
@php $draftData = $draftData ?? []; @endphp
<script>
// ─── Plot Segments ───
var plotSegments = [];

function addPlotSegment() {
    plotSegments.push({ label: '', area: '', price: '' });
    renderPlotSegments();
}

function removePlotSegment(i) {
    plotSegments.splice(i, 1);
    renderPlotSegments();
}

function renderPlotSegments() {
    var tbody = document.getElementById('plotSegBody');
    var empty = document.getElementById('plotSegEmpty');
    if (!tbody) return;
    var unit = (document.querySelector('[name=plot_area_unit]') || {}).value || 'sqyard';
    // Remove existing dynamic rows
    Array.from(tbody.querySelectorAll('tr.seg-row')).forEach(function(r){ r.remove(); });

    if (plotSegments.length === 0) {
        if (empty) empty.style.display = '';
        syncPlotHidden();
        return;
    }
    if (empty) empty.style.display = 'none';

    plotSegments.forEach(function(seg, i) {
        var tr = document.createElement('tr');
        tr.className = 'seg-row';
        tr.innerHTML =
            '<td><input type="text" placeholder="e.g. Type A — 100 sq.yd" value="' + escHtml(seg.label) + '" oninput="plotSegments[' + i + '].label=this.value;syncPlotHidden()"></td>' +
            '<td><div style="display:flex;gap:5px;align-items:center;">' +
                '<input type="number" placeholder="Area" value="' + escHtml(seg.area) + '" min="0" step="0.01" style="flex:1;" oninput="plotSegments[' + i + '].area=this.value;syncPlotHidden()">' +
                '<span style="font-size:12px;color:#64748b;white-space:nowrap;">' + escHtml(unit) + '</span>' +
            '</div></td>' +
            '<td><input type="number" placeholder="Optional" value="' + escHtml(seg.price) + '" min="0" oninput="plotSegments[' + i + '].price=this.value;syncPlotHidden()"></td>' +
            '<td style="text-align:center;"><button type="button" class="btn-del-seg" onclick="removePlotSegment(' + i + ')">×</button></td>';
        tbody.appendChild(tr);
    });
    syncPlotHidden();
}

function escHtml(s) {
    return String(s || '').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function syncPlotHidden() {
    var data = {
        min_area:    (document.getElementById('minPlotArea') || {}).value || '',
        max_area:    (document.getElementById('maxPlotArea') || {}).value || '',
        total_plots: (document.getElementById('totalPlots')  || {}).value || '',
        unit:        ((document.querySelector('[name=plot_area_unit]') || {}).value) || 'sqyard',
        segments:    plotSegments.filter(function(s){ return s.label || s.area; }),
    };
    var h = document.getElementById('plotSegmentsHidden');
    if (h) h.value = JSON.stringify(data);
}

@if(old('plot_segments') || (($draftData['plot_segments'] ?? null)))
try {
    var _psOld = JSON.parse({{ json_encode(old('plot_segments', $draftData['plot_segments'] ?? '')) }});
    if (_psOld && Array.isArray(_psOld.segments)) {
        plotSegments = _psOld.segments;
        document.addEventListener('DOMContentLoaded', function(){ renderPlotSegments(); });
    }
} catch(e) {}
@endif

</script>
