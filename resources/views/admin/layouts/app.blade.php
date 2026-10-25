<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
<meta charset="utf-8">
<title>@yield('page-title', 'Leads') — DSD Properties</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="robots" content="noindex, nofollow">

{{-- Installable web app (PWA). Static files under public/admin/ — no build step. --}}
<link rel="manifest" href="/admin/manifest.webmanifest">
<meta name="theme-color" content="#011f4b">
<link rel="apple-touch-icon" href="/admin/icons/apple-touch-icon.png">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="DSD Leads">
<meta name="mobile-web-app-capable" content="yes">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="h-full font-sans"
      x-data="adminShell"
      :class="{ 'overflow-hidden lg:overflow-auto': mobileOpen }">

<div class="flex min-h-full">

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-[260px] shrink-0 overflow-y-auto bg-brandNavy
                  transition-transform duration-200 ease-out lg:static lg:z-auto lg:translate-x-0"
           :class="{
               '-translate-x-full': !mobileOpen,
               'translate-x-0': mobileOpen,
               'lg:hidden': collapsed
           }">
        @include('admin.partials.sidebar')
    </aside>

    {{-- Mobile backdrop --}}
    <div x-show="mobileOpen" x-cloak x-transition.opacity
         @click="mobileOpen = false"
         class="fixed inset-0 z-40 bg-brandNavy/60 backdrop-blur-sm lg:hidden"></div>

    {{-- Main column --}}
    <div class="flex min-w-0 flex-1 flex-col">
        @include('admin.partials.header')

        <main class="flex-1 px-4 py-5 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    </div>
</div>

<div id="toast-root" class="pointer-events-none fixed inset-x-0 top-4 z-[100] flex flex-col items-center gap-2 px-4"></div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('adminShell', () => ({
        mobileOpen: false,
        collapsed: false,
        init() {
            // Desktop collapse is remembered; mobile always starts closed.
            try { this.collapsed = localStorage.getItem('adminSidebarHidden') === '1'; } catch (e) {}
        },
        toggleSidebar() {
            if (window.matchMedia('(min-width: 1024px)').matches) {
                this.collapsed = !this.collapsed;
                try { localStorage.setItem('adminSidebarHidden', this.collapsed ? '1' : '0'); } catch (e) {}
            } else {
                this.mobileOpen = !this.mobileOpen;
            }
        },
    }));
});

// Toast helper, kept on window so existing pages can still call dsdToast().
window.dsdToast = function (msg, type) {
    const tone = {
        success: 'bg-emerald-600', error: 'bg-rose-600', info: 'bg-brandNavy',
    }[type] || 'bg-brandNavy';
    const root = document.getElementById('toast-root');
    if (!root) return;
    const el = document.createElement('div');
    el.className = `pointer-events-auto rounded-xl ${tone} px-4 py-3 text-sm font-semibold text-white shadow-lg`;
    el.textContent = msg;
    root.appendChild(el);
    setTimeout(() => { el.style.opacity = '0'; el.style.transition = 'opacity .4s'; setTimeout(() => el.remove(), 400); }, 4000);
};
</script>

<style>[x-cloak]{display:none!important}</style>
@stack('scripts')
</body>
</html>
