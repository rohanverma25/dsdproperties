
@extends('admin.layouts.legacy')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Upload Leads (XLS)</h5>
                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="/admin/leads/upload" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Select Excel File
                            </label>
                            <input type="file" name="file" class="form-control" required>
                            <small class="text-muted">
                                Allowed format: .xls, .xlsx
                            </small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Upload & Import Leads
                            </button>
                        </div>
                    </form>

                </div>

                <div class="card-footer text-center text-muted small">
                    Bulk lead upload for CRM
                </div>
            </div>
        </div>
    </div>
</div>
@endsection