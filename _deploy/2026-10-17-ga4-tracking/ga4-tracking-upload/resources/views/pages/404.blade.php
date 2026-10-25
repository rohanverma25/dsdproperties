@extends('layouts.user-app')

@section('title', 'Page Not Found - DSD Properties')
@section('ga_page_type', 'not_found')

@section('meta')
<meta name="robots" content="noindex, follow">
@endsection

@section('content')
<style>
    .error-page-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 2rem 1rem;
    }

    .error-card {
        max-width: 800px;
        background: white;
        border-radius: 12px;
        padding: 3rem 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        text-align: center;
    }

    .error-code {
        font-size: 8rem;
        font-weight: 700;
        color: #4a5568;
        line-height: 1;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .error-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
    }

    .error-title {
        font-size: 2.5rem;
        color: #1a202c;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .error-subtitle {
        font-size: 1.25rem;
        color: #4a5568;
        margin-bottom: 2.5rem;
    }

    .search-box {
        margin: 2.5rem 0;
    }

    .search-input {
        width: 100%;
        max-width: 500px;
        padding: 1rem 1.5rem;
        font-size: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        transition: all 0.3s;
        outline: none;
    }

    .search-input:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .button-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .btn-404 {
        padding: 0.875rem 2rem;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-block;
    }

    .btn-primary-404 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-primary-404:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .btn-secondary-404 {
        background: white;
        color: #4a5568;
        border: 2px solid #e2e8f0;
    }

    .btn-secondary-404:hover {
        background: #f7fafc;
        border-color: #cbd5e0;
    }

    .quick-links-404 {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .quick-links-404 h2 {
        font-size: 1.25rem;
        color: #2d3748;
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .links-grid-404 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .link-card-404 {
        background: #f7fafc;
        padding: 1.25rem;
        border-radius: 8px;
        text-decoration: none;
        color: #2d3748;
        transition: all 0.3s;
        border: 1px solid #e2e8f0;
        display: block;
    }

    .link-card-404:hover {
        background: white;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        color: #2d3748;
        text-decoration: none;
    }

    .link-icon-404 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .link-title-404 {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .link-desc-404 {
        font-size: 0.875rem;
        color: #718096;
    }

    .help-text-404 {
        margin-top: 2rem;
        color: #718096;
        font-size: 0.875rem;
    }

    .help-text-404 a {
        color: #4299e1;
        text-decoration: none;
    }

    .help-text-404 a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .error-code {
            font-size: 5rem;
        }

        .error-title {
            font-size: 1.75rem;
        }

        .error-subtitle {
            font-size: 1rem;
        }

        .error-card {
            padding: 2rem 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-404 {
            width: 100%;
        }

        .links-grid-404 {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="error-page-container">
    <div class="error-card">
        <div class="error-icon">🏠</div>
        <div class="error-code">404</div>
        <h1 class="error-title">Page Not Found</h1>
        <p class="error-subtitle">
            Looks like this page has been sold! The URL you're looking for doesn't exist or may have been moved.
        </p>

        <div class="button-group">
            <a href="{{ url('/') }}" class="btn-404 btn-primary-404">
                🏠 Go to Homepage
            </a>
            <a href="{{ url('/blog') }}" class="btn-404 btn-secondary-404">
                📰 Browse Articles
            </a>
        </div>

        <div class="quick-links-404">
            <h2>Popular Destinations</h2>
            <div class="links-grid-404">
                <a href="{{ url('/') }}" class="link-card-404">
                    <div class="link-icon-404">🎯</div>
                    <div class="link-title-404">Get Property Estimate</div>
                    <div class="link-desc-404">Free AI valuation</div>
                </a>
                <a href="{{ url('/blog/gomti-nagar-extension-lucknow-guide-2026') }}" class="link-card-404">
                    <div class="link-icon-404">📍</div>
                    <div class="link-title-404">Gomti Nagar</div>
                    <div class="link-desc-404">Premium locality</div>
                </a>
                <a href="{{ url('/services/property-verification-lucknow') }}" class="link-card-404">
                    <div class="link-icon-404">🛡️</div>
                    <div class="link-title-404">Property Verification</div>
                    <div class="link-desc-404">Legal document check</div>
                </a>
                <a href="{{ url('/services/property-advisory-lucknow') }}" class="link-card-404">
                    <div class="link-icon-404">💼</div>
                    <div class="link-title-404">Property Advisory</div>
                    <div class="link-desc-404">Expert consulting</div>
                </a>
            </div>
        </div>

        <div class="help-text-404">
            Still can't find what you're looking for? 
            <a href="{{ url('/contact-us') }}">Contact our support team</a> 
            or call us at <a href="tel:+918595002933">(+91) 8595002933</a>
        </div>
    </div>
</div>

{{-- 404 tracking: partials/ga4 sends "page_not_found" because ga_page_type = not_found --}}
@endsection