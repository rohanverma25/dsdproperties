@extends('admin.layouts.legacy')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Galleries</h4>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary btn-sm">+ New Gallery</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="mb-3 d-flex flex-wrap gap-2">
        @foreach(['' => 'All', 'news_clipping' => 'News Clippings', 'ground_reality' => 'Ground Reality'] as $val => $label)
        <a href="{{ route('admin.galleries.index') }}?type={{ $val }}"
           class="badge fs-6 text-decoration-none {{ request('type', '') === $val ? 'bg-primary text-white' : 'bg-light text-dark border' }}"
           style="padding:6px 14px;border-radius:20px;">{{ $label }}</a>
        @endforeach
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:36px;">#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Shortcode</th>
                        <th>Images</th>
                        <th style="width:120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galleries as $gallery)
                    <tr>
                        <td class="text-muted small">{{ $gallery->id }}</td>
                        <td class="fw-semibold">{{ $gallery->name }}</td>
                        <td>
                            <span class="badge {{ $gallery->type === 'news_clipping' ? 'bg-info text-dark' : 'bg-success' }}">
                                {{ $gallery->type === 'news_clipping' ? 'News Clipping' : 'Ground Reality' }}
                            </span>
                        </td>
                        <td><code>[gallery:{{ $gallery->slug }}]</code></td>
                        <td class="small">{{ $gallery->images_count }}</td>
                        <td>
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="btn btn-sm btn-outline-primary me-1">Manage</a>
                            <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" style="display:inline;" onsubmit="return confirm('Delete this gallery and all its images?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Del</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">No galleries yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($galleries->hasPages())
    <div class="mt-3">{{ $galleries->links() }}</div>
    @endif

</div>
@endsection
