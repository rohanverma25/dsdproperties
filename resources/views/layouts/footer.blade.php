<style>
.ft {
    background:linear-gradient(135deg,#060f1e 0%,#071628 50%,#071e2e 100%);
    color:rgba(255,255,255,.55);
    font-family:'Poppins',sans-serif;
    padding:64px 0 0;
    position:relative;
    overflow:hidden;
}
.ft::before {
    content:'';position:absolute;inset:0;
    background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),
                     linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);
    background-size:50px 50px;pointer-events:none;
}
.ft::after {
    content:'';position:absolute;bottom:-100px;left:-80px;
    width:400px;height:400px;border-radius:50%;
    background:radial-gradient(circle,rgba(0,128,128,.12) 0%,transparent 65%);
    pointer-events:none;
}
.ft-wrap { max-width:1120px; margin:0 auto; padding:0 36px; position:relative;z-index:1; }

.ft-grid { display:grid; grid-template-columns:1.4fr 0.85fr 0.85fr 1fr 1fr; gap:40px 28px; padding-bottom:52px; border-bottom:1px solid rgba(255,255,255,.06); }

.ft-logo { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
.ft-logo-icon {
    width:36px; height:36px; border-radius:9px;
    background:linear-gradient(135deg,#011f4b,#008080);
    display:flex; align-items:center; justify-content:center;
}
.ft-logo-icon svg { width:18px; height:18px; fill:white; }
.ft-logo-name { font-size:17px; font-weight:600; color:#fff; letter-spacing:-.2px; }
.ft-logo-city { font-size:11px; color:rgba(255,255,255,.3); letter-spacing:.5px; display:block; margin-top:-2px; }

.ft-desc { font-size:13px; color:rgba(255,255,255,.42); line-height:1.75; margin:0 0 22px; max-width:270px; }

.ft-chips { display:flex; flex-wrap:wrap; gap:7px; margin-bottom:26px; }
.ft-chip {
    font-size:11px; font-weight:500; padding:4px 11px; border-radius:99px;
    border:1px solid rgba(0,128,128,.35); color:#2eb8b8;
    background:rgba(0,128,128,.08);
}

.ft-wa {
    display:inline-flex; align-items:center; gap:8px;
    background:#1da851; color:#fff;
    font-size:12.5px; font-weight:500; padding:9px 18px;
    border-radius:99px; text-decoration:none;
    transition:opacity .2s,transform .15s;
}
.ft-wa:hover { opacity:.85; transform:translateY(-1px); color:#fff; }
.ft-wa svg { width:15px; height:15px; fill:white; flex-shrink:0; }

.ft-col-head {
    font-size:10px; font-weight:600; letter-spacing:2px;
    text-transform:uppercase; color:rgba(255,255,255,.22); margin:0 0 18px;
}
.ft-list { list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:10px; }
.ft-list li a {
    color:rgba(255,255,255,.45); text-decoration:none; font-size:13px;
    display:flex; align-items:center; gap:5px; transition:color .18s;
}
.ft-list li a:hover { color:#2eb8b8; }
.ft-list li a .arr { font-size:10px; opacity:0; transform:translateX(-3px); transition:all .18s; }
.ft-list li a:hover .arr { opacity:1; transform:translateX(0); }

.ft-divider { width:100%; height:1px; background:rgba(255,255,255,.05); margin:0 0 16px; }
.ft-sub-head {
    font-size:10px; font-weight:600; letter-spacing:1.6px;
    text-transform:uppercase; color:rgba(255,255,255,.18); margin:16px 0 10px;
}

.ft-contact-row { display:flex; align-items:flex-start; gap:10px; margin-bottom:13px; }
.ft-ci {
    width:30px; height:30px; border-radius:7px;
    background:rgba(0,128,128,.1); border:1px solid rgba(0,128,128,.2);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; color:#2eb8b8;
}
.ft-ci svg { width:13px; height:13px; stroke:currentColor; fill:none; stroke-width:1.7; }
.ft-ct { font-size:13px; color:rgba(255,255,255,.42); line-height:1.55; }
.ft-ct a { color:rgba(255,255,255,.42); text-decoration:none; }
.ft-ct a:hover { color:#2eb8b8; }

.ft-bottom { display:flex; align-items:center; justify-content:space-between; padding:20px 0; gap:12px; flex-wrap:wrap; }
.ft-copy { font-size:12px; color:rgba(255,255,255,.2); }
.ft-bl { display:flex; gap:20px; flex-wrap:wrap; }
.ft-bl a { font-size:12px; color:rgba(255,255,255,.2); text-decoration:none; transition:color .18s; }
.ft-bl a:hover { color:rgba(255,255,255,.55); }

.ft-udyam { display:flex; align-items:center; gap:8px; padding:6px 12px; border-radius:8px; background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08); }
.ft-udyam img { height:32px; width:auto; display:block; }
.ft-udyam-text { display:flex; flex-direction:column; line-height:1.3; }
.ft-udyam-label { font-size:9px; color:rgba(255,255,255,.3); text-transform:uppercase; letter-spacing:1px; }
.ft-udyam-num { font-size:11px; color:rgba(255,255,255,.55); font-weight:600; letter-spacing:.3px; }

@media(max-width:1020px){ .ft-grid{ grid-template-columns:1fr 1fr 1fr; } }
@media(max-width:680px){ .ft-grid{ grid-template-columns:1fr 1fr; } }
@media(max-width:500px){ .ft-grid{ grid-template-columns:1fr; } .ft-bottom{ flex-direction:column; align-items:flex-start; } }
</style>

<footer class="ft">
  <div class="ft-wrap">
    <div class="ft-grid">
      <div>
        <div class="ft-logo">
          <div class="ft-logo-icon">
            <svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/></svg>
          </div>
          <div>
            <span class="ft-logo-name">DSD Properties</span>
            <span class="ft-logo-city">Lucknow &middot; Buy Safely</span>
          </div>
        </div>
        <p class="ft-desc">Honest data-driven property intelligence for Lucknow buyers. No agent bias. No inflated quotes.</p>
        <div class="ft-chips">
          <span class="ft-chip">50+ Localities</span>
          <span class="ft-chip">Zero Agent Bias</span>
          <span class="ft-chip">100% Free</span>
        </div>
        @unless(\App\Support\NoWhatsAppPages::active())
        <a class="ft-wa" href="https://wa.me/918595002933?text=Hello%2C+I+have+a+query+about+your+services.">
          <svg viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
          Connect on WhatsApp
        </a>
        @endunless
      </div>

      <div>
        <p class="ft-col-head">Explore</p>
        <ul class="ft-list">
          <li><a href="/">Home <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog">Articles <span class="arr">&rarr;</span></a></li>
          <li><a href="{{ route('tools.stamp-duty-calculator') }}">Stamp Duty Calculator <span class="arr">&rarr;</span></a></li>
          <li><a href="/rera-approved-projects-lucknow">RERA Projects <span class="arr">&rarr;</span></a></li>
          <li><a href="/lda-schemes">LDA Schemes <span class="arr">&rarr;</span></a></li>
          <li><a href="/lda-demolition-tracker">LDA Demolition Tracker <span class="arr">&rarr;</span></a></li>
          <li><a href="/news">Market Updates <span class="arr">&rarr;</span></a></li>
        </ul>

        <div class="ft-divider" style="margin-top:18px;"></div>
        <p class="ft-sub-head">Services</p>
        <ul class="ft-list">
          <li><a href="/services/property-verification-lucknow">Property Verification <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-advisory-lucknow">Property Advisory <span class="arr">&rarr;</span></a></li>
        </ul>
      </div>

      <div>
        <p class="ft-col-head">Verify by City</p>
        <ul class="ft-list">
          <li><a href="/services/property-verification-lucknow">Lucknow <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-verification-varanasi">Varanasi <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-verification-ayodhya">Ayodhya <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-verification-gorakhpur">Gorakhpur <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-verification-prayagraj">Prayagraj <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-verification-noida">Noida <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-verification-greater-noida">Greater Noida <span class="arr">&rarr;</span></a></li>
          <li><a href="/services/property-verification-agra">Agra <span class="arr">&rarr;</span></a></li>
        </ul>

        <div class="ft-divider" style="margin-top:18px;"></div>
        <p class="ft-sub-head">Company</p>
        <ul class="ft-list">
          <li><a href="/about">About Us <span class="arr">&rarr;</span></a></li>
          <li><a href="/contact-us">Contact <span class="arr">&rarr;</span></a></li>
          <li><a href="/how-property-prices-are-calculated-in-lucknow">Methodology <span class="arr">&rarr;</span></a></li>
          <li><a href="{{ route('privacy.policy') }}">Privacy Policy <span class="arr">&rarr;</span></a></li>
          <li><a href="{{ route('terms.conditions') }}">Terms &amp; Conditions <span class="arr">&rarr;</span></a></li>
          <li><a href="{{ route('cookie.policy') }}">Cookie Policy <span class="arr">&rarr;</span></a></li>
        </ul>
      </div>

      <div>
        <p class="ft-col-head">Popular Areas</p>
        <ul class="ft-list">
          <li><a href="/blog/gomti-nagar-extension-lucknow-guide-2026">Gomti Nagar <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog/vrindavan-yojna-lucknow-investment-guide-2026">Vrindavan Yojna <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog/rise-of-sultanpur-road-lucknow-real-estate-hotspot">Sultanpur Road <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog/mohanlalganj-lucknow-real-estate-guide-2026">Mohanlalganj <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog/fastest-growing-residential-areas-lucknow-2026">Fast-Growing Areas <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog/lda-vs-zila-panchayat-lucknow-comparison">LDA vs Zila Panchayat <span class="arr">&rarr;</span></a></li>
        </ul>

        <div class="ft-divider" style="margin-top:18px;"></div>
        <p class="ft-sub-head">LDA Schemes</p>
        <ul class="ft-list">
          <li><a href="/blog/it-city-lucknow-lda-plots-guide-2026">IT City <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog/wellness-city-lucknow-lda-plots-guide-2026">Wellness City <span class="arr">&rarr;</span></a></li>
          <li><a href="/blog/varun-vihar-yojana-lucknow-hindi-2026">Varun Vihar <span class="arr">&rarr;</span></a></li>
          <li><a href="/lda-schemes">All LDA Schemes <span class="arr">&rarr;</span></a></li>
        </ul>
      </div>

      <div>
        <p class="ft-col-head">Get in Touch</p>

        <div class="ft-contact-row">
          <div class="ft-ci">
            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          </div>
          <p class="ft-ct"><a href="https://www.google.com/maps/dir/?api=1&destination=128+LGE+Sanjar+Gold+Complex+Kalindi+Park+Vrindavan+Sector+2+Lucknow+226025" target="_blank" rel="noopener">128/LGE Sanjar Gold Complex, Near Kalindi Park, Vrindavan Sector 2, Lucknow 226025</a></p>
        </div>

        <div class="ft-contact-row">
          <div class="ft-ci">
            <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 3.07 9.81 19.79 19.79 0 0 1 .06 1.18 2 2 0 0 1 2 0h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L6.09 7.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 14.9v2.02z"/></svg>
          </div>
          <p class="ft-ct"><a href="tel:+918595002933">(+91) 85950 02933</a></p>
        </div>

        <div class="ft-contact-row">
          <div class="ft-ci">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </div>
          <p class="ft-ct"><a href="mailto:dheer@dsdproperties.in?subject=Property%20Inquiry&body=Hello%2C%20I%20would%20like%20to%20know%20more%20about%20your%20properties.">dheer@dsdproperties.in</a></p>
        </div>

        <div style="margin-top:22px;padding:16px;border-radius:10px;background:rgba(0,128,128,.08);border:1px solid rgba(0,128,128,.2);">
          <p style="font-size:10px;color:rgba(255,255,255,.3);margin:0 0 6px;text-transform:uppercase;letter-spacing:1.4px;font-weight:600;">Free Estimate</p>
          <p style="font-size:13px;color:rgba(255,255,255,.5);margin:0 0 12px;line-height:1.55;">Get an instant data-driven valuation for any Lucknow property.</p>
          <a href="/" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:#FF5C00;text-decoration:none;font-family:'Poppins',sans-serif;">Get Free Valuation <span style="font-size:10px;">&rarr;</span></a>
        </div>
      </div>
    </div>

    <div class="ft-bottom">
      <p class="ft-copy">&copy; 2026 DSD Properties. All rights reserved. &middot; Lucknow, Uttar Pradesh</p>

      <div class="ft-udyam">
        {{-- TODO: replace with official Udyam/MSME logo once file is provided — place at public/images/udyam-logo.png --}}
        @if(file_exists(public_path('images/udyam-logo.png')))
          <img src="{{ asset('images/udyam-logo.png') }}" alt="Udyam Registered MSME">
        @endif
        <div class="ft-udyam-text">
          <span class="ft-udyam-label">Udyam Registered MSME</span>
          <span class="ft-udyam-num">UDYAM-UP-0294947</span>
        </div>
      </div>

      <div class="ft-bl">
        <a href="/sitemap-blogs.xml">Sitemap</a>
        <a href="/how-property-prices-are-calculated-in-lucknow">Methodology</a>
        <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
        <a href="{{ route('terms.conditions') }}">Terms &amp; Conditions</a>
        <a href="{{ route('cookie.policy') }}">Cookie Policy</a>
      </div>
    </div>
  </div>
</footer>
