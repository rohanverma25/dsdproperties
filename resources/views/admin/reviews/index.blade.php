@extends('admin.layouts.legacy')

@push('scripts')
<style>
/* Category tag pills — a small reusable control, not a competing design system */
.tag-group { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 4px; }
.tag-check { display: none; }
.tag-label {
    display: inline-block; padding: 5px 14px; border-radius: 99px; font-size: .78rem;
    font-weight: 600; cursor: pointer; border: 1.5px solid #dee2e6;
    background: #f8f9fa; color: #495057; transition: all .18s; user-select: none;
}
.tag-check:checked + .tag-label { background: #011f4b; color: #fff; border-color: #011f4b; }
.reviewer-avatar {
    width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #011f4b, #008080);
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 700; color: #fff;
}
.review-card.inactive { opacity: .6; }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    <div class="page-header">
        <div>
            <h4>⭐ Google Reviews</h4>
            <p class="page-subtitle">Manage the Google reviews displayed on blog articles. Leave tags empty to show a review on <strong>all</strong> pages.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Add Review Form --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h6 class="mb-3">+ Add New Review</h6>
            <form method="POST" action="{{ route('admin.reviews.store') }}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label class="form-label small text-uppercase text-muted">Reviewer Name *</label>
                    <input type="text" name="reviewer_name" class="form-control" placeholder="e.g. Priya Sharma" required maxlength="100">
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-uppercase text-muted">Rating *</label>
                    <select name="rating" class="form-select" required>
                        <option value="5" selected>★★★★★ (5)</option>
                        <option value="4">★★★★☆ (4)</option>
                        <option value="3">★★★☆☆ (3)</option>
                        <option value="2">★★☆☆☆ (2)</option>
                        <option value="1">★☆☆☆☆ (1)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-uppercase text-muted">Review Date *</label>
                    <input type="date" name="review_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small text-uppercase text-muted">Sort Order <span class="text-normal">(0 = first)</span></label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0" max="9999">
                </div>
                <div class="col-12">
                    <label class="form-label small text-uppercase text-muted">Review Text *</label>
                    <textarea name="review_text" class="form-control" rows="3" placeholder="Paste the review content here…" required maxlength="2000"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label small text-uppercase text-muted">Show On Categories <span class="text-normal">(leave empty = show on all pages)</span></label>
                    <div class="tag-group">
                        @foreach($categories as $cat)
                        <input type="checkbox" class="tag-check" name="tags[]" value="{{ $cat }}" id="add-tag-{{ $loop->index }}">
                        <label class="tag-label" for="add-tag-{{ $loop->index }}">{{ $cat }}</label>
                        @endforeach
                    </div>
                    <p class="small text-muted mt-1">Select one or more categories. Unselected = displayed on every blog page.</p>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Add Review</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Reviews List --}}
    @forelse($reviews as $review)
    <div class="card shadow-sm mb-3 review-card {{ $review->is_active ? '' : 'inactive' }}" id="card-{{ $review->id }}">
        <div class="card-body">
            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                <div class="reviewer-avatar">{{ strtoupper(substr($review->reviewer_name, 0, 1)) }}</div>
                <div>
                    <div class="fw-bold">{{ $review->reviewer_name }}</div>
                    <div class="text-warning small">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $review->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                </div>
                <div class="small text-muted">{{ $review->review_date->format('M d, Y') }}</div>
                <span class="badge {{ $review->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $review->is_active ? 'Active' : 'Hidden' }}</span>
                <span class="small text-muted ms-auto">Order: {{ $review->sort_order }}</span>
            </div>

            <p class="mb-2">{{ $review->review_text }}</p>

            <div class="mb-3">
                @if(!empty($review->tags))
                    @foreach($review->tags as $t)
                    <span class="badge bg-info text-dark me-1">{{ $t }}</span>
                    @endforeach
                @else
                    <span class="small text-muted">Shows on all pages</span>
                @endif
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="collapse" data-bs-target="#edit-{{ $review->id }}">✏ Edit</button>

                <form method="POST" action="{{ route('admin.reviews.toggle', $review) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm {{ $review->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                        {{ $review->is_active ? '👁 Hide' : '👁 Show' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}"
                      onsubmit="return confirm('Delete this review permanently?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Delete</button>
                </form>
            </div>

            {{-- Inline Edit Form --}}
            <div class="collapse mt-3 pt-3 border-top" id="edit-{{ $review->id }}">
                <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="row g-3">
                    @csrf @method('PUT')
                    <div class="col-md-6">
                        <label class="form-label small text-uppercase text-muted">Reviewer Name</label>
                        <input type="text" name="reviewer_name" class="form-control" value="{{ e($review->reviewer_name) }}" required maxlength="100">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-uppercase text-muted">Rating</label>
                        <select name="rating" class="form-select" required>
                            @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                                {{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }} ({{ $i }})
                            </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-uppercase text-muted">Review Date</label>
                        <input type="date" name="review_date" class="form-control" value="{{ $review->review_date->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small text-uppercase text-muted">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ $review->sort_order }}" min="0" max="9999">
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-uppercase text-muted">Review Text</label>
                        <textarea name="review_text" class="form-control" rows="3" required maxlength="2000">{{ e($review->review_text) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label small text-uppercase text-muted">Show On Categories <span class="text-normal">(leave empty = show on all pages)</span></label>
                        <div class="tag-group">
                            @foreach($categories as $cat)
                            @php $eid = 'edit-tag-'.$review->id.'-'.$loop->index; @endphp
                            <input type="checkbox" class="tag-check" name="tags[]" value="{{ $cat }}" id="{{ $eid }}"
                                {{ is_array($review->tags) && in_array($cat, $review->tags) ? 'checked' : '' }}>
                            <label class="tag-label" for="{{ $eid }}">{{ $cat }}</label>
                            @endforeach
                        </div>
                        <p class="small text-muted mt-1">Select one or more categories. Unselected = displayed on every blog page.</p>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#edit-{{ $review->id }}">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">No reviews yet. Add your first review above.</div>
    @endforelse

</div>
@endsection
