@extends('admin.layouts.app')
@section('page-title', 'Notifications')

@section('content')
<style>
    .push-grid { display:grid; gap:1.25rem; }
    @media (min-width:1024px) { .push-grid { grid-template-columns:repeat(3,minmax(0,1fr)); } .push-main { grid-column:span 2; } }
</style>
<div class="mx-auto max-w-6xl">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-brandNavy">Website notifications</h2>
        <p class="mt-0.5 text-sm text-slate-500">
            Send a browser notification about a news story or article. Links get
            <code>utm_source=onesignal</code> so GA4 shows the visits and leads it brings.
            Keep it to 1–2 a week, between 9 am and 8 pm.
        </p>
    </div>

    @foreach(['success' => 'alert-success', 'info' => 'alert-info', 'error' => 'alert-danger'] as $key => $class)
        @if(session($key))
            <div class="{{ $class }} mb-4">{{ session($key) }}</div>
        @endif
    @endforeach

    @if($errors->any())
        <div class="alert-danger mb-4">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
    @endif

    @unless($configured)
        <div class="alert-danger mb-4">
            OneSignal is not set up on this server. Add <code>ONESIGNAL_APP_ID</code> and
            <code>ONESIGNAL_REST_API_KEY</code> to <code>.env</code>, then reload.
        </div>
    @endunless

    <div class="push-grid">

        {{-- ── Send form ─────────────────────────────── --}}
        <form method="POST" action="{{ route('admin.push.send') }}" class="card-p push-main" id="push-form">
            @csrf

            <div class="mb-4">
                <label class="label" for="pick">Story or article</label>
                <select id="pick" class="input">
                    <option value="">— Pick one to fill the fields, or type your own —</option>
                    @foreach($content as $i => $c)
                        <option value="{{ $i }}">{{ \Illuminate\Support\Str::limit($c['label'], 95) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="label" for="title">Title <span class="font-normal text-slate-400">(max 80, aim for 50)</span></label>
                <input id="title" name="title" class="input" maxlength="80" required value="{{ old('title') }}">
            </div>

            <div class="mb-4">
                <label class="label" for="message">Message <span class="font-normal text-slate-400">(max 200, aim for 120)</span></label>
                <textarea id="message" name="message" class="input" rows="3" maxlength="200" required>{{ old('message') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="label" for="url">Link</label>
                <input id="url" name="url" type="url" class="input" required value="{{ old('url') }}" placeholder="https://dsdproperties.in/news/…">
                <p class="help">UTM tags are added when it is sent.</p>
            </div>

            <div class="mb-4">
                <label class="label" for="image">Large image <span class="font-normal text-slate-400">(optional, Chrome on desktop/Android)</span></label>
                <input id="image" name="image" type="url" class="input" value="{{ old('image') }}">
            </div>

            <div class="mb-4">
                <label class="label" for="audience">Send to</label>
                <select id="audience" name="audience" class="input" required>
                    <option value="test" @selected(old('audience', 'test') === 'test')>Test — one browser only</option>
                    @foreach($topics as $key => $t)
                        <option value="topic:{{ $key }}" @selected(old('audience') === 'topic:' . $key)>
                            Topic: {{ $t['label'] }}
                        </option>
                    @endforeach
                    <option value="all" @selected(old('audience') === 'all')>Everyone</option>
                </select>
            </div>

            <div class="mb-5" id="test-wrap">
                <label class="label" for="test_id">Test subscription ID</label>
                <input id="test_id" name="test_id" class="input" value="{{ old('test_id', optional($recentSubs->first())->subscription_id) }}"
                       placeholder="Pick from “Latest subscribers” on the right">
                <p class="help">
                    To test: open dsdproperties.in in Chrome, allow notifications, reload this page —
                    your browser appears at the top of “Latest subscribers”.
                </p>
            </div>

            <button type="submit" class="btn-primary" id="send-btn" @disabled(!$configured)>
                <i class="fa-solid fa-paper-plane"></i> Send notification
            </button>
        </form>

        {{-- ── Stats ─────────────────────────────────── --}}
        <div class="flex flex-col gap-6">
            <div class="card-p">
                <p class="text-sm font-semibold text-slate-700">Subscribers recorded</p>
                <p class="text-2xl font-bold text-brandNavy">{{ number_format($total) }}</p>
                <p class="help">OneSignal’s dashboard has the live count; this is what our site logged.</p>
                <div class="mt-3 flex flex-col gap-2">
                    @foreach($topics as $key => $t)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600">{{ $t['label'] }}</span>
                            <span class="badge-slate">{{ $topicCounts[$key] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-p">
                <p class="mb-2 text-sm font-semibold text-slate-700">Top pages they subscribed on</p>
                @forelse($bySource as $row)
                    <div class="flex items-center justify-between gap-2 text-sm">
                        <a href="{{ url($row->source_path ?? '/') }}" target="_blank" class="truncate text-slate-600">{{ $row->source_path }}</a>
                        <span class="badge-teal">{{ $row->c }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Nobody yet.</p>
                @endforelse
            </div>

            <div class="card-p">
                <p class="mb-2 text-sm font-semibold text-slate-700">Latest subscribers</p>
                @forelse($recentSubs as $s)
                    <div class="mb-2 text-sm">
                        <div class="flex items-center justify-between gap-2">
                            <span class="truncate text-slate-600">{{ $s->source_path }}</span>
                            <button type="button" class="btn-ghost btn-sm" style="white-space:nowrap" data-test-id="{{ $s->subscription_id }}">Use for test</button>
                        </div>
                        <p class="text-xs text-slate-400">{{ $s->created_at->diffForHumans() }} · {{ $s->topics ?: 'no topic' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Nobody yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ── History ───────────────────────────────────── --}}
    <div class="card-p mt-5">
        <p class="mb-3 text-sm font-semibold text-slate-700">Sent</p>
        @forelse($sends as $s)
            <div class="border-t border-slate-200 py-3 text-sm">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="{{ ['sent' => 'badge-green', 'no_recipients' => 'badge-amber'][$s->status] ?? 'badge-rose' }}">{{ $s->status }}</span>
                    <span class="badge-slate">{{ \Illuminate\Support\Str::limit($s->audience, 30) }}</span>
                    <span class="text-xs text-slate-400">{{ $s->created_at->format('j M Y, g:i a') }}</span>
                </div>
                <p class="mt-1 font-semibold text-slate-800">{{ $s->title }}</p>
                <p class="text-slate-600">{{ $s->message }}</p>
                @if($s->error)<p class="mt-1 text-xs text-rose-700">{{ \Illuminate\Support\Str::limit($s->error, 300) }}</p>@endif
            </div>
        @empty
            <p class="text-sm text-slate-500">Nothing sent yet.</p>
        @endforelse
    </div>
</div>

<script>
(function () {
    var content  = @json($content);
    var form     = document.getElementById('push-form');
    var audience = document.getElementById('audience');
    var testWrap = document.getElementById('test-wrap');
    var testId   = document.getElementById('test_id');

    function syncTest() { testWrap.style.display = audience.value === 'test' ? '' : 'none'; }
    audience.addEventListener('change', syncTest);
    syncTest();

    document.getElementById('pick').addEventListener('change', function () {
        var c = content[this.value];
        if (!c) return;
        ['title', 'message', 'url', 'image'].forEach(function (k) { document.getElementById(k).value = c[k] || ''; });
        // Keep "test" selected; otherwise switch to the story's topic.
        if (audience.value !== 'test' && c.topic) audience.value = 'topic:' + c.topic;
    });

    document.querySelectorAll('[data-test-id]').forEach(function (b) {
        b.addEventListener('click', function () {
            testId.value = b.dataset.testId;
            audience.value = 'test';
            syncTest();
        });
    });

    form.addEventListener('submit', function (e) {
        if (audience.value !== 'test') {
            var who = audience.options[audience.selectedIndex].text;
            if (!confirm('Send this to real subscribers?\n\n' + who)) { e.preventDefault(); return; }
        }
        var btn = document.getElementById('send-btn');
        btn.disabled = true;
        btn.textContent = 'Sending…';
    });
})();
</script>
@endsection
