@extends('layouts.user-app')

@section('title', 'Privacy Policy | DSD Properties')
@section('meta_description', 'Read how DSD Properties collects, uses, stores, and protects your personal data when you use our website, forms, and valuation tools.')
@section('meta_keywords', 'privacy policy, DSD Properties privacy, personal data, Lucknow property website privacy')

@section('content')
@include('pages.legal.partials.policy-styles')

<div class="policy-wrap">
  <section class="policy-hero">
    <div class="policy-hero-inner">
      <div class="policy-pill">
        <span class="policy-pill-dot"></span>
        Privacy & Data Use
      </div>
      <h1>Privacy Policy</h1>
      <p>
        This policy explains what information DSD Properties collects, why we collect it, and how we use it when you browse our website, submit forms, request a valuation, or contact our team.
      </p>
      <div class="policy-meta">Last updated: April 18, 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="policy-content">
      <div class="policy-card">
        <p class="policy-lead">
          DSD Properties is committed to handling user information responsibly. We collect only the information needed to deliver property-related content, respond to enquiries, improve the website, and provide valuation or advisory services.
        </p>

        <div class="policy-note">
          By using this website, you agree to the data practices described below. If you do not agree, please discontinue use of the website or avoid submitting personal information through our forms.
        </div>

        <div class="policy-section">
          <h2>1. Information We Collect</h2>
          <p>Depending on how you use the site, we may collect:</p>
          <ul>
            <li>Your name, phone number, email address, and message when you fill out contact, enquiry, or consultation forms.</li>
            <li>Property details you voluntarily submit, such as address, locality, area, and property type, when using valuation or advisory tools.</li>
            <li>Technical information such as IP address, browser type, device information, referring page, and approximate usage behavior.</li>
            <li>Cookie and analytics data used to understand site performance, visitor behavior, and conversion activity.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>2. How We Use Your Information</h2>
          <ul>
            <li>To respond to your enquiries and provide requested property-related assistance.</li>
            <li>To generate, improve, or follow up on valuation and advisory requests.</li>
            <li>To send relevant updates, service-related communication, or follow-ups where you have shared your contact information.</li>
            <li>To maintain website security, analyze traffic, improve user experience, and measure campaign performance.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>3. Cookies and Analytics</h2>
          <p>
            We use cookies and similar technologies to remember preferences, understand how visitors use the site, and measure marketing performance. Some analytics and advertising tools may place cookies through the browser.
          </p>
          <p>
            For more details about the types of cookies we use and your choices, please review our <a href="{{ route('cookie.policy') }}">Cookie Policy</a>.
          </p>
        </div>

        <div class="policy-section">
          <h2>4. Sharing of Information</h2>
          <p>We do not sell your personal information. We may share limited data only when reasonably necessary:</p>
          <ul>
            <li>With service providers who support hosting, analytics, form handling, communication, or website operations.</li>
            <li>When required by law, legal process, regulatory request, or to protect our rights and website security.</li>
            <li>With internal team members or authorized representatives who need access to respond to your request.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>5. Data Retention</h2>
          <p>
            We retain enquiry, valuation, and communication records only for as long as reasonably necessary for service, record-keeping, analytics, internal review, compliance, or dispute resolution purposes.
          </p>
        </div>

        <div class="policy-section">
          <h2>6. Data Security</h2>
          <p>
            We use reasonable administrative and technical measures to protect information submitted through the website. However, no internet-based system can be guaranteed to be completely secure, so you share information at your own risk.
          </p>
        </div>

        <div class="policy-section">
          <h2>7. Your Choices</h2>
          <ul>
            <li>You may contact us to update or correct information you have submitted.</li>
            <li>You may request that we stop using your information for follow-up communication.</li>
            <li>You can control cookies through your browser settings, subject to the limits described in our Cookie Policy.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>8. Contact</h2>
          <p>
            If you have questions about this policy or your information, you can contact DSD Properties at
            <a href="mailto:dheer@dsdproperties.in">dheer@dsdproperties.in</a> or call
            <a href="tel:+918595002933">+91 85950 02933</a>.
          </p>
        </div>

        <div class="policy-cta">
          <h3>Need the full policy set?</h3>
          <p>Review the rest of our legal pages for cookie usage and website terms.</p>
          <div class="policy-links">
            <a class="policy-link" href="{{ route('cookie.policy') }}">Cookie Policy</a>
            <a class="policy-link" href="{{ route('terms.conditions') }}">Terms &amp; Conditions</a>
            <a class="policy-link" href="{{ route('contact-us') }}">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
