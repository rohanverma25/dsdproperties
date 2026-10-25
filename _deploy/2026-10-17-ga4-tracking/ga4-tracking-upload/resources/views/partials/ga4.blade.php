{{--
  DSD Properties — GA4 tracking (single source for every public page)
  Included in <head> of layouts: blogs-app, user-app, app-article.

  NAMING CONVENTION
  - Event names: GA4 recommended names where one exists (generate_lead, sign_up, search, share, exception);
    otherwise lowercase snake_case "object_action" (whatsapp_click, faq_open, map_view), max 40 chars.
  - Parameters: lowercase snake_case, max 40 chars; values trimmed to 100 chars.
  - Every event carries page_type, content_group and page_language (set once via gtag('set')).

  EVENTS SENT FROM THIS FILE
  Leads:      whatsapp_click, phone_call, email_click, generate_lead (lead_method: whatsapp|phone|email|form)
  Forms:      generate_lead (form), sign_up (newsletter), comment_submit, feedback_submit, tool_use
  Reading:    scroll_depth (25/50/75/90), article_read (30s+ engaged and 50%+ scrolled)
  Navigation: internal_link_click, navigation_click (header/footer), toc_click, anchor_click, language_switch
  Content:    faq_open, calculator_use, map_view, map_interact, button_click, text_copy
  Health:     exception (JS errors, max 3 per page), page_not_found
  GA4 also collects its own enhanced-measurement events: page_view, scroll (90%), click (outbound),
  file_download, form_start, form_submit, view_search_results, video_*.

  Debug: add ?ga_debug=1 to any URL to see events in GA4 DebugView and the browser console.
--}}
@php
    $gaPath  = trim(request()->path(), '/');
    $gaSeg   = $gaPath === '' ? [] : explode('/', $gaPath);
    $gaFirst = $gaSeg[0] ?? '';
    $gaType  = 'other';
    if ($gaPath === '')                                           $gaType = 'home';
    elseif (in_array($gaFirst, ['blog', 'blogs']))                $gaType = count($gaSeg) > 1 ? 'blog_article' : 'blog_index';
    elseif ($gaFirst === 'news')                                  $gaType = count($gaSeg) > 1 ? 'news_article' : 'news_index';
    elseif ($gaFirst === 'services')                              $gaType = 'service';
    elseif ($gaFirst === 'properties')                            $gaType = count($gaSeg) > 1 ? 'property_detail' : 'property_listing';
    elseif ($gaFirst === 'tools')                                 $gaType = 'tool';
    elseif (in_array($gaPath, ['lda-schemes', 'awas-vikas-schemes', 'rera-approved-projects-lucknow']) || str_starts_with($gaPath, 'lda-'))
                                                                  $gaType = 'scheme_hub';
    elseif (in_array($gaPath, ['contact-us', 'about-us', 'reviews'])) $gaType = 'company';
    elseif (str_contains($gaPath, 'policy') || str_contains($gaPath, 'terms')) $gaType = 'legal';
    $gaOverride = trim($__env->yieldContent('ga_page_type'));
    if ($gaOverride !== '') $gaType = $gaOverride;

    $gaLang = (isset($blog) && is_object($blog) && !empty($blog->language))
        ? (str_starts_with(strtolower($blog->language), 'hi') ? 'hi' : 'en')
        : (str_contains($gaPath, 'hindi') ? 'hi' : 'en');
    $gaArticle = null;
    if ($gaType === 'blog_article' && isset($blog) && is_object($blog) && isset($blog->id))            $gaArticle = 'blog_' . $blog->id;
    elseif ($gaType === 'news_article' && isset($article) && is_object($article) && isset($article->id)) $gaArticle = 'news_' . $article->id;
    if (!in_array($gaType, ['blog_article'])) $gaLang = str_contains($gaPath, 'hindi') ? 'hi' : 'en';

    $ga = [
        'id'         => 'G-Q3FHCGKDZ9',
        'ads'        => 'AW-18304150909',
        'page_type'  => $gaType,
        'language'   => $gaLang,
        'article_id' => $gaArticle,
        'internal'   => auth()->check(),
    ];
