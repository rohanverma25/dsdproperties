{{--
    Basic info fields shared by the create wizard and the edit form.

    Everything type-sensitive (which area units are offered, what "area" is called,
    whether the site/colony toggle even applies) reads from the `schema` object that the
    surrounding Alpine component exposes, so it always matches what the server validates.

    Expects: $L (PropertyListing|null for prefill)
--}}
@php $L = $L ?? null; @endphp

{{-- ── Category first, then the subtypes inside it ── --}}
<div class="sp-form-row" style="margin-bottom:6px;">
    <div>
        <label class="sp-label">What are you listing? <span class="req">*</span></label>

        <div class="sp-pill-group sp-cat-group">
            @foreach(\App\Support\PropertyTypeSchema::GROUPS as $gkey => $g)
            <button type="button" class="sp-cat-btn" :class="{ active: pgroup === '{{ $gkey }}' }"
                @click="setGroup('{{ $gkey }}')">
                <span>{{ $g['icon'] }}</span> {{ $g['label'] }}
            </button>
            @endforeach
        </div>

        {{--
            Every radio stays in the DOM so x-model keeps one authoritative value; only the
            chosen category's are shown.
        --}}
        @foreach(\App\Support\PropertyTypeSchema::grouped() as $gkey => $groupTypes)
        <div class="sp-subtype-row" x-show="pgroup === '{{ $gkey }}'" x-cloak>
            @if(count($groupTypes) > 1)
            <div class="sp-type-group-label">Choose the type</div>
            @endif
            <div class="sp-pill-group" @class(['sp-single-type' => count($groupTypes) === 1])>
                @foreach($groupTypes as $val => $cfg)
                <div class="sp-pill">
                    <input type="radio" name="property_type" id="pt_{{ $val }}" value="{{ $val }}"
                        x-model="ptype"
                        @checked(old('property_type', $L->property_type ?? 'flat') == $val)>
                    <label for="pt_{{ $val }}">{{ $cfg['icon'] }} {{ $cfg['label'] }}</label>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        @error('property_type') <div class="sp-error-msg">{{ $message }}</div> @enderror
    </div>
</div>

<div class="sp-form-row">
    <div>
        <label class="sp-label">
            <span x-text="titleLabel()">Property Title</span> <span class="req">*</span>
        </label>
        <input type="text" name="title" value="{{ old('title', $L->title ?? '') }}"
            class="sp-input {{ $errors->has('title') ? 'error' : '' }}"
            :placeholder="titlePlaceholder()" maxlength="255" data-step="1">
        @error('title') <div class="sp-error-msg">{{ $message }}</div> @enderror
    </div>
</div>

{{--
    The site sells only; there is no rent/lease flow, so the seller is not asked. The
    column still exists and existing rental listings keep their value on edit.
--}}

<div class="sp-form-row cols-3">
    <div>
        <label class="sp-label">
            Expected Price <span class="req">*</span>
        </label>
        {{--
            The seller types lakhs; rupees remain the stored unit, posted by the hidden
            field below. Nothing downstream sees the change.
        --}}
        <div class="sp-price-input">
            <input type="number" class="sp-input {{ $errors->has('price') ? 'error' : '' }}"
                placeholder="e.g. 45" min="0" step="any" id="priceField" x-model="priceLakh"
                :disabled="priceOnRequest" data-step="1">
            <span class="sp-price-unit">Lakh</span>
        </div>
        <input type="hidden" name="price" :value="priceOnRequest ? '' : priceRupees">
        <div class="sp-hint" x-show="!priceOnRequest && priceWords" x-cloak>
            = <span x-text="priceWords"></span>
        </div>
        @error('price') <div class="sp-error-msg">{{ $message }}</div> @enderror
    </div>
    <div style="display:flex;flex-direction:column;justify-content:flex-end;padding-bottom:4px;gap:10px;">
        <div class="sp-checkbox-item">
            <input type="checkbox" name="price_negotiable" id="price_negotiable" value="1"
                @checked(old('price_negotiable', $L->price_negotiable ?? false))>
            <label for="price_negotiable">Price Negotiable</label>
        </div>
        <div class="sp-checkbox-item">
            <input type="checkbox" name="price_on_request" id="price_on_request" value="1"
                x-model="priceOnRequest"
                @checked(old('price_on_request', $L->price_on_request ?? false))>
            <label for="price_on_request">Price on Request</label>
        </div>
    </div>
    <div>
        <label class="sp-label">
            <span x-text="areaLabel()">Area</span> <span class="req">*</span>
        </label>
        <div style="display:flex;gap:8px;">
            <input type="number" name="area" value="{{ old('area', $L->area ?? '') }}"
                class="sp-input {{ $errors->has('area') ? 'error' : '' }}"
                placeholder="e.g. 1250" min="0" step="0.01" style="flex:1;" data-step="1">
            <select name="area_unit" class="sp-select" style="width:120px;" x-model="areaUnit">
                <template x-for="u in unitList()" :key="u">
                    <option :value="u" x-text="schema.unitLabels[u]"></option>
                </template>
            </select>
        </div>
        @error('area') <div class="sp-error-msg">{{ $message }}</div> @enderror
        @error('area_unit') <div class="sp-error-msg">{{ $message }}</div> @enderror
    </div>
</div>
