@php
    $crmDue    = \App\Models\CrmLead::dueToday()->count();
    $waUnread  = \App\Models\WaChat::where('archived', false)->sum('unread_count');

    $nav = [
        ['group' => 'Leads', 'items' => [
            ['label' => 'Follow-ups', 'icon' => 'fa-phone-volume', 'url' => route('admin.crm.leads.index'), 'active' => 'admin/crm*', 'badge' => $crmDue ?: null],
            ['label' => 'All Leads',  'icon' => 'fa-address-book', 'url' => route('admin.crm.leads.all'),   'active' => null],
            ['label' => 'Enquiries',  'icon' => 'fa-inbox',        'url' => route('admin.enquiries.index'), 'active' => 'admin/enquiries*'],
            ['label' => 'WhatsApp',   'icon' => 'fa-whatsapp',     'url' => route('admin.whatsapp.index'),  'active' => 'admin/whatsapp*', 'badge' => $waUnread ?: null, 'brand' => true],
        ]],
        ['group' => 'Content', 'items' => [
            ['label' => 'Notifications', 'icon' => 'fa-bell', 'url' => route('admin.push.index'), 'active' => 'admin/push*'],
            ['label' => 'Newsletter', 'icon' => 'fa-envelope-open-text', 'url' => route('admin.newsletter.index'), 'active' => 'admin/newsletter*'],
            ['label' => 'Properties', 'icon' => 'fa-building', 'url' => url('admin/properties'), 'active' => 'admin/properties*'],
            ['label' => 'Galleries',  'icon' => 'fa-images',   'url' => url('admin/galleries'),  'active' => 'admin/galleries*'],
            ['label' => 'Comments',   'icon' => 'fa-comments', 'url' => url('admin/comments'),   'active' => 'admin/comments*'],
            ['label' => 'Reviews',    'icon' => 'fa-star',     'url' => url('admin/reviews'),    'active' => 'admin/reviews*'],
        ]],
        ['group' => 'Other', 'items' => [
            ['label' => 'Sellers',    'icon' => 'fa-user-tie',       'url' => url('admin/sellers'),   'active' => 'admin/sellers*'],
            ['label' => 'Campaigns',  'icon' => 'fa-bullhorn',       'url' => url('admin/campaigns'), 'active' => 'admin/campaigns*'],
            ['label' => 'Email Templates', 'icon' => 'fa-envelope-open-text', 'url' => url('admin/templates/create'), 'active' => 'admin/templates*'],
            ['label' => 'Import Leads',    'icon' => 'fa-file-import',        'url' => url('admin/leads/upload'),     'active' => 'admin/leads*'],
        ]],
    ];
@endphp

<div class="flex h-full flex-col">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-5 py-5">
        <span class="grid h-10 w-10 place-items-center rounded-xl bg-brandTeal text-base font-bold text-brandNavy">DSD</span>
        <div class="min-w-0">
            <p class="truncate text-sm font-bold leading-tight text-white">DSD Properties</p>
            <p class="truncate text-[11px] leading-tight text-slate-400">Lead Admin</p>
        </div>
        <button type="button" @click="mobileOpen = false"
                class="ml-auto rounded-lg p-2 text-slate-400 hover:bg-white/10 hover:text-white lg:hidden"
                aria-label="Close menu">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 space-y-6 px-3 pb-6">
        @foreach($nav as $section)
            <div>
                <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[0.12em] text-slate-500">
                    {{ $section['group'] }}
                </p>
                <ul class="space-y-1">
                    @foreach($section['items'] as $item)
                        @php $isActive = $item['active'] && request()->is($item['active']); @endphp
                        <li>
                            <a href="{{ $item['url'] }}" class="nav-item {{ $isActive ? 'nav-item-active' : '' }}">
                                <i class="{{ empty($item['brand']) ? 'fa-solid' : 'fa-brands' }} {{ $item['icon'] }}"></i>
                                <span class="truncate">{{ $item['label'] }}</span>
                                @if(! empty($item['badge']))
                                    <span class="ml-auto rounded-full bg-brandOrange px-2 py-0.5 text-[11px] font-bold text-brandNavy">
                                        {{ $item['badge'] }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    {{-- New lead shortcut --}}
    <div class="px-3 pb-5">
        <a href="{{ route('admin.crm.leads.create') }}" class="btn-teal w-full">
            <i class="fa-solid fa-plus"></i> New Lead
        </a>
    </div>
</div>
