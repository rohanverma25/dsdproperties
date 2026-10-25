@extends('admin.layouts.app')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm border-0">
                
                <div class="card-header bg-dark text-white text-center">
                    <h5 class="mb-0">📧 Email Campaign</h5>
                </div>

                <div class="card-body p-4 text-center">

                    <p class="fs-5 mb-3">
                        Total Pending Leads:
                        <span class="badge bg-primary fs-6">
                            {{ $totalLeads }}
                        </span>
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="/admin/campaigns/start"
                          onsubmit="return confirm('Are you sure you want to start the campaign?')">
                        @csrf

                        <button type="submit" class="btn btn-success btn-lg px-5">
                            🚀 Start Campaign
                        </button>
                    </form>

                </div>

                <div class="card-footer text-muted text-center small">
                    Bulk email dispatch system
                </div>

            </div>
        </div>
    </div>
</div>

@endsection