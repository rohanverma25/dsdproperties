@extends('admin.layouts.app')
@section('page-title', 'Enquiries')

@section('content')
<div class="mx-auto max-w-6xl">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-brandNavy">Enquiries</h2>
        <p class="mt-0.5 text-sm text-slate-500">
            Every form on the site lands here — contact us, the blog sidebar and the exit-intent popup.
            Call or message directly, or convert an enquiry into a CRM lead.
        </p>
    </div>

    {{-- Full class names, not interpolated ones — Tailwind only keeps classes it can see. --}}
    @foreach(['success' => 'border-emerald-500', 'info' => 'border-sky-500', 'error' => 'border-rose-500'] as $key => $border)
        @if(session($key))
            <div class="card-p mb-4 border-l-4 {{ $border }} text-sm text-slate-700">
                {{ session($key) }}
            </div>
        @endif
    @endforeach

    <form method="GET" action="{{ route('admin.enquiries.index') }}" class="card-p mb-5">
        <div class="flex flex-col gap-2 sm:flex-row">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <input type="search" name="q" value="{{ request('q') }}" class="input pl-10"
                       placeholder="Search name, number, email or message" aria-label="Search enquiries">
            </div>

            <select name="form" class="input sm:w-48" aria-label="Filter by form">
                <option value="">All forms</option>
                @foreach($forms as $value => $label)
                    <option value="{{ $value }}" @selected(request('form') === $value)>{{ $label }}</option>
                @endforeach
            </select>

            <select name="status" class="input sm:w-40" aria-label="Filter by status">
                <option value="">Any status</option>
                @foreach($statuses as $value)
                    <option value="{{ $value }}" @selected(request('status') === $value)>{{ ucfirst($value) }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-primary px-5">Search</button>
        </div>

        @if(request()->boolean('unhandled'))
            <input type="hidden" name="unhandled" value="1">
        @endif

        <div class="mt-2 text-sm">
            @if(request()->boolean('unhandled'))
                <span class="badge-amber">Showing not handled only</span>
            @elseif($unhandledCount > 0)
                <a href="{{ route('admin.enquiries.index', ['unhandled' => 1]) }}" class="font-semibold text-amber-700 hover:text-brandNavy">
                    <i class="fa-solid fa-inbox"></i> {{ $unhandledCount }} not handled in the last {{ \App\Models\FormSubmission::UNHANDLED_DAYS }} days
                </a>
            @else
                <span class="text-slate-400"><i class="fa-solid fa-check"></i> Nothing left to handle</span>
            @endif
        </div>

        @if(request()->hasAny(['q', 'form', 'status', 'unhandled']))
            <a href="{{ route('admin.enquiries.index') }}" class="mt-2 inline-block text-sm font-semibold text-slate-500 hover:text-brandNavy">
                <i class="fa-solid fa-xmark"></i> Clear filters
            </a>
        @endif

        @unless(request('form'))
            <p class="mt-2 text-xs text-slate-400">
                Newsletter sign-ups are hidden — pick them from the form filter to see them.
            </p>
        @endunless
    </form>

    <p class="mb-3 text-sm text-slate-500">
        {{ $submissions->total() }} {{ Str::plural('enquiry', $submissions->total()) }}
    </p>

    @if($submissions->isEmpty())
        <div class="card px-6 py-14 text-center">
            <p class="text-base font-semibold text-slate-700">
                {{ request()->hasAny(['q', 'form', 'status', 'unhandled']) ? 'No enquiries match those filters' : 'No enquiries received yet' }}
            </p>
        </div>
    @else

        {{-- Phone: one card per enquiry. --}}
        <div class="space-y-3 lg:hidden">
            @foreach($submissions as $submission)
                @include('admin.form-submissions.partials.entry', ['submission' => $submission, 'as' => 'card'])
            @endforeach
        </div>

        {{-- Desktop: table. --}}
        <div class="card hidden overflow-hidden lg:block">
            <table class="w-full text-left">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">Contact</th>
                        <th class="px-4 py-3">Message</th>
                        <th class="px-4 py-3">Form / Page</th>
                        <th class="px-4 py-3 whitespace-nowrap">Received</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($submissions as $submission)
                        @include('admin.form-submissions.partials.entry', ['submission' => $submission, 'as' => 'row'])
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-5">{{ $submissions->links() }}</div>
</div>
@endsection
