{{--
    Type-aware property details, shared by create and edit.

    Each block is gated on has('<field>') so a plot is never asked for bedrooms and a
    warehouse is never asked for balconies. The type-specific block below is rendered
    entirely from the schema, so adding a field to PropertyTypeSchema is enough — no
    Blade edits needed.

    Expects: $L (PropertyListing|null for prefill)
--}}
@php $L = $L ?? null; @endphp

{{-- ── Core fields that only some types use ── --}}
<div x-show="hasAny(['bedrooms','bathrooms','balconies'])" x-cloak>
    <div class="sp-form-row cols-3">
        <div x-show="has('bedrooms')" x-cloak>
            <label class="sp-label">Bedrooms <span class="req" x-show="req('bedrooms')">*</span></label>
            <select name="bedrooms" class="sp-select {{ $errors->has('bedrooms') ? 'error' : '' }}" data-step="3">
                <option value="">— Select —</option>
                <option value="0" @selected(old('bedrooms', $L->bedrooms ?? null) === 0 || old('bedrooms') === '0')>Studio</option>
                @foreach(range(1,10) as $n)
                <option value="{{ $n }}" @selected((string) old('bedrooms', $L->bedrooms ?? '') === (string) $n)>{{ $n }} BHK</option>
                @endforeach
            </select>
            @error('bedrooms') <div class="sp-error-msg">{{ $message }}</div> @enderror
        </div>
        <div x-show="has('bathrooms')" x-cloak>
            <label class="sp-label">
                <span x-text="isCommercial() ? 'Washrooms' : 'Bathrooms'">Bathrooms</span>
                <span class="req" x-show="req('bathrooms')">*</span>
            </label>
            <select name="bathrooms" class="sp-select {{ $errors->has('bathrooms') ? 'error' : '' }}" data-step="3">
                <option value="">— Select —</option>
                @foreach(range(1,10) as $n)
                <option value="{{ $n }}" @selected((string) old('bathrooms', $L->bathrooms ?? '') === (string) $n)>{{ $n }}</option>
                @endforeach
            </select>
            @error('bathrooms') <div class="sp-error-msg">{{ $message }}</div> @enderror
        </div>
        <div x-show="has('balconies')" x-cloak>
            <label class="sp-label">Balconies</label>
            <select name="balconies" class="sp-select" data-step="3">
                <option value="">— Select —</option>
                @foreach(range(0,6) as $n)
                <option value="{{ $n }}" @selected((string) old('balconies', $L->balconies ?? '') === (string) $n)>{{ $n }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div x-show="hasAny(['floor_no','total_floors','furnishing'])" x-cloak>
    <div class="sp-form-row cols-3">
        <div x-show="has('floor_no')" x-cloak>
            <label class="sp-label">Floor Number</label>
            <input type="number" name="floor_no" value="{{ old('floor_no', $L->floor_no ?? '') }}"
                class="sp-input" placeholder="e.g. 3 (0 for ground)" min="0" max="200" data-step="3">
            @error('floor_no') <div class="sp-error-msg">{{ $message }}</div> @enderror
        </div>
        <div x-show="has('total_floors')" x-cloak>
            <label class="sp-label" x-text="isLand() ? 'Floors Permitted' : 'Total Floors in Building'">Total Floors</label>
            <input type="number" name="total_floors" value="{{ old('total_floors', $L->total_floors ?? '') }}"
                class="sp-input" placeholder="e.g. 10" min="1" max="200" data-step="3">
            @error('total_floors') <div class="sp-error-msg">{{ $message }}</div> @enderror
        </div>
        <div x-show="has('furnishing')" x-cloak>
            <label class="sp-label">Furnishing <span class="req" x-show="req('furnishing')">*</span></label>
            <select name="furnishing" class="sp-select {{ $errors->has('furnishing') ? 'error' : '' }}" data-step="3">
                <option value="">— Select —</option>
                @foreach(\App\Models\PropertyListing::$furnishingLabels as $val => $lbl)
                <option value="{{ $val }}" @selected(old('furnishing', $L->furnishing ?? '') == $val)>{{ $lbl }}</option>
                @endforeach
            </select>
            @error('furnishing') <div class="sp-error-msg">{{ $message }}</div> @enderror
        </div>
    </div>
</div>

<div x-show="hasAny(['property_age','facing','parking'])" x-cloak>
    <div class="sp-form-row cols-3">
        <div x-show="has('property_age')" x-cloak>
            <label class="sp-label">Property Age</label>
            <select name="property_age" class="sp-select" data-step="3">
                <option value="">— Select —</option>
                @foreach(\App\Models\PropertyListing::$ageLabels as $val => $lbl)
                <option value="{{ $val }}" @selected(old('property_age', $L->property_age ?? '') == $val)>{{ $lbl }}</option>
                @endforeach
            </select>
        </div>
        <div x-show="has('facing')" x-cloak>
            <label class="sp-label">Facing</label>
            <select name="facing" class="sp-select" data-step="3">
                <option value="">— Select —</option>
                @foreach(\App\Support\PropertyTypeSchema::FACINGS as $d)
                <option value="{{ $d }}" @selected(old('facing', $L->facing ?? '') == $d)>{{ $d }}</option>
                @endforeach
            </select>
        </div>
        <div x-show="has('parking')" x-cloak>
            <label class="sp-label">Parking</label>
            <select name="parking" class="sp-select" data-step="3">
                <option value="">— Select —</option>
                @foreach(\App\Support\PropertyTypeSchema::PARKING as $p)
                <option value="{{ $p }}" @selected(old('parking', $L->parking ?? '') == $p)>{{ $p }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

{{-- ── Type-specific fields, rendered straight from the schema ── --}}
<div x-show="extras().length" x-cloak style="margin-top:8px;">
    <div class="sp-subsection">
        <div class="sp-subsection-title">
            <span x-text="typeIcon()"></span>
            <span x-text="typeLabel() + ' — Specific Details'"></span>
        </div>
        <div class="sp-hint" style="margin-bottom:14px;">
            These are the questions buyers of this property type actually ask. Fill what you know —
            all of them are optional unless marked.
        </div>
        <div class="sp-extras-grid">
            <template x-for="f in extras()" :key="f.key">
                <div x-show="showExtra(f)" x-cloak>
                    <label class="sp-label">
                        <span x-text="f.label"></span>
                        <span class="req" x-show="f.required">*</span>
                        <span class="sp-hint" style="display:inline;font-size:11px;font-weight:400;"
                            x-show="f.suffix" x-cloak>(<span x-text="f.suffix"></span>)</span>
                    </label>

                    <template x-if="f.type === 'select'">
                        <select class="sp-select" :name="'details[' + f.key + ']'" x-model="details[f.key]">
                            <option value="">— Select —</option>
                            <template x-for="o in f.options" :key="o">
                                <option :value="o" x-text="o"></option>
                            </template>
                        </select>
                    </template>

                    <template x-if="f.type === 'number'">
                        <input type="number" class="sp-input" min="0" step="any"
                            :name="'details[' + f.key + ']'" :placeholder="f.placeholder || ''"
                            x-model="details[f.key]">
                    </template>

                    <template x-if="f.type === 'date'">
                        <input type="date" class="sp-input"
                            :name="'details[' + f.key + ']'" x-model="details[f.key]">
                    </template>

                    <template x-if="f.type === 'text'">
                        <input type="text" class="sp-input" maxlength="255"
                            :name="'details[' + f.key + ']'" :placeholder="f.placeholder || ''"
                            x-model="details[f.key]">
                    </template>

                    <div class="sp-hint" x-show="f.hint" x-cloak x-text="f.hint"></div>
                    <div class="sp-error-msg" x-show="detailError(f.key)" x-cloak x-text="detailError(f.key)"></div>
                </div>
            </template>
        </div>
    </div>
</div>

{{-- ── Description ── --}}
<div class="sp-form-row" style="margin-top:20px;">
    <div>
        <label class="sp-label">Description <span class="req">*</span></label>
        <div id="quill-editor"></div>
        <input type="hidden" name="description" id="description-hidden"
            value="{{ old('description', $L->description ?? '') }}">
        <div class="sp-hint" style="margin-top:6px;">
            Describe what a buyer cannot see in the photos — connectivity, neighbours, why you are selling.
            Minimum 30 characters.
        </div>
        @error('description') <div class="sp-error-msg">{{ $message }}</div> @enderror
    </div>
</div>

{{-- ── Amenities, filtered to the chosen type (hidden when the type has none) ── --}}
<div style="margin-top:20px;" x-show="amenityList().length" x-cloak>
    <label class="sp-label" x-text="isLand() ? 'Land Features' : 'Amenities & Features'">Amenities</label>
    <div class="sp-hint" style="margin-bottom:8px;">Tick everything the property genuinely has.</div>
    <div class="sp-amenities-grid">
        <template x-for="a in amenityList()" :key="a">
            <div class="sp-checkbox-item">
                <input type="checkbox" name="amenities[]" :value="a" :id="'am_' + a.replace(/\W+/g,'_')"
                    x-model="amenities">
                <label :for="'am_' + a.replace(/\W+/g,'_')" x-text="a"></label>
            </div>
        </template>
    </div>
</div>
