@extends('admin.layouts.legacy')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">{{ $gallery->name }}</h4>
            <span class="badge {{ $gallery->type === 'news_clipping' ? 'bg-info text-dark' : 'bg-success' }}">
                {{ $gallery->type === 'news_clipping' ? 'News Clipping' : 'Ground Reality' }}
            </span>
            <code class="ms-2">[gallery:{{ $gallery->slug }}]</code>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Galleries</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <p class="text-muted small">
        Paste <code>[gallery:{{ $gallery->slug }}]</code> anywhere inside a blog article's body to show this gallery there.
        {{ $gallery->type === 'news_clipping' ? 'Each image below is shown with its caption, source and publish date.' : 'Each image below is shown with its caption.' }}
    </p>

    <div class="row g-4">

        {{-- Upload + images --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="mb-3">Upload Images</h6>
                    <form method="POST" action="{{ route('admin.galleries.images.upload', $gallery) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*" required>
                            <button class="btn btn-primary" type="submit">Upload</button>
                        </div>
                        <div class="form-text">You can select multiple files at once. Max 5MB per image.</div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Images ({{ $gallery->images->count() }})</h6>

                    @forelse($gallery->images as $image)
                    <div class="d-flex gap-3 align-items-start border-bottom py-3">
                        <img src="{{ $image->url }}" alt="" style="width:110px;height:110px;object-fit:cover;border-radius:8px;border:1px solid #e5e7eb;">
                        <form method="POST" action="{{ route('admin.galleries.images.update', $image) }}" class="flex-grow-1 row g-2">
                            @csrf @method('PUT')
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Caption</label>
                                <input type="text" name="caption" value="{{ $image->caption }}" class="form-control form-control-sm">
                            </div>
                            @if($gallery->type === 'news_clipping')
                            <div class="col-md-3">
                                <label class="form-label small mb-1">Newspaper / Source</label>
                                <input type="text" name="source_name" value="{{ $image->source_name }}" class="form-control form-control-sm" placeholder="e.g. Amar Ujala">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small mb-1">Published Date</label>
                                <input type="date" name="published_on" value="{{ $image->published_on?->format('Y-m-d') }}" class="form-control form-control-sm">
                            </div>
                            @endif
                            <div class="col-md-2">
                                <label class="form-label small mb-1">Order</label>
                                <input type="number" name="sort_order" value="{{ $image->sort_order }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-auto d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-sm btn-outline-primary">Save</button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('admin.galleries.images.destroy', $image) }}" onsubmit="return confirm('Delete this image?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Del</button>
                        </form>
                    </div>
                    @empty
                    <p class="text-muted small mb-0">No images uploaded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Page links --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="mb-1">Shown On Pages</h6>
                    <p class="text-muted small">
                        Link this gallery to page URLs (e.g. <code>/services/property-registry-lucknow</code>) that have a <code>@@include('components.galleries-for-page', ...)</code> block. The same gallery can be linked to multiple pages.
                    </p>

                    <form method="POST" action="{{ route('admin.galleries.links.add', $gallery) }}" class="d-flex gap-2 mb-3">
                        @csrf
                        <input type="text" name="page_url" class="form-control form-control-sm" placeholder="/services/property-registry-lucknow" required>
                        <button class="btn btn-sm btn-outline-primary">Add</button>
                    </form>

                    <ul class="list-group list-group-flush">
                        @forelse($gallery->pageLinks as $link)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <code class="small">{{ $link->page_url }}</code>
                            <form method="POST" action="{{ route('admin.galleries.links.remove', $link) }}" onsubmit="return confirm('Remove this page link?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-link text-danger p-0">Remove</button>
                            </form>
                        </li>
                        @empty
                        <li class="list-group-item px-0 text-muted small">Not linked to any page yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
