@extends('layouts.app')

@section('title', 'Report Verification — ' . ($report->report_id ?? $reportId) . ' | DSD Properties')

@section('content')
<style>
.ver-wrap{max-width:720px;margin:40px auto;padding:0 20px 60px}
.ver-card{background:#fff;border-radius:16px;border:1px solid #e2e8f0;box-shadow:0 4px 20px rgba(1,31,75,.08);overflow:hidden}
.ver-header{background:#011f4b;color:#fff;padding:22px 28px}
.ver-header-logo{font-size:1.1rem;font-weight:800;margin-bottom:4px}
.ver-header-logo span{color:#FF5C00}
.ver-header-sub{font-size:.78rem;color:rgba(255,255,255,.65)}
.ver-body{padding:28px}
.ver-id{font-size:1rem;font-weight:800;color:#011f4b;margin-bottom:4px}
.ver-status-row{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:20px}
.ver-status-pill{display:inline-block;padding:4px 14px;border-radius:99px;font-size:.78rem;font-weight:700}
.vs-green{background:#d1fae5;color:#065f46}
.vs-amber{background:#fef3c7;color:#92400e}
.vs-red{background:#fee2e2;color:#991b1b}
.ver-verdict-box{border-radius:12px;padding:18px 22px;margin-bottom:20px;text-align:center}
.vvb-green{background:#d1fae5;border:2px solid #10b981}
.vvb-amber{background:#fef3c7;border:2px solid #f59e0b}
.vvb-red{background:#fee2e2;border:2px solid #ef4444}
.vvb-emoji{font-size:2rem}
.vvb-title{font-size:1.1rem;font-weight:800;margin-top:8px}
.vvb-green .vvb-title{color:#065f46}
.vvb-amber .vvb-title{color:#92400e}
.vvb-red .vvb-title{color:#991b1b}
.vvb-summary{font-size:.88rem;color:#374151;margin-top:10px;line-height:1.7}
.ver-info-table{width:100%;border-collapse:collapse;margin-bottom:20px}
.ver-info-table td{padding:8px 12px;border:1px solid #f1f5f9;font-size:.86rem}
.ver-info-table .lbl{background:#f8fafc;font-weight:700;color:#64748b;width:40%;font-size:.78rem}
.matrix-mini{width:100%;border-collapse:collapse;margin-bottom:20px}
.matrix-mini th{background:#f8fafc;font-size:.72rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;padding:8px 12px;text-align:left;border-bottom:1px solid #e2e8f0}
.matrix-mini td{padding:8px 12px;font-size:.82rem;border-bottom:1px solid #f1f5f9}
.sc{display:inline-block;padding:2px 10px;border-radius:99px;font-size:.72rem;font-weight:700}
.sc-clear{background:#d1fae5;color:#065f46}
.sc-note{background:#fef3c7;color:#92400e}
.sc-issue{background:#fee2e2;color:#991b1b}
.sc-na{background:#f3f4f6;color:#6b7280}
.not-found-box{text-align:center;padding:50px 20px}
.not-found-icon{font-size:3rem;margin-bottom:12px}
.not-found-title{font-size:1.1rem;font-weight:700;color:#011f4b;margin-bottom:8px}
.not-found-sub{font-size:.85rem;color:#64748b}
.ver-footer{background:#f8fafc;border-top:1px solid #f1f5f9;padding:14px 28px;text-align:center;font-size:.75rem;color:#94a3b8}
.section-label{font-size:.72rem;font-weight:700;color:#FF5C00;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;margin-top:20px}
.divider{border:none;border-top:1px solid #f1f5f9;margin:16px 0}
</style>

<div class="ver-wrap">
    <div class="ver-card">

        <div class="ver-header">
            <div class="ver-header-logo">DSD <span>Properties</span></div>
            <div class="ver-header-sub">संपत्ति सत्यापन रिपोर्ट — प्रामाणिकता जांच</div>
        </div>

        <div class="ver-body">

            @if($report)

            <div class="ver-id">{{ $report->report_id }}</div>
            <div class="ver-status-row">
                @php
                    $vbClass  = ['green'=>'vvb-green','amber'=>'vvb-amber','red'=>'vvb-red'][$report->verdict] ?? 'vvb-amber';
                    $scClass  = ['green'=>'vs-green','amber'=>'vs-amber','red'=>'vs-red'][$report->verdict] ?? 'vs-amber';
                    $vEmoji   = ['green'=>'✅','amber'=>'⚠️','red'=>'❌'][$report->verdict] ?? '⚠️';
                    $vTitle   = ['green'=>'सुरक्षित — आगे बढ़ें','amber'=>'सावधानी — शर्तों के साथ','red'=>'न खरीदें'][$report->verdict] ?? '';
                @endphp
                <span class="ver-status-pill {{ $scClass }}">{{ $vEmoji }} {{ $vTitle }}</span>
                <span style="font-size:.78rem;color:#64748b">वितरित: {{ optional($report->delivered_at)->format('d M Y') ?? '—' }}</span>
            </div>

            {{-- Verdict box --}}
            <div class="ver-verdict-box {{ $vbClass }}">
                <div class="vvb-emoji">{{ $vEmoji }}</div>
                <div class="vvb-title">{{ $vTitle }}</div>
                <div class="vvb-summary">{{ $report->verdict_summary_hindi }}</div>
            </div>

            {{-- Property info --}}
            <div class="section-label">संपत्ति विवरण</div>
            <table class="ver-info-table">
                <tr><td class="lbl">पता</td><td>{{ $report->property_address }}</td></tr>
                <tr><td class="lbl">खसरा / गाटा</td><td>{{ $report->property_khasra ?? '—' }} / {{ $report->property_gata ?? '—' }}</td></tr>
                <tr><td class="lbl">क्षेत्रफल</td><td>{{ $report->property_area }}</td></tr>
                <tr><td class="lbl">विक्रेता</td><td>{{ $report->seller_name }}</td></tr>
                <tr><td class="lbl">तहसील</td><td>{{ $report->tehsil }}</td></tr>
                <tr><td class="lbl">सत्यापनकर्ता</td><td>{{ $report->verifier_name ?? 'DSD Properties' }}</td></tr>
                <tr><td class="lbl">जाँच तारीख</td><td>{{ optional($report->verifier_visit_date)->format('d M Y') ?? '—' }}</td></tr>
            </table>

            {{-- Summary matrix --}}
            <div class="section-label">जांच सारांश</div>
            <table class="matrix-mini">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>जांच</th>
                        <th>स्थिति</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checks as $check)
                    @php $f = $findings->get($check['slug']); @endphp
                    <tr>
                        <td style="color:#94a3b8;font-size:.78rem">{{ $check['order'] }}</td>
                        <td>
                            <div style="font-weight:600">{{ $check['hindi_label'] }}</div>
                            <div style="font-size:.72rem;color:#94a3b8">{{ $check['english_label'] }}</div>
                        </td>
                        <td>
                            @if($f)
                            @php $chipClass = ['clear'=>'sc-clear','note'=>'sc-note','issue'=>'sc-issue','not_applicable'=>'sc-na'][$f->status] ?? 'sc-na'; @endphp
                            <span class="sc {{ $chipClass }}">{{ $f->status_icon }} {{ $f->status_label_hindi }}</span>
                            @else
                            <span class="sc sc-na">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="divider"></div>
            <div style="text-align:center;font-size:.78rem;color:#64748b;line-height:1.7">
                यह रिपोर्ट DSD Properties द्वारा तैयार की गई है।<br>
                यह केवल सूचनात्मक उद्देश्यों के लिए है और कानूनी परामर्श नहीं है।
            </div>

            @else

            <div class="not-found-box">
                <div class="not-found-icon">🔍</div>
                <div class="not-found-title">रिपोर्ट नहीं मिली</div>
                <div class="not-found-sub">
                    रिपोर्ट ID <strong>{{ $reportId }}</strong> के लिए कोई सत्यापित रिपोर्ट नहीं मिली।<br><br>
                    सुनिश्चित करें कि आपने सही रिपोर्ट ID दर्ज की है।<br>
                    सहायता के लिए: <strong>9695602948</strong>
                </div>
            </div>

            @endif

        </div>

        <div class="ver-footer">
            DSD Properties · dsdproperties.in · Lucknow, Uttar Pradesh · 9695602948
        </div>
    </div>

    <div style="text-align:center;margin-top:20px;font-size:.78rem;color:#94a3b8">
        <a href="/" style="color:#008080;text-decoration:none">← DSD Properties होमपेज</a>
    </div>
</div>
@endsection
