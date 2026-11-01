@extends('admin.layouts.app')
@section('page-title', 'WhatsApp')

@section('content')
@php
    $connected = ($status['connection'] ?? null) === 'open';
@endphp

<div x-data="waInbox({
        chatId: {{ $chat?->id ?? 'null' }},
        lastId: {{ $messages->last()->id ?? 0 }},
        pollMs: {{ (int) config('whatsapp.poll_ms', 6000) }},
        pollUrl: '{{ route('admin.whatsapp.poll') }}',
        messagesUrl: {{ $chat ? "'".route('admin.whatsapp.messages', $chat)."'" : 'null' }},
        sendUrl: {{ $chat ? "'".route('admin.whatsapp.send', $chat)."'" : 'null' }},
        noteUrl: {{ $chat ? "'".route('admin.whatsapp.note', $chat)."'" : 'null' }},
        mediaUrl: {{ $chat ? "'".route('admin.whatsapp.media.send', $chat)."'" : 'null' }},
        labelUrl: {{ $chat ? "'".route('admin.whatsapp.label.toggle', $chat)."'" : 'null' }},
        pushSubscribeUrl: '{{ route('admin.whatsapp.push.subscribe') }}',
        pushUnsubscribeUrl: '{{ route('admin.whatsapp.push.unsubscribe') }}',
        pushKey: @js($pushKey),
        replies: @js($quickReplies),
        maxMb: {{ (int) config('whatsapp.media.max_mb', 25) }},
     })"
     class="mx-auto max-w-6xl">

    {{-- Connection banner --}}
    @if(! $connected)
        <div class="alert-danger mb-4 flex flex-wrap items-center gap-3">
            <i class="fa-solid fa-plug-circle-xmark"></i>
            <span class="flex-1">
                WhatsApp is not connected
                @if(($status['connection'] ?? '') === 'offline')
                    — the gateway service is not running.
                @else
                    — the phone needs to be linked again.
                @endif
            </span>
            <a href="{{ route('admin.whatsapp.connect') }}" class="btn-primary btn-sm">Connect</a>
        </div>
    @endif

    @foreach(['success' => 'success', 'info' => 'info', 'error' => 'danger'] as $key => $tone)
        @if(session($key))
            <div class="alert-{{ $tone }} mb-4">{{ session($key) }}</div>
        @endif
    @endforeach

    @if($errors->any())
        <div class="alert-danger mb-4">
            <ul class="list-disc space-y-0.5 pl-4">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Notifications prompt: only shown when it can actually do something. --}}
    <div x-show="pushOffer" x-cloak class="alert-info mb-4 flex flex-wrap items-center gap-3">
        <i class="fa-solid fa-bell"></i>
        <span class="flex-1">Get notified on this device when a new message arrives, even with the panel closed.</span>
        <button type="button" @click="enablePush" class="btn-primary btn-sm" :disabled="pushBusy">
            <span x-show="! pushBusy">Turn on</span>
            <span x-show="pushBusy" x-cloak>Enabling…</span>
        </button>
        <button type="button" @click="dismissPushOffer" class="btn-ghost btn-sm">Not now</button>
    </div>

    <div class="card overflow-hidden lg:grid lg:h-[calc(100vh-11rem)] lg:grid-cols-[320px_1fr]">

        {{-- ---------------------------------------------------------- chat list --}}
        <aside @class([
                'flex min-h-0 flex-col border-slate-200 lg:border-r',
                'hidden lg:flex' => (bool) $chat,
            ])>
            <div class="border-b border-slate-200 p-3">
                <div class="mb-2 flex items-center justify-between">
                    <p class="text-sm font-bold text-brandNavy">
                        Chats
                        <span x-show="unreadTotal > 0" x-cloak class="badge-teal ml-1" x-text="unreadTotal"></span>
                    </p>
                    <div class="flex items-center gap-2">
                        <span @class(['badge-green' => $connected, 'badge-rose' => ! $connected])>
                            {{ $connected ? 'Online' : 'Offline' }}
                        </span>
                        <a href="{{ route('admin.whatsapp.export') }}"
                           onclick="this.href = this.href.split('?')[0] + '?_=' + Date.now()"
                           class="text-slate-400 hover:text-brandNavy"
                           title="Export all contacts (CSV)"><i class="fa-solid fa-file-arrow-down"></i></a>
                        <a href="{{ route('admin.whatsapp.settings') }}" class="text-slate-400 hover:text-brandNavy"
                           title="Quick replies and labels"><i class="fa-solid fa-gear"></i></a>
                        <a href="{{ route('admin.whatsapp.connect') }}" class="text-slate-400 hover:text-brandNavy"
                           title="Connection"><i class="fa-solid fa-link"></i></a>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.whatsapp.index') }}" class="mb-2">
                    @if($activeLabel)<input type="hidden" name="label" value="{{ $activeLabel }}">@endif
                    @if($pending)<input type="hidden" name="pending" value="1">@endif
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                        <input type="search" name="q" value="{{ $search }}" placeholder="Search name or number"
                               class="input input-sm pl-8">
                    </div>
                </form>

                <div class="mb-2 flex gap-1.5 overflow-x-auto pb-1">
                    <a href="{{ route('admin.whatsapp.index', array_filter(['q' => $search])) }}"
                       @class([
                           'shrink-0 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1',
                           'bg-brandNavy text-white ring-brandNavy' => ! $activeLabel && ! $pending,
                           'bg-white text-slate-600 ring-slate-200 hover:bg-slate-50' => $activeLabel || $pending,
                       ])>All</a>
                    {{-- Not a lead, not archived, and the customer spoke last. --}}
                    <a href="{{ route('admin.whatsapp.index', array_filter(['q' => $search, 'pending' => 1])) }}"
                       title="Not a lead, not archived, and waiting on your reply"
                       @class([
                           'shrink-0 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1',
                           {{-- Only amber shades already in the built CSS — public/build is not in git. --}}
                           'bg-amber-200 text-amber-800 ring-2 ring-offset-1 ring-brandNavy' => $pending,
                           'bg-amber-50 text-amber-700 ring-amber-200 hover:bg-slate-50' => ! $pending,
                       ])>Not handled{{ $pendingCount ? ' · ' . $pendingCount : '' }}</a>
                    @foreach($labels as $label)
                        <a href="{{ route('admin.whatsapp.index', array_filter(['q' => $search, 'label' => $label->id])) }}"
                           @class([
                               'shrink-0 rounded-full px-2.5 py-1 text-[11px] font-semibold ring-1',
                               $label->classes,
                               'ring-2 ring-offset-1 ring-brandNavy' => $activeLabel === $label->id,
                           ])>{{ $label->name }}</a>
                    @endforeach
                </div>

                <form method="POST" action="{{ route('admin.whatsapp.start') }}" class="flex gap-2">
                    @csrf
                    <input type="tel" name="phone" required placeholder="New chat — phone number"
                           class="input input-sm flex-1">
                    <button class="btn-teal btn-sm shrink-0" title="Start chat">
                        <i class="fa-solid fa-comment-medical"></i>
                    </button>
                </form>
            </div>

            <div class="min-h-0 flex-1 divide-y divide-slate-100 overflow-y-auto">
                @forelse($chats as $row)
                    {{-- Keep the filter, so working through "Not handled" doesn't jump back to All. --}}
                    <a href="{{ route('admin.whatsapp.chat', ['chat' => $row] + array_filter(['q' => $search, 'label' => $activeLabel, 'pending' => $pending ? 1 : null])) }}"
                       @class([
                           'flex items-center gap-3 px-3 py-3 transition-colors hover:bg-slate-50',
                           'bg-brandTeal/10' => $chat && $chat->id === $row->id,
                       ])>
                        <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brandNavy text-xs font-bold text-white">
                            {{ $row->initials }}
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="flex items-baseline gap-2">
                                <span class="truncate text-sm font-semibold text-brandNavy">{{ $row->display_name }}</span>
                                <span class="ml-auto shrink-0 text-[11px] text-slate-400">
                                    {{ $row->last_message_at?->diffForHumans(null, true) }}
                                </span>
                            </span>
                            <span class="mt-0.5 flex items-center gap-2">
                                <span class="truncate text-xs text-slate-500">{{ $row->last_preview ?: 'No messages yet' }}</span>
                                @if($row->unread_count > 0)
                                    <span class="ml-auto grid h-5 min-w-[20px] shrink-0 place-items-center rounded-full bg-emerald-500 px-1.5 text-[11px] font-bold text-white">
                                        {{ $row->unread_count }}
                                    </span>
                                @endif
                            </span>
                            @if($row->labels->isNotEmpty())
                                <span class="mt-1 flex flex-wrap gap-1">
                                    @foreach($row->labels as $label)
                                        <span class="rounded px-1.5 py-0.5 text-[10px] font-semibold ring-1 {{ $label->classes }}">{{ $label->name }}</span>
                                    @endforeach
                                </span>
                            @endif
                        </span>
                    </a>
                @empty
                    <div class="px-4 py-12 text-center">
                        <i class="fa-brands fa-whatsapp mb-3 text-3xl text-slate-300"></i>
                        <p class="text-sm font-semibold text-brandNavy">
                            {{ $pending && ! $search && ! $activeLabel ? 'Every chat has been handled' : ($search || $activeLabel || $pending ? 'Nothing matches that' : 'No chats yet') }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            Incoming messages appear here. You can also start one with a number above.
                        </p>
                    </div>
                @endforelse
            </div>
        </aside>

        {{-- ------------------------------------------------------------- thread --}}
        @if($chat)
            <section class="flex min-h-0 flex-col">

                <header class="flex items-center gap-3 border-b border-slate-200 px-3 py-2.5">
                    <a href="{{ route('admin.whatsapp.index') }}" class="btn-ghost btn-sm lg:hidden" aria-label="Back to chats">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brandNavy text-xs font-bold text-white">
                        {{ $chat->initials }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-bold text-brandNavy">{{ $chat->display_name }}</p>
                        <p class="flex items-center gap-1.5 truncate text-xs text-slate-500">
                            <span>+{{ $chat->phone }}</span>
                            @if($chat->lead)
                                <span class="badge-slate">{{ str_replace('_', ' ', $chat->lead->stage) }}</span>
                            @endif
                            <template x-for="l in chatLabels" :key="l.id">
                                <span class="rounded px-1.5 py-0.5 text-[10px] font-semibold ring-1" :class="l.classes" x-text="l.name"></span>
                            </template>
                        </p>
                    </div>

                    <div class="flex items-center gap-1.5">
                        {{-- Labels --}}
                        @if($labels->isNotEmpty())
                            <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
                                <button type="button" @click="open = !open" class="btn-ghost btn-sm" title="Labels">
                                    <i class="fa-solid fa-tag"></i>
                                </button>
                                <div x-show="open" x-cloak x-transition @click.outside="open = false"
                                     class="absolute right-0 z-30 mt-2 w-56 overflow-hidden rounded-xl border border-slate-200 bg-white py-1 shadow-lg">
                                    @foreach($labels as $label)
                                        <button type="button" @click="toggleLabel({{ $label->id }})"
                                                class="flex w-full items-center gap-2.5 px-3 py-2 text-left text-sm hover:bg-slate-50">
                                            <i class="fa-solid fa-check text-xs"
                                               :class="hasLabel({{ $label->id }}) ? 'text-emerald-600' : 'text-transparent'"></i>
                                            <span class="rounded px-1.5 py-0.5 text-[11px] font-semibold ring-1 {{ $label->classes }}">{{ $label->name }}</span>
                                        </button>
                                    @endforeach
                                    <a href="{{ route('admin.whatsapp.settings') }}"
                                       class="mt-1 block border-t border-slate-100 px-3 py-2 text-xs text-slate-500 hover:bg-slate-50">
                                        Manage labels…
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($chat->lead)
                            <a href="{{ route('admin.crm.leads.show', $chat->crm_lead_id) }}" class="btn-outline btn-sm">
                                <i class="fa-solid fa-address-card"></i>
                                <span class="hidden sm:inline">Lead</span>
                            </a>
                        @else
                            <form method="POST" action="{{ route('admin.whatsapp.lead', $chat) }}">
                                @csrf
                                <button class="btn-teal btn-sm">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <span class="hidden sm:inline">Make lead</span>
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.whatsapp.archive', $chat) }}">
                            @csrf
                            <button class="btn-ghost btn-sm" title="{{ $chat->archived ? 'Unarchive' : 'Archive' }}">
                                <i class="fa-solid fa-box-archive"></i>
                            </button>
                        </form>
                    </div>
                </header>

                {{-- Messages --}}
                <div x-ref="scroll" class="min-h-0 flex-1 space-y-2 overflow-y-auto bg-slate-50 px-3 py-4"
                     @dragover.prevent="dragging = true" @dragleave="dragging = false"
                     @drop.prevent="dropFile($event)"
                     :class="dragging && 'ring-2 ring-inset ring-brandTeal'">
                    @forelse($messages as $m)
                        @include('admin.whatsapp.partials.bubble', ['m' => $m])
                    @empty
                        <p class="py-10 text-center text-xs text-slate-400">
                            No messages in this chat yet — say hello below.
                        </p>
                    @endforelse

                    {{-- Anything that arrives while the page is open. Mirrors partials/bubble. --}}
                    <template x-for="m in live" :key="m.id">
                      <div>
                        <template x-if="m.type === 'note'">
                            <div class="flex justify-center">
                                <div class="max-w-[80%] rounded-xl bg-amber-50 px-3 py-2 text-sm text-slate-800 ring-1 ring-amber-200">
                                    <p class="text-[10px] font-bold uppercase tracking-wide text-amber-800">
                                        <i class="fa-solid fa-note-sticky"></i> Note · only you see this
                                    </p>
                                    <p class="mt-0.5 whitespace-pre-wrap break-words" x-text="m.body"></p>
                                    <p class="mt-1 text-right text-[10px] text-slate-500" x-text="m.time"></p>
                                </div>
                            </div>
                        </template>
                        <template x-if="m.type !== 'note'">
                        <div class="flex" :class="m.direction === 'out' && 'justify-end'">
                            <div class="max-w-[80%] rounded-2xl px-3 py-2 text-sm shadow-sm"
                                 :class="m.direction === 'out'
                                    ? 'bg-brandTeal/25 text-slate-900 rounded-br-sm'
                                    : 'bg-white text-slate-800 rounded-bl-sm'">
                                <template x-if="m.media && m.media.image">
                                    <a :href="m.media.url" target="_blank" rel="noopener" class="block">
                                        <img :src="m.media.url" :alt="m.media.name" loading="lazy"
                                             class="mb-1 max-h-72 w-auto rounded-xl border border-black/5 bg-white object-contain">
                                    </a>
                                </template>
                                <template x-if="m.media && m.media.audio">
                                    <audio controls preload="none" :src="m.media.url" class="mb-1 w-56 max-w-full"></audio>
                                </template>
                                <template x-if="m.media && ! m.media.image && ! m.media.audio">
                                    <a :href="m.media.url"
                                       class="mb-1 flex items-center gap-2.5 rounded-xl bg-black/5 px-3 py-2 hover:bg-black/10">
                                        <i class="fa-solid fa-file-arrow-down text-slate-500"></i>
                                        <span class="min-w-0">
                                            <span class="block truncate text-xs font-semibold text-slate-700" x-text="m.media.name"></span>
                                            <span class="block text-[10px] text-slate-500" x-text="m.media.size"></span>
                                        </span>
                                    </a>
                                </template>
                                <p class="whitespace-pre-wrap break-words" x-show="m.body" x-text="m.body"></p>
                                <p class="mt-1 flex items-center justify-end gap-1.5 text-[10px] text-slate-500">
                                    <span x-text="m.time"></span>
                                    <template x-if="m.direction === 'out' && m.type !== 'call' && m.type !== 'missed_call'">
                                        <i :class="m.status_icon" :data-status="m.id"></i>
                                    </template>
                                </p>
                            </div>
                        </div>
                        </template>
                      </div>
                    </template>
                </div>

                {{-- Composer --}}
                <footer class="border-t border-slate-200 p-3">
                    <p x-show="error" x-cloak class="alert-danger mb-2 text-xs" x-text="error"></p>

                    {{-- Chosen file, before it goes --}}
                    <div x-show="file" x-cloak class="mb-2 flex items-center gap-2.5 rounded-xl bg-slate-100 px-3 py-2">
                        <i class="fa-solid fa-paperclip text-slate-500"></i>
                        <span class="min-w-0 flex-1">
                            <span class="block truncate text-xs font-semibold text-slate-700" x-text="file?.name"></span>
                            <span class="block text-[10px] text-slate-500" x-text="fileSize"></span>
                        </span>
                        <button type="button" @click="clearFile" class="btn-ghost btn-sm" aria-label="Remove attachment">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    {{-- Quick replies: chips, or the matching list while typing "/" --}}
                    <div x-show="slashMatches.length" x-cloak
                         class="mb-2 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <template x-for="(r, i) in slashMatches" :key="r.shortcut">
                            <button type="button" @click="useReply(r)"
                                    class="flex w-full items-start gap-2 px-3 py-2 text-left hover:bg-slate-50"
                                    :class="i === slashIndex && 'bg-brandTeal/10'">
                                <span class="rounded bg-slate-100 px-1.5 py-0.5 font-mono text-[11px] text-slate-600"
                                      x-text="'/' + r.shortcut"></span>
                                <span class="min-w-0 flex-1">
                                    <span class="block text-xs font-semibold text-brandNavy" x-text="r.label"></span>
                                    <span class="block truncate text-[11px] text-slate-500" x-text="r.body"></span>
                                </span>
                            </button>
                        </template>
                    </div>

                    @if($quickReplies->isNotEmpty())
                        <div x-show="! slashMatches.length && ! body" x-cloak class="mb-2 flex gap-1.5 overflow-x-auto pb-1">
                            <template x-for="r in replies" :key="r.shortcut">
                                <button type="button" @click="useReply(r)"
                                        class="shrink-0 rounded-full border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium text-slate-600 hover:border-brandTeal hover:text-brandNavy"
                                        x-text="r.label"></button>
                            </template>
                        </div>
                    @endif

                    <form @submit.prevent="send" class="flex items-end gap-2">
                        <input type="file" x-ref="fileInput" class="hidden" @change="pickFile($event)">
                        <button type="button" x-show="! noteMode" @click="$refs.fileInput.click()" class="btn-outline shrink-0"
                                title="Attach a photo or document">
                            <i class="fa-solid fa-paperclip"></i>
                        </button>
                        {{-- Note mode: what you type is saved privately, not sent. --}}
                        <button type="button" @click="noteMode = ! noteMode; clearFile(); $refs.body.focus()"
                                class="btn-outline shrink-0" :class="noteMode && 'bg-amber-200 text-amber-800'"
                                :title="noteMode ? 'Back to sending messages' : 'Write a private note (not sent)'">
                            <i class="fa-solid fa-note-sticky"></i>
                        </button>

                        <textarea x-ref="body" x-model="body" rows="1"
                                  @keydown.enter.exact.prevent="onEnter"
                                  @keydown.arrow-down.prevent="slashMatches.length && moveSlash(1)"
                                  @keydown.arrow-up.prevent="slashMatches.length && moveSlash(-1)"
                                  @keydown.escape="slashIndex = -1; slashOpen = false"
                                  @input="grow($el)"
                                  :placeholder="noteMode
                                        ? 'Private note — only you see this. Enter to save'
                                        : (file
                                            ? 'Add a caption (optional) — Enter to send'
                                            : 'Type a message, or / for a quick reply')"
                                  :class="noteMode && 'bg-amber-50 ring-1 ring-amber-200'"
                                  class="input max-h-[140px] flex-1 resize-none py-3"></textarea>

                        <button type="submit" class="btn-teal shrink-0" :disabled="sending || (! body.trim() && ! file)">
                            <i class="fa-solid" :class="sending ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                        </button>
                    </form>
                </footer>
            </section>
        @else
            <section class="hidden place-items-center bg-slate-50 lg:grid">
                <div class="px-6 text-center">
                    <i class="fa-brands fa-whatsapp mb-3 text-5xl text-slate-300"></i>
                    <p class="text-base font-semibold text-brandNavy">Pick a chat to start replying</p>
                    <p class="mt-1 text-sm text-slate-500">Messages sent here go out from the linked WhatsApp number.</p>
                </div>
            </section>
        @endif
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('waInbox', (cfg) => ({
        // Bubbles rendered by Blade stay put; anything newer is appended from `live`.
        live: [],
        lastId: cfg.lastId,
        body: '',
        file: null,
        sending: false,
        noteMode: false,
        dragging: false,
        error: '',
        unreadTotal: {{ (int) $unreadTotal }},
        chatLabels: @js($chat?->labels->map(fn ($l) => ['id' => $l->id, 'name' => $l->name, 'classes' => $l->classes])->values() ?? []),
        replies: cfg.replies || [],
        slashIndex: 0,
        pushOffer: false,
        pushBusy: false,
        timer: null,

        init() {
            this.scrollToEnd();
            this.schedulePoll();
            this.offerPush();

            // Polling while the tab is hidden is wasted work on a phone; come
            // back with an immediate refresh instead.
            document.addEventListener('visibilitychange', () => {
                if (! document.hidden) { this.poll(); this.schedulePoll(); }
            });
        },

        destroy() {
            clearInterval(this.timer);
        },

        /* ------------------------------------------------------------ polling */

        // A focused thread refreshes quickly; the list on its own can be lazy.
        schedulePoll() {
            clearInterval(this.timer);
            const every = cfg.messagesUrl ? Math.min(cfg.pollMs, 4000) : cfg.pollMs;
            this.timer = setInterval(() => this.poll(), every);
        },

        async poll() {
            if (document.hidden) return;

            try {
                // The timestamp gets past the host's page cache even if it ignores our headers.
                const listRes = await fetch(cfg.pollUrl + (cfg.pollUrl.includes('?') ? '&' : '?') + '_=' + Date.now(), {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store',
                });
                if (listRes.ok) {
                    this.unreadTotal = (await listRes.json()).unread_total;
                }

                if (! cfg.messagesUrl) return;

                const res = await fetch(cfg.messagesUrl + '?after=' + this.lastId + '&_=' + Date.now(), {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store',
                });
                if (! res.ok) return;

                const data = await res.json();
                data.messages.forEach((m) => this.append(m));
                (data.statuses || []).forEach((s) => this.applyStatus(s));
            } catch (e) { /* the next tick will try again */ }
        },

        /* ------------------------------------------------------------ sending */

        headers() {
            return {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            };
        },

        onEnter() {
            // Enter picks the highlighted quick reply first, and only then sends.
            if (this.slashMatches.length) { this.useReply(this.slashMatches[this.slashIndex] || this.slashMatches[0]); return; }
            this.send();
        },

        async send() {
            if (this.sending) return;
            if (this.noteMode) return this.saveNote();
            if (this.file) return this.sendFile();

            const text = this.body.trim();
            if (! text || ! cfg.sendUrl) return;

            this.sending = true;
            this.error = '';

            try {
                const res = await fetch(cfg.sendUrl, {
                    method: 'POST',
                    headers: { ...this.headers(), 'Content-Type': 'application/json' },
                    body: JSON.stringify({ body: text }),
                });
                const data = await res.json();

                if (! res.ok || ! data.ok) {
                    this.error = data.error || 'The message could not be sent.';
                    return;
                }

                this.append(data.message);
                this.resetComposer();
            } catch (e) {
                this.error = 'Network error — the message was not sent.';
            } finally {
                this.sending = false;
            }
        },

        /** Saved on our side only — nothing goes to WhatsApp. */
        async saveNote() {
            const text = this.body.trim();
            if (! text || ! cfg.noteUrl) return;

            this.sending = true;
            this.error = '';

            try {
                const res = await fetch(cfg.noteUrl, {
                    method: 'POST',
                    headers: { ...this.headers(), 'Content-Type': 'application/json' },
                    body: JSON.stringify({ body: text }),
                });
                const data = await res.json();

                if (! res.ok || ! data.ok) {
                    this.error = 'The note could not be saved.';
                    return;
                }

                this.append(data.message);
                this.resetComposer();
            } catch (e) {
                this.error = 'Network error — the note was not saved.';
            } finally {
                this.sending = false;
            }
        },

        async sendFile() {
            if (! cfg.mediaUrl || ! this.file) return;

            this.sending = true;
            this.error = '';

            const form = new FormData();
            form.append('file', this.file);
            if (this.body.trim()) form.append('caption', this.body.trim());

            try {
                const res  = await fetch(cfg.mediaUrl, { method: 'POST', headers: this.headers(), body: form });
                const data = await res.json();

                if (! res.ok || ! data.ok) {
                    this.error = data.error || (data.errors && Object.values(data.errors)[0][0]) || 'The file could not be sent.';
                    return;
                }

                this.append(data.message);
                this.clearFile();
                this.resetComposer();
            } catch (e) {
                this.error = 'Network error — the file was not sent.';
            } finally {
                this.sending = false;
            }
        },

        resetComposer() {
            this.body = '';
            this.slashIndex = 0;
            if (this.$refs.body) this.$refs.body.style.height = 'auto';
        },

        /* -------------------------------------------------------- attachments */

        pickFile(event) {
            const file = event.target.files?.[0];
            event.target.value = '';           // so the same file can be picked twice
            this.acceptFile(file);
        },

        dropFile(event) {
            this.dragging = false;
            this.acceptFile(event.dataTransfer?.files?.[0]);
        },

        acceptFile(file) {
            if (! file) return;

            if (file.size > cfg.maxMb * 1024 * 1024) {
                this.error = `That file is larger than ${cfg.maxMb} MB.`;
                return;
            }

            this.error = '';
            this.file = file;
            this.$refs.body?.focus();
        },

        clearFile() {
            this.file = null;
        },

        get fileSize() {
            if (! this.file) return '';
            const kb = this.file.size / 1024;
            return kb >= 1024 ? (kb / 1024).toFixed(1) + ' MB' : Math.max(1, Math.round(kb)) + ' KB';
        },

        /* ------------------------------------------------------ quick replies */

        // Only while the whole box is a single "/word" — never mid-sentence.
        get slashMatches() {
            const m = this.body.match(/^\/([a-z0-9_-]*)$/i);
            if (! m) return [];

            const term = m[1].toLowerCase();
            return this.replies.filter((r) => r.shortcut.startsWith(term)).slice(0, 6);
        },

        moveSlash(step) {
            const n = this.slashMatches.length;
            if (! n) return;
            this.slashIndex = (this.slashIndex + step + n) % n;
        },

        useReply(reply) {
            this.body = reply.body;
            this.slashIndex = 0;
            this.$nextTick(() => {
                const el = this.$refs.body;
                if (! el) return;
                el.focus();
                el.setSelectionRange(el.value.length, el.value.length);
                this.grow(el);
            });
        },

        grow(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 140) + 'px';
        },

        /* ---------------------------------------------------------- the thread */

        append(m) {
            if (m.id <= this.lastId) return;
            this.live.push(m);
            this.lastId = m.id;
            this.$nextTick(() => this.scrollToEnd());
        },

        /** Ticks change on messages Blade already rendered, so patch in place. */
        applyStatus(s) {
            const live = this.live.find((m) => m.id === s.id);
            if (live) {
                live.status = s.status;
                live.status_icon = s.status_icon;
                return;
            }

            const icon = this.$refs.scroll?.querySelector('[data-status="' + s.id + '"]');
            if (icon) icon.className = s.status_icon;
        },

        scrollToEnd() {
            const box = this.$refs.scroll;
            if (box) box.scrollTop = box.scrollHeight;
        },

        /* ---------------------------------------------------------- the labels */

        hasLabel(id) {
            return this.chatLabels.some((l) => l.id === id);
        },

        async toggleLabel(id) {
            if (! cfg.labelUrl) return;

            try {
                const res = await fetch(cfg.labelUrl, {
                    method: 'POST',
                    headers: { ...this.headers(), 'Content-Type': 'application/json' },
                    body: JSON.stringify({ label: id }),
                });
                if (! res.ok) return;

                this.chatLabels = (await res.json()).labels;
            } catch (e) { /* leave the chips as they were */ }
        },

        /* ----------------------------------------------------- notifications */

        async offerPush() {
            if (! cfg.pushKey || ! ('serviceWorker' in navigator) || ! ('PushManager' in window)) return;
            if (Notification.permission === 'denied') return;

            try {
                if (localStorage.getItem('waPushDismissed') === '1') return;
            } catch (e) { /* private mode */ }

            const reg = await navigator.serviceWorker.ready.catch(() => null);
            const existing = await reg?.pushManager.getSubscription();

            // Already subscribed on this device — nothing to ask.
            this.pushOffer = ! existing;
        },

        dismissPushOffer() {
            this.pushOffer = false;
            try { localStorage.setItem('waPushDismissed', '1'); } catch (e) {}
        },

        async enablePush() {
            this.pushBusy = true;

            try {
                if (await Notification.requestPermission() !== 'granted') {
                    this.error = 'Notifications were blocked in the browser.';
                    this.pushOffer = false;
                    return;
                }

                const reg = await navigator.serviceWorker.ready;
                const sub = await reg.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: this.urlBase64ToUint8Array(cfg.pushKey),
                });

                const res = await fetch(cfg.pushSubscribeUrl, {
                    method: 'POST',
                    headers: { ...this.headers(), 'Content-Type': 'application/json' },
                    body: JSON.stringify(sub.toJSON()),
                });

                if (! res.ok) throw new Error('subscribe failed');

                this.pushOffer = false;
                window.dsdToast?.('Notifications are on for this device.', 'success');
            } catch (e) {
                this.error = 'Could not turn notifications on for this device.';
            } finally {
                this.pushBusy = false;
            }
        },

        /** The VAPID key travels as base64url but subscribe() wants bytes. */
        urlBase64ToUint8Array(key) {
            const padding = '='.repeat((4 - (key.length % 4)) % 4);
            const raw = atob((key + padding).replace(/-/g, '+').replace(/_/g, '/'));

            return Uint8Array.from([...raw].map((c) => c.charCodeAt(0)));
        },
    }));
});
</script>
@endsection
