@extends('admin.layouts.app')
@section('page-title', 'Waiting')

@section('content')
@php
    $reasons = config('crm.waiting_reasons');

    // What the message box and the per-row links need, without the whole model.
    $rows = $leads->map(fn ($l) => [
        'id'          => $l->id,
        'first'       => trim(explode(' ', $l->name)[0]),
        'scheme'      => $l->scheme_interest ?: 'the scheme',
        'requirement' => $l->requirement ?: 'the plot you asked about',
        'phone'       => $l->whatsapp_phone,
        'send'        => route('admin.crm.leads.whatsapp', $l),
    ])->values();

    // A starting message that fits what they were waiting for; editable on the page.
    $message = match (request('waiting_for')) {
        'it_city_resale', 'wellness_resale'               => 'Hello {name}, DSD Properties here. A resale plot in {scheme} that fits what you asked for ({requirement}) is available now. Shall we talk today?',
        'it_city_land', 'wellness_land', 'lucknow_land' => 'Hello {name}, DSD Properties here. We have land in {scheme} that fits what you asked for ({requirement}). Shall we talk today?',
        default                                           => 'Hello {name}, DSD Properties here. There is an update on {scheme}. You had asked for {requirement}. Shall we talk today?',
    };
@endphp

<div class="mx-auto max-w-3xl"
     x-data="waitingLeads({ rows: @js($rows), template: @js($message) })">
    @include('admin.crm.leads.partials.nav')

    <div class="mb-4">
        <h2 class="text-lg font-bold text-brandNavy">Waiting leads</h2>
        <p class="mt-0.5 text-sm text-slate-500">
            Buyers on hold for something that hasn't happened yet. When it does, message them and move them back to Today.
            Put a lead here from its Edit screen ("On hold — waiting for").
        </p>
    </div>

    {{-- Counts by scheme and reason; each one filters the list below. --}}
    <section class="card-p mb-5">
        @if($groups->isEmpty())
            <p class="text-sm text-slate-500">No leads are waiting right now.</p>
        @else
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.crm.leads.waiting') }}"
                   @class([
                       'rounded-full px-3 py-1.5 text-xs font-semibold ring-1',
                       'bg-brandNavy text-white ring-brandNavy' => ! $filtered,
                       'bg-white text-slate-600 ring-slate-200 hover:bg-slate-50' => $filtered,
                   ])>All · {{ $groups->sum('total') }}</a>
                @foreach($groups as $g)
                    @php
                        $on = $filtered
                            && request('scheme_interest') === $g->scheme_interest
                            && request('waiting_for') === $g->waiting_for;
                    @endphp
                    <a href="{{ route('admin.crm.leads.waiting', ['scheme_interest' => $g->scheme_interest ?? '', 'waiting_for' => $g->waiting_for]) }}"
                       @class([
                           'rounded-full px-3 py-1.5 text-xs font-semibold ring-1',
                           'bg-brandNavy text-white ring-brandNavy' => $on,
                           'bg-amber-50 text-amber-800 ring-amber-200 hover:bg-slate-50' => ! $on,
                       ])>
                        {{ $g->scheme_interest ?: 'No scheme' }} · {{ $reasons[$g->waiting_for] ?? $g->waiting_for }} · {{ $g->total }}
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    @if($leads->isNotEmpty())
        {{-- One message for everyone listed. Sent one at a time, by your click —
             never as a blast, which would put the WhatsApp number at risk. --}}
        <section class="card-p mb-5 space-y-3">
            <label class="label" for="w-msg">Message for these {{ $leads->count() }} {{ Str::plural('lead', $leads->count()) }}</label>
            <textarea id="w-msg" x-model="template" rows="3" class="input min-h-[96px] py-3"></textarea>
            <p class="text-xs text-slate-500">
                {name}, {scheme} and {requirement} are filled in for each lead.
                "Send" goes from the panel's WhatsApp; "Phone" opens it in WhatsApp on this device instead.
            </p>

            <form method="POST" action="{{ route('admin.crm.leads.waiting.release') }}"
                  onsubmit="return confirm('Move all {{ $leads->count() }} listed leads back to Today?')">
                @csrf
                @foreach($leads as $l)<input type="hidden" name="ids[]" value="{{ $l->id }}">@endforeach
                <button class="btn-outline w-full">
                    <i class="fa-solid fa-bolt"></i> Move all {{ $leads->count() }} back to Today
                </button>
            </form>
        </section>

        <ul class="space-y-3">
            @foreach($leads as $i => $l)
                <li class="card-p">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('admin.crm.leads.show', $l) }}" class="font-bold text-brandNavy hover:underline">{{ $l->name }}</a>
                            <p class="text-sm text-slate-500">{{ $l->phone }}</p>
                        </div>
                        <span class="badge-amber shrink-0"><i class="fa-solid fa-hourglass-half"></i> {{ $l->waiting_label }}</span>
                    </div>

                    <p class="mt-2 text-sm text-slate-700">
                        <span class="font-semibold">{{ $l->scheme_interest ?: 'No scheme' }}</span>
                        @if($l->requirement) · {{ $l->requirement }} @endif
                    </p>
                    <p class="mt-1 text-xs text-slate-400">
                        Added {{ $l->created_at->format('d M Y') }}
                        @if($l->next_followup_at) · check again {{ $l->next_followup_at->format('d M') }} @endif
                    </p>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <button type="button" class="btn-teal btn-sm" @click="send({{ $i }})"
                                :disabled="state[{{ $i }}] === 'sending' || state[{{ $i }}] === 'sent'">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span x-text="label({{ $i }})">Send</span>
                        </button>
                        <a :href="phoneLink({{ $i }})" target="_blank" rel="noopener" class="btn-outline btn-sm">
                            <i class="fa-solid fa-mobile-screen"></i> Phone
                        </a>
                        <form method="POST" action="{{ route('admin.crm.leads.waiting.release') }}">
                            @csrf
                            <input type="hidden" name="ids[]" value="{{ $l->id }}">
                            <button class="btn-ghost btn-sm"><i class="fa-solid fa-bolt"></i> Back to Today</button>
                        </form>
                    </div>
                    <p x-show="errors[{{ $i }}]" x-cloak class="mt-2 text-xs text-rose-600" x-text="errors[{{ $i }}]"></p>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('waitingLeads', (cfg) => ({
        rows: cfg.rows,
        template: cfg.template,
        state: {},
        errors: {},

        text(i) {
            const r = this.rows[i];
            return this.template
                .replaceAll('{name}', r.first)
                .replaceAll('{scheme}', r.scheme)
                .replaceAll('{requirement}', r.requirement);
        },

        phoneLink(i) {
            return 'https://wa.me/' + this.rows[i].phone + '?text=' + encodeURIComponent(this.text(i));
        },

        label(i) {
            return { sending: 'Sending…', sent: 'Sent', failed: 'Retry' }[this.state[i]] || 'Send';
        },

        async send(i) {
            this.state[i] = 'sending';
            this.errors[i] = '';

            try {
                const res = await fetch(this.rows[i].send, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ body: this.text(i) }),
                });
                const data = await res.json();

                if (res.ok && data.ok) {
                    this.state[i] = 'sent';
                    return;
                }
                this.errors[i] = data.error || 'Not sent.';
            } catch (e) {
                this.errors[i] = 'Network error — not sent.';
            }
            this.state[i] = 'failed';
        },
    }));
});
</script>
@endsection
