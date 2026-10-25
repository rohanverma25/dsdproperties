{{--
    Social-proof toast: "N 🟢 Active visitors on DSD Properties." Appears after 5% page scroll.
    Counts first-time visitors (user_locations stores one row per IP, ever) whose landing
    page was a blog article, so it is a lower bound. Cached for 3 minutes; hidden when the
    count is under the minimum so an outage never shows a weak or zero number.
    Usage: @include('components.readers-toast') just before </body> in public layouts.
--}}
@php
    $rtReaders = 0;
    if (!request()->is('admin*', 'seller*', 'dashboard*', 'login', 'register', 'users', 'locations/*')) {
        try {
            $rtReaders = \Illuminate\Support\Facades\Cache::remember('readers_toast_24h', now()->addMinutes(3), function () {
                return \App\Models\UserLocation::where('created_at', '>=', now()->subDay())
                    ->where('page', 'like', '%/blog/%')
                    ->count();
            });
        } catch (\Throwable $e) {
            $rtReaders = 0; // never let the toast break a page
        }
    }
@endphp

@if($rtReaders >= 300)
<style>
.rt{position:fixed;left:20px;bottom:20px;z-index:9990;display:flex;align-items:center;gap:12px;max-width:340px;padding:12px 14px 12px 12px;background:#fff;color:#0b1b33;border:1px solid #e7e9ee;border-radius:16px;box-shadow:0 12px 40px rgba(11,27,51,.16);font-family:'Poppins',system-ui,sans-serif;opacity:0;transform:translateY(16px);pointer-events:none;transition:opacity .4s ease,transform .4s ease}
.rt.rt--in{opacity:1;transform:none;pointer-events:auto}
.rt__ico{flex-shrink:0;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:#e6f3f2;color:#008080}
.rt__text{font-size:.8rem;line-height:1.45;color:#4a5568;margin:0}
.rt__text strong{display:flex;align-items:center;gap:6px;font-size:.92rem;color:#0b1b33;font-weight:700}
.rt__num{font-size:1.6rem;line-height:1.1;font-weight:800;letter-spacing:-.02em;color:#008080}
.rt__live{display:inline-block;flex-shrink:0;width:8px;height:8px;border-radius:50%;background:#22c55e;vertical-align:middle;box-shadow:0 0 0 3px rgba(34,197,94,.18)}
.rt__close{flex-shrink:0;align-self:flex-start;width:24px;height:24px;margin:-4px -6px 0 0;border:0;border-radius:50%;background:transparent;color:#8a94a6;cursor:pointer;display:grid;place-items:center;font-size:16px;line-height:1}
.rt__close:hover{background:#f1f3f6;color:#0b1b33}
[data-theme="dark"] .rt{background:#16223a;color:#eef2f7;border-color:#26324a;box-shadow:0 12px 40px rgba(0,0,0,.45)}
[data-theme="dark"] .rt__text{color:#b4bfcf}
[data-theme="dark"] .rt__text strong{color:#eef2f7}
[data-theme="dark"] .rt__num{color:#2cc4b4}
[data-theme="dark"] .rt__ico{background:rgba(44,196,180,.14);color:#2cc4b4}
[data-theme="dark"] .rt__close:hover{background:#26324a;color:#eef2f7}
@media(max-width:640px){.rt{left:12px;right:12px;bottom:12px;max-width:none}}
@media(max-width:1023px){body:has(.mob-cta-bar) .rt{bottom:96px}}
@media(prefers-reduced-motion:reduce){.rt{transition:none}}
</style>

<div class="rt" id="readersToast" role="status" aria-live="polite" aria-hidden="true">
    <span class="rt__ico" aria-hidden="true">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2 4h6a4 4 0 0 1 4 4v13a3 3 0 0 0-3-3H2z"/><path d="M22 4h-6a4 4 0 0 0-4 4v13a3 3 0 0 1 3-3h7z"/></svg>
    </span>
    <p class="rt__text">
        <strong><span class="rt__num">{{ number_format($rtReaders) }}+</span></strong>
        🟢 Active visitors on DSD Properties.
    </p>
    <button type="button" class="rt__close" aria-label="Dismiss">&times;</button>
</div>

<script>
(function () {
    var KEY = 'dsd_readers_toast_seen';
    var el = document.getElementById('readersToast');
    if (!el) return;
    try { if (sessionStorage.getItem(KEY)) return; } catch (e) {}

    var shown = false, hideTimer;
    function hide() {
        el.classList.remove('rt--in');
        el.setAttribute('aria-hidden', 'true');
        clearTimeout(hideTimer);
    }
    function show() {
        if (shown) return;
        // Don't stack on top of the exit-intent inquiry popup
        var overlay = document.getElementById('fbk-overlay');
        if (overlay && getComputedStyle(overlay).display !== 'none') return;
        shown = true;
        try { sessionStorage.setItem(KEY, '1'); } catch (e) {}
        el.classList.add('rt--in');
        el.setAttribute('aria-hidden', 'false');
        hideTimer = setTimeout(hide, 8000);
        window.removeEventListener('scroll', onScroll);
    }
    // Show only after the visitor has scrolled 5% of the page
    function onScroll() {
        var max = document.documentElement.scrollHeight - window.innerHeight;
        if (max > 0 && window.scrollY / max >= 0.05) show();
    }

    el.querySelector('.rt__close').addEventListener('click', hide);
    el.addEventListener('mouseenter', function () { clearTimeout(hideTimer); });
    el.addEventListener('mouseleave', function () { if (shown) hideTimer = setTimeout(hide, 3000); });
    window.addEventListener('scroll', onScroll, { passive: true });
})();
</script>
@endif
