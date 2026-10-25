@php
    // Same normalisation the CRM and enquiries inboxes use: digits only, with 91
    // applied only when it is actually missing, so numbers already stored as
    // 91XXXXXXXXXX are not double-prefixed into a dead link. The whatsapp column
    // is optional on a seller, so each channel falls back to the other.
    $waNumber   = \App\Models\CrmLead::normalisePhone($seller->whatsapp ?: $seller->phone);
    $dialNumber = \App\Models\CrmLead::normalisePhone($seller->phone ?: $seller->whatsapp);

    $firstName = $seller->name ? explode(' ', trim($seller->name))[0] : null;
    $greeting  = $firstName ? 'Hi ' . $firstName : 'Hello';

    // Drives the "Signup n/3" badge below — the message itself is the same for
    // every seller, so this no longer affects the WhatsApp text.
    $signupIncomplete = $seller->registration_step && $seller->registration_step < 3;

    // One pre-filled follow-up for every seller, so you always know what WhatsApp
    // will open with. Edit this string to change it everywhere.
    //
    // The domain is hardcoded rather than route('seller.register') on purpose:
    // APP_URL is http://localhost in local .env, so route() would paste a
    // localhost link into a real seller's WhatsApp when composed from a dev
    // machine. Matches how the sitemap holds this URL in routes/web.php.
    $waBody = $greeting . ', this is DSD Properties. We noticed you started creating your'
        . ' seller account, but the sign-up was left incomplete. Did you run into any'
        . ' problems? Reply here, and we will help you finish it.'
        . "\n\nYou can continue here: https://dsdproperties.in/seller/register";

    $waLink   = $waNumber ? 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($waBody) : null;
    $initial  = Str::upper(Str::substr(trim((string) $seller->name) ?: '?', 0, 1));
    $waTitle  = 'Opens WhatsApp with a pre-filled follow-up you can edit before sending';
@endphp

@if($as === 'card')

    <article class="card p-4">
        <div class="flex items-start gap-3">
            @if($seller->profile_photo)
                <img src="{{ asset($seller->profile_photo) }}" alt=""
                     class="h-11 w-11 shrink-0 rounded-full border border-slate-200 object-cover">
            @else
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full
                             border border-slate-200 bg-slate-100 text-base font-bold text-slate-500">
                    {{ $initial }}
                </span>
            @endif

            <div class="min-w-0 flex-1">
                <p class="truncate text-base font-bold text-brandNavy">{{ $seller->name ?: '—' }}</p>
                @if($seller->city)
                    <p class="mt-0.5 text-xs text-slate-400">
                        <i class="fa-solid fa-location-dot"></i> {{ $seller->city }}
                    </p>
                @endif
            </div>

            <span class="shrink-0 {{ $seller->status === 'suspended' ? 'badge-rose' : 'badge-green' }}">
                {{ $seller->status === 'suspended' ? 'Suspended' : 'Active' }}
            </span>
        </div>

        <div class="mt-3 space-y-1">
            @if($seller->email)
                <a href="mailto:{{ $seller->email }}"
                   class="block break-all text-sm text-slate-500 underline decoration-slate-300">{{ $seller->email }}</a>
            @endif
            @if($seller->phone)
                <p class="text-sm text-slate-500">{{ $seller->phone }}</p>
            @endif
            @if(!$seller->email && !$seller->phone)
                <p class="text-sm text-slate-400">No contact details on file</p>
            @endif
        </div>

        <div class="mt-3 flex flex-wrap items-center gap-2">
            @if($seller->listings_count > 0)
                <span class="badge-teal">
                    {{ $seller->listings_count }} {{ Str::plural('listing', $seller->listings_count) }}
                </span>
            @else
                <span class="badge-slate">No listing yet</span>
            @endif

            @if($signupIncomplete)
                <span class="badge-amber" title="Signup wizard not finished">
                    Signup {{ $seller->registration_step }}/3
                </span>
            @endif

            @if($seller->created_at)
                <span class="text-xs text-slate-400">Joined {{ $seller->created_at->diffForHumans() }}</span>
            @endif
        </div>

        <div class="mt-3 flex gap-2">
            @if($dialNumber)
                <a href="tel:+{{ $dialNumber }}" class="btn-success flex-1">
                    <i class="fa-solid fa-phone"></i> Call
                </a>
            @endif

            @if($waLink)
                <a href="{{ $waLink }}" target="_blank" rel="noopener"
                   class="btn-outline flex-1" title="{{ $waTitle }}">
                    <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp
                </a>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.sellers.impersonate', $seller->id) }}" class="mt-2">
            @csrf
            <button type="submit" class="btn-primary w-full">
                <i class="fa-solid fa-right-to-bracket"></i> Login as this seller
            </button>
        </form>
    </article>

