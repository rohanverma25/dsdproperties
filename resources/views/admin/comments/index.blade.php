@extends('admin.layouts.legacy')

@section('content')
<div class="container-fluid py-4">

    <div class="page-header">
        <div>
            <h4>Blog Comments</h4>
            <p class="page-subtitle">Review and moderate reader comments before they appear publicly.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    <div class="filter-pills">
        @foreach(['pending' => '⏳ Pending', 'approved' => '✓ Approved', 'spam' => '🚫 Spam'] as $val => $label)
        <a href="{{ route('admin.comments.index', ['status' => $val]) }}"
           class="badge text-decoration-none {{ $status === $val ? 'bg-primary text-white' : 'bg-light text-dark border' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    @forelse($comments as $comment)
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center gap-2 small text-muted mb-2">
                <span class="fw-bold text-dark">{{ $comment->name }}</span>
                <span>{{ $comment->email }}</span>
                @php
                    $badge = ['pending' => 'warning', 'approved' => 'success', 'spam' => 'danger'][$comment->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $badge }}">{{ ucfirst($comment->status) }}</span>
                <span>{{ $comment->created_at->format('M d, Y · g:i A') }}</span>
                @if($comment->post)
                <a href="{{ route('blog.show', $comment->post->slug) }}" class="text-decoration-none" target="_blank">
                    📄 {{ Str::limit($comment->post->title, 55) }}
                </a>
                @endif
            </div>
            <p class="mb-3" style="white-space:pre-wrap; word-break:break-word;">{{ $comment->comment }}</p>
            <div class="d-flex gap-2 flex-wrap">
                @if($comment->status !== 'approved')
                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-success">✓ Approve</button>
                </form>
                @endif
                @if($comment->status !== 'spam')
                <form method="POST" action="{{ route('admin.comments.spam', $comment) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-warning">🚫 Mark Spam</button>
                </form>
                @endif
                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                      onsubmit="return confirm('Delete this comment permanently?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">No {{ $status }} comments found.</div>
    @endforelse

    <div class="mt-3">{{ $comments->withQueryString()->links() }}</div>

</div>
@endsection
