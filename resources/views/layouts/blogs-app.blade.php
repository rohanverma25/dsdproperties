<!DOCTYPE html>
<html lang="@yield('lang', 'en')" class="scroll-smooth" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DSD Properties Blog')</title>
    <!-- ✅ Clean favicon setup (only keep necessary) -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.webp') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.webp') }}">
    <meta property="og:site_name" content="DSD Properties">
    <meta name="description" content="@yield('meta_description', 'Latest updates on Lucknow properties')">
    <meta name="keywords" content="@yield('meta_keywords', 'Lucknow property, real estate, plots')">
    <link rel="canonical" href="{{ route('blog.show', $blog->slug) }}">
    {{-- hreflang for bilingual pages --}}
    @if($blog->alternate_slug)
    @php
    $altBlog = \App\Models\BlogPost::where('slug', $blog->alternate_slug)->first();
    $hreflangMap = [
        'en' => 'en-IN',
        'hi' => 'hi-IN',
    ];
    $currentHreflang = $hreflangMap[$blog->language]    ?? $blog->language;
    $altHreflang     = $hreflangMap[$altBlog->language] ?? $altBlog->language;
    $defaultSlug = $blog->language === 'en' ? $blog->slug : $altBlog->slug;
    @endphp
    @if($altBlog)
    <link rel="alternate" hreflang="{{ $currentHreflang }}" href="{{ route('blog.show', $blog->slug) }}">
    <link rel="alternate" hreflang="{{ $altHreflang }}" href="{{ route('blog.show', $altBlog->slug) }}">
    <link rel="alternate" hreflang="x-default" href="{{ route('blog.show', $defaultSlug) }}">
    @endif
    @endif
    <meta property="og:title" content="@yield('title', 'DSD Properties Blog - Insights and Updates')">
    <meta property="og:description" content="@yield('meta_description', 'Latest updates on Lucknow properties')">
    <meta property="og:image" content="@yield('og_image', asset('default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'DSD Properties Blog')">
    <meta name="twitter:description" content="@yield('meta_description', 'Latest updates on Lucknow properties')">
    <meta name="twitter:image" content="{{ asset('logo/og-image.webp') }}">
    <meta name="author" content="DSD Properties">
    {{-- max-snippet / max-image-preview let Google (incl. AI Overviews) quote full passages --}}
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="google-adsense-account" content="ca-pub-7668303809064282">
    @stack('main_schema')
    @stack('faq_schema')
    {{-- Business entity, so search and AI answers can tie every article to the firm behind it.
         No aggregateRating: Google ignores self-published review stars. --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "RealEstateAgent",
      "@id": "https://dsdproperties.in/#organization",
      "name": "DSD Properties",
      "url": "https://dsdproperties.in",
      "logo": "{{ asset('logo/image911.png') }}",
      "image": "{{ asset('logo/og-image.webp') }}",
      "description": "Lucknow real estate advisory and property verification firm: LDA scheme guidance, legal verification of plots and flats, registry support for buyers, sellers and NRIs.",
      "telephone": "+91-8595002933",
      "email": "dheer@dsdproperties.in",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2",
        "addressLocality": "Lucknow",
        "addressRegion": "Uttar Pradesh",
        "postalCode": "226025",
        "addressCountry": "IN"
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
        "opens": "09:00",
        "closes": "19:00"
      },
      "areaServed": { "@type": "City", "name": "Lucknow" },
      "knowsAbout": ["LDA housing schemes", "Property verification", "UP RERA", "Property registry in Uttar Pradesh", "Dakhil Kharij (mutation)", "IGRSUP property search"]
    }
    </script>
    <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Noto+Sans+Devanagari:wght@400;500;700&display=swap' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> --}}
    @include('partials.ga4')
    @include('partials.whatsapp-message-tag')
    @include('partials.onesignal')
     <!-- Chart.js — loaded once globally -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Destroy any existing Chart instances before re-initializing
        document.querySelectorAll('canvas[id]').forEach(function(canvas) {
            var existing = Chart.getChart(canvas);
            if (existing) existing.destroy();
        });
    });
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Responsive image classes */
        .desktop-image {
            display: block;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .mobile-image {
            display: none;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        @media screen and (max-width: 768px) {
            .desktop-image {
                display: none;
            }
            .mobile-image {
                display: block;
            }
        }
        /* close*/
        
        /* Additional styles border*/ 
        .border-color-red{
            border: 2px solid #ef5a16;
            border-radius: 10px;
            padding: 10px 20px;
            margin: 20px 0;
        }
        /* close */
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
            
            /* Hindi content font */
            --font-hindi: 'Noto Sans Devanagari', sans-serif;
            
            /* Additional colors for dark mode compatibility */
            --error-color: #ef4444;
            --success-color: #10b981;
            --info-color: #3b82f6;
            --warning-color: #f59e0b;
            --table-header-bg: #20B2AA;
            --table-header-text: #ffffff;
            --table-even-row: #f9fafb;
            --table-hover: rgba(0,128,128,0.08);
            --section-title: #011f4b;
            --sub-section-title: #008080;
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
            
            /* Additional colors for dark mode */
            --error-color: #f87171;
            --success-color: #34d399;
            --info-color: #60a5fa;
            --warning-color: #fbbf24;
            --table-header-bg: #14b8a6;
            --table-header-text: #ffffff;
            --table-even-row: #374151;
            --table-hover: rgba(59, 130, 246, 0.15);
            --section-title: #60a5fa;
            --sub-section-title: #14b8a6;
        }
        
        html, body {
            line-height: 1.8;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            overflow-x: visible; /* Change from hidden to visible */
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
            font-family: 'Poppins', 'Noto Sans Devanagari', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
        }
        
        /* Hindi content styling */
        /* .hindi-content {
            font-family: var(--font-hindi);
            line-height: 1.8;
        } */
        
        .custom-logo {
            max-height: 40px;
        }
        
        /* Only apply theme colors to content area, not globally */
        .content-area {
            color: var(--text-primary);
        }
        
        .content-area h1, 
        .content-area h2, 
        .content-area h3, 
        .content-area h4, 
        .content-area h5, 
        .content-area h6 {
            color: var(--text-primary);
        }
        
        .content-area p, 
        .content-area span, 
        .content-area li {
            color: var(--text-secondary);
        }
        
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
        
        /* Blog specific styles */
        .blog-content {
            line-height: 1.7;
        }
        
        .blog-content h1, .blog-content h2, .blog-content h3, .blog-content h4, .blog-content h5, .blog-content h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
            line-height: 1.35;
        }
        
        .blog-content h1 {
            font-size: 2rem;
        }
        
        .blog-content h2 {
            font-size: 1.75rem;
        }
        
        .blog-content h3 {
            font-size: 1.5rem;
        }
        
        .blog-content p {
            margin-bottom: 1rem;
        }
        
        .blog-content ul, .blog-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        
        .blog-content li {
            margin-bottom: 0.5rem;
        }
        
        .blog-content blockquote {
            border-left: 4px solid var(--color-accent);
            padding-left: 1rem;
            font-style: italic;
            margin: 1.5rem 0;
        }
        
        .blog-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
        }
        
        .blog-content pre {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1.5rem 0;
        }
        
        .blog-content code {
            background-color: var(--bg-tertiary);
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-size: 0.9rem;
        }
        
        .tag-cloud {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }
        
        .tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: var(--bg-secondary);
            color: var(--text-secondary);
            border-radius: 9999px;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }
        
        .tag:hover {
            background-color: var(--color-primary);
            color: white;
        }
        
        /* Author box */
        .author-box {
            display: flex;
            align-items: center;
            padding: 1rem;
            background-color: var(--bg-secondary);
            border-radius: 0.5rem;
            margin-top: 2rem;
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 1rem;
            object-fit: cover;
        }
        
        .author-info h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1.125rem;
        }
        
        .author-info p {
            margin: 0;
            font-size: 0.875rem;
        }
        
        /* Related posts */
        .related-post {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .related-post:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .related-post-image {
            width: 80px;
            height: 80px;
            border-radius: 0.5rem;
            object-fit: cover;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        .related-post-content h4 {
            margin: 0 0 0.5rem 0;
            font-size: 1rem;
            line-height: 1.4;
        }
        
        .related-post-content .date {
            font-size: 0.875rem;
            color: var(--text-tertiary);
        }
        
        /* Table styling for property data */
        .property-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
        }
        
        .property-table th,
        .property-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        .property-table th {
            background-color: var(--table-header-bg);
            color: var(--table-header-text);
            font-weight: 600;
        }
        
        .property-table tr:nth-child(even) {
            background-color: var(--table-even-row);
        }
        
        .property-table tr:hover {
            background-color: var(--table-hover);
        }
        
        /* FAQ section styling */
        /* .faq-item {
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .faq-question {
            padding: 1rem;
            background-color: var(--bg-secondary);
            font-weight: 600;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-answer {
            padding: 1rem;
            display: none;
        }
        
        .faq-item.active .faq-answer {
            display: block;
        }
        
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        
        .faq-question i {
            transition: transform 0.3s ease;
        } */
        
        /* Additional styles to fix dark mode issues */
        /* Override hardcoded colors in blog content */
        .blog-content * {
            color: inherit;
        }
        
        .blog-content p, 
        .blog-content span, 
        .blog-content li {
            color: var(--text-secondary);
        }
        
        .blog-content h1, 
        .blog-content h2, 
        .blog-content h3, 
        .blog-content h4, 
        .blog-content h5, 
        .blog-content h6 {
            color: var(--text-primary);
        }
        
        /* Section titles with theme-aware colors */
        .section-title {
            color: var(--section-title) !important;
        }
        
        .sub-section-title, 
        .sub-section, 
        .subsection-title {
            color: var(--sub-section-title) !important;
        }
        
        /* Disclaimer box */
        .kc-disc-bg {
            background-color: var(--bg-secondary) !important;
            color: var(--text-secondary) !important;
        }
        
        /* Comment form */
        .max-w-xxl {
            background-color: var(--card-bg) !important;
            color: var(--text-primary) !important;
        }
        
        .max-w-xxl input,
        .max-w-xxl textarea {
            background-color: var(--input-bg) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        
        .max-w-xxl button {
            background-color: var(--color-primary) !important;
        }
        
        /* Error messages */
        .error-message {
            color: var(--error-color) !important;
        }
        
        /* Border colors */
        .border {
            border-color: var(--border-color) !important;
        }
        
        /* Text colors */
        .text-gray-500, .text-gray-700, .text-gray-800 {
            color: var(--text-secondary) !important;
        }
        
        .text-white {
            color: white !important;
        }
        
        /* Background colors */
        .bg-white {
            background-color: var(--card-bg) !important;
        }
        
        .bg-[#F8F8FF] {
            background-color: var(--bg-secondary) !important;
        }
        
        /* Shadow */
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }
        
        /* Override specific hardcoded styles */
        [style*="color:black"], [style*="color: black"] {
            color: var(--text-primary) !important;
        }
        
        [style*="background: linear-gradient"] {
            background: var(--gradient-primary) !important;
        }
        
        /* Back to top button */
        #backToTopBtn {
            background-color: var(--color-secondary) !important;
        }
        
        /* Sticky header styles */
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: var(--bg-primary);
        }
        
        /* Progress bar */
        .progress-bar-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: var(--bg-tertiary);
        }
        
        .progress-bar {
            height: 100%;
            background: var(--gradient-primary);
            transition: width 0.3s ease;
        }
        
        /* Two-column layout: without min-width:0 the main column can't shrink below the
           widest thing inside it (the Google Reviews carousel is 1100px), which crushed the
           sidebar form to ~180px on every laptop screen. */
        @media (min-width: 1024px) {
            .blog-layout-main  { min-width: 0; }
            .blog-layout-aside { flex-shrink: 0; min-width: 280px; }
        }

        /* Sticky sidebar styles */
        .sticky-sidebar {
            position: sticky;
            top: 85px; /* Adjust this value based on header height */
            z-index: 40;
        }
        /* Add these styles to your CSS */

