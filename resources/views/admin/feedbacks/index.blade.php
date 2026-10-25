@extends('admin.layouts.app')
@section('page-title', 'Enquiries')

@section('content')
<div class="mx-auto max-w-5xl">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-brandNavy">User Enquiries</h2>
        <p class="mt-0.5 text-sm text-slate-500">
            Collected by the exit-intent popup on blog pages. Call or message directly from here.
        </p>
    </div>

    <form method="GET" action="{{ route('admin.enquiries.index') }}" class="card-p mb-5">
        <div class="flex gap-2">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <input type="search" name="q" value="{{ request('q') }}" class="input pl-10"
                       placeholder="Search name, number or requirement" aria-label="Search enquiries">
            </div>
            <button type="submit" class="btn-primary px-5">Search</button>
        </div>
        @if(request('q'))
            <a href="{{ route('admin.enquiries.index') }}" class="mt-2 inline-block text-sm font-semibold text-slate-500 hover:text-brandNavy">
                <i class="fa-solid fa-xmark"></i> Clear search
            </a>
        @endif
    </form>

    <p class="mb-3 text-sm text-slate-500">
        {{ $enquiries->total() }} {{ Str::plural('enquiry', $enquiries->total()) }}
    </p>

    @if($enquiries->isEmpty())
        <div class="card px-6 py-14 text-center">
            <p class="text-base font-semibold text-slate-700">
                {{ request('q') ? 'No enquiries match that search' : 'No enquiries received yet' }}
            </p>
            @if(request('q'))
                <p class="mt-1 text-sm text-slate-500">Try a different name or number.</p>
            @endif
        </div>
    @else

        {{-- Phone: one card per enquiry. --}}
        <div class="space-y-3 lg:hidden">
            @foreach($enquiries as $enquiry)
                @include('admin.feedbacks.partials.actions', ['enquiry' => $enquiry, 'as' => 'card'])
            @endforeach
        </div>

        {{-- Desktop: table. --}}
        <div class="card hidden overflow-hidden lg:block">
            <table class="w-full text-left">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Requirement</th>
                        <th class="px-4 py-3">Page</th>
                        <th class="px-4 py-3 whitespace-nowrap">Received</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($enquiries as $enquiry)
                        @include('admin.feedbacks.partials.actions', ['enquiry' => $enquiry, 'as' => 'row'])
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-5">{{ $enquiries->links() }}</div>
</div>
@endsection
