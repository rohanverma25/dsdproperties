{{--
    Spam trap. A real person never sees or fills this, so any request that
    arrives with it non-empty is a bot.

    Positioned off-screen rather than display:none — some bots skip fields that
    are outright hidden, but fill anything still in the layout. aria-hidden and
    tabindex="-1" keep it away from screen readers and keyboard tabbing.

    The name has to look plausible or bots ignore it, which means password
    managers might try to fill it too — hence the opt-out attributes below.
    A drop is logged (see ChecksHoneypot) so a bad autofill cannot silently
    swallow real enquiries.
--}}
<div style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
    <label for="website_url_{{ $formId ?? 'f' }}">Leave this field empty</label>
    <input type="text" id="website_url_{{ $formId ?? 'f' }}" name="website_url"
           tabindex="-1" value=""
           autocomplete="off"
           data-lpignore="true"
           data-1p-ignore
           data-bwignore
           data-form-type="other">
</div>
{{-- Cloudflare Turnstile (only when TURNSTILE_SITE_KEY is set). "interaction-only" keeps it invisible
     unless Cloudflare needs the visitor to tick a box. It puts a hidden cf-turnstile-response input
     inside this form; ChecksHoneypot verifies it on the server. --}}
@if(config('services.turnstile.site_key'))
<div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"
     data-appearance="interaction-only" data-size="flexible" data-theme="light"
     data-action="{{ $formId ?? 'form' }}" style="margin:6px 0;"></div>
@once
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script>
// A Turnstile token works once. After any form on the page is submitted, give its widget a fresh
// token so a retry (e.g. after fixing a phone number) isn't silently dropped by the server.
document.addEventListener('submit', function (e) {
    var w = e.target && e.target.querySelector ? e.target.querySelector('.cf-turnstile') : null;
    if (!w) return;
    setTimeout(function () { try { if (window.turnstile) window.turnstile.reset(w); } catch (err) {} }, 1500);
}, true);
</script>
@endonce
@endif
