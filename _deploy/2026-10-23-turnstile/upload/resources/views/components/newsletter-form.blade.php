<!-- Newsletter Signup -->
<section class="py-16 gradient-primary text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-4">Stay Informed!</h2>
            <p class="text-teal-100 mb-8">Subscribe to get property updates, tips, and new listings in your inbox.</p>
            
            <form id="newsletterFormID" class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
            <x-honeypot form-id="nl1" />
                @csrf
                <input type="email" name="email" id="newsletter_email"
                       placeholder="Your email address"
                       class="flex-grow px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-accent transition"
                       required>
                <button type="submit"
                        name="submit" class="bg-accent hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition whitespace-nowrap">
                    Subscribe
                </button>
            </form>
            <div id="newsletterStatus" class="text-sm text-center mt-2 text-green-300"></div>
            <p class="text-sm text-teal-200 mt-4">We respect your privacy. Unsubscribe at any time.</p>
        </div>
    </div>
</section>
<script>
document.getElementById('newsletterFormID').addEventListener('submit', function (e) {
        e.preventDefault();

        let email = document.getElementById('newsletter_email').value;
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
            document.getElementById('newsletterStatus').innerText = data.message;
            document.getElementById('newsletterFormID').reset();
        })
        .catch(() => {
            document.getElementById('newsletterStatus').innerText = 'Something went wrong. Please try again.';
        });
    });
    </script>