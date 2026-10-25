@extends('admin.verifications.layout')

@section('title', 'सत्यापन रिपोर्ट')

@section('content')

<div class="page-header">
    <div>
        <h4>संपत्ति सत्यापन रिपोर्ट</h4>
        <p class="page-subtitle">कुल {{ $reports->total() }} रिपोर्ट</p>
    </div>
    <a href="{{ route('ver.admin.create') }}" class="btn btn-primary" style="background:#011f4b;border-color:#011f4b;">+ नई रिपोर्ट</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-6">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="रिपोर्ट ID / नाम / फ़ोन खोजें…">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">सभी स्थिति</option>
            <option value="draft"            {{ request('status')=='draft'?'selected':'' }}>ड्राफ्ट</option>
            <option value="in_progress"      {{ request('status')=='in_progress'?'selected':'' }}>प्रगति में</option>
            <option value="ready_to_deliver" {{ request('status')=='ready_to_deliver'?'selected':'' }}>वितरण के लिए तैयार</option>
            <option value="delivered"        {{ request('status')=='delivered'?'selected':'' }}>वितरित</option>
        </select>
    </div>
    <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-outline-primary">खोजें</button>
        <a href="{{ route('ver.admin.index') }}" class="btn btn-outline-secondary">रीसेट</a>
    </div>
</form>

<div class="card shadow-sm">
    <div class="table-responsive">
        @if($reports->isEmpty())
        <div class="empty-state">कोई रिपोर्ट नहीं मिली।</div>
        @else
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>रिपोर्ट ID</th>
                    <th>ग्राहक</th>
                    <th>फ़ोन</th>
                    <th>संपत्ति</th>
                    <th>निर्णय</th>
                    <th>स्थिति</th>
                    <th>तारीख</th>
                    <th>कार्रवाई</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $r)
                <tr>
                    <td class="fw-bold small" style="color:#011f4b;">{{ $r->report_id }}</td>
                    <td>{{ $r->customer_name }}</td>
                    <td>{{ $r->customer_phone }}</td>
                    <td class="small text-truncate" style="max-width:180px;" title="{{ $r->property_address }}">
                        {{ \Illuminate\Support\Str::limit($r->property_address, 35) }}
                    </td>
                    <td>
                        @if($r->verdict)
                        <span class="badge verdict-pill v-{{ $r->verdict }}">
                            {{ $r->verdict === 'green' ? '✅ सुरक्षित' : ($r->verdict === 'amber' ? '⚠️ सावधानी' : '❌ न खरीदें') }}
                        </span>
                        @else
                        <span class="badge verdict-pill v-none">लंबित</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $statusBadge = ['draft'=>'secondary','in_progress'=>'primary','ready_to_deliver'=>'warning','delivered'=>'success'][$r->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusBadge }}">{{ $r->status_label }}</span>
                    </td>
                    <td class="small text-nowrap">{{ $r->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('ver.admin.edit', $r) }}" class="btn btn-sm btn-outline-primary">संपादन</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<div class="mt-3">{{ $reports->links('pagination::simple-default') }}</div>

@endsection
