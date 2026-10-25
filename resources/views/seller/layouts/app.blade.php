<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Seller Dashboard') — DSD Properties</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Installable seller app. Scope is /seller/ only; the public site is untouched. --}}
    <link rel="manifest" href="/seller-app/manifest.webmanifest">
    <meta name="theme-color" content="#011f4b">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="DSD Seller">
    <link rel="apple-touch-icon" href="/seller-app/apple-touch-icon.png">
    <link rel="icon" href="/seller-app/icon-192.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy:   #011f4b;
            --teal:   #008080;
            --orange: #FF5C00;
            --light:  #f4f7fb;
            --border: #e2e8f0;
            --text:   #1a2235;
            --muted:  #64748b;
            --green:  #16a34a;
            --red:    #dc2626;
            --yellow: #ca8a04;
            --sidebar-w: 240px;
        }
        body { font-family: 'Poppins', sans-serif; background: var(--light); color: var(--text); font-size: 14px; }

        /* Sidebar */
        .sp-sidebar {
            position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh;
            background: var(--navy); display: flex; flex-direction: column; z-index: 100;
            transition: transform .25s ease;
        }
        .sp-logo {
            padding: 20px 22px; border-bottom: 1px solid rgba(255,255,255,.1);
            font-size: 17px; font-weight: 700; color: #fff; text-decoration: none;
            display: flex; align-items: center; gap: 10px; line-height: 1.2;
        }
        .sp-logo span { color: var(--teal); }
        .sp-logo small { display: block; font-size: 10px; font-weight: 400; color: rgba(255,255,255,.5); }
        .sp-nav { flex: 1; padding: 16px 0; overflow-y: auto; }
        .sp-nav-label {
            padding: 8px 22px 4px; font-size: 10px; font-weight: 600; letter-spacing: .08em;
            color: rgba(255,255,255,.35); text-transform: uppercase;
        }
        .sp-nav a {
            display: flex; align-items: center; gap: 10px; padding: 10px 22px;
            color: rgba(255,255,255,.7); text-decoration: none; font-size: 13.5px;
            border-left: 3px solid transparent; transition: all .15s;
        }
        .sp-nav a:hover, .sp-nav a.active {
            color: #fff; background: rgba(255,255,255,.07); border-left-color: var(--teal);
        }
        .sp-nav a svg { width: 17px; height: 17px; flex-shrink: 0; }
        .sp-footer { padding: 16px 22px; border-top: 1px solid rgba(255,255,255,.1); }
        .sp-seller-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .sp-avatar {
            width: 36px; height: 36px; border-radius: 50%; object-fit: cover;
            background: var(--teal); display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: #fff; font-size: 14px; flex-shrink: 0;
        }
        .sp-seller-name { font-size: 13px; font-weight: 600; color: #fff; }
        .sp-seller-role { font-size: 11px; color: rgba(255,255,255,.45); }
        .sp-logout {
            display: flex; align-items: center; gap: 8px; padding: 8px 12px;
            background: rgba(255,255,255,.07); border-radius: 8px; color: rgba(255,255,255,.6);
            text-decoration: none; font-size: 12.5px; transition: all .15s; width: 100%;
            border: none; cursor: pointer;
        }
        .sp-logout:hover { background: rgba(220,38,38,.2); color: #fca5a5; }

        /* Top bar */
        .sp-topbar {
            margin-left: var(--sidebar-w); background: #fff; padding: 0 28px;
            height: 60px; display: flex; align-items: center; justify-content: space-between;
            border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 90;
        }
        .sp-topbar-title { font-size: 15px; font-weight: 600; }
        .sp-topbar-right { display: flex; align-items: center; gap: 12px; }
        .sp-btn-new {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--teal); color: #fff; padding: 7px 16px; border-radius: 8px;
            text-decoration: none; font-size: 13px; font-weight: 500; transition: background .15s;
        }
        .sp-btn-new:hover { background: #006666; }
        .sp-hamburger { display: none; background: none; border: none; cursor: pointer; padding: 4px; }

        /* Main content */
        .sp-main { margin-left: var(--sidebar-w); padding: 28px; min-height: calc(100vh - 60px); }

        /* Alerts */
        .sp-alert {
            padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;
            font-size: 13.5px; display: flex; align-items: flex-start; gap: 10px;
        }
        .sp-alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .sp-alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .sp-alert-info    { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

        /* Cards */
        .sp-card {
            background: #fff; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,.06);
            border: 1px solid var(--border);
        }
        .sp-card-header {
            padding: 18px 22px 14px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .sp-card-title { font-size: 15px; font-weight: 600; }
        .sp-card-body { padding: 22px; }

        /* Status badges */
        .sp-badge {
            display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600; letter-spacing: .02em;
        }
        .sp-badge-published { background: #dcfce7; color: #166534; }
        .sp-badge-pending   { background: #fef9c3; color: #854d0e; }
        .sp-badge-draft     { background: #f1f5f9; color: #475569; }
        .sp-badge-rejected  { background: #fee2e2; color: #991b1b; }
        .sp-badge-archived  { background: #f1f5f9; color: #64748b; }

        /* Tables */
        .sp-table { width: 100%; border-collapse: collapse; }
        .sp-table th { padding: 10px 14px; text-align: left; font-size: 11.5px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .05em; border-bottom: 1px solid var(--border); }
        .sp-table td { padding: 12px 14px; border-bottom: 1px solid var(--border); font-size: 13.5px; vertical-align: middle; }
        .sp-table tr:last-child td { border-bottom: none; }
        .sp-table tr:hover td { background: #f8fafc; }

        /* Form elements */
        .sp-form-row { display: grid; gap: 18px; margin-bottom: 18px; }
        .sp-form-row.cols-2 { grid-template-columns: 1fr 1fr; }
        .sp-form-row.cols-3 { grid-template-columns: 1fr 1fr 1fr; }
        .sp-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--muted); margin-bottom: 6px; }
        .sp-label .req { color: var(--red); }
        .sp-input, .sp-select, .sp-textarea {
            width: 100%; padding: 9px 12px; border: 1.5px solid var(--border); border-radius: 8px;
            font-family: 'Poppins', sans-serif; font-size: 13.5px; color: var(--text);
            transition: border-color .15s, box-shadow .15s; background: #fff;
        }
        .sp-input:focus, .sp-select:focus, .sp-textarea:focus {
            outline: none; border-color: var(--teal); box-shadow: 0 0 0 3px rgba(0,128,128,.1);
        }
        .sp-input.error, .sp-select.error, .sp-textarea.error { border-color: var(--red); }
        .sp-error-msg { font-size: 12px; color: var(--red); margin-top: 4px; }
        .sp-textarea { resize: vertical; min-height: 100px; }
        .sp-hint { font-size: 11.5px; color: var(--muted); margin-top: 4px; }

        .sp-btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 22px; border-radius: 8px; font-family: 'Poppins', sans-serif;
            font-size: 13.5px; font-weight: 600; cursor: pointer; border: none; transition: all .15s; text-decoration: none;
        }
        .sp-btn-primary  { background: var(--teal); color: #fff; }
        .sp-btn-primary:hover { background: #006666; }
        .sp-btn-navy     { background: var(--navy); color: #fff; }
        .sp-btn-navy:hover { background: #023372; }
        .sp-btn-outline  { background: #fff; color: var(--text); border: 1.5px solid var(--border); }
        .sp-btn-outline:hover { border-color: var(--teal); color: var(--teal); }
        .sp-btn-danger   { background: #fef2f2; color: var(--red); border: 1.5px solid #fecaca; }
        .sp-btn-danger:hover { background: #fee2e2; }
        .sp-btn-sm { padding: 5px 12px; font-size: 12.5px; }

        /* Mobile overlay */
        .sp-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 99; }

        /* Step indicator */
        .sp-steps { display: flex; align-items: center; gap: 0; margin-bottom: 28px; }
        .sp-step { display: flex; align-items: center; gap: 8px; flex: 1; }
        .sp-step-num {
            width: 28px; height: 28px; border-radius: 50%; font-size: 12px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            background: var(--border); color: var(--muted); flex-shrink: 0; transition: all .2s;
        }
        .sp-step.active .sp-step-num  { background: var(--teal); color: #fff; }
        .sp-step.done .sp-step-num    { background: var(--green); color: #fff; }
        .sp-step-label { font-size: 12px; font-weight: 500; color: var(--muted); }
        .sp-step.active .sp-step-label { color: var(--teal); font-weight: 600; }
        .sp-step.done .sp-step-label  { color: var(--green); }
        .sp-step-line { flex: 1; height: 2px; background: var(--border); margin: 0 8px; }
        .sp-step.done + .sp-step .sp-step-line,
        .sp-step.done .sp-step-line { background: var(--green); }

        /* Image upload zone */
        .sp-upload-zone {
            border: 2px dashed var(--border); border-radius: 10px; padding: 24px;
            text-align: center; cursor: pointer; transition: all .2s;
        }
        .sp-upload-zone:hover, .sp-upload-zone.drag { border-color: var(--teal); background: #f0fafa; }
        .sp-upload-zone input[type=file] { display: none; }
        .sp-upload-icon { font-size: 28px; margin-bottom: 8px; }
        .sp-upload-text { font-size: 13px; color: var(--muted); }
        .sp-upload-text strong { color: var(--teal); }
        .sp-thumb-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px; }
        .sp-thumb {
            width: 90px; height: 70px; border-radius: 8px; object-fit: cover;
            border: 2px solid var(--border); position: relative;
        }
        .sp-thumb-wrap { position: relative; }
        .sp-thumb-del {
            position: absolute; top: -6px; right: -6px; width: 20px; height: 20px;
            background: var(--red); color: #fff; border-radius: 50%; font-size: 11px;
            display: flex; align-items: center; justify-content: center; cursor: pointer; border: none;
            line-height: 1;
        }

        /* Amenities grid */
        .sp-amenities-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 8px; }
        .sp-amenity-item { display: flex; align-items: center; gap: 8px; }
        .sp-amenity-item label { font-size: 13px; cursor: pointer; }

        /* Pagination */
        .sp-pagination { display: flex; justify-content: center; gap: 6px; margin-top: 24px; }
        .sp-pagination a, .sp-pagination span {
            padding: 6px 12px; border-radius: 6px; font-size: 13px;
            border: 1.5px solid var(--border); color: var(--text); text-decoration: none;
        }
        .sp-pagination .active, .sp-pagination a:hover { background: var(--teal); color: #fff; border-color: var(--teal); }

        /* ── Installed-app chrome ───────────────────────────────────────────── */
        /* Respect the notch / home indicator when running standalone. */
        .sp-topbar { padding-top: env(safe-area-inset-top); }
        .sp-sidebar { padding-top: env(safe-area-inset-top); padding-bottom: env(safe-area-inset-bottom); }
        .sp-main { padding-bottom: calc(28px + env(safe-area-inset-bottom)); }

        /* Add-to-home-screen prompt */
        .sp-install {
            display: none; align-items: center; gap: 12px; margin-bottom: 16px;
            padding: 13px 16px; background: #fff; border: 1px solid var(--border);
            border-left: 4px solid var(--teal); border-radius: 10px;
        }
        .sp-install.show { display: flex; }
        .sp-install-icon { width: 38px; height: 38px; border-radius: 9px; flex: 0 0 auto; }
        .sp-install-text { flex: 1; font-size: 13px; line-height: 1.55; }
        .sp-install-text strong { display: block; color: var(--navy); font-size: 13.5px; }
        .sp-install-text span { color: var(--muted); }
        .sp-install button {
            font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer;
            border-radius: 8px; padding: 9px 16px; border: none; white-space: nowrap;
        }
        .sp-install .sp-install-yes { background: var(--teal); color: #fff; }
        .sp-install .sp-install-no  { background: none; color: var(--muted); padding: 9px 4px; }

        /* Offline notice */
        .sp-offline {
            display: none; position: fixed; left: 0; right: 0;
            bottom: env(safe-area-inset-bottom); z-index: 9998;
            padding: 10px 16px; background: var(--navy); color: #fff;
            font-size: 12.5px; text-align: center;
        }
        .sp-offline.show { display: block; }

        @media (max-width: 768px) {
            /* iOS zooms the page in when a focused input is under 16px. */
            .sp-input, .sp-select, .sp-textarea, input, select, textarea { font-size: 16px; }

            /* Comfortable touch targets. */
            .sp-btn { padding: 12px 20px; font-size: 14.5px; }
            .sp-checkbox-item input[type=checkbox] { width: 20px; height: 20px; }
            .sp-checkbox-item label { font-size: 14px; line-height: 1.5; }
            .sp-pill label { padding: 10px 16px; font-size: 13.5px; }

            .sp-install { flex-wrap: wrap; }
            .sp-install-text { flex: 1 1 100%; order: 2; }

            .sp-sidebar { transform: translateX(-100%); }
            .sp-sidebar.open { transform: translateX(0); }
            .sp-topbar { margin-left: 0; padding: 0 16px; }
            .sp-main { margin-left: 0; padding: 16px; }
            .sp-hamburger { display: block; }
            .sp-overlay.show { display: block; }
            .sp-form-row.cols-2,
            .sp-form-row.cols-3 { grid-template-columns: 1fr; }
            .sp-steps { flex-wrap: wrap; gap: 8px; }
            .sp-step-line { display: none; }
        }
    </style>
    @stack('head')
</head>
<body>
<div class="sp-overlay" id="spOverlay" onclick="closeSidebar()"></div>

<aside class="sp-sidebar" id="spSidebar">
    <a href="{{ route('seller.dashboard') }}" class="sp-logo">
        <span>DSD</span>
        <div><span>Properties</span><small>Seller Panel</small></div>
    </a>
    <nav class="sp-nav">
        <div class="sp-nav-label">Main</div>
        <a href="{{ route('seller.dashboard') }}" class="{{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Dashboard
        </a>
        <div class="sp-nav-label">Listings</div>
        <a href="{{ route('seller.listings.index') }}" class="{{ request()->routeIs('seller.listings.*') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            My Listings
        </a>
        <a href="{{ route('seller.listings.create') }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            Post New Property
        </a>
        <div class="sp-nav-label">Account</div>
        <a href="{{ route('seller.profile') }}" class="{{ request()->routeIs('seller.profile') ? 'active' : '' }}">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            My Profile
        </a>
        <a href="{{ url('/properties') }}" target="_blank">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            View Live Site
        </a>
    </nav>
    <div class="sp-footer">
        <div class="sp-seller-info">
            @if(session('seller_photo'))
                <img src="{{ asset(session('seller_photo')) }}" alt="" class="sp-avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
            @else
                <div class="sp-avatar">{{ strtoupper(substr(session('seller_name','S'),0,1)) }}</div>
            @endif
            <div>
                <div class="sp-seller-name">{{ session('seller_name') }}</div>
                <div class="sp-seller-role">Seller</div>
            </div>
        </div>
        <form method="POST" action="{{ route('seller.logout') }}">
            @csrf
            <button type="submit" class="sp-logout">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<header class="sp-topbar">
    <div style="display:flex;align-items:center;gap:12px;">
        <button class="sp-hamburger" onclick="openSidebar()" aria-label="Menu">
            <svg width="22" height="22" fill="none" stroke="#011f4b" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <span class="sp-topbar-title">@yield('page-title', 'Dashboard')</span>
    </div>
    <div class="sp-topbar-right">
        <a href="{{ route('seller.listings.create') }}" class="sp-btn-new">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Post Property
        </a>
    </div>
</header>

<main class="sp-main">
    {{-- Shown only when the browser says the app can actually be installed. --}}
    <div class="sp-install" id="spInstall">
        <img src="/seller-app/icon-192.png" class="sp-install-icon" alt="">
        <div class="sp-install-text">
            <strong>Add DSD Seller to your home screen</strong>
            <span>Post and manage properties from your phone, like an app.</span>
        </div>
        <button type="button" class="sp-install-yes" id="spInstallYes">Install</button>
        <button type="button" class="sp-install-no"  id="spInstallNo">Not now</button>
    </div>

    @if(session('success'))
        <div class="sp-alert sp-alert-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="sp-alert sp-alert-error">✕ {{ session('error') }}</div>
    @endif

    @yield('content')
</main>

<div class="sp-offline" id="spOffline">You're offline — changes can't be saved until the connection returns.</div>

<script>
function openSidebar()  { document.getElementById('spSidebar').classList.add('open'); document.getElementById('spOverlay').classList.add('show'); }
function closeSidebar() { document.getElementById('spSidebar').classList.remove('open'); document.getElementById('spOverlay').classList.remove('show'); }

/* ── Seller app (PWA) ──────────────────────────────────────────────────────── */
(function () {
    // Service workers need a secure context; plain http beyond localhost is skipped.
    if ('serviceWorker' in navigator && (location.protocol === 'https:' || location.hostname === 'localhost')) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw-seller.js', { scope: '/seller/' })
                .catch(function () { /* the app works fine without it */ });
        });
    }

    // Tell the seller when they have dropped off the network, so a failed save is not a
    // mystery. The listing form already autosaves each step server-side.
    var offline = document.getElementById('spOffline');
    function syncOnline() { offline.classList.toggle('show', !navigator.onLine); }
    window.addEventListener('online', syncOnline);
    window.addEventListener('offline', syncOnline);
    syncOnline();

    /* ── Add to home screen ── */
    var banner   = document.getElementById('spInstall');
    var deferred = null;
    var DISMISSED = 'sp-install-dismissed';

    function dismissedRecently() {
        try {
            var until = parseInt(localStorage.getItem(DISMISSED) || '0', 10);
            return until && Date.now() < until;
        } catch (e) { return false; }
    }

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferred = e;
        if (!dismissedRecently()) banner.classList.add('show');
    });

    document.getElementById('spInstallYes').addEventListener('click', function () {
        banner.classList.remove('show');
        if (!deferred) return;
        deferred.prompt();
        deferred.userChoice.finally(function () { deferred = null; });
    });

    document.getElementById('spInstallNo').addEventListener('click', function () {
        banner.classList.remove('show');
        // Ask again in a fortnight rather than never.
        try { localStorage.setItem(DISMISSED, String(Date.now() + 14 * 24 * 60 * 60 * 1000)); } catch (e) {}
    });

    window.addEventListener('appinstalled', function () {
        banner.classList.remove('show');
        try { localStorage.removeItem(DISMISSED); } catch (e) {}
    });
})();
</script>
@stack('scripts')
</body>
</html>
