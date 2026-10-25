<style>
/* ── Let's Talk Solutions Widget ── */
.lts-widget {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(1,31,75,.14);
    border: 1px solid #e2e8f0;
    font-family: 'Poppins', sans-serif;
}

.lts-header {
    background: linear-gradient(135deg, #011f4b 0%, #023372 60%, #005f6b 100%);
    padding: 22px 22px 18px;
    position: relative;
    overflow: hidden;
}
.lts-header::before {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(0,128,128,.18);
    top: -60px; right: -50px;
    pointer-events: none;
}

.lts-header-top {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}
.lts-header-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.lts-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    line-height: 1.2;
}
.lts-sub {
    font-size: .75rem;
    color: rgba(255,255,255,.65);
    margin: 0 0 14px;
    line-height: 1.5;
}
.lts-trust {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.lts-trust-item {
    font-size: .68rem;
    font-weight: 600;
    color: rgba(255,255,255,.85);
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 99px;
    padding: 3px 10px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.lts-body { padding: 20px; }

.lts-field { margin-bottom: 12px; }
.lts-label {
    display: block;
    font-size: .72rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .4px;
    margin-bottom: 5px;
}
.lts-input {
    width: 100%;
    padding: 10px 13px;
    border: 1.5px solid #e2e8f0;
    border-radius: 9px;
    font-family: 'Poppins', sans-serif;
    font-size: .84rem;
    color: #111827;
    background: #f8fafc;
    transition: border-color .15s, background .15s;
    box-sizing: border-box;
}
.lts-input:focus {
    outline: none;
    border-color: #008080;
    background: #fff;
}
.lts-textarea { resize: none; height: 80px; }

.lts-btn {
    width: 100%;
    padding: 13px 16px;
    background: linear-gradient(135deg, #FF5C00, #ff8840);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-family: 'Poppins', sans-serif;
    font-size: .88rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all .22s;
    box-shadow: 0 4px 16px rgba(255,92,0,.28);
    margin-bottom: 14px;
}
.lts-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 22px rgba(255,92,0,.4);
}


.lts-privacy {
    font-size: .65rem;
    color: #94a3b8;
    text-align: center;
    margin: 0;
    line-height: 1.6;
}
.lts-privacy a { color: #94a3b8; text-decoration: underline; }

/* ── Success state ── */
.lts-success {
    padding: 36px 22px;
    text-align: center;
}
.lts-success-icon {
    width: 60px; height: 60px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    font-size: 26px;
    color: #fff;
    box-shadow: 0 6px 20px rgba(16,185,129,.3);
}
.lts-success h3 {
    font-size: 1.2rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 8px;
}
.lts-success p {
    font-size: .84rem;
    color: #64748b;
    margin: 0 0 18px;
    line-height: 1.6;
}
.lts-reset {
    background: none;
    border: none;
    color: #008080;
    font-family: 'Poppins', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: underline;
    padding: 0;
}

/* ── Loading ── */
.lts-loading {
    padding: 40px 22px;
    text-align: center;
}
.lts-spinner {
    width: 36px; height: 36px;
    border: 3px solid #e2e8f0;
    border-top-color: #011f4b;
    border-radius: 50%;
    animation: lts-spin .7s linear infinite;
    margin: 0 auto 14px;
}
@keyframes lts-spin { to { transform: rotate(360deg); } }
.lts-loading p { font-size: .84rem; color: #64748b; margin: 0; }

/* ── Error messages ── */
.lts-error { font-size: .75rem; color: #dc2626; margin-top: 4px; display: block; }
.lts-input.lts-input-err { border-color: #dc2626; background: #fff5f5; }

.hidden { display: none !important; }
</style>

<div class="lts-widget">

    {{-- Header --}}
    <div class="lts-header">
        <div class="lts-header-top">
            <div class="lts-header-icon">💬</div>
            <h2 class="lts-title">Let's Talk Solutions</h2>
        </div>
        <p class="lts-sub">Provide your details and our property specialist will connect within 24 hours.</p>
    </div>

    {{-- Form --}}
    <div class="lts-body" id="ebook-form-container">
        <form id="ebook-form" method="POST" action="{{ route('inquiry.submit') }}">
            @csrf
            {{-- Tells the shared inbox which form this came from. Before this
                 existed, sidebar and contact-us rows were indistinguishable. --}}
            <input type="hidden" name="source_form" value="{{ \App\Models\FormSubmission::FORM_BLOG_SIDEBAR }}">
            <input type="hidden" name="page_url" value="{{ url()->current() }}">
            <input type="hidden" name="referrer_url" value="{{ request()->headers->get('referer') }}">
            <x-honeypot form-id="sidebar" />
            <div class="lts-field">
                <label class="lts-label">Full Name *</label>
                <input type="text" name="full_name" placeholder="Your full name" required class="lts-input">
            </div>
            <div class="lts-field">
                <label class="lts-label">Phone Number *</label>
                <input type="tel" name="phone_number" placeholder="10-digit mobile number" required class="lts-input">
            </div>
            <div class="lts-field">
                <label class="lts-label">Email <span style="font-weight:500;opacity:.7;">(optional)</span></label>
                <input type="email" name="email" placeholder="your@email.com" class="lts-input">
            </div>
            <div class="lts-field" style="margin-bottom:16px;">
                <label class="lts-label">Message *</label>
                <textarea name="message" placeholder="Tell us what you're looking for…" rows="3" required class="lts-input lts-textarea"></textarea>
            </div>

            <button type="submit" class="lts-btn">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Get Free Expert Advice
            </button>

            <p class="lts-privacy">
                Protected by reCAPTCHA ·
                <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy</a> ·
                <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms</a>
            </p>
        </form>
    </div>

    {{-- Success state --}}
    <div id="success-message" class="lts-success hidden">
        <div class="lts-success-icon">✓</div>
        <h3>Thank You!</h3>
        <p>One of our property experts will connect with you within 24 hours.</p>
        <button id="reset-form" class="lts-reset">Submit another inquiry →</button>
    </div>

    {{-- Loading --}}
    <div id="loading-indicator" class="lts-loading hidden">
        <div class="lts-spinner"></div>
        <p>Submitting your inquiry…</p>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    var form            = document.getElementById("ebook-form");
    var formContainer   = document.getElementById("ebook-form-container");
    var successMessage  = document.getElementById("success-message");
    var loadingIndicator= document.getElementById("loading-indicator");
    var resetButton     = document.getElementById("reset-form");

    resetButton.addEventListener("click", function () {
        form.reset();
        successMessage.classList.add("hidden");
        formContainer.classList.remove("hidden");
    });

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        form.querySelectorAll(".lts-error").forEach(function(el){ el.remove(); });
        form.querySelectorAll(".lts-input-err").forEach(function(el){ el.classList.remove("lts-input-err"); });

        var nameInput  = form.full_name;
        var phoneInput = form.phone_number;
        var emailInput = form.email;
        var hasError   = false;

        function showError(input, msg) {
            input.classList.add("lts-input-err");
            var err = document.createElement("span");
            err.className = "lts-error";
            err.textContent = msg;
            input.insertAdjacentElement("afterend", err);
            hasError = true;
        }

        if (!nameInput.value.trim()) {
            showError(nameInput, "Name is required.");
        } else if (nameInput.value.trim().length < 2) {
            showError(nameInput, "Name must be at least 2 characters.");
        }

        var phone = phoneInput.value.trim().replace(/\s/g, '');
        if (!phone) {
            showError(phoneInput, "Phone number is required.");
        } else if (!/^\d{10,}$/.test(phone)) {
            showError(phoneInput, "Enter a valid 10-digit number.");
        }

        // Email is optional — only validated when something was typed.
        var emailVal = emailInput.value.trim();
        if (emailVal && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailVal)) {
            showError(emailInput, "Enter a valid email address.");
        }

        if (hasError) return;

        formContainer.classList.add("hidden");
        loadingIndicator.classList.remove("hidden");

        var formData = new FormData(form);
        formData.append("page_url", window.location.href);

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(function(r){ if (!r.ok) throw new Error('Network error'); return r.json(); })
        .then(function(data) {
            loadingIndicator.classList.add("hidden");
            if (data.success) {
                successMessage.classList.remove("hidden");
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'conversion', { event_category: 'form', event_label: 'property_inquiry' });
                }
            } else {
                formContainer.classList.remove("hidden");
                if (data.errors) {
                    Object.entries(data.errors).forEach(function([field, messages]) {
                        var input = form[field];
                        if (input) showError(input, messages[0]);
                        else alert(messages[0]);   // e.g. the security (Turnstile) check
                    });
                } else {
                    alert("Something went wrong. Please try again.");
                }
            }
        })
        .catch(function() {
            loadingIndicator.classList.add("hidden");
            formContainer.classList.remove("hidden");
            alert("Submission failed. Please check your connection and try again.");
        });
    });
});
</script>
