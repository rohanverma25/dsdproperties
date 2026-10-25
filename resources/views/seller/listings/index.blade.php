@extends('seller.layouts.app')
@section('title', 'My Listings')
@section('page-title', 'My Listings')

@section('content')
<div class="sp-card">
    <div class="sp-card-header">
        <span class="sp-card-title">All Properties ({{ $listings->total() }})</span>
        <a href="{{ route('seller.listings.create') }}" class="sp-btn sp-btn-primary sp-btn-sm">+ Post New Property</a>
    </div>

    @if($listings->isEmpty())
        <div style="padding:48px;text-align:center;color:#94a3b8;">
            <div style="font-size:48px;margin-bottom:12px;">🏠</div>
            <div style="font-size:16px;font-weight:600;color:#64748b;margin-bottom:6px;">No listings yet</div>
            <div style="font-size:13px;margin-bottom:20px;">Start listing your properties — it's free and easy!</div>
            <a href="{{ route('seller.listings.create') }}" class="sp-btn sp-btn-primary">Post Your First Property</a>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th style="min-width:260px;">Property</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Inquiries</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listings as $l)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                @if($l->featured_image && file_exists(public_path($l->featured_image)))
                                    <img src="{{ asset($l->featured_image) }}" style="width:56px;height:44px;border-radius:7px;object-fit:cover;flex-shrink:0;" alt="">
                                @elseif($l->images->first())
                                    <img src="{{ asset($l->images->first()->image_path) }}" style="width:56px;height:44px;border-radius:7px;object-fit:cover;flex-shrink:0;" alt="">
                                @else
                                    <div style="width:56px;height:44px;border-radius:7px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">🏠</div>
                                @endif
                                <div>
                                    <div style="font-weight:600;font-size:13.5px;color:#011f4b;">{{ Str::limit($l->title, 45) }}</div>
                                    <div style="font-size:12px;color:#64748b;margin-top:2px;">📍 {{ $l->locality }}</div>
                                    @if($l->status === 'rejected' && $l->rejection_reason)
                                        <div style="font-size:11.5px;color:#dc2626;margin-top:3px;">Reason: {{ Str::limit($l->rejection_reason, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12.5px;">{{ $l->getTypeLabel() }}</div>
                            <div style="font-size:11.5px;color:#64748b;">{{ ucfirst($l->transaction_type) }}</div>
                        </td>
                        <td style="font-weight:600;color:#011f4b;white-space:nowrap;">{{ $l->getPriceDisplay() }}</td>
                        <td><span class="sp-badge sp-badge-{{ $l->status }}">{{ ucfirst($l->status) }}</span></td>
                        <td style="color:#64748b;">{{ number_format($l->views) }}</td>
                        <td>
                            <a href="{{ route('seller.listings.inquiries', $l) }}" style="color:#008080;text-decoration:none;font-size:13px;">
                                {{ $l->inquiries_count ?? 0 }} →
                            </a>
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                @if($l->status === 'published')
                                    <a href="{{ route('properties.show', $l->slug) }}" target="_blank" class="sp-btn sp-btn-outline sp-btn-sm">View</a>
                                @endif
                                <a href="{{ route('seller.listings.edit', $l) }}" class="sp-btn sp-btn-outline sp-btn-sm">Edit</a>
                                <form method="POST" action="{{ route('seller.listings.destroy', $l) }}" onsubmit="return confirm('Delete this listing permanently?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="sp-btn sp-btn-danger sp-btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($listings->hasPages())
        <div style="padding:16px 22px;border-top:1px solid #e2e8f0;">
            <div class="sp-pagination">
                @if($listings->onFirstPage())
                    <span>‹ Prev</span>
                @else
                    <a href="{{ $listings->previousPageUrl() }}">‹ Prev</a>
                @endif

                @foreach($listings->getUrlRange(1, $listings->lastPage()) as $page => $url)
                    @if($page == $listings->currentPage())
                        <span class="active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach

                @if($listings->hasMorePages())
                    <a href="{{ $listings->nextPageUrl() }}">Next ›</a>
                @else
                    <span>Next ›</span>
                @endif
            </div>
        </div>
        @endif
    @endif
</div>
@endsection

@push('scripts')
<script>
// Preload inquiries count
document.querySelectorAll('[data-inq-url]').forEach(el => {
    fetch(el.dataset.inqUrl).then(r=>r.json()).then(d=>{ el.textContent = d.count + ' →'; });
});
</script>
@endpush