/* Line clamp utility for truncating text */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Recent posts card styling */
.bg-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.bg-card:hover {
    transform: translateY(-2px);
}

/* Category badge styling */
.bg-primary.bg-opacity-10 {
    background-color: rgba(var(--color-primary), 0.1);
}

/* Image hover effect */
.object-cover {
    transition: transform 0.3s ease;
}
/* .blog-content p, .blog-content span, .blog-content li{
    text-align:justify;
} */
/* Responsive adjustments */
@media (max-width: 768px) {
    .group.flex.gap-4 {
        flex-direction: column;
        gap: 3;
    }
    
    .w-20.h-20 {
        width: 100%;
        height: 120px;
    }
    .content-area{
        padding:2rem 0px!important;
    }
}
h2.section-title {
  color: #011f4b;
  font-family: sans-serif;
  border-left: 5px solid #ff5c00;
  padding-left: 15px;
  margin-top: 40px;
}
.tbl-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch;margin-bottom:1rem;border-radius:6px}
.tbl-scroll table{min-width:480px;margin-bottom:0}
</style>

</head>
<?php
?>
@include('layouts.header')
<body class="flex flex-col min-h-screen">
    {{-- Sticky Header --}}
    {{-- <header class="sticky-header">
        <div class="container mx-auto flex justify-between items-center py-4 px-4">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.webp') }}" alt="logo" class="h-14 w-14 sm:h-16 sm:w-16 md:h-20 md:w-20">
                <div class="flex flex-col">
                    <div class="flex items-baseline">
                        <span class="text-3xl font-bold tracking-tight" style="color: var(--color-primary);">DSD</span>
                        <span class="text-xl font-semibold ml-1" style="color: var(--color-accent);">Properties</span>
                    </div>
                    <div class="flex mt-1">
                        <span class="text-xs tracking-widest" style="color: var(--text-tertiary);">Lucknow 2025</span>
                    </div>
                </div>
            </a>
            
            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex space-x-6">
                <a href="/" class="font-medium" style="color: var(--text-primary);">Home</a>
                <a href="/about" class="font-medium" style="color: var(--text-primary);">About</a>
                <a href="/blog" class="font-medium" style="color: var(--text-primary);">Articles</a>
                <a href="/news" class="block font-medium" style="color: var(--text-primary);">Market Updates</a>
                <a href="/contact-us" class="font-medium" style="color: var(--text-primary);">Contact</a>
            </nav>
            
            <!-- Mobile menu button -->
            <button id="menu-toggle" class="lg:hidden focus:outline-none" style="color: var(--color-primary);">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        
        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="lg:hidden hidden" style="background-color: var(--bg-primary); border-top: 1px solid var(--border-color);">
            <div class="container mx-auto px-4 py-3">
                <a href="/" class="block py-3 px-4 font-medium" style="color: var(--text-primary);">Home</a>
                <a href="/about" class="block py-3 px-4 font-medium" style="color: var(--text-primary);">About</a>
                <a href="/blog" class="block py-3 px-4 font-medium" style="color: var(--text-primary);">Articles</a>
                <a href="/news" class="block py-3 px-4 font-medium" style="color: var(--text-primary);">Market Updates</a>
                <a href="/contact-us" class="block py-3 px-4 font-medium" style="color: var(--text-primary);">Contact</a>
            </div>
        </div>
        
        <!-- Progress Bar -->
        <div class="progress-bar-container">
            <div id="progress-bar" class="progress-bar" style="width: 0%;"></div>
        </div>
    </header> --}}
    
    {{-- Main Content Area --}}
    <div class="container mx-auto flex flex-col lg:flex-row flex-1 py-4 px-2">
        {{-- Page Content (Blog) --}}
        <main class="blog-layout-main flex-1 lg:mr-8 mb-8 lg:mb-0">
            <div class="content-area">
                @yield('content')
            </div>
        </main>

        {{-- Sidebar (Recent Posts + Form); none on info-only pages, see App\Support\InfoOnlyPages --}}
        @unless(\App\Support\InfoOnlyPages::active())
        <aside class="blog-layout-aside w-full lg:w-1/4 space-y-6">
            <div class="sticky-sidebar">
                {{-- Inquiry Form --}}
                @include('components.inquiry-form')
            </div>
        </aside>
        @endunless
    </div>
    @include('layouts.footer')

    
    {{-- Mobile sticky buy/sell bar --}}
