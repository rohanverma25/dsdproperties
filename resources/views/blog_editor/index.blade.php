@extends('admin.layouts.app')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="mb-0 fw-bold">All Blogs <span class="badge bg-secondary">{{ $blogs->count() }}</span></h5>
    <a href="{{ route('blog_editor.create') }}" class="btn btn-primary btn-sm">+ New Blog</a>
</div>

<table class="display w-100" id="blogsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Updated</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($blogs as $blog)
        <tr>
            <td>{{ $blog->id }}</td>
            <td>
                <a href="https://www.dsdproperties.in/blog/{{ $blog->slug }}" target="_blank" class="text-decoration-none fw-semibold">
                    {{ $blog->title }}
                </a>
            </td>
            <td>
                <span class="badge {{ $blog->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($blog->status) }}
                </span>
            </td>
            {{-- data-order stores Unix timestamp for correct DataTables sorting --}}
            <td data-order="{{ $blog->updated_at?->timestamp ?? 0 }}">
                {{ $blog->updated_at?->format('d M Y, H:i') ?? '—' }}
            </td>
            <td class="text-nowrap text-center">
                <div class="d-flex gap-1 justify-content-center">
                    <a href="{{ route('blog_editor.full_edit', $blog->id) }}" class="btn btn-warning btn-sm" title="Full Edit">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('blog_editor.toggle_status', $blog->id) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $blog->status === 'published' ? 'btn-success' : 'btn-outline-secondary' }}" title="Toggle Status">
                            <i class="fas {{ $blog->status === 'published' ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                        </button>
                    </form>

                    <a href="{{ route('blog_editor.preview', $blog->id) }}" class="btn btn-info btn-sm" target="_blank" title="Preview">
                        <i class="fas fa-search"></i>
                    </a>

                    <form action="{{ route('blog_editor.destroy', $blog->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this blog permanently?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
$(document).ready(function () {
    // Destroy if admin layout already initialised the table, then re-init with our settings
    if ($.fn.dataTable.isDataTable('#blogsTable')) {
        $('#blogsTable').DataTable().destroy();
    }
    $('#blogsTable').DataTable({
        pageLength: 25,
        order:      [[3, 'desc']],          // Sort by "Updated" column (index 3) descending
        columnDefs: [
            { orderable: false, targets: 4 } // Actions column — not sortable
        ],
        lengthMenu: [10, 25, 50, 100],
        searching:  true,
        responsive: true,
    });
});
</script>

@endsection
