@extends('admin.layouts.legacy')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card shadow border-0">
                
                <!-- Card Header -->
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">✉️ Create Email Template</h5>
                </div>

                <div class="card-body p-4">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="/admin/templates">
                        @csrf

                        <!-- Template Name -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Template Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="e.g. Web Services Intro"
                                   required>
                        </div>

                        <!-- Email Subject -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Subject</label>
                            <input type="text"
                                   name="subject"
                                   class="form-control"
                                   placeholder="e.g. Let’s build something great together"
                                   required>
                        </div>

                        <!-- Segment -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Target Segment</label>
                            <select name="segment" class="form-select">
                                <option value="">General</option>
                                <option value="web">Web</option>
                                <option value="mobile">Mobile</option>
                                <option value="crm">CRM</option>
                                <option value="iot">IoT</option>
                            </select>
                        </div>

                        <!-- Email Body -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email Body</label>
                            <textarea name="body"
                                      rows="7"
                                      class="form-control"
                                      placeholder="Hi {{ '{name}' }},&#10;&#10;We specialize in..."
                                      required></textarea>
                            <small class="text-muted">
                                You can use <code>{name}</code> to personalize emails.
                            </small>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4">
                                💾 Save Template
                            </button>
                        </div>

                    </form>

                </div>

                <!-- Footer -->
                <div class="card-footer text-muted small text-center">
                    Email templates for cold email & campaign automation
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
