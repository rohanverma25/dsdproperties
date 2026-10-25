<style>
/*/* Card-like TOC */
h2#toc_id {
  background: linear-gradient(135deg, #e6f7f7, #fdfdfd);
  border: 1px solid #cce5e5;
  border-radius: 14px 14px 0 0;
  padding: 18px 20px;
  margin: 20px 0 0;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  font-size: 20px;
  font-weight: 700;
  color: #011f4b;
  box-shadow: 0 4px 12px rgba(1,31,75,0.15);
}

h2#toc_id + ul {
  list-style: none;
  margin: 0;
  padding: 14px 16px 20px;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-top: 0;
  border-radius: 0 0 14px 14px;
  box-shadow: 0 4px 10px rgba(0,128,128,0.08);
}

h2#toc_id + ul li {
  margin: 6px 0;
}

h2#toc_id + ul li a {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  font-size: 15px;
  color: #011f4b;
  padding: 8px 12px;
  border-radius: 10px;
  transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
  background: #f9fafb;
}

h2#toc_id + ul li a::before {
  content: "";
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #008080;
  flex-shrink: 0;
}

h2#toc_id + ul li a:hover {
  background: rgba(0,128,128,0.08);
  color: #008080;
  transform: translateX(6px);
}

h2#toc_id + ul li a.active {
  background: rgba(255,165,0,0.15);
  color: #FFA500;
  font-weight: 600;
}
h2#toc_id + ul li a.active::before {
  background: #FFA500;
  box-shadow: 0 0 0 4px rgba(255,165,0,0.2);
}

h2#toc_id + ul li a:focus {
  outline: 3px solid rgba(0,128,128,0.3);
  outline-offset: 2px;
}

@media (max-width: 480px) {
  h2#toc_id { padding: 14px 16px; font-size: 18px; }
  h2#toc_id + ul { padding: 10px 10px 14px; }
  h2#toc_id + ul li a { font-size: 14px; padding: 8px 10px; }
}
*/
/* ── TABLE: responsive wrapper ── */
.dsd-table-wrap {
    display: block;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
    max-width: 100%;
    margin: 24px 0;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
}

table {
    border-collapse: collapse;
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #111827;
    min-width: 480px;
    width: 100%;
}

