@php
    $wa        = $lead->whatsapp_phone;
    $lastNote  = $lead->last_note;
    // Set by CrmLead::loadWhatsappSummary on the list screens.
    $lastWa    = $lead->relationLoaded('latestWhatsapp') ? $lead->latestWhatsapp : null;
    $templates = config('crm.whatsapp_templates');
    $overdue   = $lead->is_overdue;

    $stageTone = match ($lead->stage) {
        'won'                    => 'badge-green',
        'lost', 'dormant'        => 'badge-slate',
        'site_visit','negotiation' => 'badge-teal',
        default                  => 'badge-slate',
    };
@endphp

<article @class([
    'card overflow-hidden mb-3.5',
    'border-l-[5px] border-l-brandOrange bg-amber-50/40' => $overdue,
    'border-l-[5px] border-l-slate-200' => ! $overdue,
])>
    <div class="p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <a href="{{ route('admin.crm.leads.show', $lead) }}"
                   class="block truncate text-[17px] font-bold text-brandNavy hover:underline">
                    {{ $lead->name }}
                </a>
                <p class="mt-0.5 text-sm text-slate-500">{{ $lead->phone }}</p>
            </div>
            <span class="{{ $stageTone }} shrink-0">{{ str_replace('_', ' ', $lead->stage) }}</span>
        </div>

        @if($lead->scheme_interest || $lead->budget_label)
            <div class="mt-2.5 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-slate-600">
                @if($lead->scheme_interest)
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot text-xs text-slate-400"></i>{{ $lead->scheme_interest }}
                    </span>
                @endif
                @if($lead->budget_label)
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-indian-rupee-sign text-xs text-slate-400"></i>{{ $lead->budget_label }}
                    </span>
                @endif
            </div>
        @endif

        @if($lead->waiting_for || $lead->requirement)
            <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-slate-600">
                @if($lead->waiting_for)
                    <span class="badge-amber"><i class="fa-solid fa-hourglass-half"></i> {{ $lead->waiting_label }}</span>
                @endif
                @if($lead->requirement)
                    <span>{{ $lead->requirement }}</span>
                @endif
            </div>
        @endif

        <div class="mt-2.5 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold">
            @if($lead->next_followup_at)
                <span class="{{ $overdue ? 'text-amber-700' : 'text-slate-500' }}">
                    <i class="fa-regular fa-clock"></i>
                    {{ $lead->next_followup_at->format('d M') }}
                    @if($overdue) · {{ $lead->next_followup_at->diffInDays(now()) }}d overdue @endif
                </span>
            @else
                <span class="text-slate-400"><i class="fa-regular fa-clock"></i> {{ $lead->waiting_for ? 'On hold, no date' : 'No follow-up date' }}</span>
            @endif
            @if($lead->no_answer_count > 0)
                <span class="text-slate-400">{{ $lead->no_answer_count }}× no answer</span>
            @endif
        </div>

        @if($lastWa)
            {{-- The last WhatsApp line — what to pick up from on the morning call. --}}
            <a href="{{ route('admin.whatsapp.chat', $lastWa->wa_chat_id) }}"
               class="mt-3 block rounded-xl bg-emerald-50 px-3 py-2 text-sm leading-relaxed text-slate-700 hover:bg-slate-50">
                <span class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-semibold text-emerald-700">
                    <i class="fa-brands fa-whatsapp"></i>
                    {{ $lastWa->is_outbound ? 'You' : 'Customer' }} · {{ $lastWa->sent_at->diffForHumans() }}
                    @if($lastWa->awaits_reply)
                        <span class="badge-amber">Your reply pending</span>
                    @endif
                </span>
                <span class="mt-0.5 block">{{ \Illuminate\Support\Str::limit($lastWa->short_text, 140) }}</span>
            </a>
        @endif

        @if($lastNote)
            <p class="mt-3 rounded-xl bg-slate-50 px-3 py-2 text-sm leading-relaxed text-slate-600">
                {{ \Illuminate\Support\Str::limit($lastNote, 140) }}
            </p>
        @endif
    </div>

    <div class="flex gap-2 border-t border-slate-100 bg-slate-50/60 p-3">
        <a href="tel:+{{ $wa }}" class="btn-success flex-1">
            <i class="fa-solid fa-phone"></i> Call
        </a>

        <div class="relative flex-1" x-data="{ open: false }" @keydown.escape.window="open = false">
            <button type="button" @click="open = !open" class="btn-outline w-full" :aria-expanded="open.toString()">
                <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp
            </button>
            <div x-show="open" x-cloak x-transition @click.outside="open = false"
                 class="absolute bottom-full left-0 z-20 mb-2 w-60 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">

                {{-- In-panel inbox: replies are sent from the linked business number
                     and logged against this lead automatically. --}}
                <form method="POST" action="{{ route('admin.whatsapp.start') }}">
                    @csrf
                    <input type="hidden" name="phone" value="{{ $wa }}">
                    <button class="flex w-full items-center gap-2.5 border-b border-slate-100 px-4 py-3 text-left text-sm font-semibold text-brandNavy hover:bg-slate-50">
                        <i class="fa-solid fa-comments text-xs text-slate-400"></i>
                        Chat here in the panel
                    </button>
                </form>

                {{-- No prefilled text: opens the existing chat so past messages
                     can be read before calling. --}}
                <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener"
                   class="flex items-center gap-2.5 border-b border-slate-100 px-4 py-3 text-sm font-semibold text-brandNavy hover:bg-slate-50">
                    <i class="fa-solid fa-clock-rotate-left text-xs text-slate-400"></i>
                    Open chat / read history
                </a>

                @foreach($templates as $tpl)
                    @php
                        $body = strtr($tpl['body'], [
                            '{name}'   => $lead->name,
                            '{scheme}' => $lead->scheme_interest ?: 'the property',
                        ]);
                    @endphp
                    <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode($body) }}" target="_blank" rel="noopener"
                       class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50">{{ $tpl['label'] }}</a>
                @endforeach
            </div>
        </div>

        <button type="button" class="btn-primary flex-1"
                @click="$dispatch('open-log', {
                    action: '{{ route('admin.crm.leads.log', $lead) }}',
                    name: @js($lead->name)
                })">
            <i class="fa-solid fa-pen"></i> Log
        </button>
    </div>
</article>
