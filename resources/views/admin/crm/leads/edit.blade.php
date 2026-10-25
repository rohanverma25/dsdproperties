@extends('admin.layouts.app')
@section('page-title', 'Edit Lead')

@section('content')
<div class="mx-auto max-w-3xl">
    @include('admin.crm.leads.partials.nav')

    <div class="mb-4 flex items-center gap-3">
        <a href="{{ route('admin.crm.leads.show', $lead) }}"
           class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-brandNavy" aria-label="Back to lead">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h2 class="truncate text-lg font-bold text-brandNavy">{{ $lead->name }}</h2>
    </div>

    <form method="POST" action="{{ route('admin.crm.leads.update', $lead) }}">
        @csrf @method('PUT')
        @include('admin.crm.leads.partials.form')
        <button type="submit" class="btn-primary mt-5 w-full">
            <i class="fa-solid fa-floppy-disk"></i> Update Lead
        </button>
    </form>

    <form method="POST" action="{{ route('admin.crm.leads.destroy', $lead) }}"
          onsubmit="return confirm('Delete this lead?');" class="mt-3">
        @csrf @method('DELETE')
        <button type="submit" class="btn-ghost w-full text-rose-600 hover:bg-rose-50">
            <i class="fa-solid fa-trash"></i> Delete Lead
        </button>
    </form>
</div>
@endsection
