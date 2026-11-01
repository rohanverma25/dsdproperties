@php
    $v = fn($field, $default = null) => old($field, $lead->{$field} ?? $default);
    $closed = in_array(old('stage', $lead->stage ?? 'new'), \App\Models\CrmLead::CLOSED_STAGES, true);

    $sourcePages   = config('crm.source_pages');
    $defaultSource = collect($sourcePages)->filter(fn($p) => $p['default'] ?? false)->keys()->first();
    $flex = old('flexible', isset($lead) && $lead->exists ? ($lead->flexible === null ? '' : (int) $lead->flexible) : '');
@endphp

<div x-data="{ stage: @js(old('stage', $lead->stage ?? 'new')), closed: @js($closed), waiting: @js((string) $v('waiting_for', '')) }"
     x-init="$watch('stage', v => closed = @js(\App\Models\CrmLead::CLOSED_STAGES).includes(v))"
     class="space-y-5">

    <section class="card-p space-y-4">
        <h2 class="text-sm font-bold uppercase tracking-wide text-slate-400">Contact</h2>

        <div>
            <label class="label" for="f-name">Name <span class="text-rose-500">*</span></label>
            <input type="text" class="input" id="f-name" name="name" value="{{ $v('name') }}" required>
        </div>

        <div>
            <label class="label" for="f-phone">Phone <span class="text-rose-500">*</span></label>
            <input type="tel" inputmode="numeric" class="input" id="f-phone" name="phone"
                   value="{{ $v('phone') }}" required>
        </div>
    </section>

    <section class="card-p space-y-4">
        <h2 class="text-sm font-bold uppercase tracking-wide text-slate-400">Requirement</h2>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="label" for="f-channel">Came from</label>
                <select class="input" id="f-channel" name="source_channel">
                    <option value="">&mdash;</option>
                    @foreach(\App\Models\CrmLead::CHANNELS as $c)
                        <option value="{{ $c }}" @selected($v('source_channel') === $c)>{{ ucfirst($c) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label" for="f-intent">Looking to</label>
                <select class="input" id="f-intent" name="intent">
                    @foreach(\App\Models\CrmLead::INTENTS as $i)
                        <option value="{{ $i }}" @selected($v('intent', 'buy') === $i)>{{ ucfirst($i) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="label" for="f-src">Source page</label>
            <select class="input" id="f-src" name="source_page">
                @foreach($sourcePages as $url => $page)
                    <option value="{{ $url }}" @selected($v('source_page', $defaultSource) === $url)>{{ $page['label'] }}</option>
                @endforeach
                {{-- Keep whatever an older lead was saved with, so editing never silently rewrites it. --}}
                @if($v('source_page') && ! array_key_exists($v('source_page'), $sourcePages))
                    <option value="{{ $v('source_page') }}" selected>{{ $v('source_page') }}</option>
                @endif
            </select>
        </div>

        <div>
            <label class="label" for="f-scheme">Scheme</label>
            <input type="text" class="input" id="f-scheme" name="scheme_interest" value="{{ $v('scheme_interest') }}"
                   list="crm-schemes" autocomplete="off">
            <datalist id="crm-schemes">
                @foreach(config('crm.schemes') as $s)<option value="{{ $s }}">@endforeach
            </datalist>
        </div>

        <div>
            <label class="label" for="f-req">Exact requirement</label>
            <input type="text" class="input" id="f-req" name="requirement" value="{{ $v('requirement') }}"
                   maxlength="255" placeholder="e.g. 200 sq m farmer-quota plot, corner, Sector B">
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="label" for="f-bmin">Budget from (&#8377;)</label>
                <input type="number" inputmode="numeric" class="input" id="f-bmin" name="budget_min" value="{{ $v('budget_min') }}">
            </div>
            <div>
                <label class="label" for="f-bmax">Budget up to (&#8377;)</label>
                <input type="number" inputmode="numeric" class="input" id="f-bmax" name="budget_max" value="{{ $v('budget_max') }}">
            </div>
        </div>

        <div>
            <span class="label">Location preference</span>
            <div class="grid grid-cols-3 gap-2">
                @foreach([['0', 'This area only'], ['1', 'Anywhere'], ['', 'Not sure']] as [$val, $label])
                    <label class="flex cursor-pointer items-center justify-center rounded-xl border border-slate-200
                                  px-2 py-3 text-center text-xs font-semibold text-slate-600
                                  has-[:checked]:border-brandTeal has-[:checked]:bg-brandTeal/10 has-[:checked]:text-brandNavy">
                        <input type="radio" name="flexible" value="{{ $val }}" class="sr-only"
                               @checked((string) $flex === $val)>
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>
    </section>

    <section class="card-p space-y-4">
        <h2 class="text-sm font-bold uppercase tracking-wide text-slate-400">Next step</h2>

        <div class="grid gap-3 sm:grid-cols-2">
            <div>
                <label class="label" for="f-stage">Stage</label>
                <select class="input" id="f-stage" name="stage" x-model="stage">
                    @foreach(\App\Models\CrmLead::STAGES as $s)
                        <option value="{{ $s }}">{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
            </div>
            <div x-show="!closed" x-transition>
                <label class="label" for="f-followup">
                    <span x-show="! waiting">Next follow-up date <span class="text-rose-500">*</span></span>
                    <span x-show="waiting" x-cloak>Check again on <span class="font-normal text-slate-400">(optional)</span></span>
                </label>
                <input type="date" class="input" id="f-followup" name="next_followup_at"
                       :required="!closed && ! waiting"
                       value="{{ old('next_followup_at', optional($lead->next_followup_at ?? null)->format('Y-m-d')) }}">
            </div>
        </div>

        {{-- On hold: wants something we can't offer yet. Listed on the Waiting screen. --}}
        <div x-show="!closed" x-transition>
            <label class="label" for="f-waiting">On hold — waiting for</label>
            <select class="input" id="f-waiting" name="waiting_for" x-model="waiting">
                <option value="">Not waiting</option>
                @foreach(config('crm.waiting_reasons') as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <p x-show="waiting" x-cloak class="mt-1 text-xs text-slate-500">
                With no date it stays off Today until you press "Back to Today" on the Waiting screen.
            </p>
        </div>

        <div>
            <label class="label" for="f-notes">Notes</label>
            <textarea class="input min-h-[96px] py-3" id="f-notes" name="notes" rows="3">{{ $v('notes') }}</textarea>
        </div>
    </section>
</div>
