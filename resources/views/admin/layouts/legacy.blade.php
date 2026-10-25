<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
{{-- LEGACY Bootstrap layout. Pages still on Bootstrap extend this.
     New work uses admin.layouts.app (Tailwind). Delete this file once
     every view below has been converted. --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

{{-- Installable web app (PWA). All static files under public/admin/ — no build step. --}}
<link rel="manifest" href="/admin/manifest.webmanifest">
<meta name="theme-color" content="#0d6efd">
<link rel="apple-touch-icon" href="/admin/icons/apple-touch-icon.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="DSD Leads">
<meta name="mobile-web-app-capable" content="yes">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.tiny.cloud/1/pub6ur1924a4vkb7bg6bkustoz95r6xzwki0h7xft4nckdvk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
#dsd-toast-container { position:fixed; top:18px; right:18px; z-index:9999; display:flex; flex-direction:column; gap:10px; }
.dsd-toast { min-width:260px; max-width:380px; padding:13px 18px; border-radius:10px; font-size:14px; font-weight:600; box-shadow:0 4px 18px rgba(0,0,0,.18); display:flex; align-items:center; gap:10px; animation:dsd-fadein .25s ease; }
.dsd-toast.success { background:#166534; color:#fff; }
.dsd-toast.error   { background:#991b1b; color:#fff; }
.dsd-toast.info    { background:#1e40af; color:#fff; }
@keyframes dsd-fadein { from { opacity:0; transform:translateX(30px); } to { opacity:1; transform:none; } }

/* ── Standard admin page chrome ── */
.page-header { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:1rem; }
.page-header h4 { margin:0; }
.page-header .page-subtitle { font-size:.82rem; color:#6c757d; margin:2px 0 0; }
.filter-pills { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:1rem; }
.filter-pills .badge { padding:6px 14px; border-radius:20px; font-size:1rem; font-weight:500; text-decoration:none; cursor:pointer; }
.empty-state { text-align:center; padding:48px 20px; color:#6c757d; font-size:.9rem; }

/* -- Sidebar show/hide -- */
#admin-sidebar { flex: 0 0 250px; width:250px; transition: margin-left .2s ease; }
#sidebar-backdrop { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:1040; }
#sidebar-toggle { border:0; background:transparent; font-size:1.25rem; line-height:1;
                  padding:6px 12px 6px 0; color:#334155; cursor:pointer; }
#sidebar-toggle:hover { color:#0d6efd; }
#sidebar-toggle i { pointer-events:none; }

/* Desktop: collapse in place. Scoped to min-width so a remembered "hidden"
   state can never leak into the mobile overlay rules below. */
@media (min-width: 768px) {
    body.sidebar-hidden #admin-sidebar { margin-left:-250px; }
}

/* Mobile: slide over the content, closed by default. */
@media (max-width: 767.98px) {
    #admin-sidebar { position:fixed; top:0; left:0; height:100vh; z-index:1050; overflow-y:auto; }
    body:not(.sidebar-open) #admin-sidebar { margin-left:-250px; }
    body.sidebar-open #sidebar-backdrop { display:block; }
    .admin-main { width:100%; }
}

/* -- Install app button -- */
#pwa-install { display:none; border:1px solid #0d6efd; background:#fff; color:#0d6efd;
               border-radius:8px; padding:7px 14px; font-size:.85rem; font-weight:600;
               cursor:pointer; white-space:nowrap; }
#pwa-install:hover { background:#0d6efd; color:#fff; }
</style>
</head>
<body>
<div class="d-flex">

<div id="admin-sidebar">
@include('admin.partials.legacy-sidebar')
</div>
<div id="sidebar-backdrop"></div>

<div class="flex-grow-1 p-4 admin-main">
@include('admin.partials.legacy-header')
@yield('content')
</div>


</div>

<script>
/* Admin chrome: sidebar toggle + installable web app.
   Deliberately in its own block and dependency-free — an error in the
   TinyMCE/jQuery block below must never stop the sidebar from opening. */

    // Sidebar show/hide. Desktop state is remembered; mobile opens as an overlay.
    (function () {
        var body = document.body;
        var MOBILE = function () { return window.matchMedia('(max-width: 767.98px)').matches; };

        try {
            if (localStorage.getItem('adminSidebarHidden') === '1') { body.classList.add('sidebar-hidden'); }
        } catch (e) {}

        document.addEventListener('click', function (e) {
            if (e.target.closest('#sidebar-toggle')) {
                if (MOBILE()) {
                    body.classList.toggle('sidebar-open');
                } else {
                    body.classList.toggle('sidebar-hidden');
                    try { localStorage.setItem('adminSidebarHidden', body.classList.contains('sidebar-hidden') ? '1' : '0'); } catch (e) {}
                }
                return;
            }
            if (e.target.closest('#sidebar-backdrop')) { body.classList.remove('sidebar-open'); }
        });
    })();

    // ---- Installable web app ----
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/admin/sw.js', { scope: '/admin/' })
                .catch(function (e) { console.warn('SW registration failed', e); });
        });
    }

    // Chrome/Edge/Android: show our own install button when the browser offers one.
    (function () {
        var deferred = null;
        var btn = document.getElementById('pwa-install');
        if (!btn) return;

        window.addEventListener('beforeinstallprompt', function (e) {
            e.preventDefault();
            deferred = e;
            btn.style.display = 'inline-block';
        });

        btn.addEventListener('click', function () {
            if (!deferred) return;
            deferred.prompt();
            deferred.userChoice.finally(function () {
                deferred = null;
                btn.style.display = 'none';
            });
        });

        window.addEventListener('appinstalled', function () { btn.style.display = 'none'; });
    })();
</script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if (window.tinymce) {
    tinymce.init({
        selector: '#editor',
        entity_encoding: "raw",
        entities: '160,nbsp',
        plugins: 'autosave preview code fullscreen link lists',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | link | code fullscreen preview',
        autosave_interval: '30s',
        menubar: false,
        height: 600,

        // Allow every element and attribute (preserves inline CSS, classes, data-attrs)
        valid_elements:          '*[*]',
        extended_valid_elements: '*[*]',
        valid_children:          '+body[style|script]',
        verify_html:             false,

        // Protect <style> and <script> blocks from being touched by the editor
        protect: [
            /\<style[\s\S]*?\<\/style\>/gi,
            /\<script[\s\S]*?\<\/script\>/gi,
        ],

        setup: function (editor) {}
    });
    }

    $(document).ready(function() {
        if (!$.fn.dataTable.isDataTable('#blogsTable')) {
            $('#blogsTable').DataTable({
                pageLength: 7,
                lengthChange: true,
                searching: true,
                ordering: true,
                responsive: true
            });
        }
    });

    // Global toast helper
    function dsdToast(msg, type) {
        var icons = { success: '✓', error: '✕', info: 'ℹ' };
        var c = document.getElementById('dsd-toast-container');
        if (!c) { c = document.createElement('div'); c.id = 'dsd-toast-container'; document.body.appendChild(c); }
        var t = document.createElement('div');
        t.className = 'dsd-toast ' + (type || 'info');
        t.innerHTML = '<span>' + (icons[type] || 'ℹ') + '</span><span>' + msg + '</span>';
        c.appendChild(t);
        setTimeout(function(){ t.style.opacity='0'; t.style.transition='opacity .4s'; setTimeout(function(){ t.remove(); }, 400); }, 4000);
    }

</script>
@stack('scripts')
</html>