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
            <span class="ml-1 font-normal normal-case tracking-normal text-slate-400">({{ $lead->activities->count() }})</span>
        </h2>

        @if($lead->activities->isEmpty())
            <div class="card px-6 py-10 text-center">
                <p class="text-sm text-slate-500">No activity logged yet.</p>
            </div>
        @else
            <ol class="relative space-y-4 border-l-2 border-slate-200 pl-5">
                @foreach($lead->activities as $a)
                    @php
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
