@extends('admin.layouts.legacy')

@section('content')
<div class="container-fluid py-4" style="max-width:960px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ url('admin/properties') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
        <h5 class="mb-0">Review Property</h5>
        @php
            $badge = ['published'=>'success','pending'=>'warning','rejected'=>'danger','draft'=>'secondary','archived'=>'dark'][$property->status] ?? 'secondary';
        @endphp
        <span class="badge bg-{{ $badge }} fs-6">{{ ucfirst($property->status) }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="row g-4">

        {{-- Left: property details --}}
        <div class="col-lg-8">

            {{-- Images --}}
            @if($property->images->isNotEmpty() || $property->featured_image)
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-semibold">Photos</div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        @if($property->featured_image && file_exists(public_path($property->featured_image)))
                            <img src="{{ asset($property->featured_image) }}"
                                 style="height:120px;border-radius:8px;object-fit:cover;border:2px solid #0d6efd;" title="Featured Image" alt="Featured">
                        @endif
                        @foreach($property->images as $img)
                            <img src="{{ asset($img->image_path) }}"
                                 style="height:120px;border-radius:8px;object-fit:cover;" alt="">
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Basic info --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-semibold">Property Details</div>
                <div class="card-body">
                    <h5 class="mb-1">{{ $property->title }}</h5>
                    <div class="text-muted mb-3">{{ $property->address }}, {{ $property->locality }}
                        @if($property->landmark) · Near {{ $property->landmark }} @endif
                        @if($property->pincode) · {{ $property->pincode }} @endif
                    </div>

                    <div class="row g-3 mb-3">
                        @php
                            // Only the fields this property type actually uses — a plot
                            // project has no bedrooms, so the row is not printed at all.
                            $applies = fn ($f) => \App\Support\PropertyTypeSchema::appliesTo($property->property_type, $f);

                            $info = array_filter([
                                'Type'          => $property->getTypeLabel(),
                                'Transaction'   => ucfirst($property->transaction_type),
                                'Price'         => $property->getPriceDisplay() . ($property->price_negotiable ? ' (Negotiable)' : ''),
                                $property->getAreaLabel() => $property->area ? $property->area . ' ' . $property->getAreaUnitLabel() : null,
                                'Bedrooms'      => $applies('bedrooms')     ? $property->bedrooms : null,
                                'Bathrooms'     => $applies('bathrooms')    ? $property->bathrooms : null,
                                'Balconies'     => $applies('balconies')    ? $property->balconies : null,
                                'Floor'         => $applies('floor_no') && $property->floor_no !== null
                                    ? 'Floor ' . $property->floor_no . ($property->total_floors ? ' / ' . $property->total_floors : '')
                                    : null,
                                'Furnishing'    => $applies('furnishing')   ? $property->getFurnishingLabel() : null,
                                'Property Age'  => $applies('property_age') ? $property->getAgeLabel() : null,
                                'Facing'        => $applies('facing')       ? $property->facing : null,
                                'Parking'       => $applies('parking')      ? $property->parking : null,
                            ], fn ($v) => $v !== null && $v !== '');
                        @endphp
                        @foreach($info as $k => $v)
                        <div class="col-6 col-md-4">
                            <div class="text-muted" style="font-size:11.5px;text-transform:uppercase;letter-spacing:.05em;">{{ $k }}</div>
                            <div class="fw-semibold small">{{ $v }}</div>
                        </div>
                        @endforeach
                    </div>

                    @php $typeRows = $property->getDetailRows(); @endphp
                    @if(count($typeRows))
                    <div class="mb-3">
                        <div class="text-muted mb-1" style="font-size:11.5px;text-transform:uppercase;letter-spacing:.05em;">
                            {{ $property->getTypeLabel() }} Details
                        </div>
                        <div class="row g-3">
                            @foreach($typeRows as $k => $v)
                            <div class="col-6 col-md-4">
                                <div class="text-muted" style="font-size:11.5px;">{{ $k }}</div>
                                <div class="fw-semibold small">{{ $v }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @php $seg = $property->plot_segments ?? []; @endphp
                    @if($property->is_site && (!empty($seg['segments']) || !empty($seg['total_plots'])))
                    <div class="mb-3">
                        <div class="text-muted mb-1" style="font-size:11.5px;text-transform:uppercase;letter-spacing:.05em;">
                            Plot Sizes &amp; Inventory
                        </div>
                        <div class="small mb-2">
                            @if(!empty($seg['total_plots'])) {{ $seg['total_plots'] }} plots @endif
                            @if(!empty($seg['min_area']) && !empty($seg['max_area']))
                                · {{ $seg['min_area'] }}–{{ $seg['max_area'] }} {{ $seg['unit'] ?? '' }}
                            @endif
                        </div>
                        @if(!empty($seg['segments']))
                        <table class="table table-sm table-bordered mb-0">
                            <thead><tr><th>Plot Size / Type</th><th>Area</th><th>Price / Rate</th></tr></thead>
                            <tbody>
                                @foreach($seg['segments'] as $row)
                                <tr>
                                    <td>{{ $row['label'] ?? '—' }}</td>
                                    <td>{{ $row['area'] ?? '—' }} {{ $seg['unit'] ?? '' }}</td>
                                    <td>{{ !empty($row['price']) ? '₹ ' . number_format((float) $row['price']) : '—' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                    @endif

                    @if(count($property->getAmenityList()))
                    <div class="mb-3">
                        <div class="text-muted mb-1" style="font-size:11.5px;text-transform:uppercase;letter-spacing:.05em;">Amenities</div>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($property->getAmenityList() as $a)
                                <span class="badge bg-light text-dark border">{{ $a }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <div class="text-muted mb-1" style="font-size:11.5px;text-transform:uppercase;letter-spacing:.05em;">Description</div>
                        <p class="small" style="white-space:pre-line;">{{ $property->description }}</p>
                    </div>
                </div>
            </div>

            {{-- Inquiries --}}
            @if($property->inquiries->isNotEmpty())
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">Recent Inquiries ({{ $property->inquiries->count() }})</div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light"><tr><th>Name</th><th>Phone</th><th>Email</th><th>Message</th><th>Date</th></tr></thead>
                        <tbody>
                            @foreach($property->inquiries as $inq)
                            <tr>
                                <td class="small fw-semibold">{{ $inq->name }}</td>
                                <td class="small"><a href="tel:{{ $inq->phone }}">{{ $inq->phone }}</a></td>
                                <td class="small">{{ $inq->email ?? '—' }}</td>
                                <td class="small">{{ Str::limit($inq->message, 60) }}</td>
                                <td class="small text-muted">{{ $inq->created_at?->format('d M') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        {{-- Right: seller info + status action --}}
        <div class="col-lg-4">

            {{-- Seller --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header fw-semibold">Seller Info</div>
                <div class="card-body">
                    @if($property->seller)
                    <div class="fw-bold">{{ $property->seller->name }}</div>
                    <div class="text-muted small mb-2">{{ $property->seller->email }}</div>
                    <a href="tel:{{ $property->seller->phone }}" class="btn btn-sm btn-outline-success me-1">
                        📞 {{ $property->seller->phone }}
                    </a>
                    @if($property->seller->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $property->seller->whatsapp) }}"
                       target="_blank" class="btn btn-sm btn-outline-success">
                        💬 WhatsApp
                    </a>
                    @endif
                    @if($property->seller->about)
                    <p class="small text-muted mt-2 mb-0">{{ $property->seller->about }}</p>
                    @endif
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </div>
            </div>

            {{-- Status Change --}}
            <div class="card shadow-sm border-primary">
                <div class="card-header fw-semibold bg-primary text-white">Change Status</div>
                <div class="card-body">
                    @if($property->rejection_reason)
                    <div class="alert alert-danger py-2 small mb-3">
                        <strong>Current rejection reason:</strong><br>{{ $property->rejection_reason }}
                    </div>
                    @endif

                    <form method="POST" action="{{ url('admin/properties/'.$property->id.'/status') }}" id="statusForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Set Status</label>
                            <div class="d-flex flex-column gap-2">
                                @foreach([
                                    'published' => ['success', '✅ Publish — make it live'],
                                    'pending'   => ['warning', '⏳ Move back to Pending'],
                                    'rejected'  => ['danger',  '❌ Reject'],
                                    'archived'  => ['secondary','📦 Archive'],
                                ] as $val => [$color, $label])
                                <label class="d-flex align-items-center gap-2 p-2 rounded border cursor-pointer
                                    {{ $property->status === $val ? 'border-'.$color.' bg-'.$color.' bg-opacity-10' : '' }}"
                                    style="cursor:pointer;">
                                    <input type="radio" name="status" value="{{ $val }}"
                                        {{ $property->status === $val ? 'checked' : '' }}
                                        onchange="toggleRejectReason(this.value)">
                                    <span class="small fw-semibold">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="rejectReasonWrap" style="display:{{ $property->status === 'rejected' ? 'block' : 'none' }};" class="mb-3">
                            <label class="form-label fw-semibold text-danger">Rejection Reason <span class="text-danger">*</span></label>
                            <textarea name="rejection_reason" class="form-control" rows="3"
                                placeholder="Tell the seller what needs to be fixed...">{{ old('rejection_reason', $property->rejection_reason) }}</textarea>
                            <div class="form-text">This is shown to the seller in their dashboard.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Status</button>
                    </form>

                    <hr>
                    <form method="POST" action="{{ url('admin/properties/'.$property->id.'/delete') }}"
                          onsubmit="return confirm('Permanently delete this property? This cannot be undone.');">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm w-100">🗑 Delete Property</button>
                    </form>
                </div>
            </div>

            {{-- Meta --}}
            <div class="card shadow-sm mt-3">
                <div class="card-body small text-muted">
                    <div><strong>Submitted:</strong> {{ $property->created_at?->format('d M Y, h:i A') }}</div>
                    <div><strong>Last updated:</strong> {{ $property->updated_at?->format('d M Y, h:i A') }}</div>
                    <div><strong>Views:</strong> {{ number_format($property->views) }}</div>
                    <div><strong>Slug:</strong> <code>{{ $property->slug }}</code></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleRejectReason(val) {
    document.getElementById('rejectReasonWrap').style.display = (val === 'rejected') ? 'block' : 'none';
}
</script>
@endsection
