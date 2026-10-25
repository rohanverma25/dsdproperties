@extends('layouts.user-app')

@section('title', 'Terms and Conditions | DSD Properties')
@section('meta_description', 'Read the terms governing your use of the DSD Properties website, valuation tools, content, and communication channels.')
@section('meta_keywords', 'terms and conditions, website terms, DSD Properties terms, valuation disclaimer')

@section('content')
@include('pages.legal.partials.policy-styles')

<div class="policy-wrap">
  <section class="policy-hero">
    <div class="policy-hero-inner">
      <div class="policy-pill">
        <span class="policy-pill-dot"></span>
        Website Terms
      </div>
      <h1>Terms and Conditions</h1>
      <p>
        These terms govern your use of the DSD Properties website, content, forms, and digital tools. Please read them carefully before relying on the information or services provided here.
      </p>
      <div class="policy-meta">Last updated: April 18, 2026</div>
    </div>
  </section>

  <section class="policy-body">
    <div class="policy-content">
      <div class="policy-card">
        <p class="policy-lead">
          By accessing or using this website, you agree to be bound by these terms. If you do not agree with them, please do not use the website or its services.
        </p>

        <div class="policy-section">
          <h2>1. Website Purpose</h2>
          <p>
            DSD Properties provides property-related information, editorial content, valuation tools, and service enquiry options focused primarily on the Lucknow real estate market. Content is intended for general information and user convenience.
          </p>
        </div>

        <div class="policy-section">
          <h2>2. No Professional Guarantee</h2>
          <p>
            Estimates, market commentary, guides, and property-related content on this site are informational in nature and should not be treated as legal, financial, investment, or regulatory advice. Users should independently verify material facts and consult qualified professionals before making any property decision.
          </p>
        </div>

        <div class="policy-section">
          <h2>3. Valuation and AI-Assisted Tools</h2>
          <ul>
            <li>Valuation outputs are indicative estimates and not certified appraisals.</li>
            <li>Outputs may rely on available locality data, user input, comparable information, and automated processing.</li>
            <li>Actual market value can vary due to documentation, condition, timing, negotiation, approvals, and locality-level changes.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>4. User Responsibilities</h2>
          <ul>
            <li>You agree to provide accurate information when submitting forms or using the website.</li>
            <li>You must not misuse the site, interfere with its operation, or attempt unauthorized access.</li>
            <li>You must not copy, scrape, republish, or exploit content from the site in violation of applicable law.</li>
          </ul>
        </div>

        <div class="policy-section">
          <h2>5. Intellectual Property</h2>
          <p>
            Unless otherwise stated, website design, branding, editorial content, text, graphics, and platform materials on this site belong to DSD Properties or are used with permission. Unauthorized reproduction or redistribution is prohibited.
          </p>
        </div>

        <div class="policy-section">
          <h2>6. Third-Party Content and Links</h2>
          <p>
            The website may reference third-party portals, government sites, maps, analytics tools, or external resources. We are not responsible for the availability, accuracy, content, privacy practices, or policies of third-party sites.
          </p>
        </div>

        <div class="policy-section">
          <h2>7. Limitation of Liability</h2>
          <p>
            To the fullest extent permitted by law, DSD Properties is not liable for any direct, indirect, incidental, or consequential loss arising from your use of the website, reliance on content, interruption of service, or inability to access the site.
          </p>
        </div>

        <div class="policy-section">
          <h2>8. Changes to the Website or Terms</h2>
          <p>
            We may update, suspend, remove, or modify any part of the website, services, or these terms at any time. Continued use after updates means you accept the revised terms.
          </p>
        </div>

        <div class="policy-section">
          <h2>9. Governing Use</h2>
          <p>
            These terms are intended to govern use of the website in connection with DSD Properties operations in India. Any dispute relating to site use should be handled under applicable Indian law and the appropriate local jurisdiction.
          </p>
        </div>

        <div class="policy-section">
          <h2>10. Contact</h2>
          <p>
            For questions about these terms, please contact
            <a href="mailto:dheer@dsdproperties.in">dheer@dsdproperties.in</a>
            or call <a href="tel:+918595002933">+91 85950 02933</a>.
          </p>
        </div>

        <div class="policy-cta">
          <h3>Review the related policies</h3>
          <p>These pages work together to explain how the website operates and how your data is handled.</p>
          <div class="policy-links">
            <a class="policy-link" href="{{ route('privacy.policy') }}">Privacy Policy</a>
            <a class="policy-link" href="{{ route('cookie.policy') }}">Cookie Policy</a>
            <a class="policy-link" href="{{ route('contact-us') }}">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
