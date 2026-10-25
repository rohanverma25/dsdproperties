@extends('admin.verifications.layout')

@section('title', $report->report_id . ' — संपादन')

@push('styles')
<style>
.wrap{max-width:1100px;margin:0 auto;padding:0}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px}
.report-meta{display:flex;flex-direction:column;gap:4px}
.report-id{font-size:1.2rem;font-weight:800;color:#011f4b}
.report-sub{font-size:.8rem;color:#64748b}
.status-pill{display:inline-block;padding:3px 10px;border-radius:99px;font-size:.7rem;font-weight:700}
.s-draft{background:#f1f5f9;color:#64748b}
.s-in_progress{background:#dbeafe;color:#1e40af}
.s-ready_to_deliver{background:#fef3c7;color:#92400e}
.s-delivered{background:#d1fae5;color:#065f46}

/* Tabs */
.tabs{display:flex;gap:0;background:#fff;border:1px solid #e2e8f0;border-radius:12px 12px 0 0;overflow:hidden;margin-bottom:0}
.tab-btn{flex:1;padding:13px 10px;font-size:.78rem;font-weight:700;border:none;cursor:pointer;font-family:inherit;background:#fff;color:#64748b;border-right:1px solid #e2e8f0;transition:all .18s;text-align:center;line-height:1.3}
.tab-btn:last-child{border-right:none}
.tab-btn.active{background:#011f4b;color:#fff}
.tab-btn:hover:not(.active){background:#f8fafc}
.tab-content{background:#fff;border:1px solid #e2e8f0;border-top:none;border-radius:0 0 12px 12px;padding:24px}

/* Forms */
.section-title{font-size:.75rem;font-weight:700;color:#008080;text-transform:uppercase;letter-spacing:.5px;padding:8px 0 6px;border-bottom:1px solid #f1f5f9;margin-bottom:14px;margin-top:20px}
.section-title:first-child{margin-top:0}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.form-full{grid-column:1/-1}
label{display:block;font-size:.7rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px}
input[type=text],input[type=tel],input[type=email],input[type=number],input[type=date],input[type=time],select,textarea{width:100%;padding:9px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.84rem;color:#1e293b;background:#f8fafc;font-family:inherit;transition:border-color .15s}
input:focus,select:focus,textarea:focus{outline:none;border-color:#008080;background:#fff}
textarea{resize:vertical;min-height:90px}
.btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:.8rem;font-weight:700;border:none;cursor:pointer;font-family:inherit;transition:all .18s;text-decoration:none}
.btn-primary{background:#011f4b;color:#fff}
.btn-primary:hover{background:#022a6e;color:#fff}
.btn-teal{background:#008080;color:#fff}
.btn-teal:hover{background:#006666}
.btn-orange{background:#FF5C00;color:#fff}
.btn-orange:hover{background:#e05200}
.btn-sm{padding:6px 12px;font-size:.75rem}
.btn-danger{background:#ef4444;color:#fff}
.btn-danger:hover{background:#dc2626}
.btn-light{background:#e2e8f0;color:#475569}
.btn-light:hover{background:#cbd5e1}
.btn-green{background:#10b981;color:#fff}
.btn-green:hover{background:#059669}
.btn-disabled{background:#e2e8f0;color:#94a3b8;cursor:not-allowed;pointer-events:none}
.actions{display:flex;gap:8px;margin-top:16px;flex-wrap:wrap;align-items:center}
.save-indicator{font-size:.72rem;font-weight:600;color:#065f46;opacity:0;transition:opacity .3s}
.save-indicator.show{opacity:1}

/* Accordion (findings) */
.accordion-item{border:1px solid #e2e8f0;border-radius:10px;margin-bottom:8px;overflow:hidden}
.accordion-header{display:flex;align-items:center;justify-content:space-between;padding:13px 16px;cursor:pointer;background:#f8fafc;gap:12px;user-select:none}
.accordion-header:hover{background:#f1f5f9}
.accordion-num{width:26px;height:26px;border-radius:50%;background:#011f4b;color:#fff;font-size:.72rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.accordion-title{font-size:.88rem;font-weight:700;color:#1e293b;flex:1}
.accordion-sub{font-size:.7rem;color:#94a3b8}
.accordion-status{display:inline-block;padding:3px 10px;border-radius:99px;font-size:.68rem;font-weight:700;flex-shrink:0}
.as-clear{background:#d1fae5;color:#065f46}
.as-note{background:#fef3c7;color:#92400e}
.as-issue{background:#fee2e2;color:#991b1b}
.as-not_applicable{background:#f3f4f6;color:#6b7280}
.accordion-body{padding:18px;border-top:1px solid #e2e8f0;background:#fff}
.accordion-chevron{color:#94a3b8;font-size:.8rem;transition:transform .2s;flex-shrink:0}

/* Evidence grid */
.ev-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;margin-top:12px}
.ev-card{border:1px solid #e2e8f0;border-radius:10px;padding:14px;background:#fff}
.ev-code{font-size:.72rem;font-weight:800;color:#FF5C00;margin-bottom:6px}
.ev-type{font-size:.82rem;font-weight:700;color:#1e293b;margin-bottom:4px}
.ev-meta{font-size:.7rem;color:#94a3b8;line-height:1.5}
.ev-actions{display:flex;gap:6px;margin-top:10px;flex-wrap:wrap}

/* Upload zone */
.upload-zone{border:2px dashed #e2e8f0;border-radius:10px;padding:20px;text-align:center;cursor:pointer;transition:border-color .2s;margin-top:12px}
.upload-zone:hover{border-color:#008080}
.upload-zone input{display:none}
.upload-zone-icon{font-size:2rem;margin-bottom:6px}
.upload-zone p{font-size:.78rem;color:#64748b}

/* Alert / toast */
.alert{padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:.82rem;font-weight:600;background:#d1fae5;color:#065f46;border:1px solid #6ee7b7}
.alert-warn{background:#fef3c7;color:#92400e;border-color:#fde68a}
.alert-error{background:#fee2e2;color:#991b1b;border-color:#fca5a5}
.toast{position:fixed;bottom:24px;right:24px;z-index:9999;background:#011f4b;color:#fff;padding:12px 20px;border-radius:10px;font-size:.82rem;font-weight:600;box-shadow:0 8px 24px rgba(0,0,0,.2);transform:translateY(80px);opacity:0;transition:all .3s}
.toast.show{transform:translateY(0);opacity:1}
.wa-box{background:#f0fdf4;border:1.5px solid #86efac;border-radius:10px;padding:16px;margin-top:16px}
.wa-box pre{font-size:.76rem;white-space:pre-wrap;color:#374151;line-height:1.7;margin-top:8px;font-family:inherit}
.verdict-card{border:2px solid;border-radius:12px;padding:16px;margin-top:12px;text-align:center}
.vc-green{border-color:#10b981;background:#f0fdf4}
.vc-amber{border-color:#f59e0b;background:#fffbeb}
.vc-red{border-color:#ef4444;background:#fef2f2}
.spinner{display:inline-block;width:16px;height:16px;border:2.5px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;vertical-align:middle}
@keyframes spin{to{transform:rotate(360deg)}}
.font-warn{background:#fef3c7;border:1px solid #fde68a;border-radius:8px;padding:10px 14px;font-size:.78rem;color:#92400e;margin-bottom:16px}
@media(max-width:680px){.form-grid{grid-template-columns:1fr}.tabs{flex-wrap:wrap}.tab-btn{flex:none;width:50%}}
</style>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')

<div class="wrap" x-data="reportApp()" x-init="init()">

    {{-- Toast --}}
    <div class="toast" :class="{'show': toastShow}" x-text="toastMsg"></div>

    <div class="page-header">
        <div class="report-meta">
            <a href="{{ route('ver.admin.index') }}" style="font-size:.78rem;color:#008080;text-decoration:none;">&larr; सूची पर वापस जाएं</a>
            <div class="report-id">{{ $report->report_id }}</div>
            <div class="report-sub">{{ $report->customer_name }} · {{ $report->customer_phone }} · {{ $report->property_address_short }}</div>
            <div style="margin-top:6px">
                <span class="status-pill s-{{ $report->status }}">{{ $report->status_label }}</span>
                @if($report->verdict)
                <span class="status-pill" style="margin-left:6px;background:{{ $report->verdict_bg }};color:{{ $report->verdict_color }}">
                    {{ $report->verdict_label }}
                </span>
                @endif
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert">{{ session('success') }}</div>
    @endif

    @if(!$fontsReady)
    <div class="font-warn">
        ⚠️ <strong>Hindi fonts not downloaded yet.</strong>
        PDF में हिंदी सही नहीं दिखेगी।
        <button onclick="downloadFonts()" style="margin-left:12px;background:#FF5C00;color:#fff;border:none;border-radius:6px;padding:4px 12px;font-size:.75rem;font-weight:700;cursor:pointer">Fonts डाउनलोड करें</button>
        <span id="font-status" style="font-size:.72rem;margin-left:8px"></span>
    </div>
    @endif

    {{-- Tabs --}}
    <div class="tabs">
        <button class="tab-btn" :class="{'active':tab===0}" @click="tab=0">📋<br>बुनियादी जानकारी</button>
        <button class="tab-btn" :class="{'active':tab===1}" @click="tab=1">🔍<br>9 जांच</button>
        <button class="tab-btn" :class="{'active':tab===2}" @click="tab=2">📎<br>साक्ष्य दस्तावेज</button>
        <button class="tab-btn" :class="{'active':tab===3}" @click="tab=3">⚖️<br>अंतिम निर्णय</button>
        <button class="tab-btn" :class="{'active':tab===4}" @click="tab=4">📤<br>वितरण</button>
    </div>

    {{-- ═══ TAB 1: Basic Info ═══════════════════════════════════════════════ --}}
    <div class="tab-content" x-show="tab===0">
        <form method="POST" action="{{ route('ver.admin.update', $report) }}">
            @csrf @method('PATCH')

            <div class="section-title">👤 ग्राहक जानकारी</div>
            <div class="form-grid">
                <div>
                    <label>पूरा नाम *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $report->customer_name) }}" required>
                </div>
                <div>
                    <label>मोबाइल *</label>
                    <input type="tel" name="customer_phone" value="{{ old('customer_phone', $report->customer_phone) }}" required maxlength="10">
                </div>
                <div class="form-full">
                    <label>ईमेल</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', $report->customer_email) }}">
                </div>
            </div>

            <div class="section-title">🏠 संपत्ति विवरण</div>
            <div class="form-grid">
                <div class="form-full">
                    <label>पूरा पता *</label>
                    <textarea name="property_address" required>{{ old('property_address', $report->property_address) }}</textarea>
                </div>
                <div><label>खसरा</label><input type="text" name="property_khasra" value="{{ old('property_khasra', $report->property_khasra) }}"></div>
                <div><label>गाटा</label><input type="text" name="property_gata" value="{{ old('property_gata', $report->property_gata) }}"></div>
                <div><label>क्षेत्रफल *</label><input type="text" name="property_area" value="{{ old('property_area', $report->property_area) }}" required></div>
                <div>
                    <label>प्रकार *</label>
                    <select name="property_type" required>
                        <option value="plot"       {{ $report->property_type=='plot'?'selected':'' }}>भूखंड</option>
                        <option value="flat"       {{ $report->property_type=='flat'?'selected':'' }}>फ्लैट</option>
                        <option value="house"      {{ $report->property_type=='house'?'selected':'' }}>मकान</option>
                        <option value="commercial" {{ $report->property_type=='commercial'?'selected':'' }}>व्यावसायिक</option>
                    </select>
                </div>
                <div><label>विक्रेता का नाम *</label><input type="text" name="seller_name" value="{{ old('seller_name', $report->seller_name) }}" required></div>
                <div><label>मांगी गई कीमत (₹)</label><input type="number" name="asking_price" value="{{ old('asking_price', $report->asking_price) }}" min="0"></div>
                <div>
                    <label>तहसील *</label>
                    <select name="tehsil" required>
                        <option value="sadar"        {{ $report->tehsil=='sadar'?'selected':'' }}>सदर</option>
                        <option value="bkt"          {{ $report->tehsil=='bkt'?'selected':'' }}>BKT</option>
                        <option value="mohanlalganj" {{ $report->tehsil=='mohanlalganj'?'selected':'' }}>मोहनलालगंज</option>
                        <option value="malihabad"    {{ $report->tehsil=='malihabad'?'selected':'' }}>मलिहाबाद</option>
                        <option value="other"        {{ $report->tehsil=='other'?'selected':'' }}>अन्य</option>
                    </select>
                </div>
            </div>

            <div class="section-title">🔍 सत्यापनकर्ता</div>
            <div class="form-grid">
                <div><label>नाम</label><input type="text" name="verifier_name" value="{{ old('verifier_name', $report->verifier_name) }}"></div>
                <div><label>जाँच तारीख</label><input type="date" name="verifier_visit_date" value="{{ old('verifier_visit_date', optional($report->verifier_visit_date)->format('Y-m-d')) }}"></div>
                <div class="form-full"><label>आंतरिक नोट्स</label><textarea name="notes">{{ old('notes', $report->notes) }}</textarea></div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">जानकारी सहेजें ✓</button>
            </div>
        </form>
    </div>

    {{-- ═══ TAB 2: 9 Checks ════════════════════════════════════════════════ --}}
    <div class="tab-content" x-show="tab===1">
        <p style="font-size:.8rem;color:#64748b;margin-bottom:18px">प्रत्येक जांच के लिए स्थिति, निष्कर्ष और साक्ष्य भरें। ब्लर पर ऑटो-सेव होता है।</p>

        @foreach($checks as $check)
        @php $finding = $findings->get($check['slug']); @endphp
        <div class="accordion-item" x-data="{open: false, saving: false, saved: false}">
            <div class="accordion-header" @click="open=!open">
                <span class="accordion-num">{{ $check['order'] }}</span>
                <div style="flex:1">
                    <div class="accordion-title">{{ $check['hindi_label'] }}</div>
                    <div class="accordion-sub">{{ $check['english_label'] }}</div>
                </div>
                @if($finding)
                <span class="accordion-status as-{{ $finding->status }}">{{ $finding->status_icon }} {{ $finding->status_label_hindi }}</span>
                @endif
                <span class="accordion-chevron" :style="open ? 'transform:rotate(180deg)' : ''">▼</span>
            </div>
            <div class="accordion-body" x-show="open" x-cloak>
                <form @submit.prevent
                      @blur.capture.debounce.600ms="autoSave('{{ $check['slug'] }}', $el.closest('form'))"
                      id="form-{{ $check['slug'] }}">

                    <div class="form-grid">
                        <div>
                            <label>स्थिति *</label>
                            <select name="status" @change="autoSave('{{ $check['slug'] }}', $el.closest('form'))">
                                <option value="clear"          {{ ($finding?->status ?? 'clear') == 'clear' ? 'selected' : '' }}>✅ स्पष्ट</option>
                                <option value="note"           {{ ($finding?->status ?? '') == 'note' ? 'selected' : '' }}>⚠️ ध्यान दें</option>
                                <option value="issue"          {{ ($finding?->status ?? '') == 'issue' ? 'selected' : '' }}>❌ समस्या</option>
                                <option value="not_applicable" {{ ($finding?->status ?? '') == 'not_applicable' ? 'selected' : '' }}>➖ लागू नहीं</option>
                            </select>
                        </div>
                        <div>
                            <label>जाँच तारीख</label>
                            <input type="date" name="visit_date" value="{{ optional($finding?->visit_date)->format('Y-m-d') }}">
                        </div>
                        <div>
                            <label>जाँच समय</label>
                            <input type="text" name="visit_time" value="{{ $finding?->visit_time }}" placeholder="जैसे: 11:40 AM">
                        </div>
                        <div>
                            <label>साक्ष्य संदर्भ (ऑटो)</label>
                            <input type="text" name="evidence_reference" value="{{ $finding?->evidence_reference }}" placeholder="E-01" readonly style="background:#f1f5f9;color:#94a3b8">
                        </div>
                        <div class="form-full">
                            <label>क्या जांचा गया?</label>
                            <textarea name="what_checked_hindi" rows="3">{{ $finding?->what_checked_hindi ?? $check['what_checked_default'] }}</textarea>
                        </div>
                        <div class="form-full">
                            <label>कहाँ जांचा गया? (कार्यालय + अधिकारी)</label>
                            <textarea name="where_checked_hindi" rows="2">{{ $finding?->where_checked_hindi ?? $check['location_hindi'] }}</textarea>
                        </div>
                        <div class="form-full">
                            <label>क्या पाया गया? (निष्कर्ष) *</label>
                            <textarea name="findings_hindi" rows="4" placeholder="इस जांच में क्या पाया गया — हिंदी में विस्तार से लिखें…">{{ $finding?->findings_hindi }}</textarea>
                        </div>
                        <div class="form-full">
                            <label>लाल झंडे / चेतावनी (यदि कोई हो)</label>
                            <textarea name="red_flags_hindi" rows="2" placeholder="कोई समस्या या चेतावनी…">{{ $finding?->red_flags_hindi }}</textarea>
                        </div>
                    </div>

                    <div class="actions">
                        <button type="button" class="btn btn-teal btn-sm" @click="autoSave('{{ $check['slug'] }}', $el.closest('form'))">
                            <span x-show="!saving">सहेजें ✓</span>
                            <span x-show="saving"><span class="spinner"></span></span>
                        </button>
                        <span class="save-indicator" :class="{'show': saved}">✓ सहेजा गया</span>
                    </div>
                </form>

                {{-- Inline evidence upload for this check --}}
                <div style="margin-top:18px;padding-top:14px;border-top:1px solid #f1f5f9">
                    <div style="font-size:.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;margin-bottom:10px">साक्ष्य अपलोड — {{ $check['hindi_label'] }}</div>
                    <div x-data="evidenceUpload('{{ $check['slug'] }}', {{ $report->id }})">
                        <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:flex-end">
                            <div style="flex:1;min-width:180px">
                                <label>दस्तावेज़ प्रकार (Hindi) *</label>
                                <input type="text" x-model="docTypeHindi" placeholder="जैसे: भार मुक्त प्रमाण पत्र">
                            </div>
                            <div style="flex:1;min-width:180px">
                                <label>स्रोत कार्यालय *</label>
                                <input type="text" x-model="sourceOffice" placeholder="जैसे: उप-रजिस्ट्रार कार्यालय">
                            </div>
                            <div style="min-width:130px">
                                <label>निकालने की तारीख *</label>
                                <input type="date" x-model="extractedOn">
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;margin-top:10px;flex-wrap:wrap;align-items:flex-end">
                            <div style="flex:1">
                                <label>फ़ाइल (PDF/JPG/PNG, max 10MB) *</label>
                                <input type="file" accept=".pdf,.jpg,.jpeg,.png" @change="fileSelected($event)" style="background:#fff">
                            </div>
                            <div style="min-width:120px">
                                <label>निकाला गया (कौन) *</label>
                                <input type="text" x-model="extractedBy" placeholder="स्टाफ नाम">
                            </div>
                            <button type="button" class="btn btn-sm btn-orange" @click="upload()" :disabled="uploading">
                                <span x-show="!uploading">अपलोड करें</span>
                                <span x-show="uploading"><span class="spinner"></span></span>
                            </button>
                        </div>
                        <div x-show="uploadMsg" x-text="uploadMsg" style="font-size:.75rem;margin-top:6px;color:#065f46;font-weight:600"></div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ═══ TAB 3: Evidence Dossier ════════════════════════════════════════ --}}
    <div class="tab-content" x-show="tab===2">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <div>
                <div style="font-size:.95rem;font-weight:700;color:#011f4b">साक्ष्य दस्तावेज</div>
                <div style="font-size:.75rem;color:#64748b;margin-top:2px">कुल {{ $report->evidences->count() }} दस्तावेज़</div>
            </div>
        </div>

        @if($report->evidences->isEmpty())
        <div style="text-align:center;padding:40px;color:#94a3b8;font-size:.85rem">
            📎 अभी तक कोई साक्ष्य अपलोड नहीं हुआ।<br>
            <span style="font-size:.75rem">"9 जांच" टैब में प्रत्येक जांच के नीचे अपलोड करें।</span>
        </div>
        @else
        <div class="ev-grid">
            @foreach($report->evidences as $ev)
            <div class="ev-card" id="ev-{{ $ev->id }}">
                <div class="ev-code">{{ $ev->evidence_code }}</div>
                <div class="ev-type">{{ $ev->document_type_hindi }}</div>
                <div class="ev-meta">
                    📁 {{ $ev->document_type }}<br>
                    🏛 {{ $ev->source_office_hindi }}<br>
                    👤 {{ $ev->extracted_by }}<br>
                    📅 {{ optional($ev->extracted_on)->format('d M Y') }}<br>
                    📄 {{ $ev->page_count }} पृष्ठ · {{ $ev->file_size_human }}
                    @if($ev->notes)<br>📝 {{ $ev->notes }}@endif
                </div>
                <div class="ev-actions">
                    <a href="{{ route('ver.admin.evidences.download', [$report, $ev]) }}"
                       class="btn btn-sm btn-teal" target="_blank">डाउनलोड</a>
                    <button type="button"
                            onclick="deleteEvidence({{ $ev->id }}, {{ $report->id }})"
                            class="btn btn-sm btn-danger">हटाएं</button>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- General evidence upload (not tied to a specific check) --}}
        <div style="margin-top:24px;padding:18px;border:1.5px dashed #e2e8f0;border-radius:10px" x-data="evidenceUpload(null, {{ $report->id }})">
            <div style="font-size:.78rem;font-weight:700;color:#64748b;margin-bottom:14px;text-transform:uppercase;letter-spacing:.4px">सामान्य साक्ष्य अपलोड (किसी जांच से जुड़ा नहीं)</div>
            <div class="form-grid">
                <div><label>दस्तावेज़ प्रकार (English)</label><input type="text" x-model="docTypeEn" placeholder="e.g. Site Photo"></div>
                <div><label>दस्तावेज़ प्रकार (Hindi) *</label><input type="text" x-model="docTypeHindi" placeholder="जैसे: साइट फोटो"></div>
                <div><label>स्रोत कार्यालय / स्थान *</label><input type="text" x-model="sourceOffice" placeholder="जैसे: संपत्ति स्थल"></div>
                <div><label>निकाला गया (कौन) *</label><input type="text" x-model="extractedBy" placeholder="स्टाफ नाम"></div>
                <div><label>निकालने की तारीख *</label><input type="date" x-model="extractedOn"></div>
                <div><label>पृष्ठ संख्या</label><input type="number" x-model="pageCount" min="1" value="1"></div>
                <div class="form-full"><label>फ़ाइल (PDF/JPG/PNG, max 10MB) *</label><input type="file" accept=".pdf,.jpg,.jpeg,.png" @change="fileSelected($event)" style="background:#fff"></div>
                <div class="form-full"><label>नोट्स</label><input type="text" x-model="notes" placeholder="वैकल्पिक नोट्स"></div>
            </div>
            <div class="actions" style="margin-top:14px">
                <button type="button" class="btn btn-orange" @click="upload()" :disabled="uploading">
                    <span x-show="!uploading">साक्ष्य अपलोड करें</span>
                    <span x-show="uploading"><span class="spinner"></span></span>
                </button>
                <span x-show="uploadMsg" x-text="uploadMsg" style="font-size:.78rem;color:#065f46;font-weight:600"></span>
            </div>
        </div>
    </div>

    {{-- ═══ TAB 4: Final Verdict ═══════════════════════════════════════════ --}}
    <div class="tab-content" x-show="tab===3" x-data="verdictTab()">
        @if(! $report->allFindingsFilled())
        <div class="alert alert-warn">⚠️ सभी 9 जांचों के निष्कर्ष भरना ज़रूरी है। अभी {{ $report->findings->where('findings_hindi', '!=', '')->count() }}/9 भरी हैं।</div>
        @endif

        <div class="form-grid">
            <div>
                <label>अंतिम निर्णय *</label>
                <select name="verdict" x-model="verdict" @change="updateVerdictCard()">
                    <option value="">चुनें…</option>
                    <option value="green" {{ $report->verdict=='green'?'selected':'' }}>✅ सुरक्षित — आगे बढ़ें</option>
                    <option value="amber" {{ $report->verdict=='amber'?'selected':'' }}>⚠️ सावधानी — शर्तों के साथ</option>
                    <option value="red"   {{ $report->verdict=='red'?'selected':'' }}>❌ न खरीदें</option>
                </select>
            </div>
        </div>

        <div class="verdict-card" :class="verdictClass" x-show="verdict" style="display:none">
            <div style="font-size:2rem;margin-bottom:6px" x-text="verdictEmoji"></div>
            <div style="font-size:1.1rem;font-weight:800" x-text="verdictText"></div>
        </div>

        <div style="margin-top:16px">
            <label>निर्णय का सारांश — हिंदी में (3-4 पंक्तियाँ) *</label>
            <textarea name="verdict_summary_hindi" x-model="verdictSummary" rows="5"
                placeholder="उदाहरण: इस संपत्ति का एलडीए रिकॉर्ड स्पष्ट है। 30 वर्षीय टाइटल चेन सुरक्षित है। भार मुक्त प्रमाण पत्र में कोई देनदारी नहीं मिली। कोर्ट में कोई मुकदमा नहीं है।">{{ $report->verdict_summary_hindi }}</textarea>
        </div>

        <div class="actions" style="margin-top:18px">
            <button type="button" class="btn btn-green"
                    :class="{'btn-disabled': generating || !verdict || !verdictSummary}"
                    @click="generatePdf()">
                <span x-show="!generating">📄 PDF बनाएं</span>
                <span x-show="generating"><span class="spinner"></span> PDF बन रही है…</span>
            </button>
            @if($report->pdf_path)
            <a href="{{ route('ver.admin.download-pdf', $report) }}" class="btn btn-teal">⬇ PDF डाउनलोड करें</a>
            @endif
        </div>

        <div x-show="pdfMsg" x-text="pdfMsg" style="margin-top:12px;font-size:.82rem;font-weight:600;padding:10px 14px;border-radius:8px"
             :style="pdfError ? 'background:#fee2e2;color:#991b1b' : 'background:#d1fae5;color:#065f46'"></div>
    </div>

    {{-- ═══ TAB 5: Delivery ════════════════════════════════════════════════ --}}
    <div class="tab-content" x-show="tab===4" x-data="deliveryTab()">
        @if(! $report->pdf_path)
        <div class="alert alert-warn">⚠️ PDF अभी तक नहीं बनी। पहले "अंतिम निर्णय" टैब में PDF बनाएं।</div>
        @endif

        <div style="margin-bottom:20px">
            <div style="font-size:.9rem;font-weight:700;color:#011f4b;margin-bottom:12px">PDF विवरण</div>
            <table style="font-size:.8rem;border-collapse:collapse;width:100%">
                <tr><td style="padding:6px 0;color:#64748b;width:160px">रिपोर्ट ID</td><td style="font-weight:700">{{ $report->report_id }}</td></tr>
                <tr><td style="padding:6px 0;color:#64748b">PDF पासवर्ड</td><td style="font-weight:700;color:#FF5C00">{{ $report->pdf_password }} <span style="font-size:.7rem;color:#94a3b8">(फ़ोन के अंतिम 4 अंक)</span></td></tr>
                <tr><td style="padding:6px 0;color:#64748b">निर्णय</td><td>{{ $report->verdict_label }}</td></tr>
                <tr><td style="padding:6px 0;color:#64748b">स्थिति</td><td><span class="status-pill s-{{ $report->status }}">{{ $report->status_label }}</span></td></tr>
                @if($report->delivered_at)
                <tr><td style="padding:6px 0;color:#64748b">वितरण तारीख</td><td>{{ $report->delivered_at->format('d M Y, g:i A') }}</td></tr>
                @endif
            </table>
        </div>

        @if($report->pdf_path)
        <div>
            <label>वितरण माध्यम</label>
            <select x-model="channel" style="width:200px;margin-bottom:16px">
                <option value="whatsapp">WhatsApp</option>
                <option value="email">Email</option>
                <option value="both">दोनों</option>
            </select>
        </div>

        <button type="button" class="btn btn-green"
                @click="deliver()"
                :disabled="delivering">
            <span x-show="!delivering">📤 वितरित करें + WhatsApp लिंक बनाएं</span>
            <span x-show="delivering"><span class="spinner"></span></span>
        </button>

        <div x-show="waLink" class="wa-box" style="margin-top:18px">
            <div style="font-size:.78rem;font-weight:700;color:#065f46;margin-bottom:8px">✅ वितरित किया गया — WhatsApp संदेश</div>
            <a :href="waLink" target="_blank" class="btn btn-green" style="margin-bottom:12px">
                📱 WhatsApp पर खोलें
            </a>
            <div style="font-size:.72rem;color:#64748b;margin-bottom:4px">Signed Download URL (30 दिन):</div>
            <div style="font-size:.72rem;word-break:break-all;background:#f0fdf4;padding:8px;border-radius:6px;border:1px solid #86efac" x-text="signedUrl"></div>
        </div>
        @endif
    </div>

</div>{{-- end .wrap --}}

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

function reportApp() {
    return {
        tab: 0,
        toastShow: false,
        toastMsg: '',
        init() {},
        showToast(msg, duration = 2500) {
            this.toastMsg = msg;
            this.toastShow = true;
            setTimeout(() => { this.toastShow = false; }, duration);
        },
        async autoSave(slug, form) {
            const fd = new FormData(form);
            try {
                const r = await fetch(`/admin/verifications/{{ $report->id }}/findings/${slug}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body: fd,
                });
                const data = await r.json();
                if (data.success) this.showToast('✓ ' + slug + ' — सहेजा गया');
            } catch(e) {}
        },
    };
}

function evidenceUpload(slug, reportId) {
    return {
        docTypeEn: '',
        docTypeHindi: '',
        sourceOffice: '',
        extractedBy: '',
        extractedOn: '',
        pageCount: 1,
        notes: '',
        file: null,
        uploading: false,
        uploadMsg: '',
        fileSelected(e) { this.file = e.target.files[0]; },
        async upload() {
            if (!this.file || !this.docTypeHindi || !this.sourceOffice || !this.extractedBy || !this.extractedOn) {
                this.uploadMsg = '⚠️ सभी अनिवार्य फ़ील्ड भरें।';
                return;
            }
            this.uploading = true;
            this.uploadMsg = '';
            const fd = new FormData();
            fd.append('file', this.file);
            fd.append('document_type', this.docTypeEn || this.docTypeHindi);
            fd.append('document_type_hindi', this.docTypeHindi);
            fd.append('source_office_hindi', this.sourceOffice);
            fd.append('extracted_by', this.extractedBy);
            fd.append('extracted_on', this.extractedOn);
            fd.append('page_count', this.pageCount);
            fd.append('notes', this.notes);
            if (slug) fd.append('check_slug', slug);
            try {
                const r = await fetch(`/admin/verifications/${reportId}/evidences`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                    body: fd,
                });
                const data = await r.json();
                if (data.success) {
                    this.uploadMsg = '✅ ' + data.message;
                    this.file = null;
                    setTimeout(() => location.reload(), 1500);
                } else {
                    this.uploadMsg = '❌ अपलोड विफल।';
                }
            } catch(e) {
                this.uploadMsg = '❌ नेटवर्क त्रुटि।';
            }
            this.uploading = false;
        }
    };
}

function verdictTab() {
    return {
        verdict: '{{ $report->verdict ?? '' }}',
        verdictSummary: '',
        generating: false,
        pdfMsg: '',
        pdfError: false,
        verdictClass: '',
        verdictEmoji: '',
        verdictText: '',
        updateVerdictCard() {
            const map = {
                green: { cls: 'vc-green', emoji: '✅', text: 'सुरक्षित — आगे बढ़ें' },
                amber: { cls: 'vc-amber', emoji: '⚠️', text: 'सावधानी — शर्तों के साथ आगे बढ़ें' },
                red:   { cls: 'vc-red',   emoji: '❌', text: 'न खरीदें' },
            };
            const v = map[this.verdict];
            if (v) { this.verdictClass = v.cls; this.verdictEmoji = v.emoji; this.verdictText = v.text; }
        },
        async generatePdf() {
            if (!this.verdict || !this.verdictSummary) return;
            this.generating = true;
            this.pdfMsg = '';
            try {
                const r = await fetch(`/admin/verifications/{{ $report->id }}/generate-pdf`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ verdict: this.verdict, verdict_summary_hindi: this.verdictSummary }),
                });
                const data = await r.json();
                this.pdfError = !data.success;
                this.pdfMsg = data.message;
                if (data.success) setTimeout(() => location.reload(), 1500);
            } catch(e) {
                this.pdfError = true;
                this.pdfMsg = 'नेटवर्क त्रुटि।';
            }
            this.generating = false;
        }
    };
}

function deliveryTab() {
    return {
        channel: 'whatsapp',
        delivering: false,
        waLink: '',
        signedUrl: '',
        async deliver() {
            this.delivering = true;
            try {
                const r = await fetch(`/admin/verifications/{{ $report->id }}/deliver`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ delivery_channel: this.channel }),
                });
                const data = await r.json();
                if (data.success) {
                    this.waLink    = data.wa_link;
                    this.signedUrl = data.signed_url;
                }
            } catch(e) {}
            this.delivering = false;
        }
    };
}

async function deleteEvidence(evidenceId, reportId) {
    if (!confirm('इस साक्ष्य को स्थायी रूप से हटाएं?')) return;
    const r = await fetch(`/admin/verifications/${reportId}/evidences/${evidenceId}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    });
    const data = await r.json();
    if (data.success) {
        document.getElementById('ev-' + evidenceId).remove();
    }
}

async function downloadFonts() {
    const el = document.getElementById('font-status');
    el.textContent = 'डाउनलोड हो रहा है… (30 सेकंड लग सकते हैं)';
    try {
        const r = await fetch('/admin/verifications/setup/fonts', {
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
        const data = await r.json();
        el.textContent = data.success ? '✅ Fonts डाउनलोड हो गईं! पेज रिफ्रेश करें।' : '❌ कुछ fonts विफल: ' + JSON.stringify(data.results);
    } catch(e) {
        el.textContent = '❌ त्रुटि।';
    }
}
</script>
@endpush
