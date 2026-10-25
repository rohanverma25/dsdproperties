{{--
    resources/views/news/show.blade.php
    URL: /news/{slug}
    FIXED: All arbitrary Tailwind [#hex] classes replaced with inline styles.
    Works on shared hosting with pre-compiled Tailwind CSS.
--}}

@extends('layouts.app-article')

@section('seo')
    <title>{{ $article->title }} | DSD Properties Lucknow</title>
    <meta name="description" content="{{ $article->meta_description }}">
    <link rel="canonical"    href="{{ $article->url }}">
    <meta name="robots"      content="index, follow">

    <meta property="og:type"                   content="article">
    <meta property="og:title"                  content="{{ $article->title }}">
    <meta property="og:description"            content="{{ $article->meta_description }}">
    <meta property="og:url"                    content="{{ $article->url }}">
    <meta property="og:site_name"              content="DSD Properties">
    <meta property="og:image"                  content="{{ asset('images/og-news.png') }}">
    <meta property="article:published_time"    content="{{ $article->created_at->toIso8601String() }}">
    <meta property="article:section"           content="{{ $article->category_label }}">
    <meta name="twitter:card"                  content="summary_large_image">
    <meta name="twitter:title"                 content="{{ $article->title }}">
    <meta name="twitter:description"           content="{{ $article->meta_description }}">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": "{{ addslashes($article->title) }}",
        "description": "{{ addslashes($article->meta_description) }}",
        "url": "{{ $article->url }}",
        "datePublished": "{{ $article->created_at->toIso8601String() }}",
        "dateModified":  "{{ $article->updated_at->toIso8601String() }}",
        "articleSection": "{{ $article->category_label }}",
        "publisher": {
            "@type": "Organization",
            "name": "DSD Properties",
            "url":  "{{ url('/') }}",
            "logo": { "@type": "ImageObject", "url": "{{ asset('images/logo.webp') }}" }
        },
        "mainEntityOfPage": { "@type": "WebPage", "@id": "{{ $article->url }}" }
        @if($article->source_url)
        ,"isBasedOn": {
            "@type": "NewsArticle",
            "url": "{{ $article->source_url }}",
            "publisher": { "@type": "Organization", "name": "{{ $article->source_name }}" }
        }
        @endif
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
            { "@type": "ListItem", "position": 2, "name": "News", "item": "{{ route('news.index') }}" },
            { "@type": "ListItem", "position": 3, "name": "{{ addslashes(Str::limit($article->title, 60)) }}", "item": "{{ $article->url }}" }
        ]
    }
    </script>

    <style>
        /* ── Category tag colours ─────────────────────────── */
        .tag-lda      { background:#f0fdf4; color:#16a34a; border-color:#bbf7d0; }
        .tag-it-city  { background:#eff6ff; color:#2563eb; border-color:#bfdbfe; }
        .tag-price    { background:#fff7ed; color:#ea580c; border-color:#fed7aa; }
        .tag-projects { background:#faf5ff; color:#7c3aed; border-color:#e9d5ff; }
        .tag-policy   { background:#fef2f2; color:#dc2626; border-color:#fecaca; }
        .tag-rera     { background:#f0fdfa; color:#0d9488; border-color:#99f6e4; }
        .tag-default  { background:#f9fafb; color:#6b7280; border-color:#e5e7eb; }

        /* ── Article body typography ──────────────────────── */
        .article-body p      { margin-bottom: 1.25rem; line-height: 1.8; color: #374151; font-size: .95rem; }
        .article-body h2     { font-size: 1.25rem; font-weight: 700; color: #111827; margin: 2rem 0 .75rem; }
        .article-body h3     { font-size: 1.05rem; font-weight: 700; color: #111827; margin: 1.5rem 0 .5rem; }
        .article-body ul     { list-style: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .article-body ol     { list-style: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
        .article-body li     { margin-bottom: .4rem; color: #374151; font-size: .95rem; }
        .article-body a      { color: #1d4ed8; text-decoration: underline; }
        .article-body strong { color: #111827; font-weight: 600; }
        .article-body table  { width:100%; border-collapse:collapse; margin-bottom:1.25rem; font-size:.88rem; }
        .article-body th,
        .article-body td     { border:1px solid #e5e7eb; padding:.55rem .75rem; text-align:left; }
        .article-body th     { background:#f9fafb; font-weight:600; color:#111827; }

        /* ── AI chat typing dots ──────────────────────────── */
        @keyframes chatBounce {
            0%, 80%, 100% { transform: translateY(0); }
            40%            { transform: translateY(-6px); }
        }
        .dot-bounce { display:inline-block; width:7px; height:7px; border-radius:50%;
                      background:#9ca3af; animation: chatBounce 1.2s infinite; }
        .dot-bounce:nth-child(2) { animation-delay:.15s; }
        .dot-bounce:nth-child(3) { animation-delay:.30s; }

        /* ── Sticky bottom bar ────────────────────────────── */
        #sticky-bottom-bar {
            position:fixed; bottom:0; left:0; right:0; z-index:999;
            background:rgba(255,255,255,.97); backdrop-filter:blur(10px);
            border-top:1px solid #e5e7eb; box-shadow:0 -4px 20px rgba(0,0,0,.08);
            padding:12px 20px; display:flex; align-items:center;
            justify-content:space-between; gap:12px;
        }

        /* ── AI chat panel ────────────────────────────────── */
        #ai-chat-panel {
            position:fixed; bottom:0; right:0; left:0;
            z-index:9999; display:none; flex-direction:column;
            background:#fff; border-radius:20px 20px 0 0;
            box-shadow:0 -8px 40px rgba(0,0,0,.18);
            max-height:85vh;
        }
        @media (min-width:768px) {
            #ai-chat-panel {
                left:auto; right:16px; bottom:16px;
                width:380px; border-radius:20px;
            }
        }

        /* ── Related article hover ────────────────────────── */
        .related-link { display:block; text-decoration:none; padding:12px 0;
                        border-bottom:1px solid #f3f4f6; }
        .related-link:last-child { border-bottom:none; }
        .related-link:hover .related-title { color:#0f1f5c; }
        .related-title { font-size:.85rem; font-weight:600; color:#111827;
                         line-height:1.4; transition:color .2s; }

        /* page bottom padding behind sticky bar */
        .show-page { padding-bottom: 80px; }
            .sticky-sidebar {
            position: sticky;
            z-index: 40;
        }
    </style>
@endsection

@section('content')

{{-- ══ BREADCRUMB ══════════════════════════════════════ --}}
<div style="background:#f9fafb; border-bottom:1px solid #e5e7eb;">
    <div style="max-width:900px; margin:0 auto; padding:10px 16px;">
        <nav style="font-size:.75rem; color:#6b7280; display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
            <a href="{{ url('/') }}"
               style="color:#6b7280; text-decoration:none;"
               onmouseover="this.style.color='#0f1f5c'"
               onmouseout="this.style.color='#6b7280'">Home</a>
            <span>›</span>
            <a href="{{ route('news.index') }}"
               style="color:#6b7280; text-decoration:none;"
               onmouseover="this.style.color='#0f1f5c'"
               onmouseout="this.style.color='#6b7280'">News</a>
            <span>›</span>
            <a href="{{ route('news.index', ['category' => $article->category]) }}"
               style="color:#6b7280; text-decoration:none;"
               onmouseover="this.style.color='#0f1f5c'"
               onmouseout="this.style.color='#6b7280'">{{ $article->category_label }}</a>
            <span>›</span>
            <span style="color:#374151; font-weight:500;">{{ Str::limit($article->title, 50) }}</span>
        </nav>
    </div>
</div>

{{-- ══ ARTICLE + SIDEBAR ═══════════════════════════════ --}}
<div class="show-page" style="max-width:1080px; margin:0 auto; padding:32px 16px;">
    <div style="display:grid; grid-template-columns:1fr; gap:32px;">

        {{-- On large screens: 2-col layout --}}
        <style>
            @media(min-width:1024px){
                .show-grid { grid-template-columns: 1fr 300px !important; }
            }
        </style>

        <div class="show-grid" style="display:grid; grid-template-columns:1fr; gap:32px;">

            {{-- ── MAIN ARTICLE ────────────────────────── --}}
            <article>

                {{-- Meta row: category tag + date + source --}}
                <div style="display:flex; flex-wrap:wrap; align-items:center; gap:8px; margin-bottom:16px;">

                    @php
                        $tagMap = [
                            'lda'      => 'tag-lda',
                            'it-city'  => 'tag-it-city',
                            'price'    => 'tag-price',
                            'projects' => 'tag-projects',
                            'policy'   => 'tag-policy',
                            'rera'     => 'tag-rera',
                        ];
                        $tagCls = $tagMap[$article->category] ?? 'tag-default';
                    @endphp

                    <span class="{{ $tagCls }}"
                          style="font-size:.7rem; font-weight:700; padding:3px 12px;
                                 border-radius:999px; border-width:1px; border-style:solid;">
                        {{ $article->category_label }}
                    </span>

                    @if($article->is_hot)
                        <span style="font-size:.68rem; font-weight:700; background:#fff5f5; color:#ef4444;
                                     border:1px solid #fecaca; padding:3px 10px; border-radius:999px;">
                            🔥 HOT
                        </span>
                    @endif

                    <span style="font-size:.75rem; color:#9ca3af;">
                        {{ $article->created_at->format('M j, Y') }}
                    </span>

                    @if($article->source_name)
                        <span style="font-size:.75rem; color:#9ca3af;">
                            · Source: {{ $article->source_name }}
                        </span>
                    @endif
                </div>

                {{-- H1 --}}
                <h1 style="font-size:clamp(1.4rem,3.5vw,2rem); font-weight:800; color:#111827;
                            line-height:1.3; margin-bottom:20px;">
                    {{ $article->title }}
                </h1>

                {{-- Quick Summary box --}}
                <div style="background:#eff6ff; border-left:4px solid #0f1f5c; border-radius:0 12px 12px 0;
                             padding:16px 20px; margin-bottom:28px;">
                    <p style="font-size:.75rem; font-weight:700; color:#0f1f5c;
                               text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px;">
                        Quick Summary
                    </p>
                    <p style="font-size:.9rem; color:#1e40af; line-height:1.7; margin:0;">
                        {{ $article->summary }}
                    </p>
                </div>

                {{-- Full article body --}}
                <div class="article-body">
                     {!! $article->full_content !!}
                </div>

                {{-- Source attribution --}}
                @if($article->source_url)
                    <div style="margin-top:28px; padding-top:16px; border-top:1px solid #e5e7eb;">
                        <p style="font-size:.75rem; color:#9ca3af;">
                            Source:
                            <a href="{{ $article->source_url }}" target="_blank" rel="noopener noreferrer"
                               style="color:#2563eb; text-decoration:underline;">
                                {{ $article->source_name ?? $article->source_url }}
                            </a>
                            &nbsp;— Rewritten for Lucknow property buyers by DSD Properties AI.
                        </p>
                    </div>
                @endif

                <!-- {{-- ── ACTION BUTTONS ──────────────────── --}}
                <div id="ask-ai" style="margin-top:28px; display:flex; flex-wrap:wrap; gap:10px;">

                    {{-- Ask AI --}}
                    <button onclick="openAiChat()"
                            style="display:inline-flex; align-items:center; gap:8px;
                                   background:#0f1f5c; color:#fff; font-size:.85rem; font-weight:700;
                                   padding:10px 22px; border-radius:999px; border:none; cursor:pointer;
                                   box-shadow:0 3px 12px rgba(15,31,92,.3); transition:background .2s;"
                            onmouseover="this.style.background='#1a3a8f'"
                            onmouseout="this.style.background='#0f1f5c'">
                        ✦ Ask AI About This
                    </button>

                    {{-- Contact Us --}}
                    <a href="/contact-us"
                    style="display:inline-flex; align-items:center; gap:8px;
                            background:#011f4b; color:#fff; font-size:.85rem; font-weight:700;
                            padding:10px 20px; border-radius:999px; text-decoration:none;
                            transition:background .2s;"
                    onmouseover="this.style.background='#022d6e'"
                    onmouseout="this.style.background='#011f4b'">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        Contact Us
                    </a>

                </div> -->
            </article>

            {{-- ── SIDEBAR ──────────────────────────────── --}}
            <aside>
                <div class="sticky-sidebar">
                    @include('components.inquiry-form')
                </div>
                {{-- Related Articles --}}
                @if($related->count() > 0)
                    <div style="margin-top:20px; background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:20px;">
                        <h4 style="font-size:.85rem; font-weight:700; color:#111827; margin-bottom:16px;">
                            Related Articles
                        </h4>
                        @foreach($related as $item)
                            @php $rc = $tagMap[$item->category] ?? 'tag-default'; @endphp
                            <a href="{{ route('news.show', $item->slug) }}" class="related-link">
                                <div style="display:flex; align-items:center; gap:6px; margin-bottom:5px; flex-wrap:wrap;">
                                    <span class="{{ $rc }}"
                                          style="font-size:.62rem; font-weight:700; padding:2px 8px;
                                                 border-radius:999px; border-width:1px; border-style:solid;">
                                        {{ $item->category_label }}
                                    </span>
                                    <span style="font-size:.7rem; color:#9ca3af;">
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="related-title">{{ Str::limit($item->title, 75) }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif

            </aside>

        </div>
    </div>
</div>

{{-- ══ STICKY BOTTOM BAR ═══════════════════════════════ --}}
<div id="sticky-bottom-bar">
    <div style="display:flex; align-items:center; gap:6px; font-size:.85rem; font-weight:500; color:#6b7280;">
        <span style="color:#ef4444; font-size:1rem;">📍</span>
        Lucknow, UP
    </div>
    <button onclick="ValuationComponent.open()" class="cta-btn" fdprocessedid="442qg">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                    Check Your Property Price →
                </button>
    <!-- <a href="{{ url('/') }}"
       style="background:#0f1f5c; color:#fff; font-size:.8rem; font-weight:700;
              padding:10px 22px; border-radius:999px; text-decoration:none; white-space:nowrap;
              box-shadow:0 3px 12px rgba(15,31,92,.35); transition:background .2s;"
       onmouseover="this.style.background='#1a3a8f'"
       onmouseout="this.style.background='#0f1f5c'">
        Get Free Valuation →
    </a> -->
</div>

{{-- ══ AI CHAT BACKDROP ════════════════════════════════ --}}
<div id="ai-backdrop"
     onclick="closeAiChat()"
     style="display:none; position:fixed; inset:0;
            background:rgba(0,0,0,.5); z-index:9998;">
</div>

{{-- ══ AI CHAT PANEL ═══════════════════════════════════ --}}
<div id="ai-chat-panel">

    {{-- Header --}}
    <div style="background:#0f1f5c; color:#fff; padding:16px 20px;
                border-radius:20px 20px 0 0; display:flex;
                align-items:center; justify-content:space-between; flex-shrink:0;">
        <div>
            <p style="font-size:.9rem; font-weight:700; margin:0;">✦ Ask AI About This Article</p>
            <p style="font-size:.72rem; color:#93c5fd; margin:3px 0 0;">Powered by Claude · Context-aware</p>
        </div>
        <button onclick="closeAiChat()"
                style="background:none; border:none; cursor:pointer; color:#93c5fd;
                       font-size:1.2rem; line-height:1; padding:4px 6px;"
                onmouseover="this.style.color='#fff'"
                onmouseout="this.style.color='#93c5fd'">✕</button>
    </div>

    {{-- Context chip --}}
    <div style="background:#eff6ff; border-bottom:1px solid #dbeafe;
                padding:10px 18px; flex-shrink:0;">
        <p style="font-size:.75rem; color:#1d4ed8; font-weight:500; margin:0;
                  white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
            📰 {{ Str::limit($article->title, 55) }}
        </p>
    </div>

    {{-- Messages --}}
    <div id="chat-messages"
         style="flex:1; overflow-y:auto; padding:16px; display:flex;
                flex-direction:column; gap:12px;">
        {{-- Welcome message --}}
        <div style="display:flex; gap:8px; align-items:flex-start;">
            <div style="width:28px; height:28px; background:#0f1f5c; border-radius:50%;
                        display:flex; align-items:center; justify-content:center;
                        color:#fff; font-size:.7rem; flex-shrink:0;">✦</div>
            <div style="background:#f3f4f6; border-radius:16px 16px 16px 4px;
                        padding:12px 16px; max-width:280px;">
                <p style="font-size:.85rem; color:#374151; line-height:1.6; margin:0;">
                    Hi! I've read this article. Ask me anything about it —
                    how it affects your property, which localities are impacted, or what you should do next.
                </p>
            </div>
        </div>
    </div>

    {{-- Suggested questions --}}
    <div id="suggested-questions"
         style="padding:0 16px 10px; display:flex; gap:6px; flex-wrap:wrap; flex-shrink:0;">
        <button onclick="sendSuggested(this)"
                style="font-size:.72rem; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;
                       padding:6px 12px; border-radius:999px; cursor:pointer; transition:background .2s;"
                onmouseover="this.style.background='#dbeafe'"
                onmouseout="this.style.background='#eff6ff'">
            How does this affect buyers?
        </button>
        <button onclick="sendSuggested(this)"
                style="font-size:.72rem; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;
                       padding:6px 12px; border-radius:999px; cursor:pointer; transition:background .2s;"
                onmouseover="this.style.background='#dbeafe'"
                onmouseout="this.style.background='#eff6ff'">
            Which localities are affected?
        </button>
        <button onclick="sendSuggested(this)"
                style="font-size:.72rem; background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe;
                       padding:6px 12px; border-radius:999px; cursor:pointer; transition:background .2s;"
                onmouseover="this.style.background='#dbeafe'"
                onmouseout="this.style.background='#eff6ff'">
            Should I invest now?
        </button>
    </div>

    {{-- Input box --}}
    <div style="padding:12px 16px; border-top:1px solid #e5e7eb;
                display:flex; gap:8px; align-items:center; flex-shrink:0;">
        <input id="chat-input"
               type="text"
               placeholder="Ask about this news..."
               onkeydown="if(event.key==='Enter') sendMessage()"
               style="flex:1; border:1.5px solid #d1d5db; border-radius:999px;
                      padding:9px 16px; font-size:.85rem; outline:none; transition:border-color .2s;"
               onfocus="this.style.borderColor='#0f1f5c'"
               onblur="this.style.borderColor='#d1d5db'">
        <button id="send-btn"
                onclick="sendMessage()"
                style="width:36px; height:36px; background:#0f1f5c; color:#fff;
                       border:none; border-radius:50%; cursor:pointer; display:flex;
                       align-items:center; justify-content:center; flex-shrink:0;
                       transition:background .2s;"
                onmouseover="this.style.background='#1a3a8f'"
                onmouseout="this.style.background='#0f1f5c'">
            <svg width="15" height="15" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
        </button>
    </div>

    {{-- Turn counter --}}
    <p id="turn-counter"
       style="text-align:center; font-size:.7rem; color:#9ca3af;
              padding:0 16px 10px; flex-shrink:0; margin:0;"></p>

</div>

{{-- ══ JAVASCRIPT ══════════════════════════════════════ --}}
@push('scripts')
<script>
    const ARTICLE_ID  = {{ $article->id }};
    const MAX_TURNS   = 10;
    let   chatHistory = [];

    // ── Open / Close ──────────────────────────────────
    function openAiChat() {
        document.getElementById('ai-backdrop').style.display  = 'block';
        document.getElementById('ai-chat-panel').style.display = 'flex';
        document.getElementById('chat-input').focus();
    }
    function closeAiChat() {
        document.getElementById('ai-backdrop').style.display  = 'none';
        document.getElementById('ai-chat-panel').style.display = 'none';
    }

    // Auto-open if URL ends with #ask-ai
    if (window.location.hash === '#ask-ai') {
        openAiChat();
    }

    // ── Suggested question ────────────────────────────
    function sendSuggested(btn) {
        document.getElementById('chat-input').value = btn.textContent.trim();
        document.getElementById('suggested-questions').style.display = 'none';
        sendMessage();
    }

    // ── Send message ──────────────────────────────────
    async function sendMessage() {
        const input   = document.getElementById('chat-input');
        const userMsg = input.value.trim();
        if (!userMsg) return;

        if (chatHistory.length >= MAX_TURNS * 2) {
            appendMessage('assistant', 'We\'ve reached the chat limit. Please refresh to start a new conversation.');
            return;
        }

        appendMessage('user', userMsg);
        chatHistory.push({ role: 'user', content: userMsg });
        input.value = '';

        const typingId = appendTyping();
        setLoading(true);

        try {
            const res  = await fetch('{{ route("news.ask-ai") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ article_id: ARTICLE_ID, messages: chatHistory })
            });
            const data = await res.json();
            removeTyping(typingId);

            if (data.error) {
                appendMessage('assistant', data.error);
            } else {
                appendMessage('assistant', data.reply);
                chatHistory.push({ role: 'assistant', content: data.reply });
            }
        } catch (e) {
            removeTyping(typingId);
            appendMessage('assistant', 'Something went wrong. Please try again.');
        }

        setLoading(false);
        updateTurnCounter();
    }

    // ── UI helpers ────────────────────────────────────
    function appendMessage(role, text) {
        const container = document.getElementById('chat-messages');
        const wrap      = document.createElement('div');
        wrap.style.cssText = 'display:flex; gap:8px; align-items:flex-start;'
            + (role === 'user' ? 'flex-direction:row-reverse;' : '');

        if (role === 'assistant') {
            wrap.innerHTML =
                '<div style="width:28px;height:28px;background:#0f1f5c;border-radius:50%;'
                + 'display:flex;align-items:center;justify-content:center;color:#fff;'
                + 'font-size:.7rem;flex-shrink:0;">✦</div>'
                + '<div style="background:#f3f4f6;border-radius:16px 16px 16px 4px;'
                + 'padding:12px 16px;max-width:280px;font-size:.85rem;color:#374151;'
                + 'line-height:1.6;">' + escapeHtml(text) + '</div>';
        } else {
            wrap.innerHTML =
                '<div style="background:#0f1f5c;color:#fff;border-radius:16px 16px 4px 16px;'
                + 'padding:12px 16px;max-width:280px;font-size:.85rem;line-height:1.6;">'
                + escapeHtml(text) + '</div>';
        }

        container.appendChild(wrap);
        container.scrollTop = container.scrollHeight;
    }

    function appendTyping() {
        const container = document.getElementById('chat-messages');
        const id  = 'typing-' + Date.now();
        const div = document.createElement('div');
        div.id = id;
        div.style.cssText = 'display:flex; gap:8px; align-items:flex-start;';
        div.innerHTML =
            '<div style="width:28px;height:28px;background:#0f1f5c;border-radius:50%;'
            + 'display:flex;align-items:center;justify-content:center;color:#fff;'
            + 'font-size:.7rem;flex-shrink:0;">✦</div>'
            + '<div style="background:#f3f4f6;border-radius:16px 16px 16px 4px;padding:12px 16px;">'
            + '<span class="dot-bounce"></span>'
            + '<span class="dot-bounce" style="margin:0 3px;"></span>'
            + '<span class="dot-bounce"></span>'
            + '</div>';
        container.appendChild(div);
        container.scrollTop = container.scrollHeight;
        return id;
    }

    function removeTyping(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    function setLoading(on) {
        const btn   = document.getElementById('send-btn');
        const input = document.getElementById('chat-input');
        btn.disabled   = on;
        input.disabled = on;
        btn.style.opacity = on ? '0.4' : '1';
    }

    function updateTurnCounter() {
        const turns   = Math.floor(chatHistory.length / 2);
        const counter = document.getElementById('turn-counter');
        if (turns > 6) {
            counter.textContent = (MAX_TURNS - turns) + ' questions remaining';
        }
    }

    function escapeHtml(t) {
        return t.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\n/g,'<br>');
    }
    const stickySidebar = document.querySelector('.sticky-sidebar');
    if (stickySidebar) {
        const header = document.querySelector('.sticky-header');
        const headerHeight = header ? header.offsetHeight : 0;
        stickySidebar.style.top = (headerHeight + 85) + 'px';
        window.addEventListener('resize', function() {
            const newHeaderHeight = header ? header.offsetHeight : 0;
            stickySidebar.style.top = (newHeaderHeight + 85) + 'px';
        });
    } 
</script>
@endpush

@endsection