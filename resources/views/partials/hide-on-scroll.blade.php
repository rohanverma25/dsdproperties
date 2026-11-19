{{-- Phones/tablets: hide the header + CTA bar while the reader scrolls forward through the article,
     bring both back as soon as they scroll back. Always shown near the top, near the end and while the menu is open.
     transform only (no display/height change), so the text never jumps and CLS stays 0. --}}
<style>
@media(max-width:1023px){
 #main-header,.mob-cta-bar{transition:transform .25s ease;will-change:transform}
 body.nav-hidden #main-header{transform:translateY(calc(-100% - 30px))}
 body.nav-hidden .mob-cta-bar{transform:translateY(calc(100% + 24px))}
}
@media(prefers-reduced-motion:reduce){#main-header,.mob-cta-bar{transition:none}}
</style>
<script>
(function () {
    var mq = window.matchMedia('(max-width: 1023px)'), body = document.body, last = window.pageYOffset, busy = false;
    function show() { body.classList.remove('nav-hidden'); }
    function update() {
        busy = false;
        var y = window.pageYOffset, menu = document.getElementById('hdr-mobile'), foot = document.querySelector('footer.ft');
        // end of article = footer on screen (scrollHeight is unreliable here: hidden widgets inflate it)
        var atEnd = foot && foot.getBoundingClientRect().top < window.innerHeight;
        // top of page (also covers iOS bounce), end of article, desktop, or menu open: keep both visible
        if (!mq.matches || y < 100 || atEnd || (menu && menu.classList.contains('open'))) { show(); last = y; return; }
        var d = y - last;
        if (Math.abs(d) < 12) return;      // ignore tiny finger movements so nothing flickers
        body.classList.toggle('nav-hidden', d > 0);
        last = y;
    }
    window.addEventListener('scroll', function () { if (!busy) { busy = true; requestAnimationFrame(update); } }, { passive: true });
    mq.addEventListener ? mq.addEventListener('change', show) : mq.addListener(show);
})();
</script>
