@php
    // Shared with the CRM module: strips non-digits and applies the 91 country
    // code only when it is actually missing, so numbers already stored as
    // 91XXXXXXXXXX are not double-prefixed into a dead link.
    $dial = \App\Models\CrmLead::normalisePhone($enquiry->mobile);

    $waText = rawurlencode(
        'Hi ' . $enquiry->name . ', this is DSD Properties. Thanks for reaching out regarding: "'
        . \Illuminate\Support\Str::limit($enquiry->suggestion, 100) . '"'
    );
@endphp

@if($as === 'card')

    <article class="card p-4">
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <p class="truncate text-base font-bold text-brandNavy">{{ $enquiry->name }}</p>
                <p class="mt-0.5 text-sm text-slate-500">{{ $enquiry->mobile }}</p>
                @if($enquiry->email)
                    <a href="mailto:{{ $enquiry->email }}"
                       class="mt-0.5 block truncate text-sm text-brandNavy underline decoration-slate-300">{{ $enquiry->email }}</a>
                @endif
            </div>
            <span class="shrink-0 text-xs text-slate-400">{{ $enquiry->created_at->format('d M') }}</span>
        </div>

        @if($enquiry->suggestion)
            <p class="mt-3 rounded-xl bg-slate-50 px-3 py-2 text-sm leading-relaxed text-slate-600">
                {{ $enquiry->suggestion }}
            </p>
        @endif

        @if($enquiry->page_url)
            <p class="mt-2 break-all text-xs text-slate-400">{{ $enquiry->page_url }}</p>
        @endif

        <div class="mt-3 flex gap-2">
            <a href="tel:+{{ $dial }}" class="btn-success flex-1">
                <i class="fa-solid fa-phone"></i> Call
            </a>
            <a href="https://wa.me/{{ $dial }}" target="_blank" rel="noopener" class="btn-outline flex-1">
                <i class="fa-brands fa-whatsapp text-emerald-600"></i> Chat
            </a>
            <a href="https://wa.me/{{ $dial }}?text={{ $waText }}" target="_blank" rel="noopener"
               class="btn-outline shrink-0 px-3" title="Send reply template">
                <i class="fa-solid fa-paper-plane text-slate-500"></i>
            </a>
        </div>
    </article>

@else

    <tr class="align-top hover:bg-slate-50/60">
        <td class="px-4 py-3">
            <p class="font-semibold text-brandNavy">{{ $enquiry->name }}</p>
            <p class="mt-0.5 text-sm text-slate-500">{{ $enquiry->mobile }}</p>
            @if($enquiry->email)
                <a href="mailto:{{ $enquiry->email }}"
                   class="mt-0.5 block break-all text-xs text-slate-500 underline decoration-slate-300">{{ $enquiry->email }}</a>
            @endif
        </td>
        <td class="max-w-sm px-4 py-3 text-sm text-slate-600">{{ $enquiry->suggestion ?: '—' }}</td>
        <td class="max-w-[14rem] break-all px-4 py-3 text-xs text-slate-400">{{ $enquiry->page_url ?: '—' }}</td>
        <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">
            {{ $enquiry->created_at->format('d M Y') }}<br>
            <span class="text-slate-400">{{ $enquiry->created_at->format('g:i A') }}</span>
        </td>
        <td class="px-4 py-3">
            <div class="flex justify-end gap-2">
                <a href="tel:+{{ $dial }}" class="btn-success btn-sm" title="Call {{ $enquiry->name }}">
                    <i class="fa-solid fa-phone"></i> Call
                </a>
                <a href="https://wa.me/{{ $dial }}" target="_blank" rel="noopener"
                   class="btn-outline btn-sm" title="Open chat / read history">
                    <i class="fa-brands fa-whatsapp text-emerald-600"></i> Chat
                </a>
                <a href="https://wa.me/{{ $dial }}?text={{ $waText }}" target="_blank" rel="noopener"
                   class="btn-outline btn-sm" title="Send reply template">
                    <i class="fa-solid fa-paper-plane text-slate-500"></i>
                </a>
            </div>
        </td>
    </tr>

@endif
