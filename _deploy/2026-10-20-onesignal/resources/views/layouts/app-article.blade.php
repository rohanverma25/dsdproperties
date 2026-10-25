<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    {{-- ══════════════════════════════════════════════
         SEO — each page injects its own meta via @yield('seo')
         Falls back to site-wide defaults if not provided
    ══════════════════════════════════════════════ --}}
    @hasSection('seo')
        @yield('seo')
    @else
        <title>DSD Properties — AI Property Valuation for Lucknow</title>
        <meta name="description" content="Free AI-powered property valuation for Lucknow. Get an instant, data-driven price estimate for any property across 50+ localities. No agents. No fees.">
        <link rel="canonical" href="{{ url()->current() }}">
        <meta property="og:type"        content="website">
        <meta property="og:title"       content="DSD Properties — AI Property Valuation for Lucknow">
        <meta property="og:description" content="Free AI-powered property valuation for Lucknow. 50+ localities covered.">
        <meta property="og:url"         content="{{ url()->current() }}">
        <meta property="og:site_name"   content="DSD Properties">
        <meta property="og:image"       content="{{ asset('images/og-default.png') }}">
        <meta name="twitter:card"       content="summary_large_image">
    @endif

    {{-- Robots — pages can override this via @section('seo') --}}
    @unless(View::hasSection('seo'))
        <meta name="robots" content="index, follow">
    @endunless

    {{-- ── FAVICON ────────────────────────────────────── --}}
    <link rel="icon"       type="image/webp" href="{{ asset('images/logo.webp') }}">
    <link rel="shortcut icon"                href="{{ asset('favicon.ico') }}">

    {{-- ── FONTS ─────────────────────────────────────── --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

    {{-- ── TAILWIND CSS ───────────────────────────────── --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ── GLOBAL STYLES ──────────────────────────────── --}}
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        /* Smooth scrollbar hiding for filter bars */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        /* Prose styles for article body */
        .article-body p  { margin-bottom: 1.25rem; line-height: 1.8; color: #374151; }
        .article-body h2 { font-size: 1.35rem; font-weight: 700; color: #111827; margin: 2rem 0 0.75rem; }
        .article-body h3 { font-size: 1.1rem;  font-weight: 700; color: #111827; margin: 1.5rem 0 0.5rem; }
        .article-body ul { list-style: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .article-body ul li { margin-bottom: 0.4rem; color: #374151; }
        .article-body a  { color: #1d4ed8; text-decoration: underline; }
        .article-body strong { color: #111827; font-weight: 600; }

                :root {
            /* Light mode colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f3f4f6;
            --bg-tertiary: #e5e7eb;
            --text-primary: #111827;
            --text-secondary: #4b5563;
            --text-tertiary: #6b7280;
            --border-color: #e5e7eb;
            --card-bg: #ffffff;
            --input-bg: #ffffff;
            
            /* Brand colors */
            --color-primary: #011f4b;
            --color-secondary: #008080;
            --color-accent: #FF5C00;
            --color-light-teal: #e0f2f1;
            
            /* Gradient */
            --gradient-primary: linear-gradient(to right, #011f4b, #008080);
        }
        #sticky-bottom-bar .cta-btn {
            background: linear-gradient(135deg, #FF5C00, #ff8840); 
            color: #fff;
            font-size: .8rem; font-weight: 700;
            padding: 10px 22px; border-radius: 999px;
            text-decoration: none; white-space: nowrap;
            box-shadow: 0 3px 12px rgba(15,31,92,.35);
            transition: background .2s;
        }
        #sticky-bottom-bar .cta-btn:hover { background: #1a3a8f; }
        .cta-btn{
            display: inline-flex;
            align-items: center;
            gap: 8px; /* space between icon and text */
        }
    </style>

    {{-- ── Google Analytics (GA4) ──────────────────────── --}}
    @include('partials.ga4')
    @include('partials.whatsapp-message-tag')
    @include('partials.onesignal')

    {{-- ── PAGE-SPECIFIC HEAD ──────────────────────────── --}}
    @stack('head')
</head>

<body class="bg-white text-gray-900 antialiased">

    {{-- ══════════════════════════════════════════════════
         NAVIGATION
    ══════════════════════════════════════════════════ --}}
  @include('layouts.header')

    {{-- ══════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════ --}}
    <main>
        @yield('content')
    </main>
    @include('components.valuation-modal')
    @include('layouts.footer')

    {{-- Page-specific scripts injected here --}}
    @stack('scripts')
@include('components.readers-toast')
</body>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1cK-JwjPR7AuRgdnSEETdxX2_KzqbOBI&libraries=visualization,places&callback=pmInitMap">
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("consultationBtn");

    if (btn) {
        btn.addEventListener("click", function () {

            const data = new FormData();
            data.append('page_url', window.location.href);
            data.append('_token', '{{ csrf_token() }}');

            navigator.sendBeacon(
                "{{ route('log.consultation.click') }}",
                data
            );
        });
    }
});
</html>