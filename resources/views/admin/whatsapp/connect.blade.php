@extends('admin.layouts.app')
@section('page-title', 'WhatsApp connection')

@section('content')
<div class="mx-auto max-w-lg"
     x-data="waConnect({ statusUrl: '{{ route('admin.whatsapp.connect.status') }}' })">

    @foreach(['success' => 'success', 'info' => 'info', 'error' => 'danger'] as $key => $tone)
        @if(session($key))
            <div class="alert-{{ $tone }} mb-4">{{ session($key) }}</div>
        @endif
    @endforeach

    <div class="card-p text-center">
        <p class="text-xs font-bold uppercase tracking-[0.12em] text-slate-400">WhatsApp</p>
        <h1 class="mt-1 text-2xl font-bold text-brandNavy" x-text="heading"></h1>
        <p class="mt-1 text-sm text-slate-500" x-text="subtext"></p>

        {{-- Connected --}}
        <template x-if="state.connection === 'open'">
            <div class="mt-6">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-emerald-50">
                    <i class="fa-brands fa-whatsapp text-2xl text-emerald-600"></i>
                </div>
                <p class="mt-3 text-sm font-semibold text-brandNavy" x-text="state.me?.name || 'Linked'"></p>
                <p class="text-xs text-slate-500" x-text="(state.me?.id || '').split(':')[0]"></p>

                <div class="mt-6 flex justify-center gap-2">
                    <a href="{{ route('admin.whatsapp.index') }}" class="btn-teal">
                        <i class="fa-solid fa-inbox"></i> Open the inbox
                    </a>
                    <form method="POST" action="{{ route('admin.whatsapp.logout') }}"
                          onsubmit="return confirm('Unlink this WhatsApp number? You will need to scan a QR code again to send messages. Saved chats stay.')">
                        @csrf
                        <button class="btn-outline"><i class="fa-solid fa-link-slash"></i> Unlink</button>
                    </form>
                </div>
            </div>
        </template>

        {{-- Waiting for a scan --}}
        <template x-if="state.connection !== 'open' && state.qr">
            <div class="mt-6">
                <img :src="state.qr" alt="WhatsApp QR code"
                     class="mx-auto h-[280px] w-[280px] rounded-xl border border-slate-200 bg-white p-2">
                <ol class="mx-auto mt-5 max-w-xs space-y-1.5 text-left text-sm text-slate-600">
                    <li>1. Open WhatsApp on the business phone.</li>
                    <li>2. Tap <strong>Settings → Linked devices → Link a device</strong>.</li>
                    <li>3. Scan this code. It refreshes on its own.</li>
                </ol>
            </div>
        </template>

        {{-- Gateway down or starting up --}}
        <template x-if="state.connection !== 'open' && ! state.qr">
            <div class="mt-6">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-slate-100">
                    <i class="fa-solid text-2xl text-slate-400"
                       :class="state.connection === 'offline' ? 'fa-plug-circle-xmark' : 'fa-spinner fa-spin'"></i>
                </div>

                <template x-if="state.connection === 'offline'">
                    <div class="mt-4 text-left">
                        <p class="text-sm text-slate-600">
                            The gateway service is not answering. Start it on the server:
                        </p>
                        <pre class="mt-2 overflow-x-auto rounded-xl bg-slate-900 px-3 py-2.5 text-xs leading-relaxed text-slate-100">cd ~/whatsapp-service
./keepalive.sh
tail -20 gateway.log</pre>
                        <p x-show="state.last_error" x-cloak class="help mt-2" x-text="state.last_error"></p>
                    </div>
                </template>
            </div>
        </template>

        <p class="mt-6 text-[11px] text-slate-400">
            This links WhatsApp through WhatsApp Web, the same as any linked device. Keep the phone
            online — if it stays offline for long, WhatsApp drops the link and you will scan again.
        </p>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('waConnect', (cfg) => ({
        state: @js($status),
        timer: null,

        init() {
            // A QR expires every ~20s, so poll faster than the inbox does.
            this.timer = setInterval(() => this.refresh(), 3000);
        },

        destroy() {
            clearInterval(this.timer);
        },

        async refresh() {
            try {
                // The timestamp gets past the host's page cache even if it ignores our headers.
                const res = await fetch(cfg.statusUrl + '?_=' + Date.now(), {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store',
                });
                if (! res.ok) return;

                const next = await res.json();
                const justConnected = this.state.connection !== 'open' && next.connection === 'open';
                this.state = next;

                if (justConnected) {
                    window.location = '{{ route('admin.whatsapp.index') }}';
                }
            } catch (e) {
                this.state = { ...this.state, connection: 'offline', qr: null };
            }
        },

        get heading() {
            if (this.state.connection === 'open')     return 'Connected';
            if (this.state.qr)                        return 'Scan to connect';
            if (this.state.connection === 'offline')  return 'Service not running';
            return 'Starting up';
        },

        get subtext() {
            if (this.state.connection === 'open')     return 'Messages sent from the panel go out from this number.';
            if (this.state.qr)                        return 'Link the phone that talks to your buyers.';
            if (this.state.connection === 'offline')  return 'Laravel cannot reach the WhatsApp gateway.';
            return 'Waiting for WhatsApp — the QR code appears in a moment.';
        },
    }));
});
</script>
@endsection
