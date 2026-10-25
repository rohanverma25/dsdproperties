<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DSD Properties')</title>

    <!-- ✅ Clean favicon setup (only keep necessary) -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.webp') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.webp') }}">

    <!-- ✅ SEO -->
    <meta name="google-site-verification" content="Q7gyYzFh-KdtZBaq-fhIqYp1kt7p-1Ve5iyRqgaHWW0" />
    <meta name="description" content="@yield('meta_description', 'Latest updates on Lucknow properties')">
    <meta name="keywords" content="@yield('meta_keywords', 'Lucknow property, real estate, plots')">
    <meta name="author" content="DSD Properties">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- ✅ Open Graph -->
    <meta property="og:title" content="@yield('title', 'DSD Properties - Insights and Updates')">
    <meta property="og:description" content="@yield('meta_description', 'Latest updates on Lucknow properties')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.webp'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <meta name="google-adsense-account" content="ca-pub-7668303809064282">
    <!-- ✅ Preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- ✅ Async Google Fonts load -->
    <link rel="preload"
          href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          as="style"
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    </noscript>

    <!-- ✅ Async Font Awesome (load after paint) -->
    <link rel="preload" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
          as="style" 
          onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" 
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </noscript>

    <!-- ✅ Main CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-DarJ6pGr.css') }}"> --}}

    <!-- ✅ Google Analytics (async) -->
    {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-Q3FHCGKDZ9"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-Q3FHCGKDZ9');
      gtag('config', 'AW-18304150909');
    </script> --}}

    <!-- ✅ Defer scripts -->
    {{-- <script src="{{ asset('build/assets/app-Br7aW4iV.js') }}" defer></script> --}}

    <!-- <link rel="stylesheet" href="{{ asset('css/valuation-component.css') }}">
    <script src="{{ asset('js/valuation-component.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/valuation-component.css') }}"> -->
    <style>
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
        
        [data-theme="dark"] {
            /* Dark mode colors */
            --bg-primary: #1f2937;
            --bg-secondary: #111827;
            --bg-tertiary: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #e5e7eb;
            --text-tertiary: #d1d5db;
            --border-color: #374151;
            --card-bg: #1f2937;
            --input-bg: #374151;
            
            /* Brand colors (adjusted for dark mode) */
            --color-primary: #3b82f6;
            --color-secondary: #14b8a6;
            --color-accent: #f97316;
            --color-light-teal: #0f766e;
            
            /* Gradient */
            --gradient-primary: linear-gradient(to right, #3b82f6, #14b8a6);
        }
        
        html, body {
            overflow-x: hidden;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        /* .custom-logo {
            max-height: 40px;
        } */
        
        /* Only apply theme colors to content area, not globally */
        .content-area {
            /* color: var(--text-primary); */
        }
        
        .content-area h1, 
        .content-area h2, 
        .content-area h3, 
        .content-area h4, 
        .content-area h5, 
        .content-area h6 {
            /* //color: var(--text-primary); */
        }
        
        /* .content-area p, 
        .content-area span, 
        .content-area li {
            color: var(--text-secondary);
        } */
        
        /* Hero section specific styles - these should remain white in light mode */
        .gradient-primary {
            background: var(--gradient-primary);
            color: white;
        }
        
        .gradient-primary h1,
        .gradient-primary h2,
        .gradient-primary h3,
        .gradient-primary h4,
        .gradient-primary h5,
        .gradient-primary h6,
        .gradient-primary p,
        .gradient-primary span,
        .gradient-primary li,
        .gradient-primary a {
            color: white;
        }
        
        /* Footer specific styles - these should remain light in light mode */
        footer {
            background-color: var(--color-primary);
            color: white;
        }
        
        footer h1,
        footer h2,
        footer h3,
        footer h4,
        footer h5,
        footer h6,
        footer p,
        footer span,
        footer li,
        footer a {
            color: white;
        }
        
        /* Utility classes */
        .bg-primary { background-color: var(--color-primary); }
        .bg-secondary { background-color: var(--color-secondary); }
        .bg-accent { background-color: var(--color-accent); }
        .bg-light-teal { background-color: var(--color-light-teal); }
        
        .color-primary { color: var(--color-primary); }
        .color-secondary { color: var(--color-secondary); }
        .color-accent { color: var(--color-accent); }
        
        .text-primary { color: var(--text-primary); }
        .text-secondary { color: var(--text-secondary); }
        .text-tertiary { color: var(--text-tertiary); }
        
        .bg-card { background-color: var(--card-bg); }
        .bg-secondary-bg { background-color: var(--bg-secondary); }
        .bg-tertiary-bg { background-color: var(--bg-tertiary); }
        
        .border-custom { border-color: var(--border-color); }
        
        .card-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-shadow:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-input {
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        /* Blog card styles */
        .blog-card {
            background-color: var(--card-bg);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .blog-card:hover {
            transform: translateY(-5px);
        }
        
        .category-badge {
            background-color: var(--color-primary);
        }
        
        .featured-badge {
            background-color: var(--color-accent);
        }
    </style>
@stack('head')
</head>
<body>
    @include('layouts.header')
       <div class="content-area">
        @yield('content')
    </div>

    @include('layouts.footer')

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
</script>
<script>
// Append page URL to every WhatsApp link so incoming messages are traceable
document.querySelectorAll('a[href*="wa.me"]').forEach(function(a) {
    try {
        var url = new URL(a.href);
        var text = url.searchParams.get('text') || '';
        if (text.indexOf('Page: ') !== -1) return; // link already names its page
        text += '\n\nPage: ' + window.location.href;
        url.searchParams.set('text', text);
        a.href = url.toString();
    } catch(e) {}
});
</script>
@stack('scripts')
<script>
// ── DSD Properties — Global Analytics ──────────────────────────
(function(){
  var HOST = window.location.hostname;
  function track(ev, p) { if (typeof gtag === 'function') gtag('event', ev, p || {}); }

  // WhatsApp, Phone, Outbound link clicks
  document.addEventListener('click', function(e) {
    var a = e.target.closest('a[href]');
    if (!a) return;
    var href = a.href || '';
    if (href.indexOf('wa.me') > -1)
      track('whatsapp_click', { event_category: 'lead', page: location.pathname });
    if (href.indexOf('tel:') === 0)
      track('phone_call', { event_category: 'lead', page: location.pathname });
    if (href.indexOf('http') === 0 && href.indexOf(HOST) === -1 && href.indexOf('wa.me') === -1)
      track('outbound_click', { event_category: 'outbound', url: href });
  });

  // Contact Us CTA — also fire GA alongside the existing sendBeacon
  document.addEventListener('click', function(e) {
    if (e.target.closest('#consultationBtn'))
      track('contact_us_click', { event_category: 'lead', page: location.pathname });
  });

  // Scroll depth 25 / 50 / 75 / 90%
  var hit = {};
  var scrollTicking = false;
  window.addEventListener('scroll', function() {
    if (scrollTicking) return;
    scrollTicking = true;
    requestAnimationFrame(function() {
      var pct = Math.min(100, Math.round((window.scrollY + window.innerHeight) / document.body.scrollHeight * 100));
      [25, 50, 75, 90].forEach(function(m) {
        if (!hit[m] && pct >= m) {
          hit[m] = true;
          track('scroll', { percent_scrolled: m, page: location.pathname });
        }
      });
      scrollTicking = false;
    });
  }, { passive: true });

})();
</script>
@include('components.readers-toast')
</body>
</html>