@else

    <tr class="align-top hover:bg-slate-50/60">
        <td class="px-4 py-3">
            <div class="flex items-start gap-3">
                @if($seller->profile_photo)
                    <img src="{{ asset($seller->profile_photo) }}" alt=""
                         class="h-10 w-10 shrink-0 rounded-full border border-slate-200 object-cover">
                @else
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full
                                 border border-slate-200 bg-slate-100 text-sm font-bold text-slate-500">
                        {{ $initial }}
                    </span>
                @endif
                <div class="min-w-0">
                    <p class="truncate font-semibold text-brandNavy">{{ $seller->name ?: '—' }}</p>
                    <p class="mt-0.5 text-xs text-slate-400">
                        #{{ $seller->id }}@if($seller->city) · {{ $seller->city }}@endif
                    </p>
                </div>
            </div>
        </td>

        <td class="max-w-[16rem] px-4 py-3">
            @if($seller->email)
                <a href="mailto:{{ $seller->email }}"
                   class="block break-all text-sm text-slate-500 underline decoration-slate-300">{{ $seller->email }}</a>
            @endif
            @if($seller->phone)
                <p class="mt-0.5 text-sm text-slate-500">{{ $seller->phone }}</p>
            @endif
            @if(!$seller->email && !$seller->phone)
                <span class="text-sm text-slate-400">—</span>
            @endif
        </td>

        <td class="px-4 py-3">
            @if($seller->listings_count > 0)
                <span class="badge-teal">{{ $seller->listings_count }}</span>
            @else
                <span class="badge-slate">None</span>
            @endif
        </td>

        <td class="px-4 py-3">
            <span class="{{ $seller->status === 'suspended' ? 'badge-rose' : 'badge-green' }}">
                {{ $seller->status === 'suspended' ? 'Suspended' : 'Active' }}
            </span>
            @if($signupIncomplete)
                <span class="mt-1 block">
                    <span class="badge-amber" title="Signup wizard not finished">
                        Signup {{ $seller->registration_step }}/3
                    </span>
                </span>
            @endif
        </td>

        <td class="whitespace-nowrap px-4 py-3 text-xs text-slate-500">
            @if($seller->created_at)
                {{ $seller->created_at->format('d M Y') }}<br>
                <span class="text-slate-400">{{ $seller->created_at->diffForHumans() }}</span>
            @else
                —
            @endif
        </td>

        <td class="px-4 py-3">
            <div class="flex flex-wrap justify-end gap-2">
                @if($dialNumber)
                    <a href="tel:+{{ $dialNumber }}" class="btn-success btn-sm"
                       title="Call {{ $seller->name }}">
                        <i class="fa-solid fa-phone"></i> Call
                    </a>
                @endif

                @if($waLink)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener"
                       class="btn-outline btn-sm whitespace-nowrap" title="{{ $waTitle }}">
                        <i class="fa-brands fa-whatsapp text-emerald-600"></i> WhatsApp
                    </a>
                @endif

                <form method="POST" action="{{ route('admin.sellers.impersonate', $seller->id) }}">
                    @csrf
                    <button type="submit" class="btn-outline btn-sm whitespace-nowrap">
                        <i class="fa-solid fa-right-to-bracket"></i> Login as
                    </button>
                </form>
            </div>

            @if(!$dialNumber && !$waLink)
                <p class="mt-1 text-right text-xs text-slate-400">No phone number on file</p>
            @endif
        </td>
    </tr>

@endif
