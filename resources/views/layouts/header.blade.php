<style>
.hdr {
    position: sticky; top: 0; z-index: 100;
    background: rgba(255,255,255,.96);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(0,128,128,.1);
    transition: box-shadow .3s;
    font-family: 'Poppins', sans-serif;
}
[data-theme="dark"] .hdr {
    background: rgba(31,41,55,.96);
    border-bottom-color: rgba(255,255,255,.08);
}
.hdr.scrolled { box-shadow: 0 4px 24px rgba(0,128,128,.12); }

.hdr__inner {
    max-width: 1100px; margin: 0 auto;
    padding: 0 24px; height: 68px;
    display: flex; align-items: center; justify-content: space-between;
}

/* Logo */
.hdr__logo { display: flex; align-items: center; gap: 12px; text-decoration: none; }
.hdr__logo-img-wrap { position: relative; flex-shrink: 0; }
.hdr__logo-img { height: 44px; width: 44px; border-radius: 10px; transition: transform .3s; }
.hdr__logo:hover .hdr__logo-img { transform: scale(1.05); }
.hdr__logo-dot {
    position: absolute; bottom: -2px; right: -2px;
    width: 12px; height: 12px; background: #4ade80;
    border-radius: 50%; border: 2px solid #fff;
    animation: hdrPulse 2.5s infinite;
}
[data-theme="dark"] .hdr__logo-dot { border-color: #1f2937; }
@keyframes hdrPulse { 0%,100%{box-shadow:0 0 0 2px rgba(74,222,128,.3)} 50%{box-shadow:0 0 0 5px rgba(74,222,128,.1)} }

.hdr__logo-name { display: flex; align-items: baseline; gap: 3px; }
.hdr__logo-dsd  { font-size: 1.4rem; font-weight: 800; color: #011f4b; letter-spacing: -.5px; }
[data-theme="dark"] .hdr__logo-dsd { color: #e5e7eb; }
.hdr__logo-prop { font-size: 1rem; font-weight: 600; color: #FF5C00; }
.hdr__logo-sub  { display: flex; align-items: center; gap: 6px; margin-top: 1px; }
.hdr__logo-sub > span:first-child { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-tertiary, #9ca3af); }
.hdr__logo-badge {
    font-size: 9px; font-weight: 700; letter-spacing: 1px;
    background: rgba(255,92,0,.12); color: #FF5C00;
    padding: 1px 6px; border-radius: 4px; border: 1px solid rgba(255,92,0,.25);
}

/* Desktop nav */
.hdr__nav { display: flex; align-items: center; gap: 2px; }
@media(max-width:1023px) { .hdr__nav { display: none; } }

.hdr__link {
    padding: 7px 10px; border-radius: 8px; font-size: .82rem; font-weight: 500;
    color: var(--text-primary, #111827); text-decoration: none;
    transition: background .2s, color .2s; white-space: nowrap;
}
.hdr__link:hover { background: rgba(0,128,128,.07); color: #008080; text-decoration: none; }

/* ── Services megamenu ── */
.hdr__dropdown {
    position: relative;
}
.hdr__dropdown-trigger {
    display: flex; align-items: center; gap: 5px;
    padding: 7px 10px; border-radius: 8px; font-size: .82rem; font-weight: 500;
    color: var(--text-primary, #111827); text-decoration: none;
    transition: background .2s, color .2s; white-space: nowrap;
    cursor: pointer; background: none; border: none;
    font-family: 'Poppins', sans-serif;
}
.hdr__dropdown-trigger:hover { background: rgba(0,128,128,.07); color: #008080; }
.hdr__dropdown-trigger svg { transition: transform .25s; flex-shrink: 0; }
.hdr__dropdown:hover .hdr__dropdown-trigger svg,
.hdr__dropdown.open   .hdr__dropdown-trigger svg { transform: rotate(180deg); }

.hdr__megamenu {
    display: none;
    position: absolute; top: calc(100% + 8px); left: 50%;
    transform: translateX(-50%);
    width: 560px;
    background: #fff; border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 16px; padding: 20px;
    box-shadow: 0 16px 48px rgba(1,31,75,.14);
    z-index: 200;
    animation: hdrDropIn .2s ease;
}
[data-theme="dark"] .hdr__megamenu {
    background: #1f2937; border-color: rgba(255,255,255,.1);
}
@keyframes hdrDropIn {
    from { opacity:0; transform: translateX(-50%) translateY(-6px); }
    to   { opacity:1; transform: translateX(-50%) translateY(0); }
}
.hdr__dropdown:hover .hdr__megamenu,
.hdr__dropdown.open   .hdr__megamenu { display: flex; gap: 20px; }

/* Left panel — service types */
.hdr__mega-left {
    flex-shrink: 0; width: 210px;
    border-right: 1px solid var(--border-color, #e5e7eb);
    padding-right: 20px;
}
.hdr__mega-head {
    font-size: 10px; font-weight: 700; letter-spacing: 1.8px;
    text-transform: uppercase; color: var(--text-tertiary, #9ca3af);
    margin: 0 0 10px; padding: 0;
}
.hdr__dropdown-item {
    display: flex; align-items: center; gap: 11px;
    padding: 10px 11px; border-radius: 10px;
    text-decoration: none;
    transition: background .18s;
    color: var(--text-primary, #111827);
    margin-bottom: 3px;
}
.hdr__dropdown-item:hover { background: rgba(0,128,128,.07); text-decoration: none; color: #008080; }
.hdr__dropdown-item-ico {
    width: 34px; height: 34px; border-radius: 8px; flex-shrink: 0;
    background: rgba(0,128,128,.08);
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem; transition: background .18s;
}
.hdr__dropdown-item:hover .hdr__dropdown-item-ico { background: rgba(0,128,128,.15); }
.hdr__dropdown-item-title { font-size: .82rem; font-weight: 700; color: var(--text-primary, #111827); display: block; line-height: 1.2; }
.hdr__dropdown-item:hover .hdr__dropdown-item-title { color: #008080; }
.hdr__dropdown-item-sub { font-size: .72rem; color: var(--text-tertiary, #9ca3af); display: block; margin-top: 2px; }

/* Right panel — verify by city */
.hdr__mega-right { flex: 1; min-width: 0; }
.hdr__mega-cities {
    display: grid; grid-template-columns: 1fr 1fr; gap: 5px;
}
.hdr__city-link {
    display: flex; align-items: center; gap: 8px;
    padding: 8px 10px; border-radius: 9px; text-decoration: none;
    font-size: .78rem; font-weight: 500;
    color: var(--text-primary, #111827);
    transition: background .18s, color .18s;
    white-space: nowrap;
}
.hdr__city-link:hover { background: rgba(0,128,128,.07); color: #008080; text-decoration: none; }
.hdr__city-dot { width: 6px; height: 6px; border-radius: 50%; background: #4ade80; flex-shrink: 0; }
.hdr__city-dot--soon { background: #d1d5db; }
.hdr__city-link--soon { color: var(--text-tertiary, #9ca3af); cursor: default; pointer-events: none; }
.hdr__city-link--soon:hover { background: none; }
.hdr__city-soon-tag {
    font-size: 9px; font-weight: 700; letter-spacing: .8px;
    background: rgba(0,0,0,.06); color: var(--text-tertiary, #9ca3af);
    padding: 1px 5px; border-radius: 4px; margin-left: auto;
}
[data-theme="dark"] .hdr__city-soon-tag { background: rgba(255,255,255,.08); }
/* ── end megamenu ── */

.hdr__sep { width: 1px; height: 22px; background: var(--border-color, #e5e7eb); margin: 0 8px; }

.hdr__cta {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 10px; border: none; cursor: pointer;
    font-family: 'Poppins', sans-serif; font-size: .83rem; font-weight: 700;
    background: linear-gradient(135deg, #FF5C00, #ff8840); color: #fff;
    box-shadow: 0 4px 14px rgba(255,92,0,.28);
    transition: transform .2s, box-shadow .2s;
    white-space: nowrap;
}
.hdr__cta:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(255,92,0,.4); }
.hdr__cta--full { width: 100%; justify-content: center; padding: 12px 18px; font-size: .9rem; border-radius: 12px; }

/* Mobile actions (call + toggle) */
.hdr__mobile-actions {
    display: none;
    align-items: center;
    gap: 12px;
}
@media(max-width:1023px) { .hdr__mobile-actions { display: flex; } }

/* Mobile call button */
.hdr__call {
    display: flex; align-items: center; justify-content: center;
    width: 42px; height: 42px;
    background: linear-gradient(135deg, #008080, #006666);
    border: none; border-radius: 50%; cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,128,128,.3);
    transition: transform .2s, box-shadow .2s;
    text-decoration: none;
}
.hdr__call:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,128,128,.4); }
.hdr__call svg { width: 20px; height: 20px; color: #fff; }

/* Mobile toggle */
.hdr__toggle {
    display: flex; flex-direction: column; gap: 5px;
    background: none; border: none; cursor: pointer; padding: 6px;
}
.hdr__toggle-bar {
    width: 22px; height: 2px; background: var(--text-primary, #111827);
    border-radius: 2px; transition: all .3s;
}
.hdr__toggle.open .hdr__toggle-bar:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
.hdr__toggle.open .hdr__toggle-bar:nth-child(2) { opacity: 0; }
.hdr__toggle.open .hdr__toggle-bar:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

/* Mobile nav */
.hdr__mobile {
    display: none; flex-direction: column;
    background: var(--bg-primary, #fff);
    border-top: 1px solid var(--border-color, #e5e7eb);
    padding: 12px 24px 20px;
}
.hdr__mobile.open { display: flex; }
.hdr__mlink {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; border-radius: 10px;
    font-size: .9rem; font-weight: 500; color: var(--text-primary, #111827);
    text-decoration: none; transition: background .2s;
}
.hdr__mlink:hover { background: rgba(0,128,128,.07); color: #008080; text-decoration: none; }
.hdr__mlink i { width: 16px; color: #008080; }

/* Mobile services sub-links */
.hdr__mlink-group {
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 12px; overflow: hidden; margin: 4px 0;
}
.hdr__mlink-group-label {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px;
    font-size: .9rem; font-weight: 600;
    color: #008080;
    background: rgba(0,128,128,.04);
    cursor: pointer; user-select: none;
    justify-content: space-between;
}
.hdr__mlink-group-label i { width: 16px; color: #008080; }
.hdr__mlink-group-chevron {
    font-size: .7rem; color: #008080; transition: transform .25s; flex-shrink: 0;
}
.hdr__mlink-group.open .hdr__mlink-group-chevron { transform: rotate(180deg); }
.hdr__mlink-sub {
    display: none; align-items: center; gap: 12px;
    padding: 10px 14px 10px 26px; border-radius: 0;
    font-size: .84rem; font-weight: 500; color: var(--text-primary, #111827);
    text-decoration: none; transition: background .2s;
    border-top: 1px solid var(--border-color, #e5e7eb);
}
.hdr__mlink-group.open .hdr__mlink-sub { display: flex; }
.hdr__mlink-sub:hover { background: rgba(0,128,128,.07); color: #008080; text-decoration: none; }
.hdr__mlink-sub i { width: 14px; color: #008080; font-size: .8rem; }

.hdr__mobile-cta { margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--border-color, #e5e7eb); }
</style>

<header class="hdr" id="main-header">
    <div class="hdr__inner">

        {{-- Logo --}}
        <a href="{{ route('homepage') }}" class="hdr__logo">
            <div class="hdr__logo-img-wrap">
                <img src="{{ asset('images/logo.webp') }}" alt="DSD Properties" class="hdr__logo-img">
                <span class="hdr__logo-dot"></span>
            </div>
            <div class="hdr__logo-text">
                <div class="hdr__logo-name">
                    <span class="hdr__logo-dsd">DSD</span>
                    <span class="hdr__logo-prop">Properties</span>
                </div>
                <div class="hdr__logo-sub">
                    <span>Lucknow</span>
                    <span class="hdr__logo-badge">Buy Safely.</span>
                </div>
            </div>
        </a>

        {{-- Desktop nav --}}
        <nav class="hdr__nav">
            <a href="/" class="hdr__link">Home</a>
            <a href="/about" class="hdr__link">About</a>
            <a href="/blog" class="hdr__link">Articles</a>
            <a href="/properties" class="hdr__link">Properties</a>
            <a href="/rera-approved-projects-lucknow" class="hdr__link">RERA</a>
            <a href="/lda-schemes" class="hdr__link">LDA Schemes</a>
            <a href="/news" class="hdr__link">News</a>

            {{-- Services megamenu --}}
            <div class="hdr__dropdown" id="hdr-services-dropdown">
                <button class="hdr__dropdown-trigger" aria-haspopup="true" aria-expanded="false" id="hdr-services-btn">
                    Services
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>
                <div class="hdr__megamenu" role="menu">

                    {{-- Left: service types --}}
                    <div class="hdr__mega-left">
                        <p class="hdr__mega-head">Our Services</p>
                        <a href="/services/property-verification-lucknow" class="hdr__dropdown-item" role="menuitem">
                            <div class="hdr__dropdown-item-ico">🛡️</div>
                            <div>
                                <span class="hdr__dropdown-item-title">Property Verification</span>
                                <span class="hdr__dropdown-item-sub">Legal doc check · From ₹5,000</span>
                            </div>
                        </a>
                        <a href="/services/property-advisory-lucknow" class="hdr__dropdown-item" role="menuitem">
                            <div class="hdr__dropdown-item-ico">🎯</div>
                            <div>
                                <span class="hdr__dropdown-item-title">Property Advisory</span>
                                <span class="hdr__dropdown-item-sub">Expert consulting · FREE</span>
                            </div>
                        </a>
                    </div>

                    {{-- Right: verify by city --}}
                    <div class="hdr__mega-right">
                        <p class="hdr__mega-head">Verify by City</p>
                        <div class="hdr__mega-cities">
                            <a href="/services/property-verification-lucknow" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Lucknow
                            </a>
                            <a href="/services/property-verification-varanasi" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Varanasi
                            </a>
                            <a href="/services/property-verification-ayodhya" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Ayodhya
                            </a>
                            <a href="/services/property-verification-gorakhpur" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Gorakhpur
                            </a>
                            <a href="/services/property-verification-agra" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Agra
                            </a>
                            <a href="/services/property-verification-prayagraj" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Prayagraj
                            </a>
                            <a href="/services/property-verification-noida" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Noida
                            </a>
                            <a href="/services/property-verification-greater-noida" class="hdr__city-link">
                                <span class="hdr__city-dot"></span> Greater Noida
                            </a>
                            <span class="hdr__city-link hdr__city-link--soon">
                                <span class="hdr__city-dot hdr__city-dot--soon"></span> Kanpur <span class="hdr__city-soon-tag">Soon</span>
                            </span>
                            <span class="hdr__city-link hdr__city-link--soon">
                                <span class="hdr__city-dot hdr__city-dot--soon"></span> Mathura <span class="hdr__city-soon-tag">Soon</span>
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="hdr__sep"></div>
            <a href="/contact-us"><button class="hdr__cta">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Contact Us
            </button></a>
        </nav>

        {{-- Mobile actions (call + menu toggle) --}}
        <div class="hdr__mobile-actions">
            {{-- Call button (mobile only) --}}
            <a href="tel:+919554102933" class="hdr__call" aria-label="Call us">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                </svg>
            </a>

            {{-- Menu toggle --}}
            <button class="hdr__toggle" id="hdr-toggle" aria-label="Menu">
                <span class="hdr__toggle-bar"></span>
                <span class="hdr__toggle-bar"></span>
                <span class="hdr__toggle-bar"></span>
            </button>
        </div>
    </div>

    {{-- Mobile nav --}}
    <div class="hdr__mobile" id="hdr-mobile">
        <a href="/" class="hdr__mlink"><i class="fas fa-home"></i> Home</a>
        <a href="/about" class="hdr__mlink"><i class="fas fa-info-circle"></i> About</a>
        <a href="/blog" class="hdr__mlink"><i class="fas fa-newspaper"></i> Articles</a>
        <a href="/properties" class="hdr__mlink"><i class="fas fa-home"></i> Properties</a>
        <a href="/rera-approved-projects-lucknow" class="hdr__mlink"><i class="fas fa-building"></i> RERA Projects</a>
        <a href="/lda-schemes" class="hdr__mlink"><i class="fas fa-building"></i> LDA Schemes</a>
        <a href="/news" class="hdr__mlink"><i class="fas fa-newspaper"></i> News</a>

        {{-- Mobile services group --}}
        <div class="hdr__mlink-group" id="hdr-svc-group">
            <div class="hdr__mlink-group-label" onclick="document.getElementById('hdr-svc-group').classList.toggle('open')">
                <span style="display:flex;align-items:center;gap:12px;"><i class="fas fa-briefcase"></i> Services</span>
                <i class="fas fa-chevron-down hdr__mlink-group-chevron"></i>
            </div>
            <a href="/services/property-advisory-lucknow" class="hdr__mlink-sub">
                <i class="fas fa-lightbulb"></i> Property Advisory
            </a>
            <a href="/services/property-verification-lucknow" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Lucknow
            </a>
            <a href="/services/property-verification-varanasi" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Varanasi
            </a>
            <a href="/services/property-verification-ayodhya" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Ayodhya
            </a>
            <a href="/services/property-verification-gorakhpur" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Gorakhpur
            </a>
            <a href="/services/property-verification-prayagraj" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Prayagraj
            </a>
            <a href="/services/property-verification-noida" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Noida
            </a>
            <a href="/services/property-verification-greater-noida" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Greater Noida
            </a>
            <a href="/services/property-verification-agra" class="hdr__mlink-sub">
                <i class="fas fa-shield-alt"></i> Verify — Agra
            </a>
        </div>

        <div class="hdr__mobile-cta">
            <a href="/contact-us"><button class="hdr__cta hdr__cta--full">
                <i class="fas fa-calculator"></i> Contact Us
            </button></a>
        </div>
    </div>
</header>

<script>
(function () {
    function init() {
        const header  = document.getElementById('main-header');
        const toggle  = document.getElementById('hdr-toggle');
        const mobile  = document.getElementById('hdr-mobile');
        if (!header || !toggle || !mobile) return;

        let open = false;

        function openMenu()  { open=true;  toggle.classList.add('open');  mobile.classList.add('open');  document.body.style.overflow='hidden'; }
        function closeMenu() { open=false; toggle.classList.remove('open'); mobile.classList.remove('open'); document.body.style.overflow=''; }

        toggle.addEventListener('click', () => open ? closeMenu() : openMenu());
        mobile.querySelectorAll('a, button').forEach(el => el.addEventListener('click', closeMenu));
        document.addEventListener('click', e => { if (open && !header.contains(e.target)) closeMenu(); });
        window.addEventListener('resize', () => { if (window.innerWidth >= 1024) closeMenu(); });

        /* Scroll shadow */
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 40);
        }, { passive: true });

        /* Services dropdown — click toggle for keyboard/touch accessibility */
        const dropdown    = document.getElementById('hdr-services-dropdown');
        const dropdownBtn = document.getElementById('hdr-services-btn');
        if (dropdown && dropdownBtn) {
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = dropdown.classList.toggle('open');
                dropdownBtn.setAttribute('aria-expanded', isOpen);
            });
            /* Close dropdown when clicking outside */
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                    dropdownBtn.setAttribute('aria-expanded', 'false');
                }
            });
            /* Close dropdown on Escape */
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    dropdown.classList.remove('open');
                    dropdownBtn.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }

    document.readyState === 'loading'
        ? document.addEventListener('DOMContentLoaded', init)
        : init();
})();
</script>