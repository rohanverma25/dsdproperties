@extends('layouts.user-app')

{{--
    Author + editorial policy page (/author/dheer-singh), 18 Nov 2026; redesigned the same day (hero, policy cards,
    searchable article list with topic chips, news cards, one verification CTA). Every blog post and news story links
    here as the byline (blogs/show, news/show). Facts about the author come only from config/author.php. The policy
    list describes how the site already works; change it only if the process changes.
    Data: $posts, $news, $newsCount from the route in routes/web.php. CSS is scoped to #au.
--}}
@php
    $a = config('author');
    $pageUrl = url('/author/' . $a['slug']);
    // Blog "tag" values grouped into a few reader-facing topics (tags not listed fall under "More guides")
    $topicOf = function ($tag) {
        $t = strtolower(trim((string) $tag));
        if (in_array($t, ['lda scheme guide', 'lda schemes', 'awas vikas'])) return 'schemes';
        if (in_array($t, ['legal advice', 'legal guide', 'property law'])) return 'legal';
        if (in_array($t, ['selling tips', 'seller guide'])) return 'selling';
        if (in_array($t, ['buying tips', 'property verification'])) return 'buying';
        return 'more';
    };
    $topics = ['schemes' => 'LDA & Awas Vikas schemes', 'buying' => 'Buying', 'legal' => 'Legal & documents', 'selling' => 'Selling', 'more' => 'Locality & more'];
    $topicCounts = $posts->groupBy(fn ($p) => $topicOf($p->tag))->map->count();
    $title = fn ($s) => html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $policy = [
        ['📄', 'Official sources first', 'Facts come from LDA, Awas Vikas (UPAVP), UP RERA and IGRSUP orders, notices, board minutes, layout plans and lottery lists. Newspaper reports are used only for statements made by officials, and we name the paper.'],
        ['🚫', 'Nothing invented', 'We do not publish rumours, price predictions or figures we cannot trace to a source. If two sources disagree, we say so, or we use the official document.'],
        ['⏳', 'Proposed is not final', 'A rate, date or plan that is not yet approved is marked "proposed", "expected" or "not confirmed".'],
        ['📅', 'Dated facts', 'Each article shows when it was last updated, and time-sensitive facts carry their own date. We revisit guides when an authority publishes something new.'],
        ['🔗', 'Links, not copies', "For lottery results and official PDFs we link to the authority's own file; we don't host or change them."],
        ['🤖', 'How articles are written', 'Articles are researched and drafted with the help of AI tools; ' . $a['name'] . ' checks every fact against the official source before publishing.'],
        ['✏️', 'Corrections', 'Found a mistake? Tell us through the contact page. We check it against the source and fix the article.'],
        ['🏢', 'Independent', 'DSD Properties is a private firm, not connected with LDA, UPAVP or any government body.'],
    ];
@endphp

@section('title', $a['name'] . ': Author, DSD Properties Lucknow | How We Research')
@section('meta_description', $a['name'] . ' writes the LDA, Awas Vikas and UP RERA guides and news on DSD Properties from official orders, notices, layout plans and lottery lists. Read how we research, check and correct our articles.')
@section('canonical', $pageUrl)

