@extends('layouts.user-app')
@section('title', 'Contact Us | DSD Properties')
@section('meta_description', 'Have questions or need help? Contact us directly using our form or through our office details.')
@section('meta_keywords', 'contact us, customer support, email us, get in touch, property inquiry')

@section('content')
<style>
  .ct-wrap * { box-sizing: border-box; }

  /* ── HERO ── */
  .ct-hero {
    position: relative;
    background: linear-gradient(135deg, #000d1f 0%, #011f4b 55%, #003d3d 100%);
    overflow: hidden;
    padding: 90px 5vw 0;
    text-align: center;
  }
  .ct-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
      radial-gradient(ellipse 60% 80% at 80% 50%, rgba(0,168,168,0.13) 0%, transparent 60%),
      radial-gradient(ellipse 40% 60% at 10% 80%, rgba(255,92,0,0.08) 0%, transparent 50%);
    pointer-events: none;
  }
  .ct-hero::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
      linear-gradient(rgba(0,128,128,0.06) 1px, transparent 1px),
      linear-gradient(90deg, rgba(0,128,128,0.06) 1px, transparent 1px);
    background-size: 60px 60px;
    mask-image: linear-gradient(to bottom, transparent, rgba(0,0,0,0.4) 30%, rgba(0,0,0,0.4) 70%, transparent);
    pointer-events: none;
  }
  .ct-hero-inner {
    position: relative; z-index: 1;
    max-width: 780px; margin: 0 auto;
    padding-bottom: 80px;
  }
  .ct-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(0,168,168,0.15);
    border: 1px solid rgba(0,168,168,0.35);
    border-radius: 40px;
    padding: 6px 16px;
    font-family: 'Poppins', sans-serif;
    font-size: 10.5px; font-weight: 600; letter-spacing: 0.12em;
    color: #00d4d4; text-transform: uppercase;
    margin-bottom: 24px;
  }
  .ct-eyebrow-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #00d4d4;
    animation: ct-pulse 2s infinite;
  }
  @keyframes ct-pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(0.6)} }

  .ct-hero h1 {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(32px, 5vw, 56px);
    font-weight: 700; line-height: 1.15;
    color: #ffffff; margin-bottom: 18px;
    letter-spacing: -0.02em;
  }
  .ct-hero h1 em { font-style: normal; color: #FF5C00; font-weight: 800; }
  .ct-hero p {
    font-family: 'Poppins', sans-serif;
    font-size: 15.5px; color: rgba(255,255,255,0.6);
    max-width: 500px; margin: 0 auto;
    line-height: 1.8; font-weight: 300;
  }
  .ct-hero-wave {
    position: relative; z-index: 1;
    line-height: 0; margin-top: -1px;
  }
  .ct-hero-wave svg { display: block; width: 100%; height: 56px; }

  /* ── MAIN GRID ── */
  .ct-section {
    max-width: 1180px; margin: 0 auto;
    padding: 72px 5vw 100px;
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 44px;
    align-items: start;
  }

  /* ── FORM CARD ── */
  .ct-form-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 50px 46px;
    box-shadow: 0 4px 40px rgba(1,31,75,0.09), 0 1px 3px rgba(0,0,0,0.04);
    border: 1px solid rgba(1,31,75,0.07);
    opacity: 0; transform: translateY(28px);
    transition: opacity 0.55s ease, transform 0.55s ease;
  }
  .ct-form-card.ct-visible { opacity: 1; transform: translateY(0); }

  .ct-form-card h2 {
    font-family: 'Poppins', sans-serif;
    font-size: 26px; font-weight: 700;
    color: #011f4b; margin-bottom: 4px;
    letter-spacing: -0.01em;
  }
  .ct-form-card .ct-sub {
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px; color: #6b7280;
    font-weight: 300; margin-bottom: 34px;
  }

  .ct-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

  .ct-field { margin-bottom: 20px; }
  .ct-field label {
    display: block;
    font-family: 'Poppins', sans-serif;
    font-size: 11px; font-weight: 600;
    letter-spacing: 0.08em; text-transform: uppercase;
    color: #011f4b; margin-bottom: 7px;
  }
  .ct-field label .ct-req { color: #FF5C00; margin-left: 2px; }
  .ct-field input, .ct-field textarea {
    width: 100%;
    background: #faf8f4;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px 15px;
    font-family: 'Poppins', sans-serif;
    font-size: 14px; color: #011f4b; font-weight: 400;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
  }
  .ct-field input:focus, .ct-field textarea:focus {
    border-color: #008080;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(0,128,128,0.09);
  }
  .ct-field input::placeholder, .ct-field textarea::placeholder {
    color: #b0b8c8; font-weight: 300;
  }
  .ct-field textarea { resize: vertical; min-height: 118px; }
  .ct-field.ct-error input,
  .ct-field.ct-error textarea { border-color: #FF5C00; background: #fff8f5; }
  .ct-err-msg {
    font-family: 'Poppins', sans-serif;
    font-size: 12px; color: #FF5C00; font-weight: 500;
    margin-top: 5px; display: none;
  }
  .ct-field.ct-error .ct-err-msg { display: block; }

  .ct-submit-btn {
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, #011f4b, #013a7a);
    color: white; border: none; border-radius: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: 14.5px; font-weight: 600; letter-spacing: 0.04em;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    transition: transform 0.2s, box-shadow 0.2s;
    margin-top: 6px;
  }
  .ct-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(1,31,75,0.25);
  }
  .ct-submit-btn svg { transition: transform 0.2s; }
  .ct-submit-btn:hover svg { transform: translateX(4px); }

  .ct-success {
    display: none; margin-top: 18px;
    background: #ecfdf5; border: 1px solid #6ee7b7;
    border-radius: 10px; padding: 14px 18px;
    color: #065f46;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px; font-weight: 500;
    align-items: center; gap: 10px;
  }
  .ct-success.ct-show { display: flex; }

  /* ── SIDEBAR ── */
  .ct-sidebar { display: flex; flex-direction: column; gap: 20px; }

  .ct-info-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 2px 20px rgba(1,31,75,0.07);
    border: 1px solid rgba(1,31,75,0.06);
    opacity: 0; transform: translateY(28px);
    transition: opacity 0.55s ease, transform 0.55s ease;
  }
  .ct-info-card.ct-visible { opacity: 1; transform: translateY(0); }
  .ct-info-card.ct-d1 { transition-delay: 0.1s; }
  .ct-info-card.ct-d2 { transition-delay: 0.2s; }

  .ct-info-card h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 16px; font-weight: 700;
    color: #011f4b; margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #f0f2f5;
    letter-spacing: -0.01em;
  }

  .ct-contact-item {
    display: flex; align-items: flex-start; gap: 13px;
    margin-bottom: 18px;
  }
  .ct-contact-item:last-child { margin-bottom: 0; }
  .ct-c-icon {
    width: 38px; height: 38px; flex-shrink: 0;
    border-radius: 10px;
    background: #e0f4f4;
    display: flex; align-items: center; justify-content: center;
  }
  .ct-c-icon svg { width: 17px; height: 17px; stroke: #008080; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .ct-c-label {
    font-family: 'Poppins', sans-serif;
    font-size: 10px; font-weight: 600;
    letter-spacing: 0.09em; text-transform: uppercase;
    color: #9ca3af; margin-bottom: 3px;
  }
  .ct-c-value {
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px; color: #011f4b;
    font-weight: 500; line-height: 1.55;
  }
  .ct-c-value a { color: #008080; text-decoration: none; }
  .ct-c-value a:hover { text-decoration: underline; }

  .ct-social-row { display: flex; gap: 9px; margin-top: 9px; }
  .ct-soc-btn {
    width: 36px; height: 36px; border-radius: 9px;
    background: #e0f4f4;
    display: flex; align-items: center; justify-content: center;
    text-decoration: none; transition: background 0.2s, transform 0.15s;
  }
  .ct-soc-btn:hover { background: #008080; transform: translateY(-2px); }
  .ct-soc-btn:hover svg { stroke: white; }
  .ct-soc-btn svg { width: 15px; height: 15px; stroke: #008080; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  /* Hours */
  .ct-hours-row {
    display: flex; justify-content: space-between; align-items: center;
    font-family: 'Poppins', sans-serif;
    font-size: 13px; padding: 9px 0;
    border-bottom: 1px solid #f5f5f5;
  }
  .ct-hours-row:last-child { border-bottom: none; }
  .ct-hours-row .ct-day { color: #4b5563; font-weight: 500; }
  .ct-hours-row .ct-time { font-weight: 600; font-size: 12.5px; color: #008080; }
  .ct-closed { color: #c0c8d4 !important; }

  /* Beta card */
  .ct-beta-card {
    background: linear-gradient(135deg, #011f4b, #013a7a);
    border-radius: 16px; padding: 28px;
    color: white; position: relative; overflow: hidden;
    opacity: 0; transform: translateY(28px);
    transition: opacity 0.55s ease 0.3s, transform 0.55s ease 0.3s;
  }
  .ct-beta-card.ct-visible { opacity: 1; transform: translateY(0); }
  .ct-beta-card::before {
    content: '';
    position: absolute; top: -30px; right: -30px;
    width: 120px; height: 120px; border-radius: 50%;
    background: rgba(0,168,168,0.18);
    pointer-events: none;
  }
  .ct-beta-card h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 18px; font-weight: 700;
    margin-bottom: 7px; color: white;
    letter-spacing: -0.01em;
  }
  .ct-beta-card p {
    font-family: 'Poppins', sans-serif;
    font-size: 13px; color: rgba(255,255,255,0.62);
    line-height: 1.7; font-weight: 300; margin-bottom: 18px;
  }
  .ct-beta-link {
    display: inline-flex; align-items: center; gap: 7px;
    background: #FF5C00; color: white;
    text-decoration: none; border-radius: 8px;
    padding: 10px 18px;
    font-family: 'Poppins', sans-serif;
    font-size: 13px; font-weight: 600;
    transition: background 0.2s;
  }
  .ct-beta-link:hover { background: #e04e00; color: white; }

  /* ── MAP ── */
  .ct-map-section {
    background: #ffffff;
    padding: 70px 5vw;
  }
  .ct-map-header {
    max-width: 1180px; margin: 0 auto 32px;
    display: flex; align-items: flex-end; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
  }
  .ct-map-header h2 {
    font-family: 'Poppins', sans-serif;
    font-size: 26px; font-weight: 700;
    color: #011f4b; margin-bottom: 4px;
    letter-spacing: -0.01em;
  }
  .ct-map-header p {
    font-family: 'Poppins', sans-serif;
    font-size: 14px; color: #6b7280; font-weight: 300;
  }
  .ct-dir-btn {
    display: inline-flex; align-items: center; gap: 7px;
    border: 1.5px solid #008080; color: #008080;
    border-radius: 8px; padding: 10px 20px;
    font-family: 'Poppins', sans-serif;
    font-size: 13.5px; font-weight: 600;
    text-decoration: none; transition: all 0.2s;
    white-space: nowrap;
  }
  .ct-dir-btn:hover { background: #008080; color: white; }
  .ct-dir-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .ct-map-wrap {
    max-width: 1180px; margin: 0 auto;
    border-radius: 18px; overflow: hidden;
    box-shadow: 0 4px 36px rgba(1,31,75,0.1);
    border: 1px solid rgba(1,31,75,0.07);
  }
  .ct-map-wrap iframe { display: block; width: 100%; height: 420px; border: none; }

  /* ── FAQ ── */
  .ct-faq-section {
    max-width: 800px; margin: 0 auto;
    padding: 80px 5vw 100px;
  }
  .ct-faq-header { text-align: center; margin-bottom: 48px; }
  .ct-faq-header h2 {
    font-family: 'Poppins', sans-serif;
    font-size: clamp(24px, 3.5vw, 36px); font-weight: 700;
    color: #011f4b; margin-bottom: 10px;
    letter-spacing: -0.02em;
  }
  .ct-faq-header p {
    font-family: 'Poppins', sans-serif;
    font-size: 14.5px; color: #6b7280; font-weight: 300;
  }

  .ct-faq-item { border-bottom: 1px solid #e8ecf0; }
  .ct-faq-question {
    width: 100%; background: none; border: none;
    display: flex; align-items: center; justify-content: space-between;
    padding: 20px 0; cursor: pointer; text-align: left; gap: 16px;
  }
  .ct-faq-question span {
    font-family: 'Poppins', sans-serif;
    font-size: 14.5px; font-weight: 600; color: #011f4b; line-height: 1.5;
  }
  .ct-faq-icon {
    width: 28px; height: 28px; flex-shrink: 0;
    border-radius: 50%; background: #e0f4f4;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, transform 0.3s;
  }
  .ct-faq-icon svg { width: 13px; height: 13px; stroke: #008080; fill: none; stroke-width: 2.5; stroke-linecap: round; }
  .ct-faq-item.ct-open .ct-faq-icon { background: #008080; transform: rotate(45deg); }
  .ct-faq-item.ct-open .ct-faq-icon svg { stroke: white; }
  .ct-faq-answer { overflow: hidden; max-height: 0; transition: max-height 0.4s ease; }
  .ct-faq-answer p {
    font-family: 'Poppins', sans-serif;
    font-size: 14px; color: #4b5563; font-weight: 300;
    line-height: 1.8; padding-bottom: 22px;
  }
  .ct-faq-item.ct-open .ct-faq-answer { max-height: 300px; }

  /* ── RESPONSIVE ── */
  @media (max-width: 900px) {
    .ct-section { grid-template-columns: 1fr; }
    .ct-form-card { padding: 34px 26px; }
    .ct-field-row { grid-template-columns: 1fr; }
  }
  @media (max-width: 600px) {
    .ct-form-card { padding: 26px 18px; }
    .ct-map-header { flex-direction: column; align-items: flex-start; }
    .ct-hero { padding-top: 80px; }
  }

  /* Add a subtle focus animation */
  input[name="full_name"]:focus {
      /* outline: 2px solid var(--color-primary);
      outline-offset: 2px; */
      transition: outline 0.3s ease;
  }

  /* Optional: Add a pulse animation on page load */
  @keyframes focusPulse {
      0%, 100% { box-shadow: 0 0 0 0 rgba(1, 31, 75, 0.4); }
      50% { box-shadow: 0 0 0 10px rgba(1, 31, 75, 0); }
  }

  .autofocus-pulse {
      animation: focusPulse 1.5s ease-out;
  }
</style>

<div class="ct-wrap">

  <!-- ── HERO ── -->
  <section class="ct-hero">
    <div class="ct-hero-inner">
      <div class="ct-eyebrow">
        <span class="ct-eyebrow-dot"></span>We're Here to Help
      </div>
      <h1>Let's Start a<br><em>Conversation</em></h1>
      <p>Have a question about Lucknow's property market? Need an honest estimate? Our team responds within 24 hours — no agent bias, no fluff.</p>
    </div>
    <div class="ct-hero-wave">
      <svg viewBox="0 0 1440 56" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <path d="M0 56 L0 28 Q360 0 720 28 Q1080 56 1440 28 L1440 56 Z" fill="#faf8f4"/>
      </svg>
    </div>
  </section>

  <!-- ── CONTACT GRID ── -->
  <section class="ct-section">

    <!-- FORM -->
    <div class="ct-form-card" id="ct-form-card">
      <h2>Send Us a Message</h2>
      <p class="ct-sub">Fill in the form below and we'll get back to you as soon as possible.</p>

      <form id="ct-contact-form" method="POST" action="{{ route('inquiry.submit') }}" novalidate>
        @csrf
        <div class="ct-field-row">
          <div class="ct-field" id="ctf-name">
            <label>Full Name <span class="ct-req">*</span></label>
            <input type="text" name="full_name" placeholder="e.g. Rahul Sharma" />
            <div class="ct-err-msg">Please enter your full name.</div>
          </div>
          <div class="ct-field" id="ctf-phone">
            <label>Phone Number <span class="ct-req">*</span></label>
            <input type="tel" name="phone_number" placeholder="10-digit mobile number" />
            <div class="ct-err-msg">Enter a valid 10-digit number.</div>
          </div>
        </div>
        <div class="ct-field" id="ctf-email">
          <label>Email Address <span class="ct-req">*</span></label>
          <input type="email" name="email" placeholder="you@example.com" />
          <div class="ct-err-msg">Please enter a valid email address.</div>
        </div>
        {{-- <div class="ct-field">
          <label>Subject</label>
          <input type="text" name="subject" placeholder="e.g. Property inquiry in Gomti Nagar" />
        </div> --}}
        <input type="hidden" name="page_url" id="page_url_input" value="">
        <input type="hidden" name="referrer_url" id="referrer_url_input" value="">
        {{-- Tells the shared inbox which form this came from. --}}
        <input type="hidden" name="source_form" value="{{ \App\Models\FormSubmission::FORM_CONTACT_US }}">
        <x-honeypot form-id="contact" />
        <div class="ct-field" id="ctf-message">
          <label>Message <span class="ct-req">*</span></label>
          <textarea name="message" rows="5" placeholder="Tell us about your property or question..."></textarea>
          <div class="ct-err-msg">Please enter a message (at least 5 characters).</div>
        </div>

        <button type="submit" class="ct-submit-btn" id="ct-submit-btn">
          Send Message
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
          </svg>
        </button>

        <div class="ct-success" id="ct-success">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#065f46" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          Message sent! We'll get back to you within 24 hours.
        </div>
      </form>
    </div>

    <!-- SIDEBAR -->
    <div class="ct-sidebar">

      <!-- Contact Info -->
      <div class="ct-info-card ct-d1" id="ct-info-1">
        <h3>Get In Touch</h3>

        <div class="ct-contact-item">
          <div class="ct-c-icon">
            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <div>
            <div class="ct-c-label">Office Address</div>

            <div class="ct-c-value">128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2, Lucknow 226025</div>
          </div>
        </div>

        <div class="ct-contact-item">
          <div class="ct-c-icon">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.41 2 2 0 0 1 3.6 1.25h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.59a16 16 0 0 0 5.5 5.5l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
          </div>
          <div>
            <div class="ct-c-label">Phone</div>
            <div class="ct-c-value"><a href="tel:+918595002933">+91 8595002933</a></div>
          </div>
        </div>

        <div class="ct-contact-item">
          <div class="ct-c-icon">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <div>
            <div class="ct-c-label">Email</div>
            <div class="ct-c-value"><a href="mailto:dheer@dsdproperties.in">dheer@dsdproperties.in</a></div>
          </div>
        </div>

        {{-- <div class="ct-contact-item" style="margin-bottom:0">
          <div class="ct-c-icon">
            <svg viewBox="0 0 24 24"><path d="M21 2H3v16h5l3 3 3-3h7V2z"/><line x1="8" y1="8" x2="16" y2="8"/><line x1="8" y1="12" x2="14" y2="12"/></svg>
          </div>
          <div>
            <div class="ct-c-label">Follow Us</div>
            <div class="ct-social-row">
              <a href="#" class="ct-soc-btn" title="Facebook">
                <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
              </a>
              <a href="#" class="ct-soc-btn" title="Instagram">
                <svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
              </a>
              <a href="#" class="ct-soc-btn" title="LinkedIn">
                <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
              </a>
              <a href="#" class="ct-soc-btn" title="Twitter/X">
                <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
              </a>
            </div>
          </div>
        </div> --}}
      </div>

      <!-- Hours -->
      <div class="ct-info-card ct-d2" id="ct-info-2">
        <h3>Business Hours</h3>
        <div class="ct-hours-row">
          <span class="ct-day">Monday – Friday</span>
          <span class="ct-time">9:00 AM – 6:00 PM</span>
        </div>
        <div class="ct-hours-row">
          <span class="ct-day">Saturday</span>
          <span class="ct-time">10:00 AM – 4:00 PM</span>
        </div>
        <div class="ct-hours-row">
          <span class="ct-day ct-closed">Sunday</span>
          <span class="ct-time ct-closed">Closed</span>
        </div>
      </div>

      <!-- Beta CTA -->
      <div class="ct-beta-card" id="ct-beta">
        <h3>Free AI Valuation</h3>
        <p>Get an instant, data-driven price estimate for any property in Lucknow — no agent, no cost.</p>
        <a href="/" class="ct-beta-link">
          Get My Estimate
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
      </div>

    </div>
  </section>

  <!-- ── MAP ── -->
  <section class="ct-map-section">
    <div class="ct-map-header">
      <div>
        <h2>Find Our Office</h2>
        <p>Visit us at DSD Properties, Sanjar Gold Complex, Lucknow</p>
      </div>
      <a href="https://www.google.com/maps/place/Sanjar+Gold+Complex/@26.8523508,80.7423879,10.25z/data=!4m16!1m9!3m8!1s0x46c7ebaa5a960f3d:0xcb6fe462e5c39a22!2sDSD+Properties!8m2!3d26.848692!4d80.9425127!9m1!1b1!16s%2Fg%2F11z12nt5cq!3m5!1s0x399bfba2a7609b1f:0x1312f38c0bf633b0!8m2!3d26.7591633!4d80.9514628!16s%2Fg%2F11s9lb6dvs?entry=ttu&g_ep=EgoyMDI2MDQwNS4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="ct-dir-btn">
        <svg viewBox="0 0 24 24"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
        Get Directions
      </a>
    </div>
    <div class="ct-map-wrap">
      <iframe
        src="https://maps.google.com/maps?q=26.7591633,80.9514628&z=17&hl=en&output=embed"
        title="DSD Properties office – 128/LGE Sanjar Gold Complex, Vrindavan Sector 2, Lucknow"
        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </section>

  <!-- ── FAQ ── -->
  <section class="ct-faq-section">
    <div class="ct-faq-header">
      <h2>Frequently Asked Questions</h2>
      <p>Answers to common questions about our services and Lucknow's property market.</p>
    </div>

    <div class="ct-faq-item">
      <button class="ct-faq-question">
        <span>What areas in Lucknow do you cover?</span>
        <div class="ct-faq-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
      </button>
      <div class="ct-faq-answer">
        <p>We cover 50+ localities across Lucknow — from Hazratganj and Gomti Nagar to Aliganj, Indira Nagar, Malihabad, and more. Our team has deep expertise in both residential and commercial segments across the city.</p>
      </div>
    </div>

    <div class="ct-faq-item">
      <button class="ct-faq-question">
        <span>How quickly can I expect a response to my inquiry?</span>
        <div class="ct-faq-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
      </button>
      <div class="ct-faq-answer">
        <p>We strive to respond to all inquiries within 24 hours on business days. For urgent matters, please call us directly at the number listed above — we're usually available during business hours.</p>
      </div>
    </div>

    <div class="ct-faq-item">
      <button class="ct-faq-question">
        <span>Do you charge for property consultation?</span>
        <div class="ct-faq-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
      </button>
      <div class="ct-faq-answer">
        <p>Our AI valuation tool is completely free, forever. Initial consultations are also free. Any additional services are discussed transparently before we proceed. No hidden fees.</p>
      </div>
    </div>

    <div class="ct-faq-item">
      <button class="ct-faq-question">
        <span>How accurate are your property estimates?</span>
        <div class="ct-faq-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></div>
      </button>
      <div class="ct-faq-answer">
        <p>Our estimates are based on real listing data from Lucknow — not generic AI guesses. We show a realistic price band rather than a single misleading number, and we're fully transparent about data quality for each locality.</p>
      </div>
    </div>
  </section>

</div><!-- /ct-wrap -->

<script>
document.addEventListener("DOMContentLoaded", function () {
document.getElementById('page_url_input').value = window.location.href;
  document.getElementById('referrer_url_input').value = document.referrer || '';
  // ── Scroll-reveal animations
  const revealEls = [
    document.getElementById('ct-form-card'),
    document.getElementById('ct-info-1'),
    document.getElementById('ct-info-2'),
    document.getElementById('ct-beta'),
  ].filter(Boolean);

  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('ct-visible'); obs.unobserve(e.target); } });
  }, { threshold: 0.1 });
  revealEls.forEach(el => obs.observe(el));

  // ── FAQ accordion
  document.querySelectorAll('.ct-faq-question').forEach(btn => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.ct-faq-item');
      const isOpen = item.classList.contains('ct-open');
      document.querySelectorAll('.ct-faq-item.ct-open').forEach(i => i.classList.remove('ct-open'));
      if (!isOpen) item.classList.add('ct-open');
    });
  });

  // ── Form validation + AJAX submit
  const form = document.getElementById('ct-contact-form');
  const submitBtn = document.getElementById('ct-submit-btn');
  const successEl = document.getElementById('ct-success');

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Clear errors
    ['ctf-name','ctf-phone','ctf-email','ctf-message'].forEach(id => {
      document.getElementById(id)?.classList.remove('ct-error');
    });

    let valid = true;

    const name    = form.full_name.value.trim();
    const phone   = form.phone_number.value.trim();
    const email   = form.email.value.trim();
    const message = form.message.value.trim();

    if (name.length < 2) { document.getElementById('ctf-name').classList.add('ct-error'); valid = false; }
    if (!/^\d{10,}$/.test(phone)) { document.getElementById('ctf-phone').classList.add('ct-error'); valid = false; }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { document.getElementById('ctf-email').classList.add('ct-error'); valid = false; }
    if (message.length < 5) { document.getElementById('ctf-message').classList.add('ct-error'); valid = false; }

    if (!valid) return;

    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.7';
    submitBtn.querySelector('svg').style.display = 'none';
    submitBtn.childNodes[0].textContent = 'Sending…';

    fetch(form.action, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value },
      body: new FormData(form)
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        submitBtn.textContent = 'Message Sent ✓';
        submitBtn.style.opacity = '1';
        submitBtn.style.background = 'linear-gradient(135deg,#065f46,#059669)';
        successEl.classList.add('ct-show');
        form.reset();
        successEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      } else {
        submitBtn.disabled = false;
        submitBtn.style.opacity = '1';
        alert(data.message || 'Something went wrong. Please try again.');
      }
    })
    .catch(() => {
      submitBtn.disabled = false;
      submitBtn.style.opacity = '1';
      alert('Submission failed. Please try again.');
    });
  });

  // Clear field errors on input
  form.querySelectorAll('input, textarea').forEach(inp => {
    inp.addEventListener('input', () => inp.closest('.ct-field')?.classList.remove('ct-error'));
  });

});

document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname === '/contact-us') {
        const nameField = document.querySelector('input[name="full_name"]');
        if (nameField) {
            setTimeout(function() {
                nameField.focus();
                nameField.classList.add('autofocus-pulse');
                
                // Remove animation class after it completes
                setTimeout(function() {
                    nameField.classList.remove('autofocus-pulse');
                }, 1500);
            }, 100);
        }
    }
});
</script>
@endsection