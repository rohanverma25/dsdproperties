@extends('admin.layouts.app')
@section('page-title', 'Lead')

@section('content')
@php
    $outcomes = config('crm.outcomes');

    $details = [
        'Phone'               => $lead->phone,
        'Came from'           => $lead->source_channel ? ucfirst($lead->source_channel) : null,
        'Looking to'          => $lead->intent ? ucfirst($lead->intent) : null,
        'Scheme'              => $lead->scheme_interest,
        'Budget'              => $lead->budget_label,
        'Location preference' => $lead->flexible === null ? 'Not sure' : ($lead->flexible ? 'Anywhere' : 'This area only'),
        'Stage'               => ucfirst(str_replace('_', ' ', $lead->stage)),
        'Last contacted'      => $lead->last_contact_at?->format('d M Y, g:i a') ?: 'Not yet',
        'No answer'           => $lead->no_answer_count . '&times;',
    ];
@endphp

<div class="mx-auto max-w-3xl">
    @include('admin.crm.leads.partials.nav')

    @include('admin.crm.leads.partials.card', ['lead' => $lead])

    <a href="{{ route('admin.crm.leads.edit', $lead) }}" class="btn-outline mb-5 w-full">
        <i class="fa-solid fa-pen-to-square"></i> Edit details
    </a>

    <section class="card mb-5 overflow-hidden">
        <h2 class="border-b border-slate-100 px-5 py-3.5 text-sm font-bold uppercase tracking-wide text-slate-400">
            Details
        </h2>
        <dl class="divide-y divide-slate-100">
            @foreach($details as $term => $value)
                <div class="flex gap-4 px-5 py-3">
                    <dt class="w-2/5 shrink-0 text-sm text-slate-500">{{ $term }}</dt>
                    <dd class="min-w-0 flex-1 text-sm font-medium text-slate-800">{!! $value ?: '&mdash;' !!}</dd>
                </div>
            @endforeach

            <div class="flex gap-4 px-5 py-3">
                <dt class="w-2/5 shrink-0 text-sm text-slate-500">Next follow-up</dt>
                <dd class="min-w-0 flex-1 text-sm font-semibold {{ $lead->is_overdue ? 'text-amber-700' : 'text-slate-800' }}">
                    {{ $lead->next_followup_at?->format('d M Y') ?: '—' }}
                </dd>
            </div>

            <div class="flex gap-4 px-5 py-3">
                <dt class="w-2/5 shrink-0 text-sm text-slate-500">Source page</dt>
                <dd class="min-w-0 flex-1 break-all text-sm">
                    @if($lead->source_page)
                        <a href="{{ $lead->source_page }}" target="_blank" rel="noopener"
                           class="font-medium text-brandNavy hover:underline">{{ $lead->source_page }}</a>
                    @else
                        <span class="text-slate-400">&mdash;</span>
                    @endif
                </dd>
            </div>
        </dl>

        @if($lead->notes)
            <div class="border-t border-slate-100 bg-slate-50/60 px-5 py-4">
                <p class="mb-1 text-xs font-bold uppercase tracking-wide text-slate-400">Notes</p>
                <p class="whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $lead->notes }}</p>
            </div>
        @endif
    </section>

    <section>
        <h2 class="mb-3 text-sm font-bold uppercase tracking-wide text-slate-400">
            Timeline
            <span class="ml-1 font-normal normal-case tracking-normal text-slate-400">({{ $timeline->count() }})</span>
        </h2>

        @if($timeline->isEmpty())
            <div class="card px-6 py-10 text-center">
                <p class="text-sm text-slate-500">No activity logged yet.</p>
            </div>
        @else
            @php $firstChatDay = true; @endphp
            <ol class="relative space-y-4 border-l-2 border-slate-200 pl-5">
                @foreach($timeline as $item)
                    @if($item['kind'] === 'whatsapp')
                        {{-- One day of WhatsApp. Only the newest day starts open. --}}
                        <li class="relative">
                            <span class="absolute -left-[27px] top-1.5 h-3 w-3 rounded-full bg-emerald-500 ring-4 ring-slate-50"></span>
                            <details class="card-p" @if($firstChatDay) open @endif>
                                <summary class="flex cursor-pointer flex-wrap items-center gap-2">
                                    <span class="text-sm font-bold text-brandNavy">
                                        <i class="fa-brands fa-whatsapp text-emerald-600"></i>
                                        WhatsApp · {{ $item['messages']->count() }} {{ \Illuminate\Support\Str::plural('message', $item['messages']->count()) }}
                                    </span>
                                    <span class="text-xs text-slate-400">{{ $item['at']->format('d M Y') }}</span>
                                </summary>
                                <div class="mt-3 space-y-1.5">
                                    @foreach($item['messages'] as $m)
                                        <div @class(['flex', 'justify-end' => $m->is_outbound])>
                                            <div @class([
                                                    'max-w-[80%] rounded-xl px-3 py-1.5 text-sm',
                                                    'bg-brandTeal/25 text-slate-900' => $m->is_outbound,
                                                    'bg-slate-100 text-slate-800' => ! $m->is_outbound,
                                                ])>
                                                <p class="whitespace-pre-wrap break-words">{{ $m->preview }}</p>
                                                <p class="mt-0.5 text-right text-[10px] text-slate-500">{{ $m->sent_at->format('g:i a') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('admin.whatsapp.chat', $item['messages']->last()->wa_chat_id) }}"
                                   class="mt-3 inline-block text-xs font-semibold text-brandNavy hover:underline">
                                    Open the chat <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </details>
                        </li>
                        @php $firstChatDay = false; @endphp
                        @continue
                    @endif

                    @if($item['kind'] === 'note')
                        <li class="relative">
                            <span class="absolute -left-[27px] top-1.5 h-3 w-3 rounded-full bg-amber-200 ring-4 ring-slate-50"></span>
                            <div class="card-p bg-amber-50">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="text-sm font-bold text-amber-800"><i class="fa-solid fa-note-sticky"></i> Note</p>
                                    <span class="badge-slate">whatsapp inbox</span>
                                </div>
                                <p class="mt-0.5 text-xs text-slate-400">{{ $item['at']->format('d M Y, g:i a') }}</p>
                                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-700">{{ $item['message']->body }}</p>
                            </div>
                        </li>
                        @continue
                    @endif

                    @php
                        $a = $item['activity'];
                        $dot = match (true) {
                            in_array($a->outcome, ['interested', 'site_visit_fixed'], true) => 'bg-emerald-500',
                            $a->outcome === 'not_interested'                                => 'bg-rose-500',
                            $a->outcome === 'no_answer'                                     => 'bg-slate-400',
                            default                                                          => 'bg-brandTeal',
                        };
                    @endphp
                    <li class="relative">
                        <span class="absolute -left-[27px] top-1.5 h-3 w-3 rounded-full ring-4 ring-slate-50 {{ $dot }}"></span>
                        <div class="card-p">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-bold text-brandNavy">
                                    {{ $a->outcome ? ($outcomes[$a->outcome]['label'] ?? $a->outcome) : ucfirst($a->type) }}
                                </p>
                                <span class="badge-slate">{{ $a->type }}</span>
                            </div>
                            <p class="mt-0.5 text-xs text-slate-400">{{ $a->happened_at->format('d M Y, g:i a') }}</p>
                            @if($a->note)
                                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $a->note }}</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        @endif
    </section>
</div>

@include('admin.crm.leads.partials.log-modal')
@endsection