@push('head')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'ProfilePage',
            'url' => $pageUrl,
            'name' => $a['name'] . ', DSD Properties',
            'dateModified' => optional($posts->max('updated_at'))->toIso8601String(),
            'mainEntity' => ['@id' => $pageUrl . '#person'],
        ],
        [
            '@type' => 'Person',
            '@id' => $pageUrl . '#person',
            'name' => $a['name'],
            'url' => $pageUrl,
            'jobTitle' => $a['job_title'],
            'description' => $a['bio'],
            'alumniOf' => ['@type' => 'CollegeOrUniversity', 'name' => $a['alumni_of']],
            'knowsAbout' => $a['knows_about'],
            'sameAs' => $a['same_as'],
            'worksFor' => ['@type' => 'Organization', 'name' => 'DSD Properties', 'url' => url('/')],
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Lucknow', 'addressRegion' => 'Uttar Pradesh', 'addressCountry' => 'IN'],
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'About', 'item' => url('/about')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $a['name'], 'item' => $pageUrl],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<style>
#au{--navy:#011f4b;--teal:#008080;--orange:#f97316;--line:#e2e8f0;--muted:#64748b;color:#334155;font-family:'Poppins',sans-serif;overflow-x:hidden}
#au *{box-sizing:border-box}
#au a{color:inherit}
#au .au-wrap{max-width:1040px;margin:0 auto;padding:0 16px}
/* hero */
#au .au-hero{background:linear-gradient(135deg,#011f4b 0%,#023e6b 60%,#006d6d 100%);color:#fff;padding:22px 0 34px}
#au .au-crumb{font-size:.78rem;color:rgba(255,255,255,.7);margin:0 0 22px}
#au .au-crumb a{color:rgba(255,255,255,.85);text-decoration:none}
#au .au-crumb a:hover{color:#fff}
#au .au-top{display:flex;gap:22px;align-items:center}
#au .au-ava{flex:none;width:88px;height:88px;border-radius:50%;background:#fff;color:var(--navy);display:flex;align-items:center;justify-content:center;font-size:2.2rem;font-weight:800;box-shadow:0 0 0 4px rgba(255,255,255,.18)}
#au h1{font-size:clamp(1.7rem,4.5vw,2.4rem);font-weight:800;margin:0;line-height:1.15;color:#fff}
#au .au-role{margin:6px 0 0;font-size:.82rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:#7dd3c8}
#au .au-bio{max-width:760px;margin:18px 0 0;font-size:1rem;line-height:1.75;color:rgba(255,255,255,.9)}
#au .au-stats{display:flex;flex-wrap:wrap;gap:10px;margin:20px 0 0;padding:0;list-style:none}
#au .au-stats li{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);border-radius:999px;padding:7px 14px;font-size:.82rem;color:#fff}
#au .au-stats b{font-weight:700}
#au .au-actions{display:flex;flex-wrap:wrap;gap:10px;margin:22px 0 0}
#au .au-btn{display:inline-flex;align-items:center;gap:8px;border-radius:10px;padding:10px 16px;font-size:.88rem;font-weight:600;text-decoration:none;transition:transform .15s,background .15s}
#au .au-btn:hover{transform:translateY(-1px)}
#au .au-btn-light{background:#fff;color:var(--navy)}
#au .au-btn-ghost{border:1px solid rgba(255,255,255,.4);color:#fff}
#au .au-btn-ghost:hover{background:rgba(255,255,255,.1)}
/* sections */
#au section{padding:40px 0 0}
#au h2{font-size:1.35rem;font-weight:800;color:var(--navy);margin:0 0 6px}
#au .au-sub{margin:0 0 20px;color:var(--muted);font-size:.92rem}
#au .au-policy{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:14px;margin:0;padding:0;list-style:none}
#au .au-policy li{background:#fff;border:1px solid var(--line);border-radius:14px;padding:18px}
#au .au-policy .ic{font-size:1.35rem;line-height:1}
#au .au-policy h3{font-size:.98rem;font-weight:700;color:var(--navy);margin:10px 0 6px}
#au .au-policy p{margin:0;font-size:.86rem;line-height:1.65;color:#475569}
#au .au-policy .hl{border-color:#99d5d5;background:#f0fafa}
/* articles */
#au .au-tools{display:flex;flex-direction:column;gap:12px;margin:0 0 16px}
#au .au-search{width:100%;border:1px solid var(--line);border-radius:12px;padding:12px 14px;font:inherit;font-size:.95rem;background:#f8fafc;outline:none}
#au .au-search:focus{border-color:var(--teal);background:#fff;box-shadow:0 0 0 3px rgba(0,128,128,.12)}
#au .au-chips{display:flex;flex-wrap:wrap;gap:8px}
#au .au-chip{border:1px solid var(--line);background:#fff;border-radius:999px;padding:6px 13px;font:inherit;font-size:.82rem;font-weight:600;color:#475569;cursor:pointer}
#au .au-chip[aria-pressed="true"]{background:var(--navy);border-color:var(--navy);color:#fff}
#au .au-chip span{opacity:.6;font-weight:500}
#au .au-list{list-style:none;margin:0;padding:0;display:grid;grid-template-columns:1fr 1fr;gap:10px}
#au .au-list a{display:flex;flex-direction:column;gap:6px;height:100%;padding:14px 16px;border:1px solid var(--line);border-radius:12px;background:#fff;text-decoration:none;transition:border-color .15s,box-shadow .15s}
#au .au-list a:hover{border-color:var(--teal);box-shadow:0 6px 18px rgba(1,31,75,.07)}
#au .au-list .t{color:var(--navy);font-weight:600;font-size:.93rem;line-height:1.45}
#au .au-list .m{display:flex;gap:8px;align-items:center;font-size:.76rem;color:#94a3b8}
#au .au-list .tag{color:var(--teal);font-weight:600}
#au .au-more{display:block;margin:16px auto 0;border:1px solid var(--navy);background:#fff;color:var(--navy);border-radius:10px;padding:10px 20px;font:inherit;font-size:.88rem;font-weight:600;cursor:pointer}
#au .au-more:hover{background:var(--navy);color:#fff}
#au .au-empty{padding:24px;text-align:center;color:var(--muted);border:1px dashed #cbd5e1;border-radius:12px}
#au [hidden]{display:none!important}
/* CTA */
#au .au-cta{margin:44px 0 56px;display:flex;gap:18px;align-items:center;justify-content:space-between;flex-wrap:wrap;background:#fff7ed;border:1px solid #fed7aa;border-radius:16px;padding:22px}
#au .au-cta h2{font-size:1.15rem;margin:0 0 4px}
#au .au-cta p{margin:0;color:#7c2d12;font-size:.9rem;line-height:1.6}
#au .au-btn-orange{background:var(--orange);color:#fff}
@media(max-width:720px){
  #au .au-list{grid-template-columns:1fr}
}
@media(max-width:560px){
  #au .au-top{flex-direction:column;align-items:flex-start;gap:14px}
  #au .au-ava{width:68px;height:68px;font-size:1.7rem}
  #au .au-bio{font-size:.95rem}
  #au .au-btn{flex:1 1 auto;justify-content:center}
  #au .au-policy{grid-template-columns:1fr 1fr;gap:10px}
  #au .au-policy li{padding:14px 12px}
  #au .au-policy h3{font-size:.9rem;margin:8px 0 4px}
  #au .au-policy p{font-size:.78rem;line-height:1.55}
}
@media(prefers-reduced-motion:reduce){#au *{transition:none!important}}
</style>
@endpush

@section('content')
<div id="au">
    {{-- ── Hero ── --}}
    <header class="au-hero">
        <div class="au-wrap">
            <nav class="au-crumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a> / <a href="{{ url('/about') }}">About</a> / <span>{{ $a['name'] }}</span>
            </nav>
            <div class="au-top">
                <div class="au-ava" aria-hidden="true">{{ mb_substr($a['name'], 0, 1) }}</div>
                <div>
                    <h1>{{ $a['name'] }}</h1>
                    <p class="au-role">{{ $a['job_title'] }} · Lucknow</p>
                </div>
            </div>
            <p class="au-bio">{{ $a['bio'] }}</p>
            <ul class="au-stats">
                <li><b>{{ $posts->count() }}</b> guides</li>
                <li><b>{{ $newsCount }}</b> news stories</li>
                <li>Studied at {{ $a['alumni_of'] }}</li>
            </ul>
            <div class="au-actions">
                <a class="au-btn au-btn-light" href="#articles">Read the guides ↓</a>
                @foreach($a['same_as'] as $link)
                    <a class="au-btn au-btn-ghost" href="{{ $link }}" target="_blank" rel="noopener me">LinkedIn profile ↗</a>
                @endforeach
            </div>
        </div>
    </header>

    <div class="au-wrap">
        {{-- ── Editorial policy ── --}}
        <section id="how-we-research" aria-labelledby="h-policy">
            <h2 id="h-policy">How we research and check our articles</h2>
            <p class="au-sub">The rules every guide and news story on this site follows.</p>
            <ul class="au-policy">
                @foreach($policy as $i => [$ic, $h, $p])
                    <li class="{{ $i === 0 ? 'hl' : '' }}">
                        <div class="ic" aria-hidden="true">{{ $ic }}</div>
                        <h3>{{ $h }}</h3>
                        <p>
                            @if($h === 'Corrections')
                                Found a mistake? Tell us through the <a href="{{ url('/contact-us') }}" style="color:var(--teal);font-weight:600;">contact page</a>. We check it against the source and fix the article.
                            @else
                                {{ $p }}
                            @endif
                        </p>
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- ── Articles ── --}}
        @if($posts->isNotEmpty())
        <section id="articles" aria-labelledby="h-articles">
            <h2 id="h-articles">Guides by {{ $a['name'] }}</h2>
            <p class="au-sub">Newest updates first. Search or pick a topic.</p>
            <div class="au-tools">
                <label for="au-q" class="sr-only" style="position:absolute;left:-9999px;">Search guides</label>
                <input id="au-q" class="au-search" type="search" autocomplete="off" placeholder="Search guides, e.g. Varun Vihar, stamp duty, mutation">
                <div class="au-chips" id="au-chips">
                    <button type="button" class="au-chip" data-t="" aria-pressed="true">All <span>{{ $posts->count() }}</span></button>
                    @foreach($topics as $k => $label)
                        @if(!empty($topicCounts[$k]))
                            <button type="button" class="au-chip" data-t="{{ $k }}" aria-pressed="false">{{ $label }} <span>{{ $topicCounts[$k] }}</span></button>
                        @endif
                    @endforeach
                </div>
            </div>
            <ul class="au-list" id="au-list">
                @foreach($posts as $p)
                    <li data-t="{{ $topicOf($p->tag) }}" data-q="{{ strtolower($title($p->title) . ' ' . $p->tag) }}">
                        <a href="{{ url('/blog/' . $p->slug) }}">
                            <span class="t">{{ $title($p->title) }}</span>
                            <span class="m">
                                @if($p->tag)<span class="tag">{{ $p->tag }}</span> ·@endif
                                <time datetime="{{ $p->updated_at->toDateString() }}">Updated {{ $p->updated_at->format('j M Y') }}</time>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <p class="au-empty" id="au-empty" hidden>No guide matches. Try another word.</p>
            <button type="button" class="au-more" id="au-more">Show all {{ $posts->count() }} guides</button>
        </section>
        @endif

        {{-- ── News ── --}}
        @if($news->isNotEmpty())
        <section id="news" aria-labelledby="h-news">
            <h2 id="h-news">Latest news</h2>
            <p class="au-sub">Short reports on LDA, Awas Vikas and RERA decisions, mostly in Hindi.</p>
            <ul class="au-list">
                @foreach($news->take(8) as $n)
                    <li>
                        <a href="{{ $n->url }}">
                            <span class="t">{{ $title($n->title) }}</span>
                            <span class="m">
                                <span class="tag">{{ $n->category_label }}</span> ·
                                <time datetime="{{ $n->created_at->toDateString() }}">{{ $n->created_at->format('j M Y') }}</time>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
            <a class="au-more" href="{{ url('/news') }}" style="text-align:center;text-decoration:none;width:max-content;">All {{ $newsCount }} news stories →</a>
        </section>
        @endif

        {{-- ── One CTA, for the service we sell ── --}}
        <aside class="au-cta">
            <div>
                <h2>Buying a plot or flat in Lucknow?</h2>
                <p>We check the property's documents against official records before you pay: ₹5,000 per property.</p>
            </div>
            <a class="au-btn au-btn-orange" href="{{ url('/services/property-verification-lucknow') }}">See property verification →</a>
        </aside>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    var list = document.getElementById('au-list'); if (!list) return;
    var items = [].slice.call(list.children), q = document.getElementById('au-q'), more = document.getElementById('au-more'),
        empty = document.getElementById('au-empty'), chips = document.getElementById('au-chips'), topic = '', words = [], all = false, LIMIT = 12;
    function apply() {
        var shown = 0, matched = 0, filtering = topic || words.length;
        items.forEach(function (li) {
            var ok = (!topic || li.dataset.t === topic) && words.every(function (w) { return li.dataset.q.indexOf(w) !== -1; });
            if (ok) matched++;
            var vis = ok && (all || filtering || matched <= LIMIT);
            li.hidden = !vis; if (vis) shown++;
        });
        empty.hidden = matched > 0;
        more.hidden = all || filtering || items.length <= LIMIT;
    }
    q.addEventListener('input', function () { words = q.value.trim().toLowerCase().split(/\s+/).filter(Boolean); apply(); });
    chips.addEventListener('click', function (e) {
        var b = e.target.closest('button'); if (!b) return;
        [].forEach.call(chips.querySelectorAll('button'), function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
        topic = b.dataset.t; apply();
    });
    more.addEventListener('click', function () { all = true; apply(); });
    apply();
})();
</script>
@endpush