<style>
.mob-cta-bar{display:none;position:fixed;bottom:0;left:0;right:0;z-index:9999;padding:10px 14px;background:#fff;border-top:1px solid #e5e7eb;box-shadow:0 -4px 18px rgba(0,0,0,.12);gap:10px}
@media(max-width:1023px){.mob-cta-bar{display:flex}body{padding-bottom:72px}}
.mob-cta-bar a{flex:1;display:flex;align-items:center;justify-content:center;gap:7px;padding:13px 10px;border-radius:10px;font-family:'Poppins',sans-serif;font-weight:700;font-size:.88rem;text-decoration:none;letter-spacing:.1px;transition:opacity .15s}
.mob-cta-bar a:hover{opacity:.88;text-decoration:none}
.mob-cta-buy{background:linear-gradient(135deg,#25D366,#128C7E);color:#fff !important}
.mob-cta-sell{background:linear-gradient(135deg,#011f4b,#013870);color:#fff !important}
</style>
@unless(\App\Support\InfoOnlyPages::active())
@include('components.mobile-cta-bar', ['ctaSlug' => $blog->slug ?? null, 'ctaTag' => $blog->tag ?? null])
@endunless
    <script>
        document.addEventListener('DOMContentLoaded', function() {
                // Mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            
            // Optional: Change icon from bars to X when menu is open
            const icon = this.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = mobileMenu.contains(event.target);
            const isClickOnToggle = menuToggle.contains(event.target);
            
            if (!isClickInsideMenu && !isClickOnToggle && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                const icon = menuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }
            const stickySidebar = document.querySelector('.sticky-sidebar');
            if (stickySidebar) {
                const header = document.querySelector('.sticky-header');
                const headerHeight = header ? header.offsetHeight : 0;
                stickySidebar.style.top = (headerHeight + 85) + 'px';
                window.addEventListener('resize', function() {
                    const newHeaderHeight = header ? header.offsetHeight : 0;
                    stickySidebar.style.top = (newHeaderHeight + 85) + 'px';
                });
            } 

            document.querySelectorAll('.consultation-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const data = new FormData();
                    data.append('page_url', window.location.href);
                    navigator.sendBeacon("{{ route('log.consultation.click') }}", data);
                });
            });

            // Make all tables in blog content horizontally scrollable on mobile
            document.querySelectorAll('.blog-content table, .content-area table').forEach(function(table) {
                if (table.parentElement.classList.contains('tbl-scroll')) return;
                var wrap = document.createElement('div');
                wrap.className = 'tbl-scroll';
                table.parentNode.insertBefore(wrap, table);
                wrap.appendChild(table);
            });

        });
</script>
@unless(\App\Support\InfoOnlyPages::active())
{{-- ── Inquiry Popup (exit-intent) — posts to /blog-feedback, which stores into the shared `form_submissions` inbox ── --}}
<style>
#fbk-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99999;
    background: rgba(0,0,0,.72);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
    align-items: center;
    justify-content: center;
    padding: 16px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
}
#fbk-overlay.fbk-show { display: flex; animation: fbkFade .25s ease; }
@keyframes fbkFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes fbkUp { from { transform: translateY(24px); opacity: 0; } to { transform: none; opacity: 1; } }
#fbk-card {
    position: relative;
    box-sizing: border-box; /* without this the padding made the card wider than a phone screen and cut off the close button */
    background: #fff;
    border-radius: 14px;
    width: 100%;
    max-width: 420px;
    /* Never taller than the screen, so the close button can't be pushed off the top on phones */
    max-height: calc(100vh - 32px);
    max-height: calc(100dvh - 32px);
    overflow-y: auto;
    margin: auto;
    padding: 24px 22px 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,.35);
    font-family: 'Poppins', sans-serif;
    animation: fbkUp .3s ease;
}
/* Phones: dock the card to the bottom like a sheet, clear of the site header */
@media (max-width: 600px) {
    #fbk-overlay { align-items: flex-end; padding: 0; }
    #fbk-card { max-width: none; margin: 0; border-radius: 18px 18px 0 0; max-height: 88vh; max-height: 88dvh; padding: 20px 18px calc(18px + env(safe-area-inset-bottom)); }
}
#fbk-card .fbk-chips { display: flex; flex-wrap: wrap; gap: 8px; }
#fbk-card .fbk-chip {
    border: 1.5px solid #e2e8f0; background: #f9fafb; color: #334155;
    border-radius: 999px; padding: 8px 13px; font-family: 'Poppins', sans-serif;
    font-size: .8rem; font-weight: 600; cursor: pointer;
}
#fbk-card .fbk-chip.on { border-color: #008080; background: #effaf9; color: #011f4b; }
#fbk-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
}
#fbk-card .fbk-logo {
    display: flex;
    align-items: center;
    gap: 8px;
}
#fbk-close-btn {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    color: #64748b;
    font-size: 1rem;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background .15s, color .15s;
}
#fbk-close-btn:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }
#fbk-card .fbk-logo span {
    font-size: 1.05rem;
    font-weight: 800;
    color: #011f4b;
}
#fbk-card .fbk-logo span em {
    color: #FF5C00;
    font-style: normal;
}
#fbk-card h3 {
    font-size: 1.05rem;
    font-weight: 800;
    color: #011f4b;
    margin: 0 0 10px;
    line-height: 1.3;
}
#fbk-card .fbk-intro {
    font-size: .8rem;
    color: #4b5563;
    line-height: 1.7;
    margin: 0 0 18px;
    border-left: 3px solid #FF5C00;
    padding-left: 10px;
}
#fbk-card .fbk-field { margin-bottom: 11px; }
#fbk-card .fbk-label {
    display: block;
    font-size: .68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    color: #6b7280;
    margin-bottom: 4px;
}
#fbk-card .fbk-optional {
    font-weight: 600;
    text-transform: none;
    letter-spacing: 0;
    color: #9ca3af;
}
#fbk-card .fbk-input {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: .84rem;
    color: #111827;
    background: #f9fafb;
    box-sizing: border-box;
    transition: border-color .15s;
}
#fbk-card .fbk-input:focus { outline: none; border-color: #008080; background: #fff; }
#fbk-card .fbk-input.fbk-err { border-color: #dc2626; background: #fff5f5; }
/* iOS Safari auto-zooms the page on focus when an input's font-size is under 16px — keep it at 16px on small screens to prevent that */
@media (max-width: 480px) {
    #fbk-card .fbk-input { font-size: 16px; }
}
#fbk-card .fbk-errtxt { font-size: .7rem; color: #dc2626; margin-top: 3px; display: none; }
#fbk-card .fbk-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #FF5C00, #ff8840);
    color: #fff;
    border: none;
    border-radius: 9px;
    font-family: 'Poppins', sans-serif;
    font-size: .88rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 6px;
    transition: opacity .2s;
}
#fbk-card .fbk-btn:disabled { opacity: .65; cursor: not-allowed; }
#fbk-skip {
    width: 100%;
    background: none;
    border: none;
    color: #94a3b8;
    font-family: 'Poppins', sans-serif;
    font-size: .78rem;
    cursor: pointer;
    padding: 10px 0 0;
    text-decoration: underline;
    display: block;
    text-align: center;
}
#fbk-skip:hover { color: #64748b; }
#fbk-success {
    text-align: center;
    padding: 10px 0 4px;
    display: none;
}
#fbk-success .fbk-tick {
    width: 52px; height: 52px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    font-size: 24px; color: #fff;
}
#fbk-success h4 { font-size: 1rem; font-weight: 800; color: #111827; margin: 0 0 6px; }
#fbk-success p  { font-size: .82rem; color: #64748b; margin: 0; line-height: 1.6; }
</style>

