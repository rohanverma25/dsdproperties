// Only wire up the newsletter form on pages that actually have one.
// Without this guard the module throws on every other page, which aborts
// app.js before Alpine.start() is ever reached.
const newsletterForm = document.getElementById('newsletterForm');

if (newsletterForm) {
    newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();

            let email = document.getElementById('newsletter_email').value;
            let formData = new FormData();
            formData.append('email', email);
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('newsletter.subscribe') }}", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('newsletterStatus').innerText = data.message;
                document.getElementById('newsletterForm').reset();
            })
            .catch(() => {
                document.getElementById('newsletterStatus').innerText = 'Something went wrong. Please try again.';
            });
        });
}