/* Header */
table thead {
    background: linear-gradient(135deg, #011f4b, #008080);
}
table thead th {
    padding: 13px 16px;
    font-weight: 600;
    font-size: 13px;
    color: #ffffff !important;
    text-align: left;
    letter-spacing: .3px;
    white-space: nowrap;
    border: none;
}

/* Body rows */
table tbody tr {
    background: #ffffff;
    transition: background .18s;
}
table tbody tr:nth-child(even) {
    background: #f8fafc;
}
table tbody tr:hover {
    background: rgba(0, 128, 128, .07);
}

/* Cells */
table td,
table th {
    padding: 12px 16px !important;
    vertical-align: middle !important;
    text-align: left !important;
    border-bottom: 1px solid #e5e7eb;
}
table tbody tr:last-child td {
    border-bottom: none;
}
table td {
    color: #374151;
    font-size: 13.5px;
    line-height: 1.55;
}

/* Mobile */
@media (max-width: 640px) {
    table {
        font-size: 13px;
        min-width: 420px;
    }
    table td, table th {
        padding: 10px 12px !important;
    }
}
</style>

<!--<div class="flex items-center gap-4 text-sm text-gray-500 p-4">
   <span class="flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    12 min read
  </span>
  
  <span class="flex items-center gap-1">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    Updated: {{ $blog->updated_at->format('M d, Y') }}
  </span>
</div> -->
<style>
/* ── Blog FAQ accordion (rewritten 2026-10-19) ─────────────────────────── */
.faq-h3-trigger{cursor:pointer;position:relative;padding-right:28px;user-select:none}
.faq-h3-trigger::after{content:'+';position:absolute;right:0;top:50%;transform:translateY(-50%);font-size:1.2em;font-weight:400;color:#008080;transition:transform .25s}
.faq-h3-trigger.faq-open::after{content:'−'}
.faq-li-class.faq-open{background:#fff;box-shadow:0 5px 15px rgba(0,0,0,.1)}

/* Questions that carry their own inline card styling: keep room for the +/− icon */
.faq-h3-trigger[style]{padding-right:48px !important}
.faq-h3-trigger[style]::after{right:18px}

/* FAQs whose anchor sits on the heading: the script wraps the questions in .dsd-faq-auto */
.dsd-faq-auto{margin:8px 0 20px}
.dsd-faq-auto .faq-h3-trigger:not([style]){display:block;margin:12px 0 0 !important;padding:14px 48px 14px 18px !important;background:#f8fafc;border:1px solid #e2e8f0;border-left:4px solid #008080;border-radius:0 10px 10px 0;font-size:16px;line-height:1.5;color:#011f4b;font-weight:600}
.dsd-faq-auto .faq-h3-trigger:not([style])::after{right:18px}
.dsd-faq-auto .faq-h3-trigger:not([style]).faq-open{border-radius:0 10px 0 0;background:#f0fdfa}
.dsd-faq-auto .faq-h3-trigger:not([style]) + .faq-auto-a{margin:0 0 4px !important;padding:12px 18px !important;background:#fff;border:1px solid #e2e8f0;border-top:0;border-radius:0 0 10px 10px;font-size:15px;line-height:1.8}
@media(max-width:640px){
  .dsd-faq-auto .faq-h3-trigger:not([style]){font-size:15px;padding:13px 44px 13px 14px !important}
  .dsd-faq-auto .faq-h3-trigger:not([style]) + .faq-auto-a{padding:11px 14px !important}
  .faq-h3-trigger[style]{padding-right:44px !important}
  .faq-h3-trigger[style]::after,.dsd-faq-auto .faq-h3-trigger:not([style])::after{right:14px}
}

/* Numbered FAQ cards (.dsd-faq-li): bold words inside answers must stay inline */
.dsd-faq-li p strong,.dsd-faq-li p b{display:inline !important;font-size:inherit !important;clear:none !important}
/* Numbered FAQ list: the cards carry their own number, so hide the browser list marker */
ol.dsd-faq-ol{list-style:none;padding-left:0}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // FAQ blocks that already ship their own accordion are left alone.
    var OWN = '.faq-q, .faq-question, .faq-item, summary, details, .faq-li-class';

    // ── Structure 1: an element with id FAQs / faqs / faq / FAQ ──
    var box = document.getElementById('FAQs') || document.getElementById('faqs')
           || document.getElementById('faq')  || document.getElementById('FAQ');

    // Anchor on a heading: gather the content that follows it (up to the next h2) into one wrapper
    if (box && /^H[1-6]$/.test(box.tagName)) {
        var items = [], n = box.nextElementSibling;
        while (n && !/^(H1|H2|SECTION|ARTICLE|FOOTER)$/.test(n.tagName)) { items.push(n); n = n.nextElementSibling; }
        var hasQ = items.some(function (el) { return /^H[34]$/.test(el.tagName) || el.querySelector('h3, h4'); });
        if (hasQ) {
            var wrap = document.createElement('div');
            wrap.className = 'dsd-faq-auto';
            box.parentNode.insertBefore(wrap, items[0]);
            items.forEach(function (el) { wrap.appendChild(el); });
            box = wrap;
        } else {
            box = null;
        }
    }

    if (box && !/^(SCRIPT|STYLE)$/.test(box.tagName)) {
        var headers = Array.prototype.filter.call(box.querySelectorAll('h3, h4'), function (h) {
            var a = h.nextElementSibling;
            return a && !/^H[1-6]$/.test(a.tagName) && !h.closest(OWN) && !h.matches(OWN);
        });
        // Older posts style the open state with their own class names (active, open, dsd-open, ...).
        // Their own click handlers are blocked below, so set every one of those classes here.
        var Q_OPEN = ['faq-open', 'active', 'open', 'dsd-open', 'dsd-faq-open'], A_OPEN = ['open', 'active'];
        function setOpen(q, on) {
            var a = q.nextElementSibling;
            a.style.display = on ? 'block' : 'none';
            Q_OPEN.forEach(function (c) { q.classList.toggle(c, on); });
            A_OPEN.forEach(function (c) { a.classList.toggle(c, on); });
            q.setAttribute('aria-expanded', on ? 'true' : 'false');
        }
        headers.forEach(function (h) {
            var answer = h.nextElementSibling;
            answer.style.display = 'none';
            if (box.classList.contains('dsd-faq-auto')) answer.classList.add('faq-auto-a');
            h.classList.add('faq-h3-trigger');
            h.setAttribute('role', 'button');
            h.setAttribute('tabindex', '0');
            h.setAttribute('aria-expanded', 'false');

            function toggle() {
                var isOpen = h.getAttribute('aria-expanded') === 'true';
                headers.forEach(function (hh) { setOpen(hh, false); });
                if (!isOpen) setOpen(h, true);
            }
            h._dsdFaqToggle = toggle;
            h.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); }
            });
        });

        // Many posts also bind their own click handler to the same questions. Catch the click on the
        // container first (capture phase) and stop it there, so only one handler toggles the answer.
        if (headers.length) {
            box.addEventListener('click', function (e) {
                var h = e.target.closest && e.target.closest('.faq-h3-trigger');
                if (!h || !h._dsdFaqToggle || !box.contains(h)) return;
                e.stopPropagation();
                h._dsdFaqToggle();
            }, true);
        }
    }

    // ── Structure 2: .faq-li-class (li with cursor:pointer) ──
    // Items with a .faq-q question ship their own toggle in the article.
    var faqItems = Array.prototype.filter.call(
        document.querySelectorAll('.faq-li-class'),
        function (li) { return !li.querySelector('.faq-q'); }
    );
    faqItems.forEach(function (item) {
        var answer = item.querySelector('p, div, span');
        if (!answer) return;
        answer.style.display = 'none';

        item.addEventListener('click', function () {
            var isOpen = this.classList.contains('faq-open');
            faqItems.forEach(function (li) {
                var a = li.querySelector('p, div, span');
                if (a) a.style.display = 'none';
                li.classList.remove('faq-open');
            });
            if (!isOpen) {
                answer.style.display = 'block';
                this.classList.add('faq-open');
            }
        });
    });

});
</script>
