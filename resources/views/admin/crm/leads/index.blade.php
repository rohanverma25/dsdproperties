@extends('admin.layouts.app')
@section('page-title', 'All Leads')

@section('content')
<div class="mx-auto max-w-3xl">
    @include('admin.crm.leads.partials.nav')

    <form method="GET" action="{{ route('admin.crm.leads.all') }}" class="card-p mb-5">
        <div class="flex gap-2">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                <input type="search" name="q" value="{{ request('q') }}"
                       class="input pl-10" placeholder="Search name or phone" aria-label="Search name or phone">
            </div>
            <button type="submit" class="btn-primary px-5">Search</button>
        </div>

        <div class="mt-3 grid grid-cols-2 gap-2">
            <select name="stage" onchange="this.form.submit()" class="input input-sm" aria-label="Stage">
                <option value="">All stages</option>
                @foreach(\App\Models\CrmLead::STAGES as $s)
                    <option value="{{ $s }}" @selected(request('stage') === $s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                @endforeach
            </select>
            <select name="scheme_interest" onchange="this.form.submit()" class="input input-sm" aria-label="Scheme">
                <option value="">All schemes</option>
                @foreach($schemes as $s)
                    <option value="{{ $s }}" @selected(request('scheme_interest') === $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="mb-3 flex items-center justify-between">
        <p class="text-sm text-slate-500">{{ $leads->total() }} {{ Str::plural('lead', $leads->total()) }}</p>
        <a href="{{ route('admin.crm.leads.import.form') }}"
           class="text-sm font-semibold text-brandNavy hover:underline">
            <i class="fa-solid fa-file-csv"></i> CSV import
        </a>
    </div>

    @forelse($leads as $lead)
        @include('admin.crm.leads.partials.card', ['lead' => $lead])
    @empty
        <div class="card px-6 py-14 text-center">
            <p class="text-base font-semibold text-slate-700">No leads found</p>
            <p class="mt-1 text-sm text-slate-500">Try clearing the filters above.</p>
        </div>
    @endforelse

    <div class="mt-5">{{ $leads->links() }}</div>
</div>

@include('admin.crm.leads.partials.log-modal')
@endsection
