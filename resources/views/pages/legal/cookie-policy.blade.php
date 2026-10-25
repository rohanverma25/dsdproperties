@extends('layouts.user-app')

@section('title', 'Cookie Policy | DSD Properties')
@section('meta_description', 'Learn what cookies DSD Properties uses, why they are used, and how you can manage cookie preferences in your browser.')
@section('meta_keywords', 'cookie policy, cookies, website analytics cookies, DSD Properties cookie policy')

@section('content')
@include('pages.legal.partials.policy-styles')

<div class="policy-wrap">
  <section class="policy-hero">
    <div class="policy-hero-inner">
      <div class="policy-pill">
        <span class="policy-pill-dot"></span>
        Cookies & Tracking
      </div>
      <h1>Cookie Policy</h1>
      <p>
        This policy explains what cookies are used on the DSD Properties website, why they are used, and what options you have to manage them.
      </p>
      <div class="policy-meta">Last updated: April 18, 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="policy-content">
      <div class="policy-card">
        <p class="policy-lead">
          Cookies are small text files stored in your browser when you visit a website. They help websites remember preferences, understand usage patterns, improve performance, and support analytics or marketing measurement.
        </p>

        <div class="policy-section">
          <h2>1. Cookies We May Use</h2>
          <ul>
            <li><strong>Essential cookies:</strong> Used to keep core website functionality working properly.</li>
            <li><strong>Preference cookies:</strong> Used to remember settings such as banner acknowledgement or user interface choices.</li>
            <li><strong>Analytics cookies:</strong> Used to understand traffic, page usage, and visitor behavior so we can improve the website.</li>
            <li><strong>Marketing or measurement cookies:</strong> Used to measure campaign effectiveness or key conversion events.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>2. Why We Use Cookies</h2>
          <ul>
            <li>To improve site speed, usability, and content performance.</li>
            <li>To understand which pages, articles, or tools are used most often.</li>
            <li>To remember consent or user interface choices.</li>
            <li>To measure interactions with enquiry and valuation journeys.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>3. Third-Party Cookies</h2>
          <p>
            Some cookies may be set by third-party tools integrated into the website, such as analytics, maps, tag management, or embedded services. Those third parties may process data according to their own privacy terms and policies.
          </p>
        </div>

        <div class="policy-section">
          <h2>4. Managing Cookies</h2>
          <p>
            You can manage or delete cookies through your browser settings. Blocking certain cookies may affect some features of the website, including tool behavior, preferences, or embedded content.
          </p>
        </div>

        <div class="policy-section">
          <h2>5. Cookie Banner</h2>
          <p>
            When available on the site, our cookie banner is used to notify visitors that cookies and similar technologies may be used. By continuing to use the website after acknowledging the banner, you consent to the use of cookies as described in this policy, subject to your browser controls.
          </p>
        </div>

        <div class="policy-section">
          <h2>6. Related Policies</h2>
          <p>
            For more information about how we handle personal information and website use, please review our
            <a href="{{ route('privacy.policy') }}">Privacy Policy</a> and
            <a href="{{ route('terms.conditions') }}">Terms and Conditions</a>.
          </p>
        </div>

        <div class="policy-section">
          <h2>7. Contact</h2>
          <p>
            If you have questions about this Cookie Policy, contact
            <a href="mailto:dheer@dsdproperties.in">dheer@dsdproperties.in</a>.
          </p>
        </div>

        <div class="policy-cta">
          <h3>Want the full picture?</h3>
          <p>Our privacy and terms pages explain how cookies fit into the broader website experience.</p>
          <div class="policy-links">
            <a class="policy-link" href="{{ route('privacy.policy') }}">Privacy Policy</a>
            <a class="policy-link" href="{{ route('terms.conditions') }}">Terms &amp; Conditions</a>
            <a class="policy-link" href="{{ route('homepage') }}">Back to Home</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
