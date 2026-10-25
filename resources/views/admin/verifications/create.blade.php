@extends('admin.verifications.layout')

@section('title', 'नई सत्यापन रिपोर्ट')

@push('styles')
<style>
.section-title { font-size:.78rem; font-weight:700; color:#008080; text-transform:uppercase; letter-spacing:.5px; padding:10px 0 8px; border-bottom:1px solid #f1f5f9; margin-bottom:16px; margin-top:24px; }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-1">नई सत्यापन रिपोर्ट</h5>
                <p class="text-muted small mb-4">ग्राहक और संपत्ति की बुनियादी जानकारी भरें। रिपोर्ट बनने के बाद 9 जांच भर सकते हैं।</p>

                @if($errors->any())
                <div class="alert alert-danger small">
                    <strong>कृपया सुधारें:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('ver.admin.store') }}">
                    @csrf

                    <div class="section-title">👤 ग्राहक जानकारी</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted">पूरा नाम *</label>
                            <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required placeholder="जैसे: राहुल कुमार शर्मा">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted">मोबाइल नंबर * (10 अंक)</label>
                            <input type="tel" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required maxlength="10" pattern="\d{10}" placeholder="9876543210">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-uppercase text-muted">ईमेल (वैकल्पिक)</label>
                            <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" placeholder="email@example.com">
                        </div>
                    </div>

                    <div class="section-title">🏠 संपत्ति विवरण</div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-uppercase text-muted">पूरा पता *</label>
                            <textarea name="property_address" class="form-control" rows="3" required placeholder="पूरा पता हिंदी या अंग्रेजी में…">{{ old('property_address') }}</textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-uppercase text-muted">खसरा नंबर</label>
                            <input type="text" name="property_khasra" class="form-control" value="{{ old('property_khasra') }}" placeholder="जैसे: 312/1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-uppercase text-muted">गाटा नंबर</label>
                            <input type="text" name="property_gata" class="form-control" value="{{ old('property_gata') }}" placeholder="जैसे: 45">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-uppercase text-muted">क्षेत्रफल *</label>
                            <input type="text" name="property_area" class="form-control" value="{{ old('property_area') }}" required placeholder="जैसे: 200 वर्ग मीटर">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-uppercase text-muted">प्रकार *</label>
                            <select name="property_type" class="form-select" required>
                                <option value="">चुनें…</option>
                                <option value="plot"       {{ old('property_type')=='plot'?'selected':'' }}>भूखंड (Plot)</option>
                                <option value="flat"       {{ old('property_type')=='flat'?'selected':'' }}>फ्लैट</option>
                                <option value="house"      {{ old('property_type')=='house'?'selected':'' }}>मकान</option>
                                <option value="commercial" {{ old('property_type')=='commercial'?'selected':'' }}>व्यावसायिक</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-uppercase text-muted">तहसील *</label>
                            <select name="tehsil" class="form-select" required>
                                <option value="">चुनें…</option>
                                <option value="sadar"        {{ old('tehsil')=='sadar'?'selected':'' }}>सदर (Sadar)</option>
                                <option value="bkt"          {{ old('tehsil')=='bkt'?'selected':'' }}>BKT</option>
                                <option value="mohanlalganj" {{ old('tehsil')=='mohanlalganj'?'selected':'' }}>मोहनलालगंज</option>
                                <option value="malihabad"    {{ old('tehsil')=='malihabad'?'selected':'' }}>मलिहाबाद</option>
                                <option value="other"        {{ old('tehsil')=='other'?'selected':'' }}>अन्य</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-uppercase text-muted">विक्रेता का नाम *</label>
                            <input type="text" name="seller_name" class="form-control" value="{{ old('seller_name') }}" required placeholder="विक्रेता का पूरा नाम">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-uppercase text-muted">मांगी गई कीमत (₹)</label>
                            <input type="number" name="asking_price" class="form-control" value="{{ old('asking_price') }}" min="0" placeholder="जैसे: 4500000">
                        </div>
                    </div>

                    <div class="section-title">🔍 सत्यापनकर्ता</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted">सत्यापनकर्ता का नाम</label>
                            <input type="text" name="verifier_name" class="form-control" value="{{ old('verifier_name') }}" placeholder="DSD स्टाफ का नाम">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-uppercase text-muted">भौतिक जाँच की तारीख</label>
                            <input type="date" name="verifier_visit_date" class="form-control" value="{{ old('verifier_visit_date') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-uppercase text-muted">नोट्स (आंतरिक)</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="आंतरिक नोट्स…">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary" style="background:#011f4b;border-color:#011f4b;">रिपोर्ट बनाएं &rarr;</button>
                        <a href="{{ route('ver.admin.index') }}" class="btn btn-outline-secondary">रद्द करें</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
