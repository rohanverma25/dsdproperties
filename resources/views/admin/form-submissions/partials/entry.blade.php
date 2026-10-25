@php
    // Shared with the CRM module: strips non-digits and applies the 91 country
    // code only when it is actually missing, so numbers already stored as
    // 91XXXXXXXXXX are not double-prefixed into a dead link.
    $dial = $submission->dial;

    // Pre-filled WhatsApp reply. Name and message are both optional on a
    // submission, so neither is interpolated blind — an enquiry with no message
    // would otherwise open WhatsApp quoting an empty pair of quotes.
    $waGreeting = $submission->name
        ? 'Hi ' . explode(' ', trim($submission->name))[0]
        : 'Hello';

    $waText = rawurlencode(
        $waGreeting . ', this is DSD Properties. Thanks for reaching out'
        . ($submission->message
            ? ' regarding: "' . \Illuminate\Support\Str::limit($submission->message, 100) . '".'
            : ' to us.')
        . ' How can we help?'
    );

    $statusBadge = [
        'new'       => 'bg-sky-50 text-sky-700',
        'converted' => 'bg-emerald-50 text-emerald-700',
        'spam'      => 'bg-rose-50 text-rose-700',
        'archived'  => 'bg-slate-100 text-slate-500',
    ][$submission->status] ?? 'bg-slate-100 text-slate-500';
@endphp

@if($as === 'card')

    <article class="card p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p class="truncate text-base font-bold text-brandNavy">{{ $submission->name ?: '—' }}</p>
                @if($submission->phone)
                    <p class="mt-0.5 text-sm text-slate-500">{{ $submission->phone }}</p>
                @endif
                @if($submission->email)
                    <a href="mailto:{{ $submission->email }}"
                       class="mt-0.5 block truncate text-sm text-brandNavy underline decoration-slate-300">{{ $submission->email }}</a>
                @endif
            </div>
            <span class="shrink-0 text-right text-xs leading-tight text-slate-400">
                {{ $submission->created_at->format('d M Y') }}<br>
                {{ $submission->created_at->format('g:i A') }}
            </span>
        </div>

        <div class="mt-2 flex flex-wrap items-center gap-2">
            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-600">
                {{ $submission->form_label }}
            </span>
            <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusBadge }}">
                {{ ucfirst($submission->status) }}
            </span>
        </div>

        @if($submission->message)
            <p class="mt-3 rounded-xl bg-slate-50 px-3 py-2 text-sm leading-relaxed text-slate-600">
                {{ $submission->message }}
            </p>
        @endif

        @if($submission->source_page)
            <p class="mt-2 break-all text-xs text-slate-400">{{ $submission->source_page }}</p>
        @endif

        @if($submission->phone)
            <div class="mt-3 flex gap-2">
                <a href="tel:+{{ $dial }}" class="btn-success flex-1">
                    <i class="fa-solid fa-phone"></i> Call
                </a>
                <a href="https://wa.me/{{ $dial }}?text={{ $waText }}" target="_blank" rel="noopener"
                   class="btn-outline flex-1" title="Opens WhatsApp with a pre-filled reply you can edit before sending">
                    <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp
                </a>
            </div>
        @endif

        <div class="mt-2">
            @include('admin.form-submissions.partials.triage', ['submission' => $submission, 'block' => true])
        </div>
    </article>

@else

    <tr class="align-top hover:bg-slate-50/60">
        <td class="px-4 py-3">
            <p class="font-semibold text-brandNavy">{{ $submission->name ?: '—' }}</p>
            @if($submission->phone)
                <p class="mt-0.5 text-sm text-slate-500">{{ $submission->phone }}</p>
            @endif
            @if($submission->email)
                <a href="mailto:{{ $submission->email }}"
                   class="mt-0.5 block break-all text-xs text-slate-500 underline decoration-slate-300">{{ $submission->email }}</a>
            @endif
            <span class="mt-1 inline-block rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusBadge }}">
                {{ ucfirst($submission->status) }}
            </span>
        </td>
        <td class="max-w-sm px-4 py-3 text-sm text-slate-600">{{ $submission->message ?: '—' }}</td>
        <td class="max-w-[14rem] px-4 py-3 text-xs">
            <span class="font-semibold text-slate-600">{{ $submission->form_label }}</span>
            <span class="mt-0.5 block break-all text-slate-400">{{ $submission->source_page ?: '—' }}</span>
        </td>
        <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">
            {{ $submission->created_at->format('d M Y') }}<br>
            <span class="text-slate-400">{{ $submission->created_at->format('g:i A') }}</span>
        </td>
        <td class="px-4 py-3">
            <div class="flex flex-wrap justify-end gap-2">
                @if($submission->phone)
                    <a href="tel:+{{ $dial }}" class="btn-success btn-sm" title="Call {{ $submission->name }}">
                        <i class="fa-solid fa-phone"></i> Call
                    </a>
                    <a href="https://wa.me/{{ $dial }}?text={{ $waText }}" target="_blank" rel="noopener"
                       class="btn-outline btn-sm whitespace-nowrap"
                       title="Opens WhatsApp with a pre-filled reply you can edit before sending">
                        <i class="fa-brands fa-whatsapp text-emerald-600"></i> Send reply template
                    </a>
                @endif
                @include('admin.form-submissions.partials.triage', ['submission' => $submission, 'block' => false])
            </div>
        </td>
    </tr>

@endif
