{{--
    DSD Properties — Valuation Modal v3
    File: resources/views/components/valuation-modal.blade.php

    Changes in v3 (design fixes):
    ✅ FIX: Loader no longer cuts — modal gets overflow:hidden while loading
    ✅ FIX: Loader content more compact — fits any modal height
    ✅ FIX: Removed "Facing" from all steps, validation, calculation, report
    ✅ FEAT: Address input shows inline search spinner while user types
    ✅ FIX: Full mobile responsive — single column grids on small screens
    ✅ FIX: Progress bar + close btn no longer overlap on mobile
    ✅ FIX: Report stats readable on mobile
    ✅ FIX: Trust strip proper wrapping
    ✅ FIX: Modal padding reduced on small screens
    ✅ FIX: Nav action buttons properly sized on mobile
    ✅ FIX: WhatsApp button z-index and tap area
    ✅ FIX: Nocoverage screens properly padded on mobile
--}}

<style>
/* ── Google Places dropdown ── */
.pac-container {
    border-radius: 14px !important;
    border: 1.5px solid rgba(1,31,75,0.12) !important;
    box-shadow: 0 12px 40px rgba(1,31,75,0.16) !important;
    font-family: 'Poppins', sans-serif !important;
    margin-top: 6px !important;
    overflow: hidden !important;
    z-index: 99999 !important;
    padding: 6px !important;
    background: #fff !important;
}
.pac-item {
    padding: 10px 12px !important;
    font-size: 0.83rem !important;
    color: #011f4b !important;
    cursor: pointer !important;
    border-top: none !important;
    border-radius: 8px !important;
    line-height: 1.5 !important;
    font-family: 'Poppins', sans-serif !important;
    margin-bottom: 2px !important;
    transition: background 0.15s !important;
}
.pac-item:hover, .pac-item-selected { background: rgba(0,128,128,0.07) !important; }
.pac-item-query { font-size: 0.86rem !important; font-weight: 600 !important; color: #011f4b !important; }
.pac-matched { color: #008080 !important; font-weight: 700 !important; }
.pac-icon { filter: grayscale(1) opacity(0.3) !important; margin-top: 3px !important; }

/* ── Backdrop ── */
.vc-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(1,20,50,0.6);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    z-index: 9998;
}
.vc-backdrop.vc-visible { display: block; }

/* ── Modal ── */
.vc-modal {
    display: none; position: fixed;
    /* FIX: top-align with margin instead of transform centering
       so iOS keyboard popup doesn't break layout */
    top: 4%; left: 50%;
    transform: translateX(-50%) scale(0.97);
    width: 94%; max-width: 480px;
    /* FIX: use svh (small viewport height) for mobile keyboard awareness */
    max-height: 92vh;
    overflow-y: auto; overflow-x: hidden;
    background: #ffffff; border-radius: 24px;
    box-shadow: 0 0 0 1px rgba(1,31,75,0.07),
                0 32px 80px rgba(1,31,75,0.22),
                0 8px 24px rgba(0,128,128,0.08);
    z-index: 9999; opacity: 0;
    transition: transform 0.3s cubic-bezier(.34,1.56,.64,1), opacity 0.25s ease;
    scrollbar-width: none;
    isolation: isolate;
    /* FIX: Prevent full-height stretch on small screens */
    margin-bottom: 4%;
}
.vc-modal::-webkit-scrollbar { display: none; }
.vc-modal.vc-visible {
    display: block;
    transform: translateX(-50%) scale(1);
    opacity: 1;
}
/* FIX: When loader is active, prevent scroll so overlay covers fully */
.vc-modal.vc-loading { overflow: hidden !important; }

/* ── Close ── */
.vc-close-btn {
    position: sticky; top: 14px;
    float: right; margin: 14px 14px 0 0;
    background: rgba(1,31,75,0.08); border: none; border-radius: 50%;
    width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #011f4b;
    transition: background 0.2s, transform 0.2s;
    z-index: 100;
    flex-shrink: 0;
    /* FIX: Always stays visible — even on dark report header */
    box-shadow: 0 1px 4px rgba(0,0,0,0.12);
}
.vc-close-btn:hover { background: rgba(1,31,75,0.14); transform: rotate(90deg); }
/* FIX: When report is shown, close btn gets higher contrast */
.vc-step-report ~ * .vc-close-btn,
.vc-modal .vc-close-btn { background: #fff; box-shadow: 0 2px 8px rgba(1,31,75,0.15); }

/* ── Progress header ── */
.vc-progress-header {
    padding: 16px 20px 0 20px;
    /* FIX: no longer needs right padding — close btn is float:right sticky */
    background: #fff; z-index: 5;
}
.vc-progress-inline { display: flex; align-items: center; gap: 10px; }
#vc-progress-text {
    font-size: 0.68rem; font-weight: 700; color: #008080;
    letter-spacing: 0.1em; text-transform: uppercase; white-space: nowrap;
    font-family: 'Poppins', sans-serif; flex-shrink: 0;
}
.vc-progress-dots { display: flex; gap: 5px; align-items: center; flex: 1; }
.vc-dot {
    height: 3px; flex: 1; border-radius: 99px;
    background: rgba(1,31,75,0.1);
    transition: background 0.35s ease, transform 0.2s;
}
.vc-dot.vc-dot-active { background: linear-gradient(90deg,#008080,#00a0a0); transform: scaleY(1.5); }
.vc-dot.vc-dot-done { background: rgba(0,128,128,0.35); }

/* ── Content ── */
.vc-content { padding: 18px 22px 28px; }
.vc-step { display: none; }
.vc-step.vc-active { display: block; animation: vcSlideIn 0.28s cubic-bezier(.22,1,.36,1); }
@keyframes vcSlideIn { from{opacity:0;transform:translateX(14px)} to{opacity:1;transform:translateX(0)} }

/* ── Step badge ── */
.vc-step-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(0,128,128,0.08); color: #008080;
    font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
    padding: 4px 10px; border-radius: 99px; margin-bottom: 10px;
    border: 1px solid rgba(0,128,128,0.15); font-family: 'Poppins', sans-serif;
}
.vc-step-badge-dot {
    width: 5px; height: 5px; border-radius: 50%; background: #008080;
    animation: vcPulse 2s infinite;
}
@keyframes vcPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.7)} }

.vc-title {
    font-size: 1.25rem; font-weight: 800; color: #011f4b;
    margin: 0 0 5px; line-height: 1.25;
    font-family: 'Poppins', sans-serif; letter-spacing: -0.02em;
}
.vc-subtitle {
    font-size: 0.82rem; color: rgba(1,31,75,0.45);
    margin: 0 0 20px; line-height: 1.6; font-family: 'Poppins', sans-serif;
}

/* ── Address input wrapper with search spinner ── */
.vc-address-wrap { position: relative; }
.vc-address-spinner {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    width: 18px; height: 18px; display: none; align-items: center; justify-content: center;
    pointer-events: none; z-index: 2;
}
.vc-address-spinner.show { display: flex; }
.vc-address-spinner svg {
    animation: vcSpin 0.8s linear infinite;
}
@keyframes vcSpin { to { transform: rotate(360deg); } }