@php
    // Popup heading/intro tailored to the blog's category (falls back to a generic pitch)
    $fbkHeadings = [
        'Property Law'     => ['h' => 'Facing a Property Legal Issue?', 'i' => "Property law questions rarely have a one-size-fits-all answer. Share a few details and our team will get back to you with guidance specific to your situation."],
        'Legal Advice'     => ['h' => 'Need Legal Help with a Property Issue?', 'i' => "Since you're reading up on the legal side of real estate, let us help directly. Share your details and our team will get back to you with the right guidance."],
        'LDA Scheme Guide' => ['h' => 'Looking to Buy an LDA Plot in Lucknow?', 'i' => "We track every active LDA scheme in Lucknow. Share your requirement and our team will help you find the right plot and verify it before you pay."],
        'Buying Tips'      => ['h' => 'Ready to Buy Your Next Property?', 'i' => "Since you're researching before you buy, let us help you do it safely. Share your requirement and our team will get back to you with the right guidance."],
        'Selling Tips'     => ['h' => 'Thinking of Selling Your Property?', 'i' => "List for free and reach verified buyers directly. Share a few details and our team will get back to you with the right next steps."],
    ];
    $fbkTag     = $blog->tag ?? null;
    $fbkContent = $fbkHeadings[$fbkTag] ?? ['h' => 'Looking to Buy, Sell, or Verify a Property?', 'i' => "Since you're already reading up on Lucknow real estate, let us help directly. Share a few details below and our team will get back to you with the right guidance — whether it's property verification, buying, selling, or general advice."];
