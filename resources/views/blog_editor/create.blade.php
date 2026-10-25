@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between mb-4">
        <h2>Create New Blog Post</h2>
        <a href="{{ route('blog_editor.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <form action="{{ route('blog_editor.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">SEO & Media</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Featured Image URL</label>
                            <input type="text" name="featured_image" class="form-control" placeholder="https://...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image Alt Text</label>
                            <input type="text" name="alt" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SEO Schema (JSON)</label>
                            <textarea name="seo_schema" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">Settings</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Language</label>
                            <input type="text" name="language" class="form-control" value="en">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100 shadow">PUBLISH BLOG</button>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">Main Content</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" required placeholder="example-blog-post">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Blog Summary</label>
                            <textarea name="blog_summary" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">HTML Content</label>
                            <textarea name="content_html" id="editor" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection