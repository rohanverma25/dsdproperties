<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'सत्यापन रिपोर्ट') — Verification Admin</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
body { background:#f1f5f9; }
.page-header { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:1rem; }
.page-header h4 { margin:0; }
.page-header .page-subtitle { font-size:.82rem; color:#6c757d; margin:2px 0 0; }
.empty-state { text-align:center; padding:48px 20px; color:#6c757d; font-size:.9rem; }
.ver-topbar { background:#011f4b; }
.ver-topbar .navbar-brand { color:#fff; font-weight:800; }
.ver-topbar .navbar-brand span { color:#FF5C00; }
.ver-topbar a.nav-link { color:rgba(255,255,255,.75); }
.ver-topbar a.nav-link:hover { color:#fff; }
.verdict-pill.v-green  { background:#d1e7dd; color:#0f5132; }
.verdict-pill.v-amber  { background:#fff3cd; color:#664d03; }
.verdict-pill.v-red    { background:#f8d7da; color:#842029; }
.verdict-pill.v-none   { background:#e9ecef; color:#6c757d; }
</style>
@stack('styles')
</head>
<body>

<nav class="navbar navbar-dark ver-topbar shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand">DSD <span>Properties</span> — Verification Admin</span>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('ver.admin.index') }}" class="nav-link">📋 रिपोर्ट</a>
            @if(Route::has('ver.admin.logout'))
            <form method="POST" action="{{ route('ver.admin.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
            </form>
            @endif
        </div>
    </div>
</nav>

<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