/* ── Location feedback pill ── */
.vc-location-pill {
    display: none; align-items: center; gap: 6px;
    padding: 7px 12px; border-radius: 99px; margin-top: 8px;
    font-size: 0.75rem; font-weight: 600; font-family: 'Poppins', sans-serif;
}
.vc-location-pill.show { display: flex; }
.vc-location-pill.ok    { background: rgba(0,128,128,0.08); color: #008080; border: 1px solid rgba(0,128,128,0.2); }
.vc-location-pill.warn  { background: rgba(255,92,0,0.08); color: #FF5C00; border: 1px solid rgba(255,92,0,0.2); }
.vc-location-pill.error { background: rgba(239,68,68,0.08); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); }

/* ── Inputs ── */
.vc-input-group { margin-bottom: 14px; }

/* ── Field error state — red border + shake + hint text ── */
.vc-input.vc-field-error,
.vc-select.vc-field-error {
    border-color: #ef4444 !important;
    background: #fff8f8 !important;
    box-shadow: 0 0 0 4px rgba(239,68,68,0.08) !important;
    animation: vcShake 0.35s ease;
}
@keyframes vcShake {
    0%,100%{transform:translateX(0)}
    20%{transform:translateX(-4px)}
    40%{transform:translateX(4px)}
    60%{transform:translateX(-3px)}
    80%{transform:translateX(3px)}
}
.vc-field-hint {
    display: none; font-size: 0.68rem; color: #ef4444;
    font-family: 'Poppins', sans-serif; margin-top: 5px;
    align-items: center; gap: 4px; font-weight: 500;
}
.vc-field-hint.show { display: flex; }
.vc-label {
    display: block; font-size: 0.7rem; font-weight: 700;
    color: rgba(1,31,75,0.5); margin-bottom: 7px;
    letter-spacing: 0.07em; text-transform: uppercase; font-family: 'Poppins', sans-serif;
}
.vc-input, .vc-select {
    width: 100%; padding: 12px 16px;
    border: 1.5px solid rgba(1,31,75,0.1);
    border-radius: 12px; font-size: 0.88rem; color: #011f4b; background: #f8fafc;
    outline: none; transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    box-sizing: border-box; font-family: 'Poppins', sans-serif;
    appearance: none; -webkit-appearance: none;
}
.vc-input:focus, .vc-select:focus {
    border-color: #008080; background: #fff;
    box-shadow: 0 0 0 4px rgba(0,128,128,0.08);
}
.vc-input::placeholder { color: rgba(1,31,75,0.25); }
/* FIX: address input has right padding for spinner */
#vc-address { padding-right: 42px; }
.vc-select {
    background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%23011f4b' stroke-opacity='0.4' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px;
}

/* ── Buttons ── */
.vc-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    padding: 13px 22px; border-radius: 12px; font-size: 0.88rem; font-weight: 700;
    cursor: pointer; border: none;
    transition: all 0.22s cubic-bezier(.34,1.56,.64,1);
    font-family: 'Poppins', sans-serif; letter-spacing: 0.01em;
    position: relative; overflow: hidden;
    -webkit-tap-highlight-color: transparent;
}
.vc-btn-primary {
    background: linear-gradient(135deg, #011f4b 0%, #022d6e 100%);
    color: #fff; width: 100%;
    box-shadow: 0 4px 16px rgba(1,31,75,0.25);
}
.vc-btn-primary::after {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,128,128,0.25), transparent);
    opacity: 0; transition: opacity 0.2s; border-radius: inherit;
}
.vc-btn-primary:hover:not(:disabled)::after { opacity: 1; }
.vc-btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(1,31,75,0.3);
}
.vc-btn-primary:active:not(:disabled) { transform: translateY(0) scale(0.98); }
.vc-btn-primary:disabled { opacity: 0.35; cursor: not-allowed; transform: none; box-shadow: none; }
.vc-btn-back {
    width: 46px; height: 46px; padding: 0; border-radius: 12px;
    background: rgba(1,31,75,0.05); color: rgba(1,31,75,0.5);
    border: 1.5px solid rgba(1,31,75,0.08); flex-shrink: 0; transition: all 0.2s;
    min-width: 46px; /* FIX: prevent shrink on mobile */
}
.vc-btn-back:hover { background: rgba(1,31,75,0.1); color: #011f4b; border-color: rgba(1,31,75,0.2); }
.vc-btn-next { flex: 1; min-width: 0; /* FIX: prevent overflow on mobile */ }
.vc-nav-actions { display: flex; gap: 10px; margin-top: 20px; align-items: center; }

/* ── Option cards ── */
.vc-options-grid { display: flex; flex-direction: column; gap: 10px; margin-bottom: 4px; }
.vc-option-card {
    display: flex; align-items: center; gap: 14px; padding: 13px 15px;
    border: 1.5px solid rgba(1,31,75,0.09); border-radius: 14px; cursor: pointer;
    transition: all 0.22s cubic-bezier(.34,1.56,.64,1);
    position: relative; background: #f8fafc;
    -webkit-tap-highlight-color: transparent;
}
.vc-option-card:hover {
    border-color: rgba(0,128,128,0.4); background: rgba(0,128,128,0.03);
    transform: translateY(-1px); box-shadow: 0 4px 16px rgba(0,128,128,0.1);
}
.vc-option-card.vc-selected {
    border-color: #011f4b; background: rgba(1,31,75,0.03);
    box-shadow: 0 0 0 4px rgba(1,31,75,0.06);
}
.vc-option-card input[type="radio"] { display: none; }
.vc-icon-box {
    width: 44px; height: 44px; border-radius: 11px;
    background: rgba(1,31,75,0.06);
    display: flex; align-items: center; justify-content: center;
    color: #011f4b; flex-shrink: 0; transition: background 0.2s;
}
.vc-option-card.vc-selected .vc-icon-box { background: rgba(0,128,128,0.1); color: #008080; }
.vc-option-card-text-title { font-weight: 700; font-size: 0.93rem; color: #011f4b; font-family: 'Poppins', sans-serif; }
.vc-option-card-text-sub { font-size: 0.76rem; color: rgba(1,31,75,0.4); margin-top: 2px; font-family: 'Poppins', sans-serif; }
.vc-check {
    width: 24px; height: 24px; border-radius: 50%;
    background: linear-gradient(135deg,#011f4b,#022d6e);
    display: none; align-items: center; justify-content: center;
    margin-left: auto; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(1,31,75,0.3);
}
.vc-option-card.vc-selected .vc-check { display: flex; }

/* ── Tags ── */
.vc-features-wrap { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
.vc-tag {
    padding: 7px 13px; border-radius: 99px;
    border: 1.5px solid rgba(1,31,75,0.12); background: #f8fafc;
    font-size: 0.78rem; color: rgba(1,31,75,0.6); cursor: pointer;
    font-weight: 600; transition: all 0.18s; font-family: 'Poppins', sans-serif;
    -webkit-tap-highlight-color: transparent;
}
.vc-tag:hover { border-color: #008080; color: #008080; background: rgba(0,128,128,0.05); }
.vc-tag.vc-tag-active {
    background: linear-gradient(135deg,#011f4b,#022d6e);
    color: #fff; border-color: transparent;
    box-shadow: 0 2px 8px rgba(1,31,75,0.2);
}

/* ── Phone ── */
#vc-phone-error { display: none; }
#vc-phone-error.vc-visible { display: flex; }
.vc-divider { height: 1px; background: linear-gradient(90deg,transparent,rgba(1,31,75,0.08),transparent); margin: 16px 0; }
.vc-phone-wrap { position: relative; display: flex; align-items: center; }
.vc-phone-prefix {
    position: absolute; left: 14px; display: flex; align-items: center; gap: 6px;
    font-size: 0.88rem; font-weight: 600; color: rgba(1,31,75,0.5);
    pointer-events: none; font-family: 'Poppins', sans-serif; z-index: 1;
}
.vc-phone-prefix-divider { width: 1px; height: 16px; background: rgba(1,31,75,0.15); margin-left: 2px; }
.vc-phone-wrap .vc-input { padding-left: 72px; }

/* ── Trust strip ── */
.vc-trust-strip {
    display: flex; align-items: center; justify-content: center;
    gap: 12px; padding: 11px 14px;
    background: linear-gradient(135deg,rgba(0,128,128,0.04),rgba(1,31,75,0.03));
    border-radius: 12px; margin-top: 14px;
    border: 1px solid rgba(1,31,75,0.06); flex-wrap: wrap;
}
.vc-trust-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 0.68rem; color: rgba(1,31,75,0.45);
    font-weight: 600; font-family: 'Poppins', sans-serif; white-space: nowrap;
}
.vc-trust-item svg { color: #008080; flex-shrink: 0; }

/* ════════════════════════════════════════
   AI LOADER — FIX: Compact layout, no cutting
════════════════════════════════════════ */
.vc-loader-overlay {
    display: none;
    /* FIX: sticky inset — covers modal regardless of scroll position */
    position: sticky;
    top: 0;
    /* Pull out of flow to cover whole modal */
    margin-top: calc(-100vh);
    height: 100vh;
    max-height: 92vh;
    /* Use full modal width */
    margin-left: -22px;
    margin-right: -22px;
    width: calc(100% + 44px);
    background: linear-gradient(160deg, #f8faff 0%, #eef4f0 100%);
    border-radius: 24px;
    z-index: 20;
    flex-direction: column; align-items: center; justify-content: center;
    gap: 0; padding: 24px 24px 28px;
    box-sizing: border-box;
}
.vc-loader-overlay.vc-visible { display: flex; }

/* FIX: More compact orbit for smaller screens */
.vc-ai-orbit {
    position: relative; width: 76px; height: 76px;
    margin-bottom: 18px; flex-shrink: 0;
}
.vc-ai-orbit-ring {
    position: absolute; inset: 0; border-radius: 50%;
    border: 2px solid transparent;
}
.vc-ai-orbit-ring-1 {
    border-top-color: #008080; border-right-color: rgba(0,128,128,0.3);
    animation: vcOrbit1 1.2s linear infinite;
}
.vc-ai-orbit-ring-2 {
    inset: 9px;
    border-bottom-color: #FF5C00; border-left-color: rgba(255,92,0,0.3);
    animation: vcOrbit1 0.8s linear infinite reverse;
}
.vc-ai-orbit-ring-3 {
    inset: 19px;
    border-top-color: #011f4b; border-right-color: rgba(1,31,75,0.2);
    animation: vcOrbit1 1.6s linear infinite;
}
.vc-ai-orbit-core {
    position: absolute; inset: 28px;
    background: linear-gradient(135deg, #011f4b, #008080);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    animation: vcCorePulse 2s ease-in-out infinite;
}
@keyframes vcOrbit1 { to { transform: rotate(360deg); } }
@keyframes vcCorePulse { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(0.85);opacity:0.8} }

.vc-ai-label {
    font-size: 1rem; font-weight: 800; color: #011f4b;
    font-family: 'Poppins', sans-serif; margin: 0 0 4px; text-align: center;
}
.vc-ai-sublabel {
    font-size: 0.75rem; color: rgba(1,31,75,0.45);
    font-family: 'Poppins', sans-serif; margin: 0 0 18px;
    text-align: center; line-height: 1.5;
}

/* FIX: Compact step items */
.vc-ai-steps {
    width: 100%; max-width: 300px;
    display: flex; flex-direction: column; gap: 8px;
}
.vc-ai-step {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-radius: 10px;
    background: rgba(255,255,255,0.7);
    border: 1px solid rgba(1,31,75,0.07);
    font-size: 0.76rem; font-family: 'Poppins', sans-serif;
    font-weight: 500; color: rgba(1,31,75,0.35);
    transition: all 0.4s ease;
}
.vc-ai-step.active {
    color: #011f4b; background: #fff;
    border-color: rgba(0,128,128,0.2);
    box-shadow: 0 2px 8px rgba(0,128,128,0.08);
}
.vc-ai-step.done {
    color: #008080; background: rgba(0,128,128,0.04);
    border-color: rgba(0,128,128,0.15);
}
.vc-ai-step-icon {
    width: 26px; height: 26px; border-radius: 7px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.76rem; background: rgba(1,31,75,0.06); transition: all 0.3s;
}
.vc-ai-step.active .vc-ai-step-icon { background: rgba(0,128,128,0.1); animation: vcStepPop 0.5s ease; }
.vc-ai-step.done .vc-ai-step-icon { background: rgba(0,128,128,0.12); }
@keyframes vcStepPop { 0%{transform:scale(0.7)} 60%{transform:scale(1.15)} 100%{transform:scale(1)} }

.vc-ai-step-bar {
    margin-top: 14px; width: 100%; max-width: 300px;
    height: 3px; background: rgba(1,31,75,0.08);
    border-radius: 99px; overflow: hidden;
}
.vc-ai-step-bar-fill {
    height: 100%; width: 0%; border-radius: 99px;
    background: linear-gradient(90deg, #008080, #00c0a0);
    transition: width 0.6s ease;
}

/* ════════════════════════════════════════
   REPORT VIEW
════════════════════════════════════════ */
.vc-report { font-family: 'Poppins', sans-serif; }

.vc-report-header {
    background: linear-gradient(135deg, #011f4b 0%, #022d6e 60%, #013a5e 100%);
    border-radius: 16px; padding: 18px; margin-bottom: 14px;
    position: relative; overflow: hidden;
}
.vc-report-header::before {
    content: ''; position: absolute; top: -30px; right: -30px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(0,128,128,0.15); pointer-events: none;
}
.vc-report-header::after {
    content: ''; position: absolute; bottom: -20px; left: 40px;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(255,92,0,0.08); pointer-events: none;
}
.vc-report-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(0,128,128,0.2); border: 1px solid rgba(0,128,128,0.3);
    color: #4de8d0; font-size: 0.63rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    padding: 4px 10px; border-radius: 99px; margin-bottom: 10px;
    position: relative; z-index: 1;
}
.vc-report-badge-dot {
    width: 5px; height: 5px; border-radius: 50%;
    background: #4de8d0; animation: vcPulse 2s infinite;
}
.vc-report-address {
    font-size: 0.88rem; font-weight: 700; color: #fff;
    margin: 0 0 4px; line-height: 1.35; position: relative; z-index: 1;
}
.vc-report-meta {
    font-size: 0.7rem; color: rgba(255,255,255,0.5);
    margin: 0; position: relative; z-index: 1;
}

.vc-report-price-block {
    background: #fff; border: 1.5px solid rgba(0,128,128,0.15);
    border-radius: 16px; padding: 16px; margin-bottom: 12px;
    box-shadow: 0 4px 20px rgba(0,128,128,0.06);
}
.vc-report-price-label {
    font-size: 0.66rem; font-weight: 700; color: rgba(1,31,75,0.4);
    letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 8px;
}
.vc-report-price-range {
    font-size: 1.5rem; font-weight: 900; color: #011f4b;
    line-height: 1.1; margin-bottom: 6px;
    font-variant-numeric: tabular-nums; letter-spacing: -0.03em;
}
.vc-report-price-range span { color: #008080; }
.vc-report-price-mid {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,92,0,0.08); border: 1px solid rgba(255,92,0,0.15);
    color: #FF5C00; font-size: 0.73rem; font-weight: 700;
    padding: 4px 10px; border-radius: 99px;
}

.vc-report-meter { margin: 13px 0 0; }
.vc-report-meter-track { height: 6px; background: rgba(1,31,75,0.07); border-radius: 99px; overflow: hidden; }
.vc-report-meter-fill {
    height: 100%; border-radius: 99px;
    background: linear-gradient(90deg,#008080,#00c0a0,#FF5C00);
    transition: width 1s ease 0.3s; width: 0%;
}
.vc-report-meter-labels {
    display: flex; justify-content: space-between;
    margin-top: 5px; font-size: 0.63rem;
    color: rgba(1,31,75,0.35); font-weight: 600;
}

/* FIX: Report stats — single column on very small screens */
.vc-report-stats {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 8px; margin-bottom: 12px;
}
.vc-report-stat {
    background: #f8fafc; border: 1.5px solid rgba(1,31,75,0.07);
    border-radius: 12px; padding: 11px 13px;
}
.vc-report-stat-label {
    font-size: 0.63rem; font-weight: 700; color: rgba(1,31,75,0.4);
    letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 4px;
}
.vc-report-stat-value { font-size: 0.88rem; font-weight: 800; color: #011f4b; }
.vc-report-stat-value.teal { color: #008080; }
.vc-report-stat-value.orange { color: #FF5C00; }

.vc-report-segment {
    display: flex; align-items: center; gap: 10px;
    background: #f8fafc; border: 1.5px solid rgba(1,31,75,0.07);
    border-radius: 12px; padding: 11px 13px; margin-bottom: 12px;
}
.vc-report-segment-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.vc-report-segment-info { flex: 1; min-width: 0; }
.vc-report-segment-name { font-size: 0.85rem; font-weight: 700; color: #011f4b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.vc-report-segment-desc { font-size: 0.7rem; color: rgba(1,31,75,0.45); margin-top: 1px; }
.vc-report-segment-tag {
    font-size: 0.66rem; font-weight: 700;
    padding: 3px 9px; border-radius: 99px; white-space: nowrap; flex-shrink: 0;
}

.vc-report-note {
    display: flex; align-items: flex-start; gap: 8px;
    background: rgba(1,31,75,0.03); border: 1px solid rgba(1,31,75,0.07);
    border-radius: 10px; padding: 10px 12px; margin-bottom: 12px;
    font-size: 0.68rem; color: rgba(1,31,75,0.45); line-height: 1.5;
    font-family: 'Poppins', sans-serif;
}
.vc-report-note svg { flex-shrink: 0; margin-top: 1px; color: rgba(1,31,75,0.3); }

/* ── WhatsApp CTA ── */
.vc-btn-whatsapp {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 13px; border-radius: 12px; border: none; cursor: pointer;
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: #fff; font-size: 0.86rem; font-weight: 700;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 4px 16px rgba(37,211,102,0.3);
    transition: all 0.22s cubic-bezier(.34,1.56,.64,1);
    text-decoration: none;
    -webkit-tap-highlight-color: transparent;
}
.vc-btn-whatsapp:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,211,102,0.4); color: #fff; text-decoration: none; }
.vc-btn-whatsapp:active { transform: scale(0.98); }

.vc-report-actions { display: flex; flex-direction: column; gap: 10px; }
.vc-btn-outline {
    background: transparent; border: 1.5px solid rgba(1,31,75,0.15);
    color: rgba(1,31,75,0.6); width: 100%; padding: 11px; border-radius: 12px;
    font-size: 0.83rem; font-weight: 600; cursor: pointer;
    font-family: 'Poppins', sans-serif; transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    -webkit-tap-highlight-color: transparent;
}
.vc-btn-outline:hover { border-color: #011f4b; color: #011f4b; background: rgba(1,31,75,0.03); }

/* ── No coverage / outside city screens ── */
.vc-nocoverage {
    display: flex; flex-direction: column; align-items: center; text-align: center;
    padding: 16px 4px 8px;
}
.vc-nocoverage-icon {
    width: 64px; height: 64px; border-radius: 50%; margin: 0 auto 16px;
    display: flex; align-items: center; justify-content: center; font-size: 1.8rem;
}
.vc-nocoverage-icon.orange { background: rgba(255,92,0,0.1); }
.vc-nocoverage-icon.blue   { background: rgba(59,130,246,0.1); }
.vc-nocoverage h3 {
    font-size: 1.1rem; font-weight: 800; color: #011f4b;
    margin: 0 0 8px; font-family: 'Poppins', sans-serif;
}
.vc-nocoverage p {
    font-size: 0.82rem; color: rgba(1,31,75,0.5); line-height: 1.7;
    margin: 0 0 18px; font-family: 'Poppins', sans-serif;
}
.vc-notify-form { width: 100%; display: flex; flex-direction: column; gap: 10px; }
.vc-notify-label {
    font-size: 0.7rem; font-weight: 700; color: rgba(1,31,75,0.5);
    letter-spacing: 0.07em; text-transform: uppercase;
    text-align: left; font-family: 'Poppins', sans-serif;
}

/* ════════════════════════════════════════
   MOBILE RESPONSIVE — FIX
════════════════════════════════════════ */
@media (max-width: 400px) {
    /* Modal */
    .vc-modal { width: 97%; border-radius: 20px; }
    .vc-content { padding: 14px 16px 24px; }
    .vc-progress-header { padding: 16px 50px 0 16px; }

    /* Close btn */
    .vc-close-btn { top: 12px; right: 12px; width: 32px; height: 32px; }

    /* Title sizes */
    .vc-title { font-size: 1.1rem; }
    .vc-subtitle { font-size: 0.79rem; margin-bottom: 16px; }

    /* Step 3 details — FIX: single column on tiny screens */
    .vc-details-grid { grid-template-columns: 1fr !important; }

    /* Report price range — smaller */
    .vc-report-price-range { font-size: 1.25rem; }

    /* Report stats — FIX: stack on tiny screens */
    .vc-report-stats { grid-template-columns: 1fr; }
    .vc-report-stat-value { font-size: 0.82rem; }

    /* Trust strip — center items */
    .vc-trust-strip { gap: 8px; padding: 10px 12px; }
    .vc-trust-item { font-size: 0.63rem; }

    /* Option cards */
    .vc-option-card { padding: 11px 12px; gap: 12px; }
    .vc-icon-box { width: 40px; height: 40px; }
    .vc-option-card-text-title { font-size: 0.88rem; }

    /* Nav actions */
    .vc-nav-actions { gap: 8px; }
    .vc-btn-back { width: 42px; height: 42px; min-width: 42px; }
    .vc-btn { font-size: 0.83rem; padding: 12px 16px; }

    /* Loader */
    .vc-loader-overlay { padding: 20px 16px 20px; margin-left: -16px; margin-right: -16px; width: calc(100% + 32px); }
    .vc-ai-orbit { width: 66px; height: 66px; margin-bottom: 14px; }
    .vc-ai-orbit-core { inset: 24px; }
    .vc-ai-orbit-ring-2 { inset: 8px; }
    .vc-ai-orbit-ring-3 { inset: 17px; }
    .vc-ai-label { font-size: 0.92rem; }
    .vc-ai-sublabel { font-size: 0.72rem; margin-bottom: 14px; }
    .vc-ai-step { padding: 8px 10px; font-size: 0.73rem; gap: 8px; }
    .vc-ai-step-icon { width: 24px; height: 24px; font-size: 0.72rem; }
}

@media (max-width: 360px) {
    .vc-report-price-range { font-size: 1.1rem; }
    .vc-btn-whatsapp { font-size: 0.8rem; gap: 7px; }
    .vc-btn-whatsapp svg { width: 16px; height: 16px; }
}

/* Larger phones — minor tweaks */
@media (min-width: 401px) and (max-width: 480px) {
    .vc-content { padding: 16px 20px 26px; }
    .vc-progress-header { padding: 18px 52px 0 20px; }
}
</style>

<!-- Backdrop -->
<div id="vc-backdrop" class="vc-backdrop" onclick="ValuationComponent.close()"></div>

<!-- Modal -->
<div id="vc-modal" class="vc-modal" role="dialog" aria-modal="true" aria-label="Property Valuation">

    <button onclick="ValuationComponent.close()" class="vc-close-btn" aria-label="Close">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <line x1="18" y1="6" x2="6" y2="18"/>
            <line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>

    <!-- Progress header -->
    <div class="vc-progress-header" id="vc-progress-header">
        <div class="vc-progress-inline">
            <span id="vc-progress-text">Step 1 of 4</span>
            <div class="vc-progress-dots">
                <div class="vc-dot"></div>
                <div class="vc-dot"></div>
                <div class="vc-dot"></div>
                <div class="vc-dot"></div>
            </div>
        </div>
    </div>

    <div id="vc-content" class="vc-content">

        <!-- AI LOADER — FIX: placed inside vc-content so sticky positioning works -->
        <div id="vc-loader" class="vc-loader-overlay">
            <div class="vc-ai-orbit">
                <div class="vc-ai-orbit-ring vc-ai-orbit-ring-1"></div>
                <div class="vc-ai-orbit-ring vc-ai-orbit-ring-2"></div>
                <div class="vc-ai-orbit-ring vc-ai-orbit-ring-3"></div>
                <div class="vc-ai-orbit-core">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="white">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
            </div>
            <p class="vc-ai-label">Analyzing Property</p>
            <p class="vc-ai-sublabel">Our AI is processing your data…</p>
            <div class="vc-ai-steps">
                <div class="vc-ai-step" id="vcls-1"><div class="vc-ai-step-icon">📍</div><span>Locating property &amp; locality</span></div>
                <div class="vc-ai-step" id="vcls-2"><div class="vc-ai-step-icon">📊</div><span>Fetching locality price bands</span></div>
                <div class="vc-ai-step" id="vcls-3"><div class="vc-ai-step-icon">🏠</div><span>Applying property parameters</span></div>
                <div class="vc-ai-step" id="vcls-4"><div class="vc-ai-step-icon">✨</div><span>Generating valuation report</span></div>
            </div>
            <div class="vc-ai-step-bar">
                <div class="vc-ai-step-bar-fill" id="vc-loader-bar"></div>
            </div>
        </div>

        <!-- ══ STEP 1 — Address ══ -->
        <div id="vc-step-1" class="vc-step vc-active">
            <div class="vc-step-badge"><div class="vc-step-badge-dot"></div>Location</div>
            <h2 class="vc-title">Where is your property?</h2>
            <p class="vc-subtitle">Start typing your address — we'll find it instantly.</p>
            <div class="vc-input-group">
                <label class="vc-label">Property Address</label>
                <!-- FIX: Wrapper for search spinner -->
                <div class="vc-address-wrap">
                    <input id="vc-address" type="text" class="vc-input"
                        placeholder="e.g. Vibhuti Khand, Gomti Nagar, Lucknow"
                        autocomplete="off"
                        oninput="ValuationComponent.onAddressInput(this)">
                    <!-- FIX: Inline search spinner shown while typing -->
                    <div class="vc-address-spinner" id="vc-address-spinner">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#008080" stroke-width="2.5" stroke-linecap="round">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                        </svg>
                    </div>
                </div>
                <div class="vc-location-pill" id="vc-location-pill"></div>
            </div>
            <button id="vc-next-1" class="vc-btn vc-btn-primary" onclick="ValuationComponent.goToStep(2)" disabled>
                Continue
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
            <div class="vc-trust-strip">
                <div class="vc-trust-item">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    100% Free
                </div>
                <div class="vc-trust-item">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Instant Report
                </div>
                <div class="vc-trust-item">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    No Agent Bias
                </div>
            </div>
        </div>

        <!-- ══ STEP 2 — Property Type ══ -->
        <div id="vc-step-2" class="vc-step">
            <div class="vc-step-badge"><div class="vc-step-badge-dot"></div>Property Type</div>
            <h2 class="vc-title">What type of property?</h2>
            <p class="vc-subtitle">This helps us apply the right pricing model.</p>
            <div class="vc-options-grid">
                <label class="vc-option-card vc-type-card" onclick="ValuationComponent.selectType('house', this)">
                    <input type="radio" name="vc-type" value="house">
                    <div class="vc-icon-box">
                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <div>
                        <div class="vc-option-card-text-title">House / Villa</div>
                        <div class="vc-option-card-text-sub">Independent residential property</div>
                    </div>
                    <div class="vc-check">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </label>
                <label class="vc-option-card vc-type-card" onclick="ValuationComponent.selectType('flat', this)">
                    <input type="radio" name="vc-type" value="flat">
                    <div class="vc-icon-box">
                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <path d="M3 9h18M3 15h18M9 3v18"/>
                        </svg>
                    </div>
                    <div>
                        <div class="vc-option-card-text-title">Flat / Apartment</div>
                        <div class="vc-option-card-text-sub">Multi-storey residential unit</div>
                    </div>
                    <div class="vc-check">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </label>
                <label class="vc-option-card vc-type-card" onclick="ValuationComponent.selectType('plot', this)">
                    <input type="radio" name="vc-type" value="plot">
                    <div class="vc-icon-box">
                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <line x1="3" y1="9" x2="21" y2="9"/>
                            <line x1="9" y1="21" x2="9" y2="9"/>
                        </svg>
                    </div>
                    <div>
                        <div class="vc-option-card-text-title">Plot / Land</div>
                        <div class="vc-option-card-text-sub">Residential land for construction</div>
                    </div>
                    <div class="vc-check">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                </label>
            </div>
            <div class="vc-nav-actions">
                <button class="vc-btn vc-btn-back" onclick="ValuationComponent.goToStep(1)">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                </button>
                <button id="vc-next-2" class="vc-btn vc-btn-primary vc-btn-next" onclick="ValuationComponent.goToStep(3)" disabled>Continue</button>
            </div>
        </div>

        <!-- ══ STEP 3 — Property Details (FIX: Facing removed) ══ -->
        <div id="vc-step-3" class="vc-step">
            <div class="vc-step-badge"><div class="vc-step-badge-dot"></div>Property Details</div>
            <h2 id="vc-step-3-title" class="vc-title">Tell us more</h2>
            <p class="vc-subtitle">A few details help our AI give you a precise estimate.</p>

            <!-- FIX: Area is now full width since Facing is removed -->
            <div class="vc-input-group">
                <label class="vc-label">Area (Sq Ft)</label>
                <input id="vc-area" type="number" class="vc-input"
                    placeholder="e.g. 1500"
                    min="100"
                    oninput="ValuationComponent.validateStep(3)">
                <div class="vc-field-hint" id="vc-area-hint">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Minimum area is 100 sq ft
                </div>
            </div>

            <!-- House/Villa fields -->
            <div id="vc-house-fields" style="display:none">
                <div class="vc-divider"></div>
                <!-- FIX: responsive grid class -->
                <div class="vc-details-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="vc-input-group">
                        <label class="vc-label">Rooms</label>
                        <select id="vc-rooms" class="vc-select" onchange="ValuationComponent.validateStep(3)">
                            <option value="">Select</option>
                            <option value="1">1 BHK</option>
                            <option value="2">2 BHK</option>
                            <option value="3">3 BHK</option>
                            <option value="4">4 BHK</option>
                            <option value="5+">5+ BHK</option>
                        </select>
                        <div class="vc-field-hint" id="vc-rooms-hint"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Please select rooms</div>
                    </div>
                    <div class="vc-input-group">
                        <label class="vc-label">Floor</label>
                        <select id="vc-floor" class="vc-select" onchange="ValuationComponent.validateStep(3)">
                            <option value="">Select</option>
                            <option value="G">Ground</option>
                            <option value="G+1">G+1</option>
                            <option value="G+2">G+2</option>
                            <option value="G+3+">G+3+</option>
                        </select>
                        <div class="vc-field-hint" id="vc-floor-hint"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Please select floor</div>
                    </div>
                </div>
                <div class="vc-input-group">
                    <label class="vc-label">Construction Year</label>
                    <select id="vc-year" class="vc-select" onchange="ValuationComponent.validateStep(3)">
                        <option value="">Select Year</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2020-2022">2020–2022</option>
                        <option value="2015-2019">2015–2019</option>
                        <option value="2010-2014">2010–2014</option>
                        <option value="Older">Older</option>
                    </select>
                    <div class="vc-field-hint" id="vc-year-hint"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Please select construction year</div>
                </div>
                <div class="vc-input-group">
                    <label class="vc-label">Amenities</label>
                    <div class="vc-features-wrap">
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="kitchen">🍳 Kitchen</button>
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="furnished">🛋️ Furnished</button>
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="parking">🚗 Parking</button>
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="garden">🌿 Garden</button>
                    </div>
                </div>
            </div>

            <!-- Flat/Apartment fields -->
            <div id="vc-flat-fields" style="display:none">
                <div class="vc-divider"></div>
                <div class="vc-details-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                    <div class="vc-input-group">
                        <label class="vc-label">BHK</label>
                        <select id="vc-bhk" class="vc-select" onchange="ValuationComponent.validateStep(3)">
                            <option value="">Select</option>
                            <option value="1">1 BHK</option>
                            <option value="2">2 BHK</option>
                            <option value="3">3 BHK</option>
                            <option value="4">4 BHK</option>
                            <option value="5+">5+ BHK</option>
                        </select>
                        <div class="vc-field-hint" id="vc-bhk-hint"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Please select BHK</div>
                    </div>
                    <div class="vc-input-group">
                        <label class="vc-label">Floor No.</label>
                        <select id="vc-flat-floor" class="vc-select" onchange="ValuationComponent.validateStep(3)">
                            <option value="">Select</option>
                            <option value="G">Ground</option>
                            <option value="1-3">1–3</option>
                            <option value="4-7">4–7</option>
                            <option value="8-12">8–12</option>
                            <option value="13+">13+</option>
                        </select>
                        <div class="vc-field-hint" id="vc-flatfloor-hint"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Please select floor</div>
                    </div>
                </div>
                <div class="vc-input-group">
                    <label class="vc-label">Construction Year</label>
                    <select id="vc-flat-year" class="vc-select" onchange="ValuationComponent.validateStep(3)">
                        <option value="">Select Year</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2020-2022">2020–2022</option>
                        <option value="2015-2019">2015–2019</option>
                        <option value="2010-2014">2010–2014</option>
                        <option value="Older">Older</option>
                    </select>
                    <div class="vc-field-hint" id="vc-flatyear-hint"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>Please select construction year</div>
                </div>
                <div class="vc-input-group">
                    <label class="vc-label">Amenities</label>
                    <div class="vc-features-wrap">
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="furnished">🛋️ Furnished</button>
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="parking">🚗 Parking</button>
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="lift">🛗 Lift</button>
                        <button class="vc-tag" onclick="ValuationComponent.toggleFeature(this)" data-feature="gym">🏋️ Gym</button>
                    </div>
                </div>
            </div>

            <div class="vc-nav-actions">
                <button class="vc-btn vc-btn-back" onclick="ValuationComponent.goToStep(2)">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                </button>
                <button id="vc-next-3" class="vc-btn vc-btn-primary vc-btn-next" onclick="ValuationComponent.tryProceedStep(3)" disabled>Continue</button>
            </div>
        </div>

        <!-- ══ STEP 4 — Phone ══ -->
        <div id="vc-step-4" class="vc-step">
            <div class="vc-step-badge"><div class="vc-step-badge-dot"></div>Almost Done</div>
            <h2 class="vc-title">Where to send your report?</h2>
            <p class="vc-subtitle">Enter your mobile number and we'll generate your AI valuation report instantly.</p>
            <div class="vc-input-group">
                <label class="vc-label">Mobile Number</label>
                <div class="vc-phone-wrap">
                    <div class="vc-phone-prefix">
                        🇮🇳 +91
                        <div class="vc-phone-prefix-divider"></div>
                    </div>
                    <input id="vc-phone" type="tel" class="vc-input"
                        placeholder="10-digit number"
                        maxlength="10"
                        oninput="ValuationComponent.validatePhone(this)">
                </div>
                <p id="vc-phone-error" style="font-size:0.73rem;margin-top:8px;color:#ef4444;font-family:'Poppins',sans-serif;align-items:center;gap:5px;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    Enter a valid 10-digit mobile number
                </p>
            </div>
            <div class="vc-nav-actions">
                <button class="vc-btn vc-btn-back" onclick="ValuationComponent.goToStep(3)">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                </button>
                <button id="vc-next-4" class="vc-btn vc-btn-primary vc-btn-next" onclick="ValuationComponent.submit()" disabled>
                    Get My Valuation
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </div>
            <div class="vc-trust-strip" style="margin-top:16px">
                <div class="vc-trust-item">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Data is private
                </div>
                <div class="vc-trust-item">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    No spam calls
                </div>
                <div class="vc-trust-item">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Report in seconds
                </div>
            </div>
        </div>

        <!-- ══ REPORT ══ -->
        <div id="vc-step-report" class="vc-step">
            <div class="vc-report" id="vc-report-content"></div>
        </div>

        <!-- ══ OUTSIDE LUCKNOW screen ══ -->
        <div id="vc-step-outside" class="vc-step">
            <div class="vc-nocoverage">
                <div class="vc-nocoverage-icon blue">🗺️</div>
                <h3>We're Only in Lucknow Right Now</h3>
                <p>DSD Properties currently covers <strong>50+ localities across Lucknow</strong>. We detected your property is outside Lucknow.<br><br>We're expanding to other UP cities soon — leave your number and we'll notify you!</p>
                <div class="vc-notify-form">
                    <label class="vc-notify-label">Your Mobile Number</label>
                    <div class="vc-phone-wrap">
                        <div class="vc-phone-prefix">🇮🇳 +91<div class="vc-phone-prefix-divider"></div></div>
                        <input id="vc-outside-phone" type="tel" class="vc-input" placeholder="10-digit number" maxlength="10">
                    </div>
                    <button class="vc-btn vc-btn-primary" onclick="ValuationComponent.notifyOutside()">
                        Notify Me When Available
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </button>
                    <button class="vc-btn-outline" onclick="ValuationComponent.goToStep(1)">← Try a Different Address</button>
                </div>
            </div>
        </div>

        <!-- ══ NO COVERAGE screen ══ -->
        <div id="vc-step-nocoverage" class="vc-step">
            <div class="vc-nocoverage">
                <div class="vc-nocoverage-icon orange">📍</div>
                <h3>This Area Isn't in Our Database Yet</h3>
                <p>We couldn't find <strong id="vc-nc-area-name">this locality</strong> in our coverage map yet.<br><br>We cover <strong>50+ Lucknow localities</strong> and are adding more every month — drop your number and we'll notify you!</p>
                <div class="vc-notify-form">
                    <label class="vc-notify-label">Your Mobile Number</label>
                    <div class="vc-phone-wrap">
                        <div class="vc-phone-prefix">🇮🇳 +91<div class="vc-phone-prefix-divider"></div></div>
                        <input id="vc-nc-phone" type="tel" class="vc-input" placeholder="10-digit number" maxlength="10">
                    </div>
                    <button class="vc-btn vc-btn-primary" onclick="ValuationComponent.notifyNoCoverage()">
                        Notify Me When Added
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </button>
                    <button class="vc-btn-outline" style="margin-top:4px" onclick="ValuationComponent.goToStep(1)">← Try a Different Address</button>
                </div>
            </div>
        </div>

    </div><!-- /vc-content -->
</div><!-- /vc-modal -->

<script>
const ValuationComponent = (function () {

    const LOCATIONS = [
        { name:'Hazratganj',           aliases:['hazrat ganj','hzg'],                                      lat:26.8500,lng:80.9440, segment:'Premium',    price:'₹9,000–₹14,000/sqft',  min:9000,  max:14000 },
        { name:'Butler Colony',        aliases:['butler'],                                                  lat:26.8610,lng:80.9580, segment:'Premium',    price:'₹10,000–₹15,000/sqft', min:10000, max:15000 },
        { name:'Vibhuti Khand',        aliases:['vibhuti'],                                                 lat:26.8650,lng:81.0020, segment:'Premium',    price:'₹8,000–₹11,000/sqft',  min:8000,  max:11000 },
        { name:'Gomti Nagar',          aliases:['gomti nagar central','gomtinagar','gomti'],                 lat:26.8500,lng:80.9960, segment:'Premium',    price:'₹8,000–₹12,000/sqft',  min:8000,  max:12000 },
        { name:'Gomti Nagar Extension',aliases:['gne','gomti nagar ext','gomtinagar extension'],             lat:26.8380,lng:81.0250, segment:'Premium',    price:'₹7,000–₹9,500/sqft',   min:7000,  max:9500  },
        { name:'Mahanagar',            aliases:['maha nagar'],                                              lat:26.8770,lng:80.9540, segment:'Premium',    price:'₹7,500–₹10,000/sqft',  min:7500,  max:10000 },
        { name:'Nirala Nagar',         aliases:['nirala'],                                                  lat:26.8800,lng:80.9400, segment:'Premium',    price:'₹7,000–₹9,500/sqft',   min:7000,  max:9500  },
        { name:'New Hyderabad',        aliases:['new hyderabad colony'],                                    lat:26.8710,lng:80.9470, segment:'Premium',    price:'₹7,000–₹9,000/sqft',   min:7000,  max:9000  },
        { name:'Sushant Golf City',    aliases:['sushant','golf city','sgc'],                               lat:26.7750,lng:81.0150, segment:'Premium',    price:'₹6,500–₹8,500/sqft',   min:6500,  max:8500  },
        { name:'Ashiyana',             aliases:['ashiana'],                                                 lat:26.7880,lng:80.9150, segment:'Premium',    price:'₹6,500–₹9,000/sqft',   min:6500,  max:9000  },
        { name:'Aliganj',              aliases:['ali ganj'],                                                lat:26.9000,lng:80.9500, segment:'Upper Mid',  price:'₹5,500–₹7,500/sqft',   min:5500,  max:7500  },
        { name:'Vrindavan Yojna',      aliases:['vrindavan','vridavan yojna','vrindaban'],                  lat:26.7680,lng:80.9530, segment:'Upper Mid',  price:'₹5,000–₹7,000/sqft',   min:5000,  max:7000  },
        { name:'Amar Shaheed Path',    aliases:['shaheed path','amar path','asp'],                          lat:26.8020,lng:81.0230, segment:'Upper Mid',  price:'₹5,500–₹7,500/sqft',   min:5500,  max:7500  },
        { name:'Faizabad Road',        aliases:['faizabad rd'],                                             lat:26.8800,lng:81.0600, segment:'Upper Mid',  price:'₹5,000–₹7,000/sqft',   min:5000,  max:7000  },
        { name:'Raebareli Road',       aliases:['rae bareli road','rbl road','pgi road','raebareli rd'],    lat:26.7550,lng:80.9350, segment:'Upper Mid',  price:'₹4,800–₹6,800/sqft',   min:4800,  max:6800  },
        { name:'Kursi Road',           aliases:['kursi rd'],                                                lat:26.9100,lng:80.9200, segment:'Upper Mid',  price:'₹4,800–₹6,500/sqft',   min:4800,  max:6500  },
        { name:'Indira Nagar',         aliases:['indira nagar a block','indiranagar','indira'],             lat:26.8850,lng:80.9950, segment:'Upper Mid',  price:'₹5,000–₹7,000/sqft',   min:5000,  max:7000  },
        { name:'Krishna Nagar',        aliases:['krishnanagar'],                                            lat:26.8000,lng:80.9000, segment:'Upper Mid',  price:'₹4,800–₹6,800/sqft',   min:4800,  max:6800  },
        { name:'Telibagh',             aliases:['teli bagh'],                                               lat:26.8000,lng:80.9500, segment:'Upper Mid',  price:'₹4,800–₹6,500/sqft',   min:4800,  max:6500  },
        { name:'Chinhat',              aliases:['chin hat'],                                                lat:26.8750,lng:81.0400, segment:'Upper Mid',  price:'₹5,000–₹7,200/sqft',   min:5000,  max:7200  },
        { name:'IIM Road',             aliases:['iim','lucknow iim'],                                       lat:26.9210,lng:80.8920, segment:'Mid',        price:'₹4,200–₹6,200/sqft',   min:4200,  max:6200  },
        { name:'Jankipuram Extension', aliases:['jankipuram ext','janki puram'],                            lat:26.9380,lng:80.9520, segment:'Mid',        price:'₹4,000–₹5,800/sqft',   min:4000,  max:5800  },
        { name:'Sitapur Road',         aliases:['sitapur rd'],                                              lat:26.9400,lng:80.9000, segment:'Mid',        price:'₹4,000–₹5,500/sqft',   min:4000,  max:5500  },
        { name:'Balaganj',             aliases:['bala ganj'],                                               lat:26.8300,lng:80.8700, segment:'Mid',        price:'₹3,800–₹5,200/sqft',   min:3800,  max:5200  },
        { name:'Thakurganj',           aliases:['thakur ganj'],                                             lat:26.8500,lng:80.8800, segment:'Mid',        price:'₹4,000–₹5,800/sqft',   min:4000,  max:5800  },
        { name:'Rajajipuram',          aliases:['rajaji puram','raja ji puram'],                            lat:26.8350,lng:80.8880, segment:'Mid',        price:'₹4,000–₹5,500/sqft',   min:4000,  max:5500  },
        { name:'Para',                 aliases:[],                                                          lat:26.8100,lng:80.8800, segment:'Mid',        price:'₹3,800–₹5,200/sqft',   min:3800,  max:5200  },
        { name:'Matiyari',             aliases:[],                                                          lat:26.8600,lng:81.0450, segment:'Mid',        price:'₹4,200–₹5,800/sqft',   min:4200,  max:5800  },
        { name:'South City',           aliases:['south city lucknow'],                                      lat:26.7800,lng:80.9400, segment:'Mid',        price:'₹4,500–₹6,000/sqft',   min:4500,  max:6000  },
        { name:'Engineering College Road', aliases:['ec road','engineering college rd'],                    lat:26.9150,lng:80.9400, segment:'Mid',        price:'₹4,800–₹6,500/sqft',   min:4800,  max:6500  },
        { name:'Sarojini Nagar',       aliases:['sarojini'],                                                lat:26.7600,lng:80.8800, segment:'Affordable', price:'₹3,500–₹5,000/sqft',   min:3500,  max:5000  },
        { name:'Alambagh',             aliases:['alam bagh','alambaug'],                                    lat:26.8220,lng:80.9050, segment:'Affordable', price:'₹3,800–₹5,200/sqft',   min:3800,  max:5200  },
        { name:'Kakori Road',          aliases:['kakori'],                                                  lat:26.8500,lng:80.7700, segment:'Affordable', price:'₹3,000–₹4,500/sqft',   min:3000,  max:4500  },
        { name:'Dubagga',              aliases:[],                                                          lat:26.8500,lng:80.8600, segment:'Affordable', price:'₹3,000–₹4,800/sqft',   min:3000,  max:4800  },
        { name:'Bijnor Road',          aliases:['bijnor rd'],                                               lat:26.7500,lng:80.8800, segment:'Affordable', price:'₹3,200–₹4,800/sqft',   min:3200,  max:4800  },
        { name:'Kisan Path',           aliases:['kisan path belt','kishan path'],                           lat:26.8200,lng:81.0800, segment:'Affordable', price:'₹3,000–₹4,800/sqft',   min:3000,  max:4800  },
        { name:'Kamta',                aliases:[],                                                          lat:26.8700,lng:81.0300, segment:'Affordable', price:'₹4,000–₹5,500/sqft',   min:4000,  max:5500  },
        { name:'Deva Road',            aliases:['deva rd'],                                                 lat:26.8800,lng:81.0800, segment:'Affordable', price:'₹3,500–₹5,200/sqft',   min:3500,  max:5200  },
        { name:'LDA Colony',           aliases:['lda','kanpur road colony'],                                lat:26.7800,lng:80.9000, segment:'Affordable', price:'₹3,800–₹5,500/sqft',   min:3800,  max:5500  },
        { name:'Transport Nagar',      aliases:['transport nagar lucknow'],                                 lat:26.8100,lng:80.8900, segment:'Affordable', price:'₹3,500–₹5,000/sqft',   min:3500,  max:5000  },
        { name:'Mohanlalganj',         aliases:['mohan lal ganj'],                                          lat:26.6700,lng:81.0000, segment:'Budget',     price:'₹2,800–₹4,200/sqft',   min:2800,  max:4200  },
        { name:'Gosainganj',           aliases:['gosain ganj'],                                             lat:26.7200,lng:81.1200, segment:'Budget',     price:'₹2,500–₹3,800/sqft',   min:2500,  max:3800  },
        { name:'Banthra',              aliases:[],                                                          lat:26.6800,lng:80.8300, segment:'Budget',     price:'₹2,800–₹4,000/sqft',   min:2800,  max:4000  },
        { name:'Malihabad',            aliases:[],                                                          lat:26.9200,lng:80.7100, segment:'Budget',     price:'₹2,500–₹3,500/sqft',   min:2500,  max:3500  },
        { name:'Barabanki Road',       aliases:['barabanki rd fringe','barabanki road fringe'],             lat:26.9000,lng:81.1100, segment:'Budget',     price:'₹2,800–₹4,000/sqft',   min:2800,  max:4000  },
        { name:'Kisan Path Outer',     aliases:['kisan path outer zone'],                                   lat:26.7800,lng:81.1000, segment:'Budget',     price:'₹2,800–₹4,200/sqft',   min:2800,  max:4200  },
        { name:'Outer Ring Road',      aliases:['outer ring rd west','orr'],                                lat:26.9000,lng:80.7800, segment:'Budget',     price:'₹3,000–₹4,500/sqft',   min:3000,  max:4500  },
        { name:'Hardoi Road',          aliases:['hardoi rd fringe','hardoi road fringe'],                   lat:26.8800,lng:80.8200, segment:'Budget',     price:'₹2,800–₹4,000/sqft',   min:2800,  max:4000  },
        { name:'Raebareli Road Outer', aliases:['raebareli rd outer','rbl road outer'],                     lat:26.7121,lng:80.9695, segment:'Budget',     price:'₹2,800–₹4,200/sqft',   min:2800,  max:4200  },
        { name:'Sultanpur Road',       aliases:['sultanpur rd','sultanpur road outer','spr'],               lat:26.7400,lng:81.0800, segment:'Budget',     price:'₹3,000–₹4,500/sqft',   min:3000,  max:4500  }
    ];

    const LKO_BOUNDS   = { swLat:26.60, swLng:80.65, neLat:27.10, neLng:81.25 };
    const LKO_KEYWORDS = ['lucknow','lko','lucknau','लखनऊ'];

    const SEG_COLOR = { Premium:'#ef4444','Upper Mid':'#f97316',Mid:'#22c55e',Affordable:'#3b82f6',Budget:'#8b5cf6' };
    const SEG_BG    = { Premium:'#fef2f2','Upper Mid':'#fff7ed',Mid:'#f0fdf4',Affordable:'#eff6ff',Budget:'#f5f3ff' };

    const FLOOR_MULT   = { G:1.00,'G+1':1.03,'G+2':1.05,'G+3+':1.02 };
    const FLAT_FL_MULT = { G:0.97,'1-3':1.00,'4-7':1.03,'8-12':1.05,'13+':1.04 };
    const YEAR_MULT    = { '2025':1.10,'2024':1.08,'2023':1.06,'2020-2022':1.03,'2015-2019':0.97,'2010-2014':0.92,'Older':0.85 };
    const AMENITY_BUMP = { kitchen:0.02,furnished:0.04,parking:0.03,garden:0.025,lift:0.02,gym:0.02 };
    const PLOT_DISCOUNT = 0.70;
    const FLAT_DISCOUNT = 0.92;

    let currentStep    = 1;
    let selectedType   = null;
    let features       = [];
    let submissionData = {};
    let placesResult   = null;
    // FIX: Debounce timer for address spinner
    let _spinnerTimer  = null;

    function escHtml(s) { return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
    function capFirst(s) { return s ? s.charAt(0).toUpperCase()+s.slice(1) : ''; }
    function getCsrf() { var m = document.querySelector('meta[name="csrf-token"]'); return m ? m.content : ''; }

    function open() {
        document.getElementById('vc-backdrop').classList.add('vc-visible');
        document.getElementById('vc-modal').classList.add('vc-visible');
        document.body.style.overflow = 'hidden';
        if (window._initPlacesAutocomplete) window._initPlacesAutocomplete();
    }

    function close() {
        document.getElementById('vc-backdrop').classList.remove('vc-visible');
        document.getElementById('vc-modal').classList.remove('vc-visible');
        document.body.style.overflow = '';
        document.querySelectorAll('.pac-container').forEach(function(p){ p.style.display='none'; });
        setTimeout(resetForm, 350);
    }

    function goToStep(step) {
        var prev = document.getElementById('vc-step-' + currentStep);
        if (prev) prev.classList.remove('vc-active');

        // FIX: Clear validation errors when moving between steps
        clearAllErrors();

        var targetId;
        if (step === 'outside')     targetId = 'vc-step-outside';
        else if (step === 'nocoverage') targetId = 'vc-step-nocoverage';
        else if (step === 'report') targetId = 'vc-step-report';
        else                        targetId = 'vc-step-' + step;

        currentStep = step;
        var curr = document.getElementById(targetId);
        if (curr) curr.classList.add('vc-active');

        var ph = document.getElementById('vc-progress-header');
        var isNumericStep = (typeof step === 'number' && step >= 1 && step <= 4);
        if (ph) ph.style.display = isNumericStep ? '' : 'none';
        if (isNumericStep) updateProgress();

        // Scroll modal to top on step change
        var modal = document.getElementById('vc-modal');
        if (modal) modal.scrollTop = 0;
    }

    function updateProgress() {
        if (typeof currentStep !== 'number') return;
        document.querySelectorAll('.vc-dot').forEach(function(d,i){
            d.classList.remove('vc-dot-active','vc-dot-done');
            if (i+1 === currentStep) d.classList.add('vc-dot-active');
            else if (i+1 < currentStep) d.classList.add('vc-dot-done');
        });
        var txt = document.getElementById('vc-progress-text');
        if (txt) txt.textContent = 'Step '+currentStep+' of 4';
    }

    // FIX: Address input handler — shows spinner while typing, hides after pause
    function onAddressInput(input) {
        var spinner = document.getElementById('vc-address-spinner');
        var pill    = document.getElementById('vc-location-pill');

        // Show spinner
        if (spinner) spinner.classList.add('show');
        // Hide location pill while typing a new query
        if (pill && (input.value||'').length < 5) {
            pill.className = 'vc-location-pill';
            pill.innerHTML = '';
        }

        // Clear previous timer
        if (_spinnerTimer) clearTimeout(_spinnerTimer);

        // Hide spinner after 1.5s of inactivity (Places selection will also hide it)
        _spinnerTimer = setTimeout(function(){
            if (spinner) spinner.classList.remove('show');
        }, 1500);

        validateStep(1);
    }

    // ── Helper: mark field error ──────────────────────────────
    function setFieldError(id, hintId, hasError) {
        var el   = document.getElementById(id);
        var hint = hintId ? document.getElementById(hintId) : null;
        if (!el) return;
        if (hasError) {
            el.classList.add('vc-field-error');
            if (hint) hint.classList.add('show');
        } else {
            el.classList.remove('vc-field-error');
            if (hint) hint.classList.remove('show');
        }
    }

    function clearAllErrors() {
        document.querySelectorAll('.vc-field-error').forEach(function(el){ el.classList.remove('vc-field-error'); });
        document.querySelectorAll('.vc-field-hint.show').forEach(function(el){ el.classList.remove('show'); });
    }

    // ── Called by Continue buttons — highlights errors if any ─
    function tryProceedStep(step) {
        var valid = validateStep(step, true); // true = highlight errors
        if (valid) goToStep(step + 1);
    }

    function validateStep(step, showErrors) {
        showErrors = showErrors || false;
        if (step === 1) {
            var val = (document.getElementById('vc-address').value||'').trim();
            var btn = document.getElementById('vc-next-1');
            var ok  = val.length >= 5;
            if (btn) btn.disabled = !ok;
            return ok;
        }
        if (step === 2) {
            var btn2 = document.getElementById('vc-next-2');
            var ok2  = !!selectedType;
            if (btn2) btn2.disabled = !ok2;
            return ok2;
        }
        if (step === 3) {
            var areaEl  = document.getElementById('vc-area');
            var areaVal = parseInt(areaEl ? areaEl.value : 0) || 0;
            // FIX: min area 100 sqft
            var areaOk  = areaVal >= 100;
            if (showErrors) setFieldError('vc-area', 'vc-area-hint', !areaOk);
            else if (areaOk) setFieldError('vc-area', 'vc-area-hint', false);

            var valid = areaOk;

            if (selectedType === 'house') {
                var roomsOk = !!document.getElementById('vc-rooms').value;
                var floorOk = !!document.getElementById('vc-floor').value;
                var yearOk  = !!document.getElementById('vc-year').value;
                if (showErrors) {
                    setFieldError('vc-rooms','vc-rooms-hint', !roomsOk);
                    setFieldError('vc-floor','vc-floor-hint', !floorOk);
                    setFieldError('vc-year', 'vc-year-hint',  !yearOk);
                } else {
                    if (roomsOk) setFieldError('vc-rooms','vc-rooms-hint', false);
                    if (floorOk) setFieldError('vc-floor','vc-floor-hint', false);
                    if (yearOk)  setFieldError('vc-year', 'vc-year-hint',  false);
                }
                valid = valid && roomsOk && floorOk && yearOk;
            }
            if (selectedType === 'flat') {
                var bhkOk      = !!document.getElementById('vc-bhk').value;
                var ffOk       = !!document.getElementById('vc-flat-floor').value;
                var fyOk       = !!document.getElementById('vc-flat-year').value;
                if (showErrors) {
                    setFieldError('vc-bhk',       'vc-bhk-hint',      !bhkOk);
                    setFieldError('vc-flat-floor', 'vc-flatfloor-hint',!ffOk);
                    setFieldError('vc-flat-year',  'vc-flatyear-hint', !fyOk);
                } else {
                    if (bhkOk) setFieldError('vc-bhk',       'vc-bhk-hint',      false);
                    if (ffOk)  setFieldError('vc-flat-floor', 'vc-flatfloor-hint',false);
                    if (fyOk)  setFieldError('vc-flat-year',  'vc-flatyear-hint', false);
                }
                valid = valid && bhkOk && ffOk && fyOk;
            }

            var btn3 = document.getElementById('vc-next-3');
            if (btn3) btn3.disabled = !valid;
            return valid;
        }
        return true;
    }

    function validatePhone(input) {
        var val = input.value.replace(/\D/g,'');
        input.value = val;
        var err  = document.getElementById('vc-phone-error');
        var btn  = document.getElementById('vc-next-4');
        var valid = /^[6-9]\d{9}$/.test(val);
        if (err) err.classList.toggle('vc-visible', val.length > 0 && !valid);
        if (btn) btn.disabled = !valid;
    }

    function selectType(type, el) {
        selectedType = type;
        document.querySelectorAll('.vc-type-card').forEach(function(c){ c.classList.remove('vc-selected'); });
        el.classList.add('vc-selected');
        document.getElementById('vc-house-fields').style.display = (type==='house') ? 'block' : 'none';
        document.getElementById('vc-flat-fields').style.display  = (type==='flat')  ? 'block' : 'none';
        var t = document.getElementById('vc-step-3-title');
        if (t) t.textContent = type==='house' ? 'House Details' : type==='flat' ? 'Flat / Apartment Details' : 'Plot Details';
        validateStep(2);
    }

    function toggleFeature(btn) {
        var feat = btn.getAttribute('data-feature');
        btn.classList.toggle('vc-tag-active');
        if (features.indexOf(feat) > -1) features = features.filter(function(f){ return f!==feat; });
        else features.push(feat);
    }

    function isOutsideLucknow(address, lat, lng) {
        if (lat !== null && lng !== null) {
            if (lat < LKO_BOUNDS.swLat || lat > LKO_BOUNDS.neLat ||
                lng < LKO_BOUNDS.swLng || lng > LKO_BOUNDS.neLng) return true;
            return false;
        }
        var lower = address.toLowerCase();
        return !LKO_KEYWORDS.some(function(kw){ return lower.indexOf(kw) > -1; });
    }

    function findLocality(address) {
        var addrLower = address.toLowerCase();
        var best = null, bestScore = 0;
        LOCATIONS.forEach(function(loc) {
            var allTerms = [loc.name.toLowerCase()].concat(loc.aliases || []);
            allTerms.forEach(function(term) {
                if (addrLower.indexOf(term) > -1) {
                    var score = term.length;
                    if (score > bestScore) { bestScore = score; best = loc; }
                }
            });
        });
        return { loc: best, matched: best !== null };
    }

    // FIX: calcValuation — Facing removed
    function calcValuation(data) {
        var result = findLocality(data.address);
        var loc    = result.loc;
        var area   = parseInt(data.area) || 1000;
        var aMult  = 1.0;
        (data.features||[]).forEach(function(f){ aMult += (AMENITY_BUMP[f]||0); });

        var flMult = 1.0, yMult = 1.0, typeDiscount = 1.0;

        if (data.type === 'house') {
            flMult       = FLOOR_MULT[data.floor]  || 1.0;
            yMult        = YEAR_MULT[data.year]    || 0.95;
        } else if (data.type === 'flat') {
            flMult       = FLAT_FL_MULT[data.flatFloor] || 1.0;
            yMult        = YEAR_MULT[data.flatYear]     || 0.95;
            typeDiscount = FLAT_DISCOUNT;
        } else if (data.type === 'plot') {
            typeDiscount = PLOT_DISCOUNT;
        }

        var totalMult = flMult * yMult * aMult * typeDiscount;
        var minRate   = Math.round(loc.min * totalMult);
        var maxRate   = Math.round(loc.max * totalMult);
        var midRate   = Math.round((minRate+maxRate)/2);

        return {
            locality:loc, matched:result.matched,
            minRate, maxRate, midRate,
            totalMin:minRate*area, totalMax:maxRate*area, totalMid:midRate*area,
            area
        };
    }

    function formatCrore(n) {
        if (n>=10000000) return '₹'+(n/10000000).toFixed(2)+' Cr';
        if (n>=100000)   return '₹'+(n/100000).toFixed(1)+' L';
        return '₹'+n.toLocaleString('en-IN');
    }

    function submit() {
        var addr  = document.getElementById('vc-address').value;
        var phone = document.getElementById('vc-phone').value;

        // FIX: Removed 'facing' from submission data
        submissionData = {
            address:   addr,
            type:      selectedType,
            area:      document.getElementById('vc-area').value,
            phone:     phone,
            features:  features.slice(),
            timestamp: new Date().toISOString(),
            ua:        navigator.userAgent,
            rooms:     selectedType==='house' ? document.getElementById('vc-rooms').value    : null,
            floor:     selectedType==='house' ? document.getElementById('vc-floor').value    : null,
            year:      selectedType==='house' ? document.getElementById('vc-year').value     : null,
            bhk:       selectedType==='flat'  ? document.getElementById('vc-bhk').value      : null,
            flatFloor: selectedType==='flat'  ? document.getElementById('vc-flat-floor').value : null,
            flatYear:  selectedType==='flat'  ? document.getElementById('vc-flat-year').value  : null,
        };

        var _pr  = window._vcPlacesResult || null;
        var lat  = _pr ? _pr.lat : null;
        var lng  = _pr ? _pr.lng : null;
        if (isOutsideLucknow(addr, lat, lng)) {
            logSubmission(submissionData, 'outside_lucknow', null);
            goToStep('outside');
            return;
        }

        var locResult = findLocality(addr);
        if (!locResult.matched) {
            var ncName = document.getElementById('vc-nc-area-name');
            if (ncName) {
                var parts = addr.split(',');
                ncName.textContent = '"' + (parts[0] || addr).trim() + '"';
            }
            logSubmission(submissionData, 'no_coverage', null);
            goToStep('nocoverage');
            return;
        }

        // FIX: Lock modal scroll + show loader properly
        var modal = document.getElementById('vc-modal');
        var ph    = document.getElementById('vc-progress-header');
        if (ph)    ph.style.display = 'none';
        if (modal) modal.classList.add('vc-loading');
        if (modal) modal.scrollTop = 0;

        var loader = document.getElementById('vc-loader');
        loader.classList.add('vc-visible');

        var steps   = [1,2,3,4];
        var delays  = [0,900,1800,2700];
        var barPcts = [20,45,72,95];

        steps.forEach(function(s,i){
            setTimeout(function(){
                if (i>0) {
                    var prev = document.getElementById('vcls-'+steps[i-1]);
                    if (prev){ prev.classList.remove('active'); prev.classList.add('done'); prev.querySelector('.vc-ai-step-icon').textContent='✅'; }
                }
                var el = document.getElementById('vcls-'+s);
                if (el) el.classList.add('active');
                var bar = document.getElementById('vc-loader-bar');
                if (bar) bar.style.width = barPcts[i]+'%';
            }, delays[i]);
        });

        setTimeout(function(){
            var last = document.getElementById('vcls-4');
            if (last){ last.classList.remove('active'); last.classList.add('done'); last.querySelector('.vc-ai-step-icon').textContent='✅'; }
            var bar = document.getElementById('vc-loader-bar');
            if (bar) bar.style.width='100%';
            setTimeout(function(){
                loader.classList.remove('vc-visible');
                if (modal) modal.classList.remove('vc-loading');
                showReport(submissionData);
            }, 400);
        }, 3600);
    }

    function showReport(data) {
        var v        = calcValuation(data);
        var loc      = v.locality;
        var segColor = SEG_COLOR[loc.segment] || '#008080';
        var segBg    = SEG_BG[loc.segment]    || '#f0fdf4';
        var meterMap = { Premium:90,'Upper Mid':72,Mid:55,Affordable:38,Budget:20 };
        var meterPct = meterMap[loc.segment] || 50;

        // FIX: Property meta — no longer includes facing
        var propLabel = capFirst(data.type);
        if (data.type==='flat' && data.bhk) propLabel = data.bhk+' BHK Flat';
        var metaParts = [propLabel, parseInt(data.area).toLocaleString('en-IN')+' sq ft'];
        if (data.type==='house' && data.rooms) metaParts.push(data.rooms+' BHK');

        logSubmission(data, 'success', { localityName:loc.name, minTotal:v.totalMin, maxTotal:v.totalMax, midTotal:v.totalMid });

        var html =
        '<div class="vc-report-header">'+
          '<div class="vc-report-badge"><div class="vc-report-badge-dot"></div>AI Valuation Report · DSD Properties</div>'+
          '<div class="vc-report-address">'+escHtml(data.address)+'</div>'+
          '<div class="vc-report-meta">'+escHtml(metaParts.join(' · '))+'</div>'+
        '</div>'+

        '<div class="vc-report-price-block">'+
          '<div class="vc-report-price-label">Estimated Price Band</div>'+
          '<div class="vc-report-price-range">'+formatCrore(v.totalMin)+' <span>–</span> '+formatCrore(v.totalMax)+'</div>'+
          '<div style="margin-top:6px"><span class="vc-report-price-mid">📊 Mid Estimate: '+formatCrore(v.totalMid)+'</span></div>'+
          '<div class="vc-report-meter">'+
            '<div class="vc-report-meter-track"><div class="vc-report-meter-fill" id="vc-meter-fill" style="width:0%"></div></div>'+
            '<div class="vc-report-meter-labels"><span>Budget</span><span>Mid</span><span>Premium</span></div>'+
          '</div>'+
        '</div>'+

        '<div class="vc-report-stats">'+
          '<div class="vc-report-stat"><div class="vc-report-stat-label">Rate / Sq Ft</div><div class="vc-report-stat-value teal">₹'+v.minRate.toLocaleString('en-IN')+' – ₹'+v.maxRate.toLocaleString('en-IN')+'</div></div>'+
          '<div class="vc-report-stat"><div class="vc-report-stat-label">Area</div><div class="vc-report-stat-value">'+parseInt(data.area).toLocaleString('en-IN')+' sq ft</div></div>'+
          '<div class="vc-report-stat"><div class="vc-report-stat-label">Avg Rate</div><div class="vc-report-stat-value orange">₹'+v.midRate.toLocaleString('en-IN')+'/sqft</div></div>'+
          '<div class="vc-report-stat"><div class="vc-report-stat-label">Data Quality</div><div class="vc-report-stat-value">'+(loc.segment==='Premium'||loc.segment==='Upper Mid'?'🟢 High':'🟡 Moderate')+'</div></div>'+
        '</div>'+

        '<div class="vc-report-segment">'+
          '<div class="vc-report-segment-dot" style="background:'+segColor+';box-shadow:0 0 0 3px '+segColor+'22"></div>'+
          '<div class="vc-report-segment-info">'+
            '<div class="vc-report-segment-name">'+escHtml(loc.name)+'</div>'+
            '<div class="vc-report-segment-desc">'+loc.price+'</div>'+
          '</div>'+
          '<span class="vc-report-segment-tag" style="background:'+segBg+';color:'+segColor+';border:1px solid '+segColor+'33">'+loc.segment+'</span>'+
        '</div>'+

        '<div class="vc-report-note">'+
          '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'+
          'Data-based estimate, not a certified appraisal. Actual price depends on condition, negotiation, floor, and market timing.'+
        '</div>'+

        '<div class="vc-report-actions">'+
          '<a href="https://wa.me/918595002933?text='+encodeURIComponent('Hi, I just got a DSD Properties valuation for '+data.address+'. Estimated value: '+formatCrore(v.totalMin)+' – '+formatCrore(v.totalMax)+'. Can we discuss?')+'" target="_blank" rel="noopener" class="vc-btn-whatsapp">'+
            '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.4 0C5.098 0 0 5.098 0 11.4c0 2.1.57 4.07 1.562 5.757L0 22.8l5.79-1.519A11.356 11.356 0 0011.4 22.8c6.302 0 11.4-5.098 11.4-11.4S17.702 0 11.4 0zm0 20.88a9.463 9.463 0 01-5.035-1.446l-.361-.214-3.438.9.916-3.35-.235-.373A9.44 9.44 0 011.92 11.4C1.92 6.158 6.158 1.92 11.4 1.92S20.88 6.158 20.88 11.4 16.642 20.88 11.4 20.88z"/></svg>'+
            'Talk to a Local Expert on WhatsApp'+
          '</a>'+
          '<button class="vc-btn vc-btn-primary" onclick="ValuationComponent.close()">'+
            '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Done'+
          '</button>'+
          '<button class="vc-btn-outline" onclick="ValuationComponent.resetForm()">'+
            '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4"/></svg>Estimate Another Property'+
          '</button>'+
        '</div>';

        document.getElementById('vc-report-content').innerHTML = html;
        document.querySelectorAll('.vc-step').forEach(function(s){ s.classList.remove('vc-active'); });
        document.getElementById('vc-step-report').classList.add('vc-active');

        setTimeout(function(){
            var fill = document.getElementById('vc-meter-fill');
            if (fill) fill.style.width = meterPct+'%';
        }, 100);
    }

    function notifyOutside() {
        var phone = document.getElementById('vc-outside-phone').value;
        if (!/^[6-9]\d{9}$/.test(phone)) { alert('Please enter a valid 10-digit number.'); return; }
        logSubmission({ phone:phone, address:document.getElementById('vc-address').value, timestamp:new Date().toISOString() }, 'notify_outside', null);
        document.getElementById('vc-step-outside').innerHTML =
            '<div class="vc-nocoverage"><div class="vc-nocoverage-icon blue">✅</div><h3>You\'re on the List!</h3><p>We\'ll notify you on <strong>+91 '+escHtml(phone)+'</strong> as soon as DSD Properties expands to your area.</p><button class="vc-btn vc-btn-primary" style="margin-top:8px" onclick="ValuationComponent.close()">Done</button></div>';
    }

    function notifyNoCoverage() {
        var phone = document.getElementById('vc-nc-phone').value;
        if (!/^[6-9]\d{9}$/.test(phone)) { alert('Please enter a valid 10-digit number.'); return; }
        logSubmission({ phone:phone, address:document.getElementById('vc-address').value, timestamp:new Date().toISOString() }, 'notify_nocoverage', null);
        document.getElementById('vc-step-nocoverage').innerHTML =
            '<div class="vc-nocoverage"><div class="vc-nocoverage-icon orange">✅</div><h3>Got It!</h3><p>We\'ll notify you on <strong>+91 '+escHtml(phone)+'</strong> when your area goes live on DSD Properties.</p><button class="vc-btn vc-btn-primary" style="margin-top:8px" onclick="ValuationComponent.close()">Done</button></div>';
    }

    function resetForm() {
        // Reset state
        selectedType = null; features = []; placesResult = null; currentStep = 1;
        window._vcPlacesResult = null;

        // Clear all inputs
        ['vc-address','vc-area','vc-phone'].forEach(function(id){
            var el=document.getElementById(id); if(el) el.value='';
        });
        ['vc-rooms','vc-floor','vc-year','vc-bhk','vc-flat-floor','vc-flat-year'].forEach(function(id){
            var el=document.getElementById(id); if(el) el.value='';
        });

        // FIX: Reset all button disabled states explicitly
        ['vc-next-1','vc-next-2','vc-next-3','vc-next-4'].forEach(function(id){
            var btn = document.getElementById(id);
            if (btn) btn.disabled = true;
        });

        // Clear selections & tags
        document.querySelectorAll('.vc-type-card').forEach(function(c){ c.classList.remove('vc-selected'); });
        document.querySelectorAll('.vc-tag').forEach(function(t){ t.classList.remove('vc-tag-active'); });

        // Hide conditional fields
        document.getElementById('vc-house-fields').style.display = 'none';
        document.getElementById('vc-flat-fields').style.display  = 'none';

        // Clear location pill & spinner
        var pill = document.getElementById('vc-location-pill');
        if (pill){ pill.className='vc-location-pill'; pill.textContent=''; }
        var spinner = document.getElementById('vc-address-spinner');
        if (spinner) spinner.classList.remove('show');

        // FIX: Clear all field errors
        clearAllErrors();

        // Reset loader steps
        [1,2,3,4].forEach(function(i){
            var el=document.getElementById('vcls-'+i); if(!el) return;
            el.classList.remove('active','done');
            el.querySelector('.vc-ai-step-icon').textContent=['📍','📊','🏠','✨'][i-1];
        });
        var bar=document.getElementById('vc-loader-bar'); if(bar) bar.style.width='0%';
        var loader=document.getElementById('vc-loader'); if(loader) loader.classList.remove('vc-visible');

        // Reset progress header
        var ph=document.getElementById('vc-progress-header'); if(ph) ph.style.display='';
        var modal=document.getElementById('vc-modal'); if(modal) modal.classList.remove('vc-loading');

        // Reset phone error
        var perr=document.getElementById('vc-phone-error'); if(perr) perr.classList.remove('vc-visible');

        // Reset step visibility
        document.querySelectorAll('.vc-step').forEach(function(s){ s.classList.remove('vc-active'); });
        var s1=document.getElementById('vc-step-1'); if(s1) s1.classList.add('vc-active');

        // Reset step 3 title
        var t=document.getElementById('vc-step-3-title'); if(t) t.textContent = 'Tell us more';

        updateProgress();
    }

    function logSubmission(data, status, valuationResult) {
        var payload = Object.assign({}, data, {
            status:    status || 'success',
            valuation: valuationResult || null,
            page_url:  window.location.href
        });
        console.log('📋 DSD Valuation:', status, payload);
        fetch('/api/valuation-log', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(function(r){ if(!r.ok) throw new Error('HTTP '+r.status); return r.json(); })
        .then(function(d){ console.log('✅ Saved to DB:', d); })
        .catch(function(e){ console.warn('⚠️ DB log failed (non-critical):', e); });
    }

    return { open, close, goToStep, validateStep, tryProceedStep, validatePhone, selectType, toggleFeature, submit, resetForm, notifyOutside, notifyNoCoverage, onAddressInput };

})();

/* ── Google Places Autocomplete ── */
(function () {
    var _autocomplete = null;

    function initPlacesAutocomplete() {
        if (_autocomplete) return;
        if (!window.google || !google.maps || !google.maps.places) {
            setTimeout(initPlacesAutocomplete, 400); return;
        }
        var input = document.getElementById('vc-address');
        if (!input) return;

        _autocomplete = new google.maps.places.Autocomplete(input, {
            bounds: new google.maps.LatLngBounds(
                new google.maps.LatLng(26.70, 80.80),
                new google.maps.LatLng(27.05, 81.12)
            ),
            strictBounds: false,
            componentRestrictions: { country: 'in' },
            fields: ['formatted_address', 'name', 'geometry'],
            types: ['geocode', 'establishment']
        });

        _autocomplete.addListener('place_changed', function () {
            var place   = _autocomplete.getPlace();
            var spinner = document.getElementById('vc-address-spinner');
            var pill    = document.getElementById('vc-location-pill');

            // FIX: Hide spinner when place is selected
            if (spinner) spinner.classList.remove('show');
            if (!place) return;

            if (place.formatted_address) input.value = place.formatted_address;
            else if (place.name) input.value = place.name;

            if (place.geometry && place.geometry.location) {
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                window._vcPlacesResult = { lat: lat, lng: lng };
                var lkoBounds  = { swLat:26.60,swLng:80.65,neLat:27.10,neLng:81.25 };
                var inLucknow  = lat>=lkoBounds.swLat && lat<=lkoBounds.neLat && lng>=lkoBounds.swLng && lng<=lkoBounds.neLng;
                if (pill) {
                    pill.className = 'vc-location-pill show ' + (inLucknow ? 'ok' : 'error');
                    pill.innerHTML = inLucknow
                        ? '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Lucknow location detected'
                        : '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg> This location appears to be outside Lucknow';
                }
            } else {
                window._vcPlacesResult = null;
                if (pill) { pill.className = 'vc-location-pill show warn'; pill.innerHTML = '📍 Location selected — verifying area…'; }
            }

            ValuationComponent.validateStep(1);
        });

        console.log('✅ Places Autocomplete ready');
    }

    window._initPlacesAutocomplete = initPlacesAutocomplete;

    window.addEventListener('load', function () {
        var _orig = window.pmInitMap;
        window.pmInitMap = function () {
            if (typeof _orig === 'function') _orig.apply(this, arguments);
            initPlacesAutocomplete();
        };
        if (window.google && window.google.maps && window.google.maps.places) {
            initPlacesAutocomplete();
        }
    });
})();
</script>