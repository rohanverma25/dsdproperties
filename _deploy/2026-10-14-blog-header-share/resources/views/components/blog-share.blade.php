{{--
    Copy-link button for a blog post.
    @param  \App\Models\BlogPost  $blog
    @param  string  $variant  'compact' (next to the title) | 'full' (end of article, with heading)
    Styles live in blogs/show.blade.php (.bs-share*). The script renders once per page.
--}}
@php
    $variant  = $variant ?? 'compact';
    $isHindi  = ($blog->language ?? 'en') === 'hi';
    $shareUrl = route('blog.show', $blog->slug);
@endphp

<div class="bs-share bs-share--{{ $variant }}" data-share-url="{{ $shareUrl }}">
    @if($variant === 'full')
        <p class="bs-share-heading">{{ $isHindi ? 'यह जानकारी काम की लगी? लिंक कॉपी करके परिवार और दोस्तों को भेजें' : 'Found this useful? Copy the link and share it with family and friends' }}</p>
    @endif

    <div class="bs-share-row">
        <button type="button" class="bs-share-btn bs-share-copy" data-share="copy" aria-label="{{ $isHindi ? 'लिंक कॉपी करें' : 'Copy link' }}">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg>
            <span class="bs-share-copy-label" data-done="{{ $isHindi ? 'कॉपी हो गया' : 'Copied' }}">{{ $isHindi ? 'लिंक कॉपी करें' : 'Copy link' }}</span>
        </button>
    </div>
</div>

@once
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.bs-share').forEach(function (box) {
        var url = box.dataset.shareUrl;
        box.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-share="copy"]');
            if (!btn) return;
            e.preventDefault();
            if (typeof gtag === 'function') { gtag('event', 'share', { method: 'copy', item_id: url }); }

            var label = btn.querySelector('.bs-share-copy-label'), old = label.textContent;
            var done = function () {
                label.textContent = label.dataset.done;
                btn.classList.add('is-done');
                setTimeout(function () { label.textContent = old; btn.classList.remove('is-done'); }, 2000);
            };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(done, function () { window.prompt('', url); });
            } else {
                window.prompt('', url);
            }
        });
    });
});
</script>
@endonce
