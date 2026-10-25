<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="flex h-16 items-center gap-3 px-4 sm:px-6 lg:px-8">

        <button type="button" @click="toggleSidebar()"
                class="-ml-2 rounded-lg p-2.5 text-slate-500 hover:bg-slate-100 hover:text-brandNavy"
                aria-label="Show or hide menu">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>

        <h1 class="truncate text-base font-bold text-brandNavy sm:text-lg">
            @yield('page-title', 'Dashboard')
        </h1>

        <div class="ml-auto flex items-center gap-2">

            <button id="pwa-install" type="button" class="btn-outline btn-sm hidden">
                <i class="fa-solid fa-mobile-screen"></i>
                <span class="hidden sm:inline">Install app</span>
            </button>

            <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                <button type="button" @click="open = !open"
                        class="flex items-center gap-2 rounded-xl px-2 py-1.5 hover:bg-slate-100"
                        :aria-expanded="open.toString()">
                    <span class="grid h-9 w-9 place-items-center rounded-full bg-brandNavy text-xs font-bold text-white">
                        {{ strtoupper(mb_substr(auth()->user()?->name ?: 'A', 0, 1)) }}
                    </span>
                    <span class="hidden max-w-[10rem] truncate text-sm font-semibold text-slate-700 sm:inline">
                        {{ auth()->user()?->name ?: auth()->user()?->email }}
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                </button>

                <div x-show="open" x-cloak x-transition @click.outside="open = false"
                     class="absolute right-0 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                    <div class="border-b border-slate-100 px-4 py-3">
                        <p class="truncate text-sm font-semibold text-slate-800">{{ auth()->user()?->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ auth()->user()?->email }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}"
                       class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">
                        <i class="fa-solid fa-user mr-2 text-slate-400"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full px-4 py-2.5 text-left text-sm font-semibold text-rose-600 hover:bg-rose-50">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i> Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

@push('scripts')
<script>
// Installable web app: register the worker and surface Chrome's install prompt.
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/admin/sw.js', { scope: '/admin/' })
            .catch((e) => console.warn('SW registration failed', e));
    });
}
(function () {
    let deferred = null;
    const btn = document.getElementById('pwa-install');
    if (!btn) return;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault(); deferred = e; btn.classList.remove('hidden');
    });
    btn.addEventListener('click', () => {
        if (!deferred) return;
        deferred.prompt();
        deferred.userChoice.finally(() => { deferred = null; btn.classList.add('hidden'); });
    });
    window.addEventListener('appinstalled', () => btn.classList.add('hidden'));
})();
</script>
@endpush
