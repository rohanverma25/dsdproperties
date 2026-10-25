<!-- Newsletter Signup -->
<style>
.nl-section {
    padding: 64px 0;
    background: var(--gradient-primary, linear-gradient(to right, #011f4b, #008080));
    color: #fff;
    font-family: 'Poppins', sans-serif;
}
.nl-wrap { max-width: 720px; margin: 0 auto; padding: 0 16px; text-align: center; }
.nl-title { font-size: 1.9rem; font-weight: 700; margin: 0 0 16px; color: #fff; }
.nl-desc { color: rgba(255,255,255,.85); margin: 0 0 32px; font-size: 1rem; line-height: 1.6; }
.nl-form {
    display: flex; flex-direction: column; gap: 16px;
    max-width: 540px; margin: 0 auto;
}
@media(min-width: 640px) { .nl-form { flex-direction: row; } }
.nl-input {
    flex-grow: 1; padding: 12px 16px; border-radius: 8px; border: none;
    color: #1f2937; font-size: 1rem; font-family: 'Poppins', sans-serif;
}
.nl-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(255,92,0,.4); }
.nl-btn {
    background: #FF5C00; color: #fff; font-weight: 600; padding: 12px 24px;
    border-radius: 8px; border: none; cursor: pointer; white-space: nowrap;
    font-size: 1rem; font-family: 'Poppins', sans-serif; transition: background .2s;
}
.nl-btn:hover { background: #e54f00; }
.nl-status { font-size: .875rem; text-align: center; margin-top: 12px; min-height: 1.2em; }
.nl-status.success { color: #6ee7b7; }
.nl-status.error { color: #fca5a5; }
.nl-privacy { font-size: .875rem; color: rgba(255,255,255,.7); margin: 16px 0 0; }
</style>

<section class="nl-section">
    <div class="nl-wrap">
        <h2 class="nl-title">{{ $title ?? 'Stay Informed!' }}</h2>

        <p class="nl-desc">{{ $description ?? 'Subscribe to get property updates, tips, and new listings in your inbox.' }}</p>

        <form id="newsletterForm" class="nl-form">
            <x-honeypot form-id="nl2" />
            @csrf

            <input type="email"
                   name="email"
                   id="newsletter_email"
                   placeholder="Your email address"
                   class="nl-input"
                   required>

            <button type="submit" class="nl-btn">Subscribe</button>
        </form>

        <div id="newsletterStatus" class="nl-status"></div>

        <p class="nl-privacy">We respect your privacy. Unsubscribe at any time.</p>
    </div>
</section>

<script>
document.getElementById('newsletterForm').addEventListener('submit', function (e) {
    e.preventDefault();

    let email = document.getElementById('newsletter_email').value;
    let statusBox = document.getElementById('newsletterStatus');

    let formData = new FormData();
    formData.append('email', email);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('page_url', window.location.href);
    // Page-load time; the server drops sign-ups sent too fast or without it (bot guard)
    formData.append('ts', Math.round(performance.timeOrigin || Date.now()));
    // Built by hand rather than from the form, so the spam trap is copied across explicitly.
    formData.append('website_url', this.querySelector('input[name="website_url"]').value);
    // Cloudflare Turnstile token (present only when Turnstile is switched on)
    var tsTok = this.querySelector('[name="cf-turnstile-response"]');
    if (tsTok) formData.append('cf-turnstile-response', tsTok.value);

    fetch("{{ route('newsletter.subscribe') }}", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        statusBox.textContent = data.message;
        statusBox.className = 'nl-status success';
        document.getElementById('newsletterForm').reset();
    })
    .catch(() => {
        statusBox.textContent = 'Something went wrong. Please try again.';
        statusBox.className = 'nl-status error';
    });
});
</script>
