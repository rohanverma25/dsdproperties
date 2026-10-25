@extends('admin.layouts.legacy')

@section('content')
<div class="container-fluid py-4">

    <h4 class="mb-3">New Gallery</h4>

    <div class="card shadow-sm" style="max-width:560px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.galleries.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select" required>
                        <option value="news_clipping">News Clipping</option>
                        <option value="ground_reality">Ground Reality</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Amrapali Case Coverage">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description (optional, internal note)</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                @error('name')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                @error('type')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

                <button type="submit" class="btn btn-primary">Create Gallery</button>
                <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

</div>
@endsection
