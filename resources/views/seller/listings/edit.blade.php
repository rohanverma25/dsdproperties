@extends('seller.layouts.app')
@section('title', 'Edit Listing')
@section('page-title', 'Edit Listing')

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

@if($listing->status === 'rejected' && $listing->rejection_reason)
<div class="sp-alert" style="background:#fef9c3;color:#854d0e;border:1px solid #fde68a;">
    <div>
        <strong>Rejection Reason:</strong> {{ $listing->rejection_reason }}<br>
        <span style="font-size:12px;margin-top:4px;display:block;">Please update the listing and resubmit. It will go back for review.</span>
    </div>
</div>
@endif

{{--
    novalidate: all validation runs through checkAll(), which knows which fields apply to
    the selected property type, and is re-checked on the server.
--}}
<div id="listingWizard" x-data="editListingForm()" x-init="init()" x-cloak>
<form id="editListingForm" method="POST" action="{{ route('seller.listings.update', $listing) }}"
    enctype="multipart/form-data" novalidate>
    @csrf @method('PUT')
    <input type="hidden" name="delete_images" id="deleteImagesField" value="">

    <div x-show="stepErrors.length" x-cloak>
        <div class="sp-step-errors">
            <strong>Please fix these before saving:</strong>
            <ul>
                <template x-for="msg in stepErrors" :key="msg"><li x-text="msg"></li></template>
            </ul>
        </div>
    </div>

    <div class="sp-card" style="margin-bottom:20px;">
        <div class="sp-card-header"><span class="sp-card-title">Basic Information</span></div>
        <div class="sp-card-body">

            @include('seller.listings.partials._basics', ['L' => $listing])

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
                                <input type="number" name="min_plot_area" id="editMinPlotArea"
                                    value="{{ old('min_plot_area', $listing->plot_segments['min_area'] ?? '') }}"
                                    class="sp-input" placeholder="e.g. 100" min="0" step="0.01" style="flex:1;"
                                    oninput="editSyncPlotHidden()">
                                <select name="plot_area_unit" class="sp-select" style="width:100px;"
                                    onchange="editRenderPlotSegments()">
                                    @foreach(\App\Support\PropertyTypeSchema::AREA_UNITS as $val => $lbl)
                                    <option value="{{ $val }}"
                                        @selected(old('plot_area_unit', $listing->plot_segments['unit'] ?? 'sqyard') == $val)>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="sp-label">Max Plot Area</label>
                            <input type="number" name="max_plot_area" id="editMaxPlotArea"
                                value="{{ old('max_plot_area', $listing->plot_segments['max_area'] ?? '') }}"
                                class="sp-input" placeholder="e.g. 300" min="0" step="0.01"
                                oninput="editSyncPlotHidden()">
                        </div>
                        <div>
                            <label class="sp-label">Total Number of Plots</label>
                            <input type="number" name="total_plots" id="editTotalPlots"
                                value="{{ old('total_plots', $listing->plot_segments['total_plots'] ?? '') }}"
                                class="sp-input" placeholder="e.g. 48" min="1"
                                oninput="editSyncPlotHidden()">
                        </div>
                    </div>

                    <div>
                        <label class="sp-label">
                            Plot Sizes Offered
                            <span class="sp-hint" style="display:inline;font-size:11px;">(optional — add specific plot types with size &amp; price)</span>
                        </label>
                        <table class="plot-seg-table" id="editPlotSegTable">
                            <thead>
                                <tr>
                                    <th style="width:35%;">Plot Size / Type</th>
                                    <th style="width:25%;">Area</th>
                                    <th style="width:25%;">Price / Rate ₹ (optional)</th>
                                    <th style="width:15%;">Remove</th>
                                </tr>
                            </thead>
                            <tbody id="editPlotSegBody">
                                <tr id="editPlotSegEmpty">
                                    <td colspan="4" style="text-align:center;color:#94a3b8;font-size:12.5px;padding:14px;">
                                        No segments added yet. Click "Add Plot Segment" below.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn-add-seg" onclick="editAddPlotSegment()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                            Add Plot Segment
                        </button>
                        <input type="hidden" name="plot_segments" id="editPlotSegmentsHidden"
                            value="{{ old('plot_segments') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sp-card" style="margin-bottom:20px;">
        <div class="sp-card-header"><span class="sp-card-title">Location</span></div>
        <div class="sp-card-body">
            <div class="sp-form-row">
                <div>
                    <label class="sp-label">Locality / Area <span class="req">*</span></label>
                    <input type="text" name="locality" value="{{ old('locality', $listing->locality) }}"
                        class="sp-input {{ $errors->has('locality') ? 'error' : '' }}">
                    @error('locality') <div class="sp-error-msg">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="sp-form-row">
                <div>
                    <label class="sp-label">Full Address <span class="req">*</span></label>
                    <textarea name="address" rows="3"
                        class="sp-textarea {{ $errors->has('address') ? 'error' : '' }}">{{ old('address', $listing->address) }}</textarea>
                    @error('address') <div class="sp-error-msg">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- ── Map Picker ── --}}
            <input type="hidden" name="lat" id="propLat" value="{{ old('lat', $listing->lat) }}">
            <input type="hidden" name="lng" id="propLng" value="{{ old('lng', $listing->lng) }}">
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
                    <button type="button" id="clearPinBtn" onclick="clearMapPin()" style="{{ $listing->lat ? '' : 'display:none;' }}font-size:12px;color:#dc2626;background:none;border:none;cursor:pointer;padding:0;">✕ Remove pin</button>
                </div>
                <div class="sp-hint">Click the map or drag the marker to update the pin. Buyers see this on the listing page.</div>
            </div>
        </div>
    </div>

    <div class="sp-card" style="margin-bottom:20px;">
        <div class="sp-card-header">
            <span class="sp-card-title" x-text="typeIcon() + '  ' + typeLabel() + ' — Details'">Property Details</span>
        </div>
        <div class="sp-card-body">

            @include('seller.listings.partials._details', ['L' => $listing])

            {{-- ── Tags ── --}}
            @php
                $initialSelected = $tags->whereIn('id', old('tags', $listing->tags->pluck('id')->toArray()))
                    ->values()->map(fn($t) => ['id' => $t->id, 'name' => $t->name])->toArray();
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
        </div>
    </div>

    <div class="sp-card" style="margin-bottom:28px;">
        <div class="sp-card-header"><span class="sp-card-title">Photos</span></div>
        <div class="sp-card-body">
            @if($listing->featured_image && file_exists(public_path($listing->featured_image)))
            <div style="margin-bottom:18px;">
                <label class="sp-label">Current Cover Photo</label>
                <img src="{{ asset($listing->featured_image) }}" style="max-height:150px;border-radius:8px;border:2px solid #e2e8f0;display:block;" alt="">
            </div>
            @endif
            <div class="sp-form-row cols-2">
                <div>
                    <label class="sp-label">Replace Cover Photo</label>
                    <input type="file" name="featured_image" accept="image/*" class="sp-input" style="padding:6px;">
                    @error('featured_image') <div class="sp-error-msg">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="sp-label">Add More Photos</label>
                    <input type="file" name="images[]" accept="image/*" multiple class="sp-input" style="padding:6px;">
                    <div class="sp-hint">Hold Ctrl/Cmd to select multiple files</div>
                </div>
            </div>

            @if($listing->images->count())
            <div style="margin-top:16px;">
                <label class="sp-label">Existing Photos (click × to remove)</label>
                <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:8px;" id="existingPhotos">
                    @foreach($listing->images as $img)
                    <div style="position:relative;" id="imgWrap{{ $img->id }}">
                        <img src="{{ asset($img->image_path) }}" style="width:100px;height:78px;object-fit:cover;border-radius:8px;border:2px solid #e2e8f0;" alt="">
                        <button type="button" onclick="markDelete({{ $img->id }})"
                            style="position:absolute;top:-7px;right:-7px;width:22px;height:22px;background:#dc2626;color:#fff;border-radius:50%;font-size:13px;line-height:22px;text-align:center;cursor:pointer;border:none;font-weight:700;">×</button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Video --}}
            <div style="margin-top:20px;padding-top:18px;border-top:1px solid #e2e8f0;">
                <label class="sp-label">Property Video <span class="sp-hint" style="font-size:11px;display:inline;">(optional · mp4/mov/webm · max 100 MB)</span></label>
                @if($listing->video_path && file_exists(public_path($listing->video_path)))
                <div style="margin-bottom:12px;" id="existingVideoWrap">
                    <video controls style="width:100%;max-height:220px;border-radius:8px;border:2px solid #e2e8f0;display:block;">
                        <source src="{{ asset($listing->video_path) }}">
                    </video>
                    <label style="display:inline-flex;align-items:center;gap:6px;margin-top:8px;font-size:13px;color:#dc2626;cursor:pointer;">
                        <input type="checkbox" name="delete_video" value="1" onchange="toggleVideoRemove(this)"> Remove current video
                    </label>
                </div>
                @endif
                <input type="file" name="video" id="editVideoInput" accept="video/mp4,video/quicktime,video/webm,video/x-msvideo"
                    class="sp-input" style="padding:6px;" onchange="previewEditVideo(this)">
                <div class="sp-hint">Upload a new video to replace the existing one</div>
                @error('video') <div class="sp-error-msg" style="margin-top:4px;">{{ $message }}</div> @enderror
                <div id="editVideoPreview" style="margin-top:10px;"></div>
            </div>

            {{-- YouTube --}}
            <div style="margin-top:20px;padding-top:18px;border-top:1px solid #e2e8f0;">
                <label class="sp-label">YouTube Walkthrough URL <span class="sp-hint" style="font-size:11px;display:inline;">(optional)</span></label>
                <input type="text" name="youtube_url" value="{{ old('youtube_url', $listing->youtube_url) }}"
                    class="sp-input" placeholder="https://www.youtube.com/watch?v=…">
                <div class="sp-hint">Setting this replaces an uploaded video file.</div>
                @error('youtube_url') <div class="sp-error-msg">{{ $message }}</div> @enderror
            </div>

            {{-- Brochure PDF --}}
            <div style="margin-top:20px;padding-top:18px;border-top:1px solid #e2e8f0;">
                <label class="sp-label">
                    Site Brochure / PDF
                    <span class="sp-hint" style="font-size:11px;display:inline;">(optional)</span>
                </label>
                @if($listing->brochure_path && file_exists(public_path($listing->brochure_path)))
                <div style="margin-bottom:12px;display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f0fdfa;border:1px solid #a7f3d0;border-radius:8px;font-size:13px;color:#065f46;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span style="flex:1;">Current brochure: <strong>{{ basename($listing->brochure_path) }}</strong></span>
                    <a href="{{ asset($listing->brochure_path) }}" target="_blank" style="color:#008080;font-weight:600;text-decoration:none;">View PDF →</a>
                </div>
                @endif
                <div class="brochure-zone" id="brochureZone"
                    onclick="document.getElementById('brochureInput').click();"
                    ondragover="event.preventDefault();this.classList.add('drag')"
                    ondragleave="this.classList.remove('drag')"
                    ondrop="event.preventDefault();this.classList.remove('drag');handleBrochureDrop(event)">
                    <input type="file" name="brochure" id="brochureInput"
                        accept=".pdf,application/pdf" onchange="handleBrochureSelect(this)" style="display:none;">
                    <div style="font-size:30px;margin-bottom:6px;">📄</div>
                    <div style="font-size:13px;font-weight:600;color:#475569;">Click or drag to upload {{ $listing->brochure_path ? 'a new' : 'a' }} Brochure</div>
                    <div style="font-size:11.5px;color:#94a3b8;margin-top:3px;">PDF only &nbsp;·&nbsp; max 10 MB</div>
                </div>
                <div id="brochureError" style="color:#dc2626;font-size:12px;margin-top:6px;display:none;"></div>
                <div id="brochureInfo" style="display:none;margin-top:8px;"></div>
                @error('brochure') <div class="sp-error-msg">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>

    <div style="display:flex;gap:12px;align-items:center;">
        <button type="submit" class="sp-btn sp-btn-primary" style="font-size:14px;padding:10px 28px;">Save Changes</button>
        <a href="{{ route('seller.listings.index') }}" class="sp-btn sp-btn-outline">Cancel</a>
        @if($listing->status === 'published')
            <a href="{{ route('properties.show', $listing->slug) }}" target="_blank" class="sp-btn sp-btn-outline" style="margin-left:auto;">View Live →</a>
        @endif
    </div>