@endphp
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Q3FHCGKDZ9"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
(function () {
  var C = @json($ga);
  window.DSD_GA = C;
  C.debug = /[?&]ga_debug=1(&|$)/.test(location.search);
  var common = { page_type: C.page_type, content_group: C.page_type, page_language: C.language };
  if (C.article_id) common.article_id = C.article_id;
  gtag('set', common);
  var cfg = { content_group: C.page_type };
  if (C.internal) cfg.traffic_type = 'internal';
  if (C.debug) cfg.debug_mode = true;
  gtag('config', C.id, cfg);
  gtag('config', C.ads);
})();
</script>
<script>
(function () {
  'use strict';
  var C = window.DSD_GA || {};
  var HOST = location.hostname.replace(/^www\./, '');
  var sent = {};

  function cut(s, n) { return (s == null ? '' : String(s)).replace(/\s+/g, ' ').trim().slice(0, n || 100); }
  function send(name, params) {
    try {
      params = params || {};
      if (C.debug && window.console) console.log('[GA4]', name, params);
      gtag('event', name, params);
    } catch (e) {}
  }
  function once(key, fn) { if (!sent[key]) { sent[key] = 1; fn(); } }
  function txt(el) { return cut(el && (el.innerText || el.textContent || el.getAttribute('aria-label') || el.getAttribute('title') || ''), 100); }

  // Where on the page an element sits (link_location)
  function where(el) {
    if (!el || !el.closest) return 'other';
    var rules = [
      ['.dsd-verify-cta', 'verify_cta'],
      ['.consultationBtn', 'consultation_button'],
      ['.dsd-key-facts', 'key_facts'],
      ['#FAQs, .faq-ol-class, .dsd-faq', 'faq'],
      ['.dsd-toc, [aria-label="Table of contents"], #toc_id', 'toc'],
      ['header', 'header'],
      ['footer', 'footer']
    ];
    for (var i = 0; i < rules.length; i++) { if (el.closest(rules[i][0])) return rules[i][1]; }
    for (var n = el, d = 0; n && n !== document.body && d < 8; n = n.parentElement, d++) {
      var pos = window.getComputedStyle(n).position;
      if (pos === 'fixed' || pos === 'sticky') return 'floating_button';
    }
    if (el.closest('nav')) return 'navigation';
    if (el.closest('aside')) return 'sidebar';
    if (el.closest('[class*="related"]')) return 'related_content';
    if (el.closest('article, main, section, .prose, .blog-content, .dsd-hindi')) return 'content';
    return 'other';
  }

  function lead(method, extra) {
    var p = { lead_method: method };
    for (var k in extra) p[k] = extra[k];
    send('generate_lead', p);
  }

  // ── Clicks (capture phase, so other handlers cannot hide them) ──
  document.addEventListener('click', function (e) {
    var t = e.target;
    if (!t || !t.closest) return;

    // Interactive maps (first interaction per map per page) — checked first so map controls are not counted as links
    var map = t.closest('.leaflet-container, .openseadragon-container, .openseadragon-canvas');
    if (map && !t.closest('.leaflet-control-attribution')) {
      var mname = cut((map.closest('[id]') || map).id || 'map', 40);
      once('mapi:' + mname, function () { send('map_interact', { map_name: mname }); });
      return;
    }

    var a = t.closest('a[href]');
    if (a) {
      var raw = a.getAttribute('href') || '';
      var abs = a.href || '';
      var base = { link_url: cut(abs, 100), link_text: txt(a), link_location: where(a) };

      if (/(^|\/\/)(wa\.me|api\.whatsapp\.com|web\.whatsapp\.com)|whatsapp:\/\//i.test(abs)) { send('whatsapp_click', base); lead('whatsapp', base); return; }
      if (/^tel:/i.test(raw))    { send('phone_call', base);  lead('phone', base); return; }
      if (/^mailto:/i.test(raw)) { send('email_click', base); lead('email', base); return; }

      var u; try { u = new URL(abs, location.href); } catch (x) { return; }
      if (u.hostname.replace(/^www\./, '') !== HOST) return;            // outbound: GA4 built-in "click"
      if (/\.(pdf|xlsx?|docx?|csv|zip|kml|kmz)$/i.test(u.pathname)) return; // GA4 built-in "file_download"

      if (u.pathname === location.pathname && u.hash) {
        send(base.link_location === 'toc' ? 'toc_click' : 'anchor_click', { link_text: base.link_text, link_url: cut(u.hash, 100), link_location: base.link_location });
        return;
      }
      if (a.getAttribute('hreflang') || /read in english|english version|हिंदी में पढ़ें|हिन्दी में पढ़ें|hindi version/i.test(base.link_text)) {
        send('language_switch', { link_url: base.link_url, link_text: base.link_text, language: /hindi|-hi(\/|$)/i.test(u.pathname) ? 'hi' : 'en' });
        return;
      }
      if (base.link_location === 'header' || base.link_location === 'footer' || base.link_location === 'navigation') send('navigation_click', base);
      else send('internal_link_click', base);
      return;
    }

    // FAQ question opened
    var q = t.closest('#FAQs h3, #FAQs h4, .faq-li-class, .dsd-faq h3, .faq-q');
    if (q) {
      setTimeout(function () {
        var head = q.matches('li') ? (q.querySelector('h3, h4') || q) : q;
        var open = q.classList.contains('faq-open') || head.classList.contains('faq-open') || head.classList.contains('active');
        if (open) send('faq_open', { faq_question: txt(head) });
      }, 60);
      return;
    }

    // Calculators (first use per calculator per page)
    var calc = t.closest('.dsd-calc, [id*="calc" i], [class*="calculator" i]');
    if (calc) {
      var cname = cut(calc.id || (calc.className + '').split(' ')[0] || 'calculator', 40);
      once('calc:' + cname, function () { send('calculator_use', { calculator_name: cname }); });
    }

    // Other buttons (first click per button text per page)
    var b = t.closest('button, [role="button"]');
    if (b && !calc) {
      var bt = txt(b) || cut(b.id || b.className, 40);
      once('btn:' + bt, function () { send('button_click', { button_text: bt, link_location: where(b) }); });
    }
  }, true);

  // ── Scroll depth 25/50/75/90 (GA4's own "scroll" event still fires at 90%) ──
  var maxPct = 0, hit = {}, ticking = false;
  function measure() {
    var h = Math.max(document.documentElement.scrollHeight, document.body ? document.body.scrollHeight : 0);
    var pct = h > 0 ? Math.min(100, Math.round((window.scrollY + window.innerHeight) / h * 100)) : 0;
    if (pct > maxPct) maxPct = pct;
    [25, 50, 75, 90].forEach(function (m) {
      if (!hit[m] && pct >= m) { hit[m] = 1; send('scroll_depth', { percent_scrolled: m }); }
    });
  }
  window.addEventListener('scroll', function () {
    if (ticking) return; ticking = true;
    requestAnimationFrame(function () { measure(); ticking = false; });
  }, { passive: true });

  // ── Article read: 30s+ of active time and 50%+ scrolled (blog and news articles) ──
  if (C.page_type === 'blog_article' || C.page_type === 'news_article') {
    var active = 0, lastAct = Date.now(), readSent = false;
    ['scroll', 'mousemove', 'keydown', 'touchstart', 'click'].forEach(function (ev) {
      window.addEventListener(ev, function () { lastAct = Date.now(); }, { passive: true });
    });
    var timer = setInterval(function () {
      if (document.visibilityState === 'visible' && Date.now() - lastAct < 30000) active++;
      if (!readSent && active >= 30 && maxPct >= 50) {
        readSent = true; clearInterval(timer);
        send('article_read', { read_time_sec: active, percent_scrolled: maxPct });
      }
    }, 1000);
  }

  // ── Maps shown (Leaflet / OpenSeadragon appear lazily) ──
  function scanMaps(root) {
    var els = (root.querySelectorAll ? root : document).querySelectorAll('.leaflet-container, .openseadragon-container');
    Array.prototype.forEach.call(els, function (m) {
      var name = cut((m.closest('[id]') || m).id || 'map', 40);
      once('mapv:' + name, function () { send('map_view', { map_name: name }); });
    });
  }
  if ('MutationObserver' in window) {
    new MutationObserver(function (list) {
      for (var i = 0; i < list.length; i++) if (list[i].addedNodes.length) { scanMaps(document); break; }
    }).observe(document.documentElement, { childList: true, subtree: true });
  }

  // ── Text copied (e.g. phone numbers, khasra numbers) ──
  var lastCopy = 0;
  document.addEventListener('copy', function () {
    if (Date.now() - lastCopy < 10000) return; lastCopy = Date.now();
    var sel = window.getSelection ? String(window.getSelection()) : '';
    var node = window.getSelection && window.getSelection().anchorNode;
    send('text_copy', { text_length: sel.length, link_location: where(node && node.parentElement) });
  });

  // ── Forms: fire on confirmed success (fetch / XHR) or on normal POST submit ──
  var FORMS = [
    [/\/inquiry-submit\/?$/,           'generate_lead',   { lead_method: 'form', form_name: 'inquiry' }],
    [/\/properties\/[^\/]+\/inquiry\/?$/, 'generate_lead', { lead_method: 'form', form_name: 'property_inquiry' }],
    [/\/subscribe\/?$/,                'sign_up',         { method: 'newsletter' }],
    [/\/blog\/[^\/]+\/comment\/?$/,    'comment_submit',  {}],
    [/\/blog-feedback\/?$/,            'feedback_submit', {}],
    [/\/generate-rent-receipt\/?$/,    'tool_use',        { tool_name: 'rent_receipt' }]
  ];
  function formRule(url) {
    try {
      var p = new URL(url, location.href);
      if (p.hostname.replace(/^www\./, '') !== HOST) return null;
      for (var i = 0; i < FORMS.length; i++) if (FORMS[i][0].test(p.pathname)) return FORMS[i];
    } catch (e) {}
    return null;
  }
  function fireForm(rule, how) {
    var p = { submit_type: how, link_location: 'form' };
    for (var k in rule[2]) p[k] = rule[2][k];
    send(rule[1], p);
  }
  if (window.fetch) {
    var _fetch = window.fetch;
    window.fetch = function (input, init) {
      var url = typeof input === 'string' ? input : (input && input.url) || '';
      var method = ((init && init.method) || (input && input.method) || 'GET').toUpperCase();
      var pr = _fetch.apply(this, arguments);
      var rule = method === 'POST' ? formRule(url) : null;
      if (rule) {
        pr.then(function (res) {
          if (!res || !res.ok) return;
          res.clone().json().then(function (d) { if (!d || d.success !== false) fireForm(rule, 'ajax'); })
            .catch(function () { fireForm(rule, 'ajax'); });
        }).catch(function () {});
      }
      return pr;
    };
  }
  if (window.XMLHttpRequest) {
    var _open = XMLHttpRequest.prototype.open, _send = XMLHttpRequest.prototype.send;
    XMLHttpRequest.prototype.open = function (m, url) { this.__dsdRule = String(m).toUpperCase() === 'POST' ? formRule(url) : null; return _open.apply(this, arguments); };
    XMLHttpRequest.prototype.send = function () {
      var x = this;
      if (x.__dsdRule) x.addEventListener('load', function () {
        if (x.status >= 200 && x.status < 300) {
          try { var d = JSON.parse(x.responseText); if (d && d.success === false) return; } catch (e) {}
          fireForm(x.__dsdRule, 'ajax');
        }
      });
      return _send.apply(this, arguments);
    };
  }
  document.addEventListener('submit', function (e) {
    var f = e.target;
    if (!f || (f.method || '').toUpperCase() !== 'POST') return;
    var rule = formRule(f.action || location.href);
    if (!rule) return;
    setTimeout(function () { if (!e.defaultPrevented) fireForm(rule, 'page'); }, 0);
  }, true);

  // ── JavaScript errors (max 3 per page) ──
  var errs = 0;
  window.addEventListener('error', function (ev) {
    if (errs >= 3 || !ev || !ev.message) return; errs++;
    send('exception', { description: cut(ev.message + (ev.lineno ? ' @' + ev.lineno : ''), 100), fatal: false });
  });

  // ── 404 pages ──
  if (C.page_type === 'not_found') {
    send('page_not_found', { page_path: cut(location.pathname, 100), page_referrer: cut(document.referrer, 100) });
  }
})();
</script>
