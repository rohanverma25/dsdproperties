@extends('admin.layouts.app')
@section('page-title', 'Sellers')

@section('content')
<div class="mx-auto max-w-6xl">

    <div class="mb-5">
        <h2 class="text-lg font-bold text-brandNavy">Seller Accounts</h2>
        <p class="mt-0.5 text-sm text-slate-500">
            Everyone who registered to list a property. Call or WhatsApp a seller directly — the
            WhatsApp message is pre-filled based on how far they got, so you can chase the ones who
            signed up but never listed anything.
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

    <form method="GET" action="{{ route('admin.sellers.index') }}" class="card-p mb-5">
        <div class="flex flex-col gap-2 sm:flex-row">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <input type="search" name="q" value="{{ request('q') }}" class="input pl-10"
                       placeholder="Search name or email" aria-label="Search sellers">
            </div>

            <button type="submit" class="btn-primary px-5">Search</button>
        </div>

        @if(request('q'))
            <a href="{{ route('admin.sellers.index') }}" class="mt-2 inline-block text-sm font-semibold text-slate-500 hover:text-brandNavy">
                <i class="fa-solid fa-xmark"></i> Clear search
            </a>
        @endif
    </form>

    <p class="mb-3 text-sm text-slate-500">
        {{ number_format($sellers->total()) }} {{ Str::plural('seller', $sellers->total()) }}
    </p>

    @if($sellers->isEmpty())
        <div class="card px-6 py-14 text-center">
            <p class="text-base font-semibold text-slate-700">
                {{ request('q') ? 'No sellers match that search' : 'No sellers have registered yet' }}
            </p>
        </div>
    @else

        {{-- Phone: one card per seller. --}}
        <div class="space-y-3 lg:hidden">
            @foreach($sellers as $seller)
                @include('admin.sellers.partials.entry', ['seller' => $seller, 'as' => 'card'])
            @endforeach
        </div>

        {{-- Desktop: table. --}}
        <div class="card hidden overflow-hidden lg:block">
            <table class="w-full text-left">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">Seller</th>
                        <th class="px-4 py-3">Contact</th>
                        <th class="px-4 py-3">Listings</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 whitespace-nowrap">Joined</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($sellers as $seller)
                        @include('admin.sellers.partials.entry', ['seller' => $seller, 'as' => 'row'])
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-5">{{ $sellers->withQueryString()->links() }}</div>
</div>
@endsection
