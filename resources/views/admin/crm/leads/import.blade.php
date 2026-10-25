@extends('admin.layouts.app')
@section('page-title', 'CSV Import')

@section('content')
<div class="mx-auto max-w-3xl">
    @include('admin.crm.leads.partials.nav')

    <div class="mb-5">
        <h2 class="text-lg font-bold text-brandNavy">CSV import</h2>
        <p class="mt-0.5 text-sm text-slate-500">
            One-time backfill. Numbers that already exist will be skipped.
        </p>
    </div>

    @if(! $headers)
        <section class="card-p">
            <div class="mb-4 flex items-center gap-3">
                <span class="grid h-8 w-8 place-items-center rounded-full bg-brandNavy text-sm font-bold text-white">1</span>
                <h3 class="text-base font-bold text-brandNavy">Choose the file</h3>
            </div>

            <form method="POST" action="{{ route('admin.crm.leads.import.headers') }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".csv,.txt" required
                       class="block w-full text-sm text-slate-600
                              file:mr-4 file:rounded-xl file:border-0 file:bg-brandNavy file:px-4 file:py-3
                              file:text-sm file:font-semibold file:text-white hover:file:bg-[#02306f]">
                <button type="submit" class="btn-primary mt-4 w-full">Read columns</button>
            </form>
        </section>
    @else
        <section class="card-p">
            <div class="mb-4 flex items-center gap-3">
                <span class="grid h-8 w-8 place-items-center rounded-full bg-brandNavy text-sm font-bold text-white">2</span>
                <h3 class="text-base font-bold text-brandNavy">Map the columns</h3>
            </div>

            <form method="POST" action="{{ route('admin.crm.leads.import') }}" enctype="multipart/form-data">
                @csrf

                <p class="mb-2 text-sm text-slate-500">Choose the same file again, then pick the CSV column for each field.</p>
                <input type="file" name="file" accept=".csv,.txt" required
                       class="mb-5 block w-full text-sm text-slate-600
                              file:mr-4 file:rounded-xl file:border-0 file:bg-slate-200 file:px-4 file:py-3
                              file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-300">

                <div class="space-y-2">
                    @foreach($mappable as $field => $label)
                        <div class="grid grid-cols-5 items-center gap-3">
                            <label class="col-span-2 text-sm font-medium text-slate-700" for="map-{{ $field }}">
                                {{ $label }}@if($field === 'phone')<span class="text-rose-500">&nbsp;*</span>@endif
                            </label>
                            <select class="input input-sm col-span-3" id="map-{{ $field }}" name="map[{{ $field }}]">
                                <option value="">&mdash; skip &mdash;</option>
                                @foreach($headers as $h)
                                    <option value="{{ $h }}"
                                        @selected(old("map.$field", strtolower($h) === $field ? $h : null) === $h)>{{ $h }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>

                <hr class="my-5 border-slate-200">

                <label class="label" for="imp-followup">
                    First follow-up date for all imported leads <span class="text-rose-500">*</span>
                </label>
                <input type="date" class="input" id="imp-followup" name="next_followup_at"
                       value="{{ old('next_followup_at', now()->addDay()->format('Y-m-d')) }}" required>

                <button type="submit" class="btn-primary mt-5 w-full">
                    <i class="fa-solid fa-file-import"></i> Import
                </button>
            </form>
        </section>
    @endif
</div>
@endsection
