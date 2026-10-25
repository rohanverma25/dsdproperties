Cloudflare Turnstile on all lead forms (23 Oct 2026)

Forms covered (all use <x-honeypot />): Contact Us, blog sidebar enquiry, blog exit-intent popup,
both newsletter sign-up forms, LDA calculator feedback.

1. Upload everything inside "upload/" to the site root, keeping the folders.
   Upload this AFTER the newsletter bundle (_deploy/2026-10-23-newsletter): the two newsletter
   form files here are the newest versions (bot guard + Turnstile token) and must overwrite those.
2. Add to the server .env (keys from Cloudflare dashboard -> Turnstile -> your site):
     TURNSTILE_SITE_KEY=0x...
     TURNSTILE_SECRET_KEY=0x...
   The hostname list in Cloudflare must include dsdproperties.in (and www.dsdproperties.in).
3. Open https://dsdproperties.in/run-route-cache twice (clears the config cache).
4. Test: submit the Contact Us form once. It should arrive in /admin/form-submissions.
   Dropped submissions are logged in storage/logs/laravel.log as "Turnstile failed".