@endphp

<div id="fbk-overlay" role="dialog" aria-modal="true" aria-labelledby="fbk-title">
    <div id="fbk-card">
        <div id="fbk-card-header">
            <div class="fbk-logo">
                <svg width="26" height="26" viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="10" fill="#011f4b"/><path d="M10 20 C10 13 30 13 30 20 C30 27 10 27 10 20Z" fill="#008080" opacity=".5"/><circle cx="20" cy="20" r="5" fill="#FF5C00"/></svg>
                <span>DSD <em>Properties</em></span>
            </div>
            <button type="button" id="fbk-close-btn" aria-label="Close">&#x2715;</button>
        </div>

        <div id="fbk-form-wrap">
            <h3 id="fbk-title">{{ $fbkContent['h'] }}</h3>
            <p class="fbk-intro">{{ $fbkContent['i'] }}</p>

            <form id="fbk-form" novalidate>
                @csrf
                <input type="hidden" name="page_url" id="fbk-page-url">
                <x-honeypot form-id="exit" />

                <div class="fbk-field">
                    <label class="fbk-label" for="fbk-name">Your Name *</label>
                    <input type="text" id="fbk-name" name="name" class="fbk-input" autocomplete="name">
                    <div class="fbk-errtxt" id="fbk-name-err">Please enter your name.</div>
                </div>

                <div class="fbk-field">
                    <label class="fbk-label" for="fbk-mobile">Mobile Number *</label>
                    <input type="tel" id="fbk-mobile" name="mobile" class="fbk-input" autocomplete="tel" maxlength="10" inputmode="numeric">
                    <div class="fbk-errtxt" id="fbk-mobile-err">Enter a valid 10-digit Indian mobile number.</div>
                </div>

                {{-- Short form: the email box was dropped (it was optional), and the free-text requirement
                     became one-tap chips. The chosen chip fills the same `suggestion` field the server expects. --}}
                <div class="fbk-field">
                    <span class="fbk-label">I want to *</span>
                    <div class="fbk-chips" id="fbk-chips">
                        <button type="button" class="fbk-chip" data-v="Property advice">Property Advice</button>
                        <button type="button" class="fbk-chip" data-v="Legal advice">Legal Advice</button>
                        <button type="button" class="fbk-chip" data-v="Other enquiry">Other</button>
                    </div>
                    <input type="hidden" id="fbk-suggestion" name="suggestion">
                    <div class="fbk-errtxt" id="fbk-suggestion-err">Please pick one option.</div>
                </div>

                <button type="submit" class="fbk-btn" id="fbk-submit">Submit Inquiry →</button>
                <button type="button" id="fbk-skip">Maybe Later, Skip for now</button>
            </form>
        </div>

        <div id="fbk-success">
            <div class="fbk-tick">✓</div>
            <h4>Thank You!</h4>
            <p>We've received your inquiry. Our team will reach out to you shortly.</p>
        </div>
    </div>
