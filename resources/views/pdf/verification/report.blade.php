<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<style>
@font-face {
    font-family: 'NotoDevanagari';
    src: url("{{ public_path('fonts/NotoSansDevanagari-Regular.ttf') }}") format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'NotoDevanagari';
    src: url("{{ public_path('fonts/NotoSansDevanagari-Bold.ttf') }}") format('truetype');
    font-weight: bold;
    font-style: normal;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'NotoDevanagari', 'Segoe UI', sans-serif;
    font-size: 10pt;
    color: #1e293b;
    background: #fff;
    line-height: 1.55;
}

/* ── Layout ─────────────────────────────── */
.page { padding: 20mm 18mm; }

/* ── Cover ──────────────────────────────── */
.cover-header {
    background: #011f4b;
    color: #fff;
    padding: 18px 22px 14px;
    border-radius: 8px 8px 0 0;
    margin-bottom: 0;
}
.cover-logo-row { display: table; width: 100%; margin-bottom: 10px; }
.cover-logo-cell { display: table-cell; vertical-align: middle; }
.cover-logo-text { font-size: 16pt; font-weight: bold; color: #fff; }
.cover-logo-text span { color: #FF5C00; }
.cover-logo-sub { font-size: 7.5pt; color: rgba(255,255,255,.65); margin-top: 2px; }
.cover-report-id { display: table-cell; text-align: right; vertical-align: middle; }
.cover-report-id-text { font-size: 12pt; font-weight: bold; color: #fff; }
.cover-report-id-sub { font-size: 7.5pt; color: rgba(255,255,255,.6); }

.cover-title-band {
    background: #FF5C00;
    color: #fff;
    padding: 10px 22px;
    font-size: 12pt;
    font-weight: bold;
    letter-spacing: .3px;
}

.cover-body {
    border: 2px solid #011f4b;
    border-top: none;
    padding: 18px 22px;
    border-radius: 0 0 8px 8px;
}

.cover-grid { display: table; width: 100%; }
.cover-col { display: table-cell; width: 50%; vertical-align: top; padding-right: 14px; }
.cover-col:last-child { padding-right: 0; }

.cover-field { margin-bottom: 10px; }
.cover-label { font-size: 7pt; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.cover-value { font-size: 9.5pt; font-weight: bold; color: #1e293b; }
.cover-value-small { font-size: 8.5pt; color: #374151; }

.verdict-box {
    margin-top: 16px;
    padding: 12px 16px;
    border-radius: 8px;
    text-align: center;
}
.vb-green { background: #d1fae5; border: 2px solid #10b981; }
.vb-amber { background: #fef3c7; border: 2px solid #f59e0b; }
.vb-red   { background: #fee2e2; border: 2px solid #ef4444; }

.verdict-emoji { font-size: 18pt; }
.verdict-title { font-size: 11pt; font-weight: bold; margin-top: 4px; }
.vb-green .verdict-title { color: #065f46; }
.vb-amber .verdict-title { color: #92400e; }
.vb-red   .verdict-title { color: #991b1b; }
.verdict-summary { font-size: 8.5pt; margin-top: 8px; color: #374151; line-height: 1.6; }

/* ── Section headers ─────────────────────── */
.section-break { page-break-before: always; padding-top: 8mm; }
.section-title {
    font-size: 11pt;
    font-weight: bold;
    color: #011f4b;
    border-bottom: 2px solid #FF5C00;
    padding-bottom: 5px;
    margin-bottom: 14px;
}
.section-sub {
    font-size: 8pt;
    color: #64748b;
    margin-top: -10px;
    margin-bottom: 14px;
}

/* ── Property snapshot table ─────────────── */
.info-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
.info-table td { padding: 6px 10px; font-size: 9pt; border: 1px solid #e2e8f0; vertical-align: top; }
.info-table .lbl { background: #f8fafc; font-weight: bold; color: #64748b; width: 38%; font-size: 8pt; }

/* ── Summary matrix ──────────────────────── */
.matrix-table { width: 100%; border-collapse: collapse; }
.matrix-table th { background: #011f4b; color: #fff; padding: 7px 10px; font-size: 8pt; text-align: left; }
.matrix-table td { padding: 7px 10px; font-size: 8.5pt; border: 1px solid #e2e8f0; vertical-align: middle; }
.matrix-table tr:nth-child(even) td { background: #f8fafc; }
.status-chip { display: inline-block; padding: 2px 8px; border-radius: 99px; font-size: 7.5pt; font-weight: bold; }
.sc-clear { background: #d1fae5; color: #065f46; }
.sc-note  { background: #fef3c7; color: #92400e; }
.sc-issue { background: #fee2e2; color: #991b1b; }
.sc-na    { background: #f3f4f6; color: #6b7280; }

/* ── Finding detail card ─────────────────── */
.finding-card {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 14px;
    overflow: hidden;
    page-break-inside: avoid;
}
.finding-header {
    display: table;
    width: 100%;
    padding: 8px 12px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.fh-num { display: table-cell; width: 28px; vertical-align: middle; }
.fh-num-badge {
    width: 22px; height: 22px; border-radius: 50%;
    background: #011f4b; color: #fff;
    font-size: 8pt; font-weight: bold;
    text-align: center; line-height: 22px;
}
.fh-title { display: table-cell; vertical-align: middle; padding-left: 8px; }
.fh-title-main { font-size: 9.5pt; font-weight: bold; color: #1e293b; }
.fh-title-sub  { font-size: 7.5pt; color: #64748b; }
.fh-status { display: table-cell; text-align: right; vertical-align: middle; }

.finding-body { padding: 10px 14px; }
.finding-row { margin-bottom: 8px; }
.finding-row-label { font-size: 7pt; font-weight: bold; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 2px; }
.finding-row-text  { font-size: 9pt; color: #374151; }

.red-flag-box {
    background: #fff5f5;
    border: 1px solid #fca5a5;
    border-radius: 6px;
    padding: 8px 12px;
    margin-top: 8px;
    font-size: 8.5pt;
    color: #991b1b;
}

.ev-ref { display: inline-block; background: #FF5C00; color: #fff; font-size: 7pt; font-weight: bold; padding: 1px 7px; border-radius: 4px; }

/* ── Evidence index ──────────────────────── */
.ev-table { width: 100%; border-collapse: collapse; }
.ev-table th { background: #f1f5f9; color: #64748b; padding: 6px 10px; font-size: 7.5pt; text-align: left; border: 1px solid #e2e8f0; }
.ev-table td { padding: 6px 10px; font-size: 8.5pt; border: 1px solid #e2e8f0; vertical-align: top; }

/* ── Red flags summary ───────────────────── */
.rf-item { background: #fff5f5; border-left: 3px solid #ef4444; padding: 8px 12px; border-radius: 0 6px 6px 0; margin-bottom: 8px; font-size: 8.5pt; color: #991b1b; }

/* ── Footer ──────────────────────────────── */
.footer {
    margin-top: 20px;
    padding-top: 12px;
    border-top: 1px solid #e2e8f0;
    font-size: 7pt;
    color: #94a3b8;
    text-align: center;
    line-height: 1.6;
}
.disclaimer {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 7.5pt;
    color: #64748b;
    margin-top: 14px;
    line-height: 1.6;
}

/* ── Signature row ───────────────────────── */
.sig-row { display: table; width: 100%; margin-top: 20px; }
.sig-col { display: table-cell; width: 50%; vertical-align: bottom; }
.sig-line { border-top: 1px solid #1e293b; margin-top: 36px; padding-top: 5px; font-size: 8pt; color: #64748b; }

/* ── QR / verify row ─────────────────────── */
.verify-row {
    background: #011f4b;
    color: #fff;
    padding: 10px 16px;
    border-radius: 8px;
    margin-top: 14px;
    font-size: 8pt;
    text-align: center;
}
.verify-url { font-size: 9pt; font-weight: bold; color: #FF5C00; word-break: break-all; }
</style>
</head>
<body>
<div class="page">

{{-- ═══════════════════════════════════════════════════════════════
     PAGE 1: COVER
══════════════════════════════════════════════════════════════════ --}}

{{-- Header band --}}
<div class="cover-header">
    <div class="cover-logo-row">
        <div class="cover-logo-cell">
            <div class="cover-logo-text">DSD <span>Properties</span></div>
            <div class="cover-logo-sub">dsdproperties.in · lucknow.dsd@gmail.com · 9695602948</div>
        </div>
        <div class="cover-report-id">
            <div class="cover-report-id-text">{{ $report->report_id }}</div>
            <div class="cover-report-id-sub">{{ now()->format('d M Y') }}</div>
        </div>
    </div>
</div>

<div class="cover-title-band">संपत्ति सत्यापन रिपोर्ट — Property Verification Report</div>

<div class="cover-body">
    <div class="cover-grid">
        <div class="cover-col">
            <div class="cover-field">
                <div class="cover-label">ग्राहक का नाम</div>
                <div class="cover-value">{{ $report->customer_name }}</div>
            </div>
            <div class="cover-field">
                <div class="cover-label">मोबाइल</div>
                <div class="cover-value">{{ $report->customer_phone }}</div>
            </div>
            @if($report->customer_email)
            <div class="cover-field">
                <div class="cover-label">ईमेल</div>
                <div class="cover-value-small">{{ $report->customer_email }}</div>
            </div>
            @endif
        </div>
        <div class="cover-col">
            <div class="cover-field">
                <div class="cover-label">सत्यापनकर्ता</div>
                <div class="cover-value">{{ $report->verifier_name ?? 'DSD Properties' }}</div>
            </div>
            <div class="cover-field">
                <div class="cover-label">भौतिक जाँच तारीख</div>
                <div class="cover-value">{{ optional($report->verifier_visit_date)->format('d M Y') ?? '—' }}</div>
            </div>
            <div class="cover-field">
                <div class="cover-label">रिपोर्ट तारीख</div>
                <div class="cover-value">{{ now()->format('d M Y') }}</div>
            </div>
        </div>
    </div>

    {{-- Property snapshot --}}
    <div class="cover-field" style="margin-top:14px;border-top:1px solid #e2e8f0;padding-top:12px">
        <div class="cover-label" style="margin-bottom:6px">संपत्ति विवरण</div>
        <table class="info-table">
            <tr><td class="lbl">पूरा पता</td><td>{{ $report->property_address }}</td></tr>
            <tr>
                <td class="lbl">खसरा / गाटा</td>
                <td>{{ $report->property_khasra ?? '—' }} / {{ $report->property_gata ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">क्षेत्रफल / प्रकार</td>
                <td>{{ $report->property_area }} · {{ $report->property_type }}</td>
            </tr>
            <tr><td class="lbl">विक्रेता</td><td>{{ $report->seller_name }}</td></tr>
            @if($report->asking_price)
            <tr><td class="lbl">मांगी गई कीमत</td><td>₹{{ number_format($report->asking_price) }}</td></tr>
            @endif
            <tr><td class="lbl">तहसील</td><td>{{ $report->tehsil }}</td></tr>
        </table>
    </div>

    {{-- Verdict box --}}
    @php
        $vbClass = ['green'=>'vb-green','amber'=>'vb-amber','red'=>'vb-red'][$report->verdict] ?? 'vb-amber';
        $vEmoji  = ['green'=>'✅','amber'=>'⚠️','red'=>'❌'][$report->verdict] ?? '⚠️';
        $vTitle  = ['green'=>'सुरक्षित — आगे बढ़ें','amber'=>'सावधानी — शर्तों के साथ आगे बढ़ें','red'=>'न खरीदें — गंभीर समस्याएं'][$report->verdict] ?? '';
    @endphp
    <div class="verdict-box {{ $vbClass }}">
        <div class="verdict-emoji">{{ $vEmoji }}</div>
        <div class="verdict-title">{{ $vTitle }}</div>
        <div class="verdict-summary">{{ $report->verdict_summary_hindi }}</div>
    </div>

    <div class="verify-row">
        रिपोर्ट की प्रामाणिकता जांचें (Verify authenticity):
        <div class="verify-url">dsdproperties.in/verify/{{ $report->report_id }}</div>
    </div>

    <div class="disclaimer">
        <strong>अस्वीकरण (Disclaimer):</strong> यह रिपोर्ट DSD Properties द्वारा उपलब्ध सरकारी रिकॉर्ड और भौतिक निरीक्षण के आधार पर तैयार की गई है। यह कानूनी परामर्श नहीं है। संपत्ति खरीद से पहले एक पंजीकृत वकील से परामर्श अवश्य लें। DSD Properties किसी भी भविष्य के विवाद के लिए उत्तरदायी नहीं होगी।
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     PAGE 2: SUMMARY MATRIX
══════════════════════════════════════════════════════════════════ --}}
<div class="section-break">
    <div class="section-title">जांच सारांश तालिका</div>
    <div class="section-sub">नीचे सभी 9 जांचों का त्वरित अवलोकन दिया गया है।</div>

    <table class="matrix-table">
        <thead>
            <tr>
                <th style="width:6%">#</th>
                <th style="width:30%">जांच का नाम</th>
                <th style="width:22%">कार्यालय</th>
                <th style="width:14%">स्थिति</th>
                <th style="width:28%">संक्षिप्त निष्कर्ष</th>
            </tr>
        </thead>
        <tbody>
            @foreach($checks as $check)
            @php $f = $findings->get($check['slug']); @endphp
            <tr>
                <td style="text-align:center;font-weight:bold">{{ $check['order'] }}</td>
                <td>
                    <div style="font-weight:bold;font-size:8.5pt">{{ $check['hindi_label'] }}</div>
                    <div style="font-size:7pt;color:#94a3b8">{{ $check['english_label'] }}</div>
                </td>
                <td style="font-size:8pt">{{ $check['location_hindi'] }}</td>
                <td>
                    @if($f)
                    @php
                        $chipClass = ['clear'=>'sc-clear','note'=>'sc-note','issue'=>'sc-issue','not_applicable'=>'sc-na'][$f->status] ?? 'sc-na';
                    @endphp
                    <span class="status-chip {{ $chipClass }}">{{ $f->status_icon }} {{ $f->status_label_hindi }}</span>
                    @else
                    <span class="status-chip sc-na">—</span>
                    @endif
                </td>
                <td style="font-size:8pt">
                    @if($f && $f->findings_hindi)
                    {{ \Illuminate\Support\Str::limit($f->findings_hindi, 80) }}
                    @else
                    —
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     PAGES 3+: DETAILED FINDINGS
══════════════════════════════════════════════════════════════════ --}}
<div class="section-break">
    <div class="section-title">विस्तृत जांच रिपोर्ट</div>
    <div class="section-sub">प्रत्येक जांच का पूरा विवरण, जिसमें साक्ष्य संदर्भ और निष्कर्ष शामिल हैं।</div>

    @foreach($checks as $check)
    @php $f = $findings->get($check['slug']); @endphp
    <div class="finding-card">
        <div class="finding-header">
            <div class="fh-num"><div class="fh-num-badge">{{ $check['order'] }}</div></div>
            <div class="fh-title">
                <div class="fh-title-main">{{ $check['hindi_label'] }}</div>
                <div class="fh-title-sub">{{ $check['english_label'] }} · {{ $check['location_hindi'] }}</div>
            </div>
            <div class="fh-status">
                @if($f)
                @php $chipClass = ['clear'=>'sc-clear','note'=>'sc-note','issue'=>'sc-issue','not_applicable'=>'sc-na'][$f->status] ?? 'sc-na'; @endphp
                <span class="status-chip {{ $chipClass }}">{{ $f->status_icon }} {{ $f->status_label_hindi }}</span>
                @if($f->evidence_reference)
                <div style="margin-top:4px;text-align:right"><span class="ev-ref">{{ $f->evidence_reference }}</span></div>
                @endif
                @endif
            </div>
        </div>

        <div class="finding-body">
            @if($f)
            @if($f->what_checked_hindi)
            <div class="finding-row">
                <div class="finding-row-label">क्या जांचा गया?</div>
                <div class="finding-row-text">{{ $f->what_checked_hindi }}</div>
            </div>
            @endif

            @if($f->where_checked_hindi)
            <div class="finding-row">
                <div class="finding-row-label">कहाँ जांचा गया?</div>
                <div class="finding-row-text">{{ $f->where_checked_hindi }}</div>
            </div>
            @endif

            @if($f->visit_date)
            <div class="finding-row">
                <div class="finding-row-label">जाँच तारीख / समय</div>
                <div class="finding-row-text">{{ optional($f->visit_date)->format('d M Y') }}@if($f->visit_time) · {{ $f->visit_time }}@endif</div>
            </div>
            @endif

            <div class="finding-row">
                <div class="finding-row-label">निष्कर्ष (Findings)</div>
                <div class="finding-row-text">{{ $f->findings_hindi ?: '—' }}</div>
            </div>

            @if($f->red_flags_hindi)
            <div class="red-flag-box">
                <strong>⚠️ लाल झंडा:</strong> {{ $f->red_flags_hindi }}
            </div>
            @endif

            @else
            <div style="color:#94a3b8;font-size:8.5pt">इस जांच का डेटा उपलब्ध नहीं।</div>
            @endif
        </div>
    </div>
    @endforeach
</div>

{{-- ═══════════════════════════════════════════════════════════════
     RED FLAGS SUMMARY (only if any)
══════════════════════════════════════════════════════════════════ --}}
@php $redFlags = $findings->filter(fn($f) => $f && $f->red_flags_hindi); @endphp
@if($redFlags->count())
<div class="section-break">
    <div class="section-title" style="color:#991b1b;border-bottom-color:#ef4444">⚠️ लाल झंडे — Red Flags सारांश</div>
    @foreach($redFlags as $slug => $f)
    @php $check = collect($checks)->firstWhere('slug', $slug); @endphp
    <div class="rf-item">
        <strong>{{ $check['hindi_label'] ?? $slug }}:</strong> {{ $f->red_flags_hindi }}
    </div>
    @endforeach
</div>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     EVIDENCE INDEX
══════════════════════════════════════════════════════════════════ --}}
@if($report->evidences->count())
<div class="section-break">
    <div class="section-title">साक्ष्य दस्तावेज सूची</div>
    <div class="section-sub">नीचे सूचीबद्ध दस्तावेज़ मूल प्रति में संलग्न हैं।</div>

    <table class="ev-table">
        <thead>
            <tr>
                <th>कोड</th>
                <th>दस्तावेज़</th>
                <th>स्रोत कार्यालय</th>
                <th>निकाला गया</th>
                <th>तारीख</th>
                <th>पृष्ठ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->evidences as $ev)
            <tr>
                <td><span class="ev-ref">{{ $ev->evidence_code }}</span></td>
                <td>
                    <div style="font-weight:bold">{{ $ev->document_type_hindi }}</div>
                    <div style="font-size:7.5pt;color:#64748b">{{ $ev->document_type }}</div>
                </td>
                <td>{{ $ev->source_office_hindi }}</td>
                <td>{{ $ev->extracted_by }}</td>
                <td style="white-space:nowrap">{{ optional($ev->extracted_on)->format('d M Y') }}</td>
                <td style="text-align:center">{{ $ev->page_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

{{-- ═══════════════════════════════════════════════════════════════
     SIGNATURE + DISCLAIMER
══════════════════════════════════════════════════════════════════ --}}
<div style="margin-top:20px">
    <div class="sig-row">
        <div class="sig-col">
            <div class="sig-line">
                सत्यापनकर्ता: {{ $report->verifier_name ?? 'DSD Properties टीम' }}<br>
                DSD Properties, Lucknow
            </div>
        </div>
        <div class="sig-col" style="text-align:right">
            <div class="sig-line" style="display:inline-block;text-align:left">
                रिपोर्ट ID: {{ $report->report_id }}<br>
                दिनांक: {{ now()->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="disclaimer" style="margin-top:14px">
        <strong>विस्तृत अस्वीकरण:</strong> यह रिपोर्ट केवल सूचना के उद्देश्य से है और कानूनी परामर्श का विकल्प नहीं है। DSD Properties ने उपलब्ध सरकारी दस्तावेज़ों और रिकॉर्ड के आधार पर यह रिपोर्ट तैयार की है। भविष्य में कोई भी रिकॉर्ड परिवर्तन, अदृश्य देनदारी, या अप्रकट विवाद के लिए DSD Properties जिम्मेदार नहीं होगी। संपत्ति की अंतिम खरीद से पहले एक पंजीकृत वकील और बैंक से परामर्श लें। यह रिपोर्ट केवल {{ $report->report_id }} रिपोर्ट आईडी के ग्राहक के लिए तैयार की गई है।
    </div>

    <div class="footer">
        DSD Properties · dsdproperties.in · 9695602948 · Lucknow, Uttar Pradesh<br>
        रिपोर्ट {{ $report->report_id }} · उत्पन्न: {{ now()->format('d M Y, g:i A') }}
    </div>
</div>

</div>{{-- .page --}}
</body>
</html>
