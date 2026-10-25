@extends('admin.layouts.app')
@section('page-title', 'New Lead')

@section('content')
<div class="mx-auto max-w-3xl">
    @include('admin.crm.leads.partials.nav')

    @isset($submission)
        @if($submission)
            <div class="card-p mb-5 border-l-4 border-brandNavy bg-slate-50">
                <p class="text-sm font-bold text-brandNavy">
                    Converting a {{ $submission->form_label }} enquiry
                </p>
                <p class="mt-1 text-sm text-slate-600">
                    Received {{ $submission->created_at->format('d M Y, g:i A') }}.
                    Contact details are filled in below — add the requirement and a follow-up date.
                </p>
                @if($submission->email)
                    <p class="mt-1 text-xs text-slate-500">{{ $submission->email }}</p>
                @endif
            </div>
        @endif
    @endisset

    <form method="POST" action="{{ route('admin.crm.leads.store') }}">
        @csrf
        @isset($submission)
            @if($submission)
                {{-- Links the new lead back to the enquiry it came from. --}}
                <input type="hidden" name="from_submission" value="{{ $submission->id }}">
            @endif
        @endisset
        @include('admin.crm.leads.partials.form')
        <button type="submit" class="btn-primary mt-5 w-full">
            <i class="fa-solid fa-floppy-disk"></i> Save Lead
        </button>
    </form>
</div>
@endsection