</div>

<script>
(function () {
    var STORAGE_KEY = 'dsd_feedback_done';
    if (localStorage.getItem(STORAGE_KEY)) return; // already submitted

    var overlay    = document.getElementById('fbk-overlay');
    var form       = document.getElementById('fbk-form');
    var submitBtn  = document.getElementById('fbk-submit');
    var formWrap   = document.getElementById('fbk-form-wrap');
    var successBox = document.getElementById('fbk-success');
    var triggered  = false;

    document.getElementById('fbk-page-url').value = window.location.href;

    function showPopup() {
        if (triggered) return;
        triggered = true;
        overlay.classList.add('fbk-show');
        document.body.style.overflow = 'hidden';
    }

    // Real exit intent, not "30% scrolled". The reader must first have spent 20 s on the page
    // and read 40% of it. After that:
    //  - desktop: the mouse leaves through the top of the window (towards the tabs / close button);
    //  - phones (no mouse): a fast flick back up, the usual move before leaving or tapping back.
    // It shows once per browser session, and never again after Skip/close or a submission.
    var SESSION_KEY = 'dsd_fbk_shown';
    var startedAt   = Date.now();
    var maxRead     = 0;
    try { if (sessionStorage.getItem(SESSION_KEY)) triggered = true; } catch (e) {}

    function readShare() {
        var doc   = document.documentElement;
        var total = doc.scrollHeight - doc.clientHeight;
        return total > 0 ? (window.scrollY || doc.scrollTop) / total : 0;
    }
    function eligible() {
        return !triggered && Date.now() - startedAt >= 20000 && maxRead >= 0.40
            && !document.querySelector('#onesignal-slidedown-container .slidedown-body');
    }
    function exitIntent() {
        if (!eligible()) return;
        try { sessionStorage.setItem(SESSION_KEY, '1'); } catch (e) {}
        showPopup();
    }

    document.addEventListener('mouseout', function (e) {
        if (!e.relatedTarget && e.clientY <= 0) exitIntent();
    });

    var lastY = window.scrollY, lastT = Date.now();
    window.addEventListener('scroll', function () {
        var y = window.scrollY, t = Date.now();
        maxRead = Math.max(maxRead, readShare());
        // Upward speed of at least 1.2 px/ms, kept up for at least 120 px, counts as a flick back up
        if (lastY - y > 120 && (lastY - y) / Math.max(t - lastT, 1) > 1.2) exitIntent();
        if (t - lastT > 150) { lastY = y; lastT = t; }
    }, { passive: true });

    document.querySelectorAll('#fbk-chips .fbk-chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.querySelectorAll('#fbk-chips .fbk-chip').forEach(function (c) { c.classList.remove('on'); });
            chip.classList.add('on');
            document.getElementById('fbk-suggestion').value = chip.getAttribute('data-v');
            document.getElementById('fbk-suggestion-err').style.display = 'none';
        });
    });
    overlay.addEventListener('click', function (e) { if (e.target === overlay) dismissPopup(); });

    function dismissPopup() {
        localStorage.setItem(STORAGE_KEY, '1');
        overlay.classList.remove('fbk-show');
        document.body.style.overflow = '';
    }

    document.getElementById('fbk-skip').addEventListener('click', dismissPopup);
    document.getElementById('fbk-close-btn').addEventListener('click', dismissPopup);

    function showErr(inputEl, errEl) {
        inputEl.classList.add('fbk-err');
        errEl.style.display = 'block';
    }
    function clearErr(inputEl, errEl) {
        inputEl.classList.remove('fbk-err');
        errEl.style.display = 'none';
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var nameEl  = document.getElementById('fbk-name');
        var mobEl   = document.getElementById('fbk-mobile');
        var sugEl   = document.getElementById('fbk-suggestion');
        var nameErr = document.getElementById('fbk-name-err');
        var mobErr  = document.getElementById('fbk-mobile-err');
        var sugErr  = document.getElementById('fbk-suggestion-err');

        clearErr(nameEl, nameErr);
        clearErr(mobEl, mobErr);
        sugErr.style.display = 'none';

        var valid = true;

        if (!nameEl.value.trim() || nameEl.value.trim().length < 2) {
            showErr(nameEl, nameErr); valid = false;
        }
        if (!/^[6-9]\d{9}$/.test(mobEl.value.trim())) {
            showErr(mobEl, mobErr); valid = false;
        }
        if (!sugEl.value.trim()) {
            sugErr.style.display = 'block'; valid = false;
        }
        if (!valid) return;

        submitBtn.disabled    = true;
        submitBtn.textContent = 'Submitting…';

        fetch('{{ route("blog.feedback.store") }}', {
            method:  'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept':       'application/json',
            },
            body: new FormData(form),
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success) {
                localStorage.setItem(STORAGE_KEY, '1');
                formWrap.style.display = 'none';
                successBox.style.display = 'block';
                setTimeout(function () {
                    overlay.classList.remove('fbk-show');
                    document.body.style.overflow = '';
                }, 2200);
            } else {
                submitBtn.disabled    = false;
                submitBtn.textContent = 'Submit Inquiry →';
                if (data.errors) {
                    var msgs = [];
                    Object.values(data.errors).forEach(function (m) { msgs.push(m[0]); });
                    alert(msgs.join('\n'));
                }
            }
        })
        .catch(function () {
            submitBtn.disabled    = false;
            submitBtn.textContent = 'Submit Inquiry →';
            alert('Submission failed. Please check your connection.');
        });
    });
})();
</script>
@endunless