</form>
</div>

{{-- Upload Loader Overlay --}}
<div id="upload-loader">
    <div class="ul-spinner"></div>
    <div class="ul-text">Saving your property listing…</div>
    <div class="ul-sub">Please do not close or refresh this page.<br>Photos and videos may take a moment to upload.</div>
</div>

@endsection

@push('head')
@include('seller.listings.partials._js-map')
@endpush

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@include('seller.listings.partials._form-script', ['L' => $listing, 'draft' => []])
@include('seller.listings.partials._js-tags')

<script>
/** The edit form: the same type-aware state, as one page rather than a wizard. */
function editListingForm() {
    const state = listingTypeState();

    Object.defineProperties(state, Object.getOwnPropertyDescriptors({
        init() {
            this.initTypeWatchers();
            onMapStepVisible();
        },
    }));

    return state;
}

let toDelete = [];
function markDelete(id) {
    toDelete.push(id);
    document.getElementById('deleteImagesField').value = toDelete.join(',');
    const wrap = document.getElementById('imgWrap' + id);
    if (wrap) wrap.style.opacity = '0.3';
}

function previewEditVideo(input) {
    const file = input.files && input.files[0];
    if (file) {
        var allowed = ['video/mp4','video/quicktime','video/webm','video/x-msvideo'];
        if (!allowed.includes(file.type)) { alert('Please upload a valid video file (MP4, MOV, WebM, AVI).'); input.value=''; return; }
        if (file.size > 100 * 1024 * 1024) { alert('Video must be under 100 MB.'); input.value=''; return; }
    }
    const preview = document.getElementById('editVideoPreview');
    preview.innerHTML = '';
    if (file) {
        const video = document.createElement('video');
        video.controls = true;
        video.style.cssText = 'width:100%;max-height:220px;border-radius:8px;border:2px solid #e2e8f0;display:block;';
        video.src = URL.createObjectURL(file);
        preview.appendChild(video);
    }
}

function toggleVideoRemove(checkbox) {
    const wrap = document.getElementById('existingVideoWrap');
    if (wrap) wrap.style.opacity = checkbox.checked ? '0.3' : '1';
}

// ─── Brochure upload ───
function handleBrochureSelect(input) {
    var errDiv  = document.getElementById('brochureError');
    var infoDiv = document.getElementById('brochureInfo');
    errDiv.style.display = 'none';
    infoDiv.style.display = 'none';
    var file = input.files && input.files[0];
    if (!file) return;
    if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
        errDiv.textContent = 'Only PDF files are allowed.';
        errDiv.style.display = 'block';
        input.value = '';
        return;
    }
    if (file.size > 10 * 1024 * 1024) {
        errDiv.textContent = 'File size must be under 10 MB. Your file is ' + (file.size / 1024 / 1024).toFixed(2) + ' MB.';
        errDiv.style.display = 'block';
        input.value = '';
        return;
    }
    infoDiv.innerHTML = '<div class="brochure-info">' +
        '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' +
        '<span><strong>' + escHtml(file.name) + '</strong> &nbsp;·&nbsp; ' + (file.size / 1024 / 1024).toFixed(2) + ' MB</span>' +
        '<button type="button" onclick="clearBrochure()" style="background:none;border:none;color:#dc2626;cursor:pointer;font-size:18px;line-height:1;">×</button>' +
        '</div>';
    infoDiv.style.display = 'block';
}

function handleBrochureDrop(event) {
    var file = event.dataTransfer.files[0];
    if (!file) return;
    var input = document.getElementById('brochureInput');
    var dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;
    handleBrochureSelect(input);
}

function clearBrochure() {
    document.getElementById('brochureInput').value = '';
    document.getElementById('brochureInfo').style.display = 'none';
    document.getElementById('brochureError').style.display = 'none';
}

// ─── Image file validation ───
(function() {
    var featImg = document.querySelector('input[name=featured_image]');
    if (featImg) featImg.addEventListener('change', function() {
        var file = this.files && this.files[0];
        if (!file) return;
        var allowed = ['image/jpeg','image/jpg','image/png','image/webp'];
        if (!allowed.includes(file.type)) { alert('Cover photo must be JPG, PNG or WebP.'); this.value=''; return; }
        if (file.size > 2 * 1024 * 1024) { alert('Cover photo must be under 2 MB.'); this.value=''; }
    });
    var galleryImg = document.querySelector('input[name="images[]"]');
    if (galleryImg) galleryImg.addEventListener('change', function() {
        var allowed = ['image/jpeg','image/jpg','image/png','image/webp'];
        var files = Array.from(this.files || []);
        var bad = files.filter(function(f){ return !allowed.includes(f.type) || f.size > 2*1024*1024; });
        if (bad.length) { alert('All images must be JPG/PNG/WebP and under 2 MB each.'); this.value=''; }
        if (files.length > 10) { alert('You can add up to 10 photos at a time.'); this.value=''; }
    });
})();

// ─── Plot Segments ───
var editPlotSegments = [];

