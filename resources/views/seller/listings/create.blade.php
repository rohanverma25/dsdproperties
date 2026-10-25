@extends('seller.layouts.app')
@section('title', 'Post New Property')
@section('page-title', 'Post New Property')

@push('head')
{{-- Quill's stylesheet first, so our overrides below actually win. --}}
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
@include('seller.listings.partials._form-styles')
@endpush

@section('content')
@if($errors->any())
<div class="sp-alert sp-alert-error">
    <div>
        <strong>Please fix the following:</strong>
        <ul style="margin-top:6px;padding-left:18px;">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
</div>
@endif

<div class="sp-card" id="listingWizard" x-data="listingForm()" x-init="init()" x-cloak>

    {{-- Steps indicator --}}
    <div style="padding:22px 28px 0;">
        <div class="progress-bar"><div class="progress-fill" :style="`width:${(step/4)*100}%`"></div></div>
        <div class="sp-steps">
            @foreach(['Basic Info','Location','Details & Amenities','Photos & Submit'] as $i => $label)
            <div class="sp-step" :class="{ active: step == {{ $i+1 }}, done: step > {{ $i+1 }} }">
                <div class="sp-step-num">
                    <span x-show="step <= {{ $i+1 }}">{{ $i+1 }}</span>
                    <span x-show="step > {{ $i+1 }}">✓</span>
                </div>
                <div class="sp-step-label">{{ $label }}</div>
                @if($i < 3) <div class="sp-step-line"></div> @endif
            </div>
            @endforeach
        </div>
    </div>

    {{--
        novalidate is deliberate. The wizard keeps every step in the DOM and hides the
        inactive ones, and a browser refuses to submit a form whose `required` field is
        hidden — silently, with no visible error. All validation is done by checkStep()
        below and re-checked on the server.
    --}}
    <form method="POST" action="{{ route('seller.listings.store') }}" enctype="multipart/form-data"
        id="listingForm" novalidate>
        @csrf

        {{-- Step validation summary --}}
        <div x-show="stepErrors.length" x-cloak style="padding:22px 28px 0;">
            <div class="sp-step-errors">
                <strong>Just a couple of things before you continue:</strong>
                <ul>
                    <template x-for="msg in stepErrors" :key="msg"><li x-text="msg"></li></template>
                </ul>
            </div>
        </div>

        {{-- ══ STEP 1: Basic Info ══ --}}
        <div x-show="step === 1" style="padding:28px;">
            <div class="sp-section-title">Basic Information</div>

            @include('seller.listings.partials._basics', ['L' => null])

            {{-- ── Site / colony listing: only offered for land types ── --}}
            <div x-show="allowSite()" x-cloak>
                <div class="sp-form-row" style="margin-top:20px;margin-bottom:0;">
                    <div style="padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;">
                        <div class="sp-checkbox-item">
                            <input type="checkbox" name="is_site" id="is_site" value="1" x-model="isSite">
                            <label for="is_site" style="font-weight:600;color:#011f4b;font-size:13.5px;"
                                x-text="ptype === 'plot'
                                    ? '🏘 This project offers multiple plot sizes — list them below'
                                    : '🏘 This is a complete site / colony with multiple plot segments'">
                            </label>
                        </div>
                        <div style="font-size:12px;color:#64748b;margin-top:5px;padding-left:24px;"
                            x-text="ptype === 'plot'
                                ? 'Add each plot size you are selling, with its area and rate. Buyers see the full range.'
                                : 'Enable this if you own an entire site and want to list individual plot sizes, price ranges, or segment types.'">
                        </div>
                    </div>
                </div>

                <div x-show="isSite" x-cloak style="margin-top:14px;padding:20px;background:#f0fdfa;border:1.5px solid #a7f3d0;border-radius:10px;">
                    <div style="font-size:13.5px;font-weight:700;color:#011f4b;margin-bottom:16px;"
                        x-text="ptype === 'plot' ? '📐 Plot Sizes & Inventory' : '📐 Plot Configuration'"></div>

                    <div class="sp-form-row cols-3" style="margin-bottom:16px;">
                        <div>
                            <label class="sp-label">Min Plot Area</label>
                            <div style="display:flex;gap:6px;">
                                <input type="number" name="min_plot_area" id="minPlotArea"
                                    value="{{ old('min_plot_area') }}" class="sp-input"
                                    placeholder="e.g. 100" min="0" step="0.01" style="flex:1;"
                                    oninput="syncPlotHidden()">
                                <select name="plot_area_unit" class="sp-select" style="width:100px;"
                                    onchange="renderPlotSegments()">
                                    <template x-for="u in unitList()" :key="u">
                                        <option :value="u" x-text="schema.unitLabels[u]"
                                            :selected="u === areaUnit"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="sp-label">Max Plot Area</label>
                            <input type="number" name="max_plot_area" id="maxPlotArea"
                                value="{{ old('max_plot_area') }}" class="sp-input"
                                placeholder="e.g. 300" min="0" step="0.01" oninput="syncPlotHidden()">
                        </div>
                        <div>
                            <label class="sp-label">Total Number of Plots</label>
                            <input type="number" name="total_plots" id="totalPlots"
                                value="{{ old('total_plots') }}" class="sp-input"
                                placeholder="e.g. 48" min="1" oninput="syncPlotHidden()">
                        </div>
                    </div>

                    <div>
                        <label class="sp-label">
                            Plot Sizes Offered
                            <span class="sp-hint" style="display:inline;font-size:11px;">(optional — add specific plot types with size &amp; price)</span>
                        </label>
                        <table class="plot-seg-table" id="plotSegTable">
                            <thead>
                                <tr>
                                    <th style="width:35%;">Plot Size / Type</th>
                                    <th style="width:25%;">Area</th>
                                    <th style="width:25%;">Price / Rate ₹ (optional)</th>
                                    <th style="width:15%;">Remove</th>
                                </tr>
                            </thead>
                            <tbody id="plotSegBody">
                                <tr id="plotSegEmpty">
                                    <td colspan="4" style="text-align:center;color:#94a3b8;font-size:12.5px;padding:14px;">
                                        No segments added yet. Click "Add Plot Segment" below.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn-add-seg" onclick="addPlotSegment()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            Add Plot Segment
                        </button>
                        <input type="hidden" name="plot_segments" id="plotSegmentsHidden"
                            value="{{ old('plot_segments', $draftData['plot_segments'] ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="sp-wizard-nav" style="display:flex;justify-content:flex-end;margin-top:24px;">
                <button type="button" @click="nextStep(1)" class="sp-btn sp-btn-navy">Next: Location →</button>
            </div>
        </div>

        {{-- ══ STEP 2: Location ══ --}}
        <div x-show="step === 2" style="padding:28px;">
            <div class="sp-section-title">Property Location</div>

            <div class="sp-form-row">
                <div>
                    <label class="sp-label">Locality / Area <span class="req">*</span></label>
                    <input type="text" name="locality" value="{{ old('locality') }}"
                        class="sp-input {{ $errors->has('locality') ? 'error' : '' }}"
                        placeholder="e.g. Gomti Nagar" data-step="2">
                    @error('locality') <div class="sp-error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="sp-form-row">
                <div>
                    <label class="sp-label">Full Address <span class="req">*</span></label>
                    <textarea name="address" class="sp-textarea {{ $errors->has('address') ? 'error' : '' }}" rows="3"
                        placeholder="Plot/House No., Street, Colony, City…" data-step="2">{{ old('address') }}</textarea>
                    <div class="sp-hint" x-show="isLand()" x-cloak>
                        For land, mention the village / tehsil and the nearest highway.
                    </div>
                    @error('address') <div class="sp-error-msg">{{ $message }}</div> @enderror
                </div>
            </div>


            {{-- ── Map Picker ── --}}
            <input type="hidden" name="lat" id="propLat" value="{{ old('lat') }}">
            <input type="hidden" name="lng" id="propLng" value="{{ old('lng') }}">
            <div style="margin-top:22px;">
                <label class="sp-label">Pin Exact Location on Map <span class="sp-hint" style="font-size:11px;display:inline;">(optional)</span></label>
                <div style="position:relative;margin-top:8px;margin-bottom:8px;">
                    <input type="text" id="mapSearchInput" placeholder="Search your property location on map…"
                        class="sp-input" autocomplete="off" style="padding-left:36px;">
                    <span style="position:absolute;left:11px;top:50%;transform:translateY(-50%);font-size:15px;pointer-events:none;">🔍</span>
                </div>
                <div id="sellerMap" style="width:100%;height:300px;border-radius:10px;border:1.5px solid #e2e8f0;background:#f1f5f9;"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;">
                    <span id="mapCoordsDisplay" style="font-size:12px;color:#008080;"></span>
                    <button type="button" id="clearPinBtn" onclick="clearMapPin()" style="display:none;font-size:12px;color:#dc2626;background:none;border:none;cursor:pointer;padding:0;">✕ Remove pin</button>
                </div>
                <div class="sp-hint">Click the map or drag the marker to pin your property's exact location. Buyers can see it on the listing.</div>
            </div>

            {{-- ── Tags ── --}}
            @php
                $selectedTagIds  = old('tags', $draftData['tags'] ?? []);
                $initialSelected = $tags->whereIn('id', $selectedTagIds)->values()->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->toArray();
            @endphp
            <div style="margin-top:20px;" x-data="tagPicker({{ json_encode($tags->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->values()) }}, {{ json_encode($initialSelected) }})">
                <label class="sp-label">Tags</label>
                <div class="sp-hint" style="margin-bottom:10px;">Tag your listing with zones or communities (e.g. IT City, Wellness City)</div>

                <div style="display:flex;flex-wrap:wrap;gap:6px;min-height:32px;margin-bottom:10px;">
                    <template x-for="tag in selected" :key="tag.id">
                        <span class="tag-chip">
                            <span x-text="tag.name"></span>
                            <button type="button" @click="remove(tag)" title="Remove">&times;</button>
                            <input type="hidden" name="tags[]" :value="tag.id">
                        </span>
                    </template>
                    <span x-show="selected.length === 0" style="font-size:12.5px;color:#94a3b8;line-height:32px;">No tags selected</span>
                </div>

                <div style="position:relative;max-width:380px;" @click.outside="open=false">
                    <input type="text" x-model="search" @focus="open=true" @keydown.escape="open=false"
                        placeholder="Search or create a tag…" class="sp-input" autocomplete="off">
                    <div x-show="open" x-cloak class="tag-dropdown">
                        <template x-for="tag in filtered" :key="tag.id">
                            <div class="tag-option" @click="choose(tag)" x-text="tag.name"></div>
                        </template>
                        <div x-show="canCreate" class="tag-option tag-option-create" @click="create()">
                            <span x-show="!creating">+ Create "<span x-text="search.trim()"></span>"</span>
                            <span x-show="creating" style="color:#94a3b8;">Creating…</span>
                        </div>
                        <div x-show="filtered.length === 0 && !canCreate" class="tag-empty">
                            <span x-show="search.trim()">No matching tags</span>
                            <span x-show="!search.trim()">Type to search or create a tag</span>
                        </div>
                    </div>
                </div>
                @error('tags') <div class="sp-error-msg" style="margin-top:6px;">{{ $message }}</div> @enderror
            </div>

            <div class="sp-wizard-nav" style="display:flex;justify-content:space-between;margin-top:24px;">
                <button type="button" @click="goStep(1)" class="sp-btn sp-btn-outline">← Back</button>
                <button type="button" @click="nextStep(2)" class="sp-btn sp-btn-navy">Next: Details →</button>
            </div>
        </div>

        {{-- ══ STEP 3: Details & Amenities ══ --}}
        <div x-show="step === 3" style="padding:28px;">
            <div class="sp-section-title">
                <span x-text="typeIcon() + '  ' + typeLabel() + ' — Details'">Property Details</span>
            </div>

            @include('seller.listings.partials._details', ['L' => null])

            <div class="sp-wizard-nav" style="display:flex;justify-content:space-between;margin-top:28px;">
                <button type="button" @click="goStep(2)" class="sp-btn sp-btn-outline">← Back</button>
                <button type="button" @click="nextStep(3)" class="sp-btn sp-btn-navy">Next: Photos →</button>
            </div>
        </div>

        {{-- ══ STEP 4: Photos & Submit ══ --}}
        <div x-show="step === 4" style="padding:28px;">
            <div class="sp-section-title">Photos & Final Review</div>

            <div class="sp-form-row cols-2">
                <div>
                    <label class="sp-label">Featured / Cover Photo <span class="req">*</span></label>
                    <div class="sp-upload-zone" onclick="document.getElementById('featuredInput').click();"
                        ondragover="event.preventDefault();this.classList.add('drag')"
                        ondragleave="this.classList.remove('drag')"
                        ondrop="event.preventDefault();this.classList.remove('drag');handleDrop(event,'featuredInput','featuredPreview')">
                        <input type="file" name="featured_image" id="featuredInput" accept="image/*"
                            onchange="previewSingle(this,'featuredPreview')">
                        <div class="sp-upload-icon">🖼</div>
                        <div class="sp-upload-text">Click or drag to upload<br><strong>cover photo</strong></div>
                    </div>
                    <div id="featuredPreview" style="margin-top:10px;"></div>
                    @error('featured_image') <div class="sp-error-msg">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="sp-label">Additional Photos <span class="sp-hint" style="font-size:11px;display:inline;">(up to 10)</span></label>
                    <div class="sp-upload-zone" onclick="document.getElementById('galleryInput').click();"
                        ondragover="event.preventDefault();this.classList.add('drag')"
                        ondragleave="this.classList.remove('drag')"
                        ondrop="event.preventDefault();this.classList.remove('drag');handleGalleryDrop(event)">
                        <input type="file" name="images[]" id="galleryInput" accept="image/*" multiple
                            onchange="previewMultiple(this)">
                        <div class="sp-upload-icon">📷</div>
                        <div class="sp-upload-text">Click or drag multiple<br><strong>property photos</strong></div>
                    </div>
                    <div id="galleryError" style="color:#dc2626;font-size:12px;margin-top:6px;display:none;"></div>
                    <div class="img-preview-grid" id="galleryPreview"></div>
                </div>
            </div>

            {{-- Video upload / YouTube --}}
            <div style="margin-top:20px;">
                <label class="sp-label">Property Video <span class="sp-hint" style="font-size:11px;display:inline;">(optional)</span></label>

                <div style="display:flex;gap:0;margin-bottom:12px;border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;width:fit-content;">
                    <button type="button" id="tabUpload" onclick="switchVideoTab('upload')"
                        style="padding:8px 20px;font-size:13px;font-weight:600;border:none;cursor:pointer;background:#011f4b;color:#fff;transition:all .2s;">
                        📁 Upload File
                    </button>
                    <button type="button" id="tabYoutube" onclick="switchVideoTab('youtube')"
                        style="padding:8px 20px;font-size:13px;font-weight:600;border:none;cursor:pointer;background:#f4f7fb;color:#475569;transition:all .2s;">
                        ▶ YouTube URL
                    </button>
                </div>

                <div id="videoUploadTab">
                    <div class="sp-upload-zone" onclick="document.getElementById('videoInput').click();"
                        ondragover="event.preventDefault();this.classList.add('drag')"
                        ondragleave="this.classList.remove('drag')"
                        ondrop="event.preventDefault();this.classList.remove('drag');handleVideoDrop(event)">
                        <input type="file" name="video" id="videoInput" accept="video/mp4,video/quicktime,video/webm,video/x-msvideo"
                            onchange="previewVideo(this)">
                        <div class="sp-upload-icon">🎥</div>
                        <div class="sp-upload-text" id="videoUploadText">Click or drag to upload a<br><strong>property walkthrough video</strong><br><span style="font-size:11px;color:#94a3b8;">mp4 · mov · webm · avi &nbsp;·&nbsp; max 100 MB</span></div>
                    </div>
                    <div id="videoError" style="color:#dc2626;font-size:12px;margin-top:6px;display:none;"></div>
                    <div id="videoPreview" style="margin-top:10px;"></div>
                </div>

                <div id="videoYoutubeTab" style="display:none;">
                    <input type="text" name="youtube_url" id="youtubeUrlInput"
                        placeholder="https://www.youtube.com/watch?v=…"
                        style="width:100%;padding:11px 14px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:14px;font-family:inherit;outline:none;"
                        oninput="previewYoutube(this.value)">
                    <div style="font-size:11px;color:#94a3b8;margin-top:5px;">Paste a YouTube video URL — your property walkthrough will be embedded for buyers.</div>
                    <div id="youtubePreview" style="margin-top:12px;"></div>
                    @error('youtube_url') <div class="sp-error-msg">{{ $message }}</div> @enderror
                </div>

                @error('video') <div class="sp-error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Brochure PDF --}}
            <div style="margin-top:20px;">
                <label class="sp-label">
                    Site Brochure / PDF
                    <span class="sp-hint" style="font-size:11px;display:inline;">(optional)</span>
                </label>
                <div class="brochure-zone" id="brochureZone"
                    onclick="document.getElementById('brochureInput').click();"
                    ondragover="event.preventDefault();this.classList.add('drag')"
                    ondragleave="this.classList.remove('drag')"
                    ondrop="event.preventDefault();this.classList.remove('drag');handleBrochureDrop(event)">
                    <input type="file" name="brochure" id="brochureInput"
                        accept=".pdf,application/pdf" onchange="handleBrochureSelect(this)" style="display:none;">
                    <div style="font-size:30px;margin-bottom:6px;">📄</div>
                    <div style="font-size:13px;font-weight:600;color:#475569;">Click or drag to upload Brochure</div>
                    <div style="font-size:11.5px;color:#94a3b8;margin-top:3px;">PDF only &nbsp;·&nbsp; max 10 MB</div>
                </div>
                <div id="brochureError" style="color:#dc2626;font-size:12px;margin-top:6px;display:none;"></div>
                <div id="brochureInfo" style="display:none;margin-top:8px;"></div>
                @error('brochure') <div class="sp-error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Live summary so the seller can check the whole listing before submitting --}}
            <div style="background:#f0fdfa;border:1.5px solid #a7f3d0;border-radius:10px;padding:18px;margin-top:24px;">
                <div style="font-size:13.5px;font-weight:700;color:#011f4b;margin-bottom:10px;">
                    <span x-text="typeIcon()"></span> Review
                </div>
                <div style="font-size:13px;color:#334155;line-height:1.9;">
                    <div><strong x-text="typeLabel()"></strong> · For Sale</div>
                    <div x-show="!priceOnRequest" x-cloak><span x-text="areaLabel()"></span> priced at <strong x-text="priceWords"></strong></div>
                    <div x-show="priceOnRequest" x-cloak>Price on Request</div>
                </div>
            </div>

            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:18px;margin-top:14px;">
                <div style="font-size:13.5px;font-weight:700;color:#011f4b;margin-bottom:10px;">📋 Submission Note</div>
                <ul style="font-size:13px;color:#475569;padding-left:18px;line-height:1.8;">
                    <li>Your listing will be reviewed by our team within <strong>24 hours</strong>.</li>
                    <li>After approval it will be <strong>live on the website</strong> for buyers to contact you directly.</li>
                    <li>You'll be able to edit your listing anytime from your dashboard.</li>
                    <li>Photos should be clear, well-lit, and show the actual property.</li>
                </ul>
            </div>

            <div class="sp-wizard-nav" style="display:flex;justify-content:space-between;align-items:center;margin-top:24px;">
                <button type="button" @click="goStep(3)" class="sp-btn sp-btn-outline">← Back</button>
                <button type="submit" class="sp-btn sp-btn-primary" style="font-size:15px;padding:12px 32px;">
                    🚀 Submit Property for Review
                </button>
            </div>
        </div>

    </form>
</div>

{{-- Upload Loader Overlay --}}
<div id="upload-loader">
    <div class="ul-spinner"></div>
    <div class="ul-text">Uploading your property listing…</div>
    <div class="ul-sub">Please do not close or refresh this page.<br>Photos and videos may take a moment to upload.</div>
</div>

@endsection

@push('head')
@include('seller.listings.partials._js-map')
@endpush

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@include('seller.listings.partials._form-script', ['L' => null, 'draft' => $draftData])
@include('seller.listings.partials._js-tags')
@include('seller.listings.partials._js-uploads')
@include('seller.listings.partials._js-plot')

<script>
const draftSaveUrl = '{{ route("seller.listings.draft.save") }}';
const csrfToken    = document.querySelector('meta[name=csrf-token]').content;
const draftData    = @json($draftData);
const draftStep    = {{ (int) $draftStep }};

// Fields Alpine owns. Restoring these by poking the DOM would desync its state, so the
// draft values for them are seeded server-side into LISTING_INITIAL instead.
const ALPINE_OWNED = [
    'property_type', 'transaction_type', 'price', 'price_on_request',
    'area_unit', 'is_site', 'amenities', 'details', 'tags',
];

/**
 * Autosave: persist the current step's fields right away, instead of waiting for the
 * final "Submit" click.
 */
function saveDraftStep(step) {
    const form = document.getElementById('listingForm');
    const fd   = new FormData(form);
    fd.set('step', step);
    fd.delete('featured_image');
    fd.delete('images[]');
    fd.delete('video');
    fd.delete('brochure');

    return fetch(draftSaveUrl, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: fd,
    }).then(showSavedToast).catch(() => {});
}

function showSavedToast() {
    let el = document.getElementById('draftSavedToast');
    if (!el) {
        el = document.createElement('div');
        el.id = 'draftSavedToast';
        el.style.cssText = 'position:fixed;top:16px;right:16px;z-index:99998;background:#011f4b;color:#fff;padding:8px 16px;border-radius:8px;font-size:12.5px;font-family:Poppins,sans-serif;box-shadow:0 4px 12px rgba(0,0,0,.15);opacity:0;transition:opacity .25s;';
        el.textContent = '✓ Progress saved';
        document.body.appendChild(el);
    }
    el.style.opacity = '1';
    clearTimeout(el._t);
    el._t = setTimeout(() => { el.style.opacity = '0'; }, 1400);
}

/** Restore the plain (non-Alpine) fields of a saved draft. */
function applyDraftData() {
    if (!draftData || !Object.keys(draftData).length) return;

    Object.keys(draftData).forEach(key => {
        if (ALPINE_OWNED.includes(key)) return;
        const val = draftData[key];
        if (val === null || val === undefined || val === '' || typeof val === 'object') return;

        Array.from(document.getElementsByName(key)).forEach(el => {
            if (el.type === 'file' || el.type === 'radio' || el.type === 'checkbox') return;
            if (!el.value) el.value = val;
        });
    });

    if (draftData.description && window._quill && !window._quill.getText().trim()) {
        window._quill.root.innerHTML = draftData.description;
    }
}

document.addEventListener('DOMContentLoaded', applyDraftData);

/** The wizard, layered on top of the shared type-aware state. */
function listingForm() {
    const state = listingTypeState();

    Object.defineProperties(state, Object.getOwnPropertyDescriptors({
        step:   1,
        saving: false,

        init() {
            this.initTypeWatchers();

            // Resume where the seller left off, unless a failed submit brought them back.
            if (!{{ $errors->any() ? 'true' : 'false' }} && draftStep > 1) {
                this.step = Math.min(draftStep, 4);
            } else if (window._initStep) {
                this.step = window._initStep;
            }
            if (this.step === 2) setTimeout(onMapStepVisible, 150);
        },

        goStep(n) {
            this.stepErrors = [];
            this.step = n;
            if (n === 2) setTimeout(onMapStepVisible, 80);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        nextStep(current) {
            if (!this.checkStep(current)) return;

            this.saving = true;
            saveDraftStep(current).finally(() => { this.saving = false; });

            this.goStep(current + 1);
        },
    }));

    return state;
}

// ─── Quill rich text editor ───
document.addEventListener('DOMContentLoaded', function () {
    if (!document.getElementById('quill-editor') || typeof Quill === 'undefined') return;

    window._quill = new Quill('#quill-editor', {
        theme: 'snow',
        placeholder: 'Describe the property — highlights, nearby facilities, special features, why someone should buy/rent this…',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });

    const oldVal = document.getElementById('description-hidden').value;
    if (oldVal) window._quill.root.innerHTML = oldVal;

    // Keep the hidden field in step with the editor so the draft autosave picks it up.
    window._quill.on('text-change', function () {
        document.getElementById('description-hidden').value =
            window._quill.getText().trim().length > 1 ? window._quill.root.innerHTML : '';
    });
});

// ─── Form submit: sync hidden inputs + show loader ───
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('listingForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        if (window._quill) {
            const text = window._quill.getText().trim();
            document.getElementById('description-hidden').value =
                text.length > 1 ? window._quill.root.innerHTML : '';
        }

        syncPlotHidden();

        // Last guard: never let a half-filled listing reach the server silently.
        const alpine = Alpine.$data(document.getElementById('listingWizard'));
        if (alpine && !alpine.checkAll()) {
            e.preventDefault();
            alpine.step = 1;
            return;
        }

        const loader = document.getElementById('upload-loader');
        if (loader) loader.classList.add('active');

        window.onbeforeunload = null;
    });
});

// Restore the step that failed validation on the server.
@if($errors->any())
window._initStep =
    {{ $errors->hasAny(['title','property_type','transaction_type','price','area','area_unit']) ? 1
        : ($errors->hasAny(['locality','address','tags']) ? 2
        : ($errors->hasAny(['description','bedrooms','bathrooms','balconies','furnishing','floor_no','total_floors','amenities']) || collect($errors->keys())->contains(fn($k) => str_starts_with($k, 'details.')) ? 3
        : 4)) }};
@endif
</script>
@endpush
