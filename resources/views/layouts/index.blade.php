@extends('admin.layouts.app')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Property Listings</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Status filter tabs --}}
    <div class="mb-3 d-flex flex-wrap gap-2">
        @foreach([''=>'All','pending'=>'Pending','published'=>'Published','rejected'=>'Rejected','draft'=>'Draft'] as $val => $label)
        <a href="{{ url('admin/properties') }}?status={{ $val }}&q={{ request('q') }}"
           class="badge fs-6 text-decoration-none
               {{ request('status', '') === $val
                   ? 'bg-primary text-white'
                   : 'bg-light text-dark border' }}"
           style="padding:6px 14px;border-radius:20px;">
            {{ $label }}
            <span class="ms-1">
                ({{ $val === '' ? $counts['all'] : ($counts[$val] ?? 0) }})
            </span>
        </a>
        @endforeach
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ url('admin/properties') }}" class="mb-3">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <div class="input-group" style="max-width:380px;">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                placeholder="Search title or locality...">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:36px;">#</th>
                        <th>Property</th>
                        <th>Seller</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th style="width:140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listings as $listing)
                    <tr>
                        <td class="text-muted small">{{ $listing->id }}</td>
                        <td>
                            <div class="fw-semibold">{{ Str::limit($listing->title, 45) }}</div>
                            <div class="text-muted small">{{ $listing->locality }}
                                @if($listing->pincode) · {{ $listing->pincode }} @endif
                            </div>
                            @if($listing->status === 'rejected' && $listing->rejection_reason)
                                <div class="text-danger small mt-1">
                                    <i>Reason: {{ Str::limit($listing->rejection_reason, 60) }}</i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="small fw-semibold">{{ $listing->seller->name ?? '—' }}</div>
                            <div class="text-muted" style="font-size:11px;">{{ $listing->seller->phone ?? '' }}</div>
                        </td>
                        <td class="small">{{ $listing->getTypeLabel() }}<br>
                            <span class="text-muted">{{ ucfirst($listing->transaction_type) }}</span>
                        </td>
                        <td class="small fw-semibold">{{ $listing->getPriceDisplay() }}</td>
                        <td>
                            @php
                            $badge = ['published'=>'success','pending'=>'warning','rejected'=>'danger','draft'=>'secondary','archived'=>'dark'][$listing->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($listing->status) }}</span>
                        </td>
                        <td class="small text-muted">{{ $listing->created_at?->format('d M Y') }}</td>
                        <td>
                            <a href="{{ url('admin/properties/'.$listing->id) }}"
                               class="btn btn-sm btn-outline-primary me-1">Review</a>
                            <form method="POST" action="{{ url('admin/properties/'.$listing->id.'/delete') }}"
                                  style="display:inline;"
                                  onsubmit="return confirm('Delete this property permanently?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Del</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">No listings found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if($listings->hasPages())
    <div class="mt-3">{{ $listings->links() }}</div>
    @endif

</div>
@endsection
