@php
    $tabs = [
        ['label' => 'Today',     'route' => 'admin.crm.leads.index',  'icon' => 'fa-bolt'],
        ['label' => 'All Leads', 'route' => 'admin.crm.leads.all',    'icon' => 'fa-list'],
        ['label' => 'Waiting',   'route' => 'admin.crm.leads.waiting', 'icon' => 'fa-hourglass-half'],
        ['label' => 'New Lead',  'route' => 'admin.crm.leads.create', 'icon' => 'fa-plus'],
    ];
@endphp

<nav class="mb-5 flex gap-1.5 rounded-2xl border border-slate-200 bg-white p-1.5 shadow-sm">
    @foreach($tabs as $tab)
        @php $on = request()->routeIs($tab['route']); @endphp
        <a href="{{ route($tab['route']) }}"
           @class([
               'flex flex-1 items-center justify-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition-colors',
               'bg-brandNavy text-white shadow-sm' => $on,
               'text-slate-600 hover:bg-slate-100' => ! $on,
           ])>
            <i class="fa-solid {{ $tab['icon'] }} text-xs"></i>
            <span>{{ $tab['label'] }}</span>
        </a>
    @endforeach
</nav>

@foreach(['success' => 'success', 'info' => 'info', 'error' => 'danger'] as $key => $tone)
    @if(session($key))
        <div class="alert-{{ $tone }} mb-4">{{ session($key) }}</div>
    @endif
@endforeach

@if($errors->any())
    <div class="alert-danger mb-4">
        <ul class="list-disc space-y-0.5 pl-4">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif
