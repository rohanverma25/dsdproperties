@extends('admin.layouts.app')
@section('page-title', 'Newsletter')

@section('content')
<style>
    .nl-grid { display:grid; gap:1.25rem; }
    @media (min-width:1024px) { .nl-grid { grid-template-columns:repeat(3,minmax(0,1fr)); } .nl-main { grid-column:span 2; } }
    .nl-bar { height:8px; border-radius:99px; background:#e2e8f0; overflow:hidden; }
    .nl-bar > i { display:block; height:100%; background:#008080; }
</style>
@php $current = \App\Support\Newsletter::weekKey(now()); $defaultWeek = array_key_first($weeks); @endphp
<div class="mx-auto max-w-6xl">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-brandNavy">Weekly newsletter</h2>
        <p class="mt-0.5 text-sm text-slate-500">
            One email a week with that week's /news stories, sent only to people who gave us their email on our forms.
            Every email has a one-click unsubscribe. It goes out {{ $batchSize }} emails an hour (9 am–8 pm) to stay inside the mailbox limits.
            Links carry <code>utm_source=newsletter</code>, so GA4 shows the visits and leads.
        </p>
    </div>

    @foreach(['success' => 'alert-success', 'info' => 'alert-info', 'error' => 'alert-danger'] as $key => $class)
        @if(session($key))<div class="{{ $class }} mb-4">{{ session($key) }}</div>@endif
    @endforeach
    @if($errors->any())
        <div class="alert-danger mb-4">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    @unless($configured)
        <div class="alert-danger mb-4">
            The newsletter mailbox is not set up on this server. Add these to <code>.env</code>, then reload:
            <code>NEWSLETTER_MAIL_USERNAME</code>, <code>NEWSLETTER_MAIL_PASSWORD</code> (the Hostinger mailbox),
            and optionally <code>NEWSLETTER_FROM_NAME</code> and <code>NEWSLETTER_REPLY_TO</code>.
            <ul class="mt-2 text-sm">
                @foreach($checks as $label => $ok)
                    <li>{!! $ok ? '✅' : '❌' !!} {{ $label }}</li>
                @endforeach
            </ul>
        </div>
    @endunless

    <div class="nl-grid">
        {{-- ── New campaign ── --}}
        <form method="POST" action="{{ route('admin.newsletter.store') }}" class="card-p nl-main">
            @csrf
            <h3 class="mb-3 font-bold text-brandNavy">New weekly email</h3>

            <div class="mb-4">
                <label class="label" for="week">Week</label>
                <select id="week" name="week" class="input" required>
                    @foreach($weeks as $k => $n)
                        <option value="{{ $k }}" @selected(old('week', $defaultWeek) === $k)>
                            {{ \App\Support\Newsletter::weekLabel($k) }} — {{ $n }} {{ $n === 1 ? 'story' : 'stories' }}{{ $k === $current ? ' (this week)' : '' }}
                        </option>
                    @endforeach
                </select>
                <p class="help">The email lists every published story dated in that week. Page: <code>/news/weekly/{week}</code></p>
            </div>

            <div class="mb-4">
                <label class="label" for="subject">Subject line</label>
                <input id="subject" name="subject" class="input" maxlength="190" required
                       value="{{ old('subject', 'Lucknow real estate this week: ' . ($defaultWeek ? \App\Support\Newsletter::weekLabel($defaultWeek) : '')) }}">
                <p class="help">Tip: lead with the biggest story, for example "New ₹1,150/sq m charge in Sushant Golf City + 10 more updates".</p>
            </div>

            <div class="mb-4">
                <label class="label" for="intro">Opening lines <span class="font-normal text-slate-400">(optional)</span></label>
                <textarea id="intro" name="intro" class="input" rows="3" maxlength="1000" placeholder="Leave empty for the standard opening.">{{ old('intro') }}</textarea>
            </div>

            <div class="mb-5">
                <span class="label">Send to</span>
                @foreach($sources as $key => $label)
                    <label class="mb-1 flex items-center gap-2 text-sm">
                        <input type="checkbox" name="sources[]" value="{{ $key }}" @checked(in_array($key, old('sources', array_keys($sources))))>
                        {{ $label }} <span class="text-slate-400">({{ $sourceCounts[$key] }} emails)</span>
                    </label>
                @endforeach
                <p class="help">All sources together: <strong>{{ $allCount }}</strong> unique emails (duplicates and {{ $unsubscribed }} unsubscribed removed).</p>
            </div>

            <button type="submit" class="btn-primary" @disabled(!$weeks)>Save draft</button>
        </form>

        {{-- ── How it works ── --}}
        <div class="card-p text-sm text-slate-600">
            <h3 class="mb-2 font-bold text-brandNavy">How to send</h3>
            <ol class="list-decimal space-y-1 pl-4">
                <li>Save a draft for the week.</li>
                <li><strong>Preview</strong> it, then send a <strong>test</strong> to your own Gmail. Check the inbox and spam.</li>
                <li>Press <strong>Start</strong>. The first {{ $batchSize }} go at once; the rest go hourly by cron.</li>
                <li>No cron on the server? Press <strong>Send next batch</strong> once an hour.</li>
            </ol>
            <p class="mt-3">Send one email a week at most. People who unsubscribe are never emailed again.</p>
        </div>
    </div>

    {{-- ── Campaigns ── --}}
    <div class="card-p mt-5">
        <h3 class="mb-3 font-bold text-brandNavy">Campaigns</h3>
        @forelse($campaigns as $c)
            @php $pct = $c->total ? round(($c->sent + $c->failed) / $c->total * 100) : 0; @endphp
            <div class="border-b border-slate-100 py-4 last:border-0">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <div class="font-semibold text-brandNavy">{{ $c->subject }}</div>
                        <div class="text-xs text-slate-500">
                            {{ \App\Support\Newsletter::weekLabel($c->week) }} ·
                            <span class="{{ ['draft' => 'badge-amber', 'sending' => 'badge-teal', 'done' => 'badge-green'][$c->status] ?? '' }}">{{ $c->status }}</span>
                            @if($c->total) · {{ $c->sent }} sent / {{ $c->failed }} failed / {{ $c->total }} total @endif
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.newsletter.preview', $c) }}" target="_blank" class="btn-outline">Preview</a>
                        @if($c->status === 'draft')
                            <form method="POST" action="{{ route('admin.newsletter.test', $c) }}" class="flex gap-1">
                                @csrf
                                <input name="email" type="email" class="input" style="width:200px" placeholder="your@gmail.com" required>
                                <button class="btn-outline" @disabled(!$configured)>Send test</button>
                            </form>
                            <form method="POST" action="{{ route('admin.newsletter.start', $c) }}"
                                  onsubmit="return confirm('Send this email to all {{ $allCount }} recipients now?')">
                                @csrf <button class="btn-primary" @disabled(!$configured)>Start</button>
                            </form>
                            <form method="POST" action="{{ route('admin.newsletter.destroy', $c) }}">
                                @csrf @method('DELETE') <button class="btn-outline">Delete</button>
                            </form>
                        @elseif($c->status === 'sending')
                            <form method="POST" action="{{ route('admin.newsletter.batch', $c) }}">
                                @csrf <button class="btn-primary">Send next batch</button>
                            </form>
                        @endif
                    </div>
                </div>
                @if($c->total)<div class="nl-bar mt-2"><i style="width:{{ $pct }}%"></i></div>@endif
                @if($c->status === 'draft')
                    @php $wkStories = \App\Support\Newsletter::stories($c->week); $done = collect($c->items ?? [])->filter(fn ($i) => trim($i['title'] ?? '') !== '')->count(); @endphp
                    <details class="mt-3" @if($done < $wkStories->count()) open @endif>
                        <summary class="cursor-pointer text-sm font-semibold text-brandNavy">
                            English headlines for the email ({{ $done }}/{{ $wkStories->count() }} filled)
                        </summary>
                        <p class="help mt-1">The stories are in Hindi. Write the headline and a one-line summary in English; empty rows fall back to the Hindi text.</p>
                        <form method="POST" action="{{ route('admin.newsletter.items', $c) }}" class="mt-2">
                            @csrf
                            @foreach($wkStories as $s)
                                @php $it = ($c->items ?? [])[$s->id] ?? []; @endphp
                                <div class="mb-3 rounded-lg border border-slate-100 p-3">
                                    <div class="mb-1 text-xs text-slate-500">{{ $s->created_at->format('j M') }} · {{ $s->title }}</div>
                                    <input name="items[{{ $s->id }}][title]" class="input mb-1" maxlength="200" placeholder="English headline" value="{{ $it['title'] ?? '' }}">
                                    <textarea name="items[{{ $s->id }}][summary]" class="input" rows="2" maxlength="500" placeholder="One-line English summary">{{ $it['summary'] ?? '' }}</textarea>
                                </div>
                            @endforeach
                            <button class="btn-primary">Save English headlines</button>
                        </form>
                    </details>
                @endif
            </div>
        @empty
            <p class="text-sm text-slate-500">No campaigns yet.</p>
        @endforelse
    </div>
</div>
@endsection