<script>
@stack('scripts')
</script>
{{-- GA4 events now come from partials/ga4.blade.php --}}

<style>
.dsd-rv-popup {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 10000;
    max-width: 300px;
    background: var(--bg-primary, #fff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 16px;
    box-shadow: 0 16px 44px rgba(0,0,0,.18);
    padding: 18px 20px 20px;
    font-family: 'Poppins', sans-serif;
    transform: translateY(24px) scale(.96);
    opacity: 0;
    pointer-events: none;
    transition: transform .35s ease, opacity .35s ease;
}
.dsd-rv-popup.show { transform: translateY(0) scale(1); opacity: 1; pointer-events: auto; }
.dsd-rv-close {
    position: absolute; top: 10px; right: 12px;
    background: none; border: none; cursor: pointer;
    font-size: 15px; color: var(--text-tertiary, #9ca3af); line-height: 1;
    padding: 4px;
}
.dsd-rv-close:hover { color: var(--text-primary, #111827); }
.dsd-rv-title { font-size: 13.5px; font-weight: 700; color: var(--text-primary, #111827); margin: 0 0 4px; padding-right: 16px; line-height: 1.4; }
.dsd-rv-sub { font-size: 11.5px; color: var(--text-secondary, #6b7280); margin: 0 0 12px; line-height: 1.5; }
.dsd-rv-stars { display: flex; gap: 4px; }
.dsd-rv-star {
    background: none; border: none; cursor: pointer; padding: 2px;
    font-size: 26px; line-height: 1; color: #f59e0b;
    transition: color .15s, transform .15s;
}
.dsd-rv-star.hl { transform: scale(1.12); }
/* Clear the fixed mobile buy/sell CTA bar (.mob-cta-bar, ~72px tall) */
@media(max-width:1023px){
    .dsd-rv-popup { bottom: 88px; }
}
@media(max-width:480px){
    .dsd-rv-popup { left: 16px; right: 16px; max-width: none; }
}
</style>

<div class="dsd-rv-popup" id="dsdReviewPopup" role="dialog" aria-label="Rate this article">
    <button type="button" class="dsd-rv-close" id="dsdReviewClose" aria-label="Close">✕</button>
    <p class="dsd-rv-title">Finding this useful?</p>
    <p class="dsd-rv-sub">Rate DSD Properties on Google — it helps other buyers find honest advice.</p>
    <div class="dsd-rv-stars" id="dsdReviewStars">
        <button type="button" class="dsd-rv-star" data-star="1">☆</button>
        <button type="button" class="dsd-rv-star" data-star="2">☆</button>
        <button type="button" class="dsd-rv-star" data-star="3">☆</button>
        <button type="button" class="dsd-rv-star" data-star="4">☆</button>
        <button type="button" class="dsd-rv-star" data-star="5">☆</button>
    </div>
</div>

<script>
(function(){
    var REVIEW_URL = 'https://g.page/r/CSKaw-Vi5G_LEAE/review';
    var SHOWN_KEY = 'dsd_rv_shown_at';
    var SUPPRESS_DAYS_DISMISS = 14;
    var SUPPRESS_DAYS_CLICK = 180;

    function daysSince(ts) { return (Date.now() - ts) / 86400000; }

    function suppressed() {
        var raw = localStorage.getItem(SHOWN_KEY);
        if (!raw) return false;
        try {
            var data = JSON.parse(raw);
            var days = data.action === 'clicked' ? SUPPRESS_DAYS_CLICK : SUPPRESS_DAYS_DISMISS;
            return daysSince(data.ts) < days;
        } catch(e) { return false; }
    }

    function remember(action) {
        localStorage.setItem(SHOWN_KEY, JSON.stringify({ ts: Date.now(), action: action }));
    }

    if (suppressed()) return;

    var popup = document.getElementById('dsdReviewPopup');
    var closeBtn = document.getElementById('dsdReviewClose');
    var starsWrap = document.getElementById('dsdReviewStars');
    var stars = starsWrap.querySelectorAll('.dsd-rv-star');
    var shown = false;

    function highlight(count) {
        stars.forEach(function(s) {
            var filled = parseInt(s.dataset.star, 10) <= count;
            s.classList.toggle('hl', filled);
            s.textContent = filled ? '★' : '☆';
        });
    }

    starsWrap.addEventListener('mouseover', function(e) {
        var star = e.target.closest('.dsd-rv-star');
        if (star) highlight(parseInt(star.dataset.star, 10));
    });
    starsWrap.addEventListener('mouseleave', function() { highlight(0); });

    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            var rating = parseInt(star.dataset.star, 10);
            if (typeof gtag === 'function') {
                gtag('event', 'review_popup_rating', { event_category: 'lead', rating: rating, page: location.pathname });
            }
            remember('clicked');
            window.open(REVIEW_URL, '_blank', 'noopener');
            popup.classList.remove('show');
        });
    });

    closeBtn.addEventListener('click', function() {
        remember('dismissed');
        popup.classList.remove('show');
    });

    function checkScroll() {
        if (shown) return;
        var scrollable = document.body.scrollHeight - window.innerHeight;
        var pct = scrollable > 0 ? (window.scrollY / scrollable) * 100 : 0;
        if (pct >= 65) {
            shown = true;
            popup.classList.add('show');
            if (typeof gtag === 'function') {
                gtag('event', 'review_popup_shown', { event_category: 'lead', page: location.pathname });
            }
            window.removeEventListener('scroll', checkScroll);
        }
    }
    window.addEventListener('scroll', checkScroll, { passive: true });
})();
</script>
@include('components.readers-toast')
</body>
</html>