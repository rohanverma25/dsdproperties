@extends('admin.layouts.app')
@section('page-title', 'Today')

@section('content')
<div class="mx-auto max-w-3xl">
    @include('admin.crm.leads.partials.nav')

    <div class="mb-5 flex items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.12em] text-slate-400">Due today</p>
            <p class="text-3xl font-bold leading-tight text-brandNavy">{{ $dueCount }}</p>
        </div>
        @if($overdueCount > 0)
            <span class="badge-amber">{{ $overdueCount }} overdue — clear these first</span>
        @endif
    </div>

    @forelse($leads as $lead)
        @include('admin.crm.leads.partials.card', ['lead' => $lead])
    @empty
        <div class="card px-6 py-14 text-center">
            <div class="mx-auto mb-4 grid h-14 w-14 place-items-center rounded-full bg-emerald-50">
                <i class="fa-solid fa-check text-xl text-emerald-600"></i>
            </div>
            <p class="text-lg font-semibold text-brandNavy">No follow-ups left for today</p>
            <p class="mt-1 text-sm text-slate-500">Nothing is waiting on you right now.</p>
            <a href="{{ route('admin.crm.leads.create') }}" class="btn-teal mt-5 inline-flex">
                <i class="fa-solid fa-plus"></i> Add a new lead
            </a>
        </div>
    @endforelse
</div>

@include('admin.crm.leads.partials.log-modal')
@endsection