function editAddPlotSegment() {
    editPlotSegments.push({ label: '', area: '', price: '' });
    editRenderPlotSegments();
}

function editRemovePlotSegment(i) {
    editPlotSegments.splice(i, 1);
    editRenderPlotSegments();
}

function editRenderPlotSegments() {
    var tbody = document.getElementById('editPlotSegBody');
    var empty = document.getElementById('editPlotSegEmpty');
    if (!tbody) return;
    var unit = (document.querySelector('[name=plot_area_unit]') || {}).value || 'sqyard';
    Array.from(tbody.querySelectorAll('tr.seg-row')).forEach(function(r){ r.remove(); });

    if (editPlotSegments.length === 0) {
        if (empty) empty.style.display = '';
        editSyncPlotHidden();
        return;
    }
    if (empty) empty.style.display = 'none';

    editPlotSegments.forEach(function(seg, i) {
        var tr = document.createElement('tr');
        tr.className = 'seg-row';
        tr.innerHTML =
            '<td><input type="text" placeholder="e.g. Type A — 100 sq.yd" value="' + escHtml(seg.label) + '" oninput="editPlotSegments[' + i + '].label=this.value;editSyncPlotHidden()"></td>' +
            '<td><div style="display:flex;gap:5px;align-items:center;">' +
                '<input type="number" placeholder="Area" value="' + escHtml(seg.area) + '" min="0" step="0.01" style="flex:1;" oninput="editPlotSegments[' + i + '].area=this.value;editSyncPlotHidden()">' +
                '<span style="font-size:12px;color:#64748b;white-space:nowrap;">' + escHtml(unit) + '</span>' +
            '</div></td>' +
            '<td><input type="number" placeholder="Optional" value="' + escHtml(seg.price) + '" min="0" oninput="editPlotSegments[' + i + '].price=this.value;editSyncPlotHidden()"></td>' +
            '<td style="text-align:center;"><button type="button" class="btn-del-seg" onclick="editRemovePlotSegment(' + i + ')">×</button></td>';
        tbody.appendChild(tr);
    });
    editSyncPlotHidden();
}

function escHtml(s) {
    return String(s || '').replace(/&/g,'&amp;').replace(/"/g,'&quot;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function editSyncPlotHidden() {
    var data = {
        min_area:    (document.getElementById('editMinPlotArea') || {}).value || '',
        max_area:    (document.getElementById('editMaxPlotArea') || {}).value || '',
        total_plots: (document.getElementById('editTotalPlots')  || {}).value || '',
        unit:        ((document.querySelector('[name=plot_area_unit]') || {}).value) || 'sqyard',
        segments:    editPlotSegments.filter(function(s){ return s.label || s.area; }),
    };
    var h = document.getElementById('editPlotSegmentsHidden');
    if (h) h.value = JSON.stringify(data);
}

// Populate from existing listing data
@if($listing->plot_segments && isset($listing->plot_segments['segments']))
try {
    var _psExisting = @json($listing->plot_segments);
    if (_psExisting && Array.isArray(_psExisting.segments)) {
        editPlotSegments = _psExisting.segments;
        document.addEventListener('DOMContentLoaded', function(){ editRenderPlotSegments(); });
    }
} catch(e) {}
@endif

@if(old('plot_segments'))
try {
    var _psOld = JSON.parse({{ json_encode(old('plot_segments')) }});
    if (_psOld && Array.isArray(_psOld.segments)) {
        editPlotSegments = _psOld.segments;
        document.addEventListener('DOMContentLoaded', function(){ editRenderPlotSegments(); });
    }
} catch(e) {}
@endif

// ─── Quill Rich Text Editor ───
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

    var oldVal = document.getElementById('description-hidden').value;
    if (oldVal) window._quill.root.innerHTML = oldVal;
});

// ─── Form submit: sync hidden inputs + validate + show loader ───
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('editListingForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        if (window._quill) {
            var text = window._quill.getText().trim();
            document.getElementById('description-hidden').value = text.length > 1
                ? window._quill.root.innerHTML
                : '';
        }

        editSyncPlotHidden();

        var alpine = Alpine.$data(document.getElementById('listingWizard'));
        if (alpine && !alpine.checkAll()) {
            e.preventDefault();
            return;
        }

        var loader = document.getElementById('upload-loader');
        if (loader) loader.classList.add('active');

        window.onbeforeunload = null;
    });
});
</script>
@endpush
