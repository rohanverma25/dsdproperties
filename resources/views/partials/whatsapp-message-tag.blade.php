{{--
    WhatsApp message tagging — included next to partials/ga4 on every public layout.

    Every WhatsApp link on the page (Blade buttons, PageCta, and links inside
    blog content_html) gets two lines appended to its pre-filled message:

        Button: <text written on the button that was clicked>
        Page: <full URL of the page>

    Any "Button:" / "Page:" lines already in the message are replaced, so a
    link is never tagged twice. Links are tagged on page load (so long-press
    "copy link" also carries the tags) and again at click time (so buttons
    added later by JavaScript are covered too).
--}}
<script>
(function () {
  'use strict';
  var WA = /(^|\/\/)(wa\.me|api\.whatsapp\.com|web\.whatsapp\.com)\/|^whatsapp:\/\//i;

  function label(a) {
    var s = a.innerText || a.textContent || '';
    s = s.replace(/\s+/g, ' ').trim();
    if (!s) s = (a.getAttribute('aria-label') || a.getAttribute('title') || '').trim();
    if (!s) {
      var img = a.querySelector('img[alt]');
      if (img) s = img.getAttribute('alt').trim();
    }
    return s.slice(0, 120);
  }

  function tag(a) {
    try {
      var href = a.getAttribute('href') || '';
      if (!WA.test(href)) return;
      var url = new URL(href, location.href);
      // Drop old tag lines, and an inline " Page: /path" left by Blade buttons
      var lines = (url.searchParams.get('text') || '').split(/\r?\n/).filter(function (l) {
        return !/^\s*(Button|Page)\s*:/i.test(l);
      }).map(function (l) {
        return l.replace(/\s*\bPage\s*:\s*\S*\s*$/i, '');
      });
      var msg = lines.join('\n').replace(/\s+$/, '') || 'Hello, I have a query.';
      var btn = label(a);
      var page = location.origin + location.pathname + location.search;
      msg += '\n\n' + (btn ? 'Button: ' + btn + '\n' : '') + 'Page: ' + page;
      url.searchParams.set('text', msg);
      a.setAttribute('href', url.toString());
    } catch (e) {}
  }

  function tagAll() {
    var links = document.querySelectorAll('a[href]');
    for (var i = 0; i < links.length; i++) tag(links[i]);
  }

  function onClick(e) {
    var a = e.target && e.target.closest && e.target.closest('a[href]');
    if (a) tag(a);
  }
  document.addEventListener('click', onClick, true);
  document.addEventListener('auxclick', onClick, true);
  document.addEventListener('contextmenu', onClick, true);

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', tagAll);
  else tagAll();
})();
</script>
