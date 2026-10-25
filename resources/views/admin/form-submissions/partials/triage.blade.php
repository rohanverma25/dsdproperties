{{-- Convert / spam / archive. Shared by the card and table layouts. --}}
@php
    $isSpam = $submission->status === 'spam';
@endphp

<div class="flex flex-wrap gap-2 {{ $block ? '' : 'justify-end' }}">

    @if($submission->crm_lead_id)
        <a href="{{ route('admin.crm.leads.show', $submission->crm_lead_id) }}"
           class="btn-outline btn-sm {{ $block ? 'flex-1' : '' }}" title="Open the lead this became">
            <i class="fa-solid fa-user-check text-emerald-600"></i> View lead
        </a>
    @elseif($submission->is_convertible)
        <form method="POST" action="{{ route('admin.enquiries.convert', $submission) }}" class="{{ $block ? 'flex-1' : '' }}">
            @csrf
            <button type="submit" class="btn-primary btn-sm w-full" title="Create a CRM lead from this enquiry">
                <i class="fa-solid fa-user-plus"></i> Convert to lead
            </button>
        </form>
    @endif

    @if($submission->status !== 'converted')
        <form method="POST" action="{{ route('admin.enquiries.status', $submission) }}">
            @csrf
            <input type="hidden" name="status" value="{{ $isSpam ? 'new' : 'spam' }}">
            <button type="submit" class="btn-outline btn-sm"
                    title="{{ $isSpam ? 'Put back in the inbox' : 'Mark as spam' }}">
                <i class="fa-solid {{ $isSpam ? 'fa-rotate-left' : 'fa-ban' }} text-slate-500"></i>
            </button>
        </form>

        @if($submission->status !== 'archived')
            <form method="POST" action="{{ route('admin.enquiries.status', $submission) }}">
                @csrf
                <input type="hidden" name="status" value="archived">
                <button type="submit" class="btn-outline btn-sm" title="Archive — handled, no follow-up needed">
                    <i class="fa-solid fa-box-archive text-slate-500"></i>
                </button>
            </form>
        @endif
    @endif
</div>
