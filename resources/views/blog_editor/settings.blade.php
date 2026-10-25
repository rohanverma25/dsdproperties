@extends('admin.layouts.app')

@section('content')
<div class="container-fluid p-4">

    {{-- Status bar --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h5 class="mb-0 fw-bold">Edit Blog #{{ $blog->id }}</h5>
            <small class="text-muted">Last saved: <span id="lastSavedAt">{{ $blog->updated_at?->format('d M Y, H:i:s') ?? '—' }}</span></small>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <span id="saveStatus" class="badge bg-secondary" style="font-size:13px;padding:7px 14px;">Ready</span>
            <button id="btnSaveAll" type="button" class="btn btn-primary btn-lg px-4 shadow-sm">
                💾 Save All Changes
            </button>
            <a href="{{ route('blog_editor.preview', $blog->id) }}" target="_blank" class="btn btn-outline-secondary">👁 Preview</a>
            <a href="{{ route('blog_editor.index') }}" class="btn btn-outline-dark">← Back</a>
        </div>
    </div>

    <div class="row g-3">

        {{-- ── LEFT: SEO & Meta ── --}}
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-dark text-white fw-semibold">SEO & Media</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Featured Image URL</label>
                        <input type="text" id="f_featured_image" class="form-control" value="{{ $blog->featured_image }}">
                        @if($blog->featured_image)
                        <img src="{{ $blog->featured_image }}" class="mt-2 rounded" style="max-width:100%;max-height:120px;object-fit:cover;" onerror="this.style.display='none'">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image Alt Text</label>
                        <input type="text" id="f_alt" class="form-control" value="{{ $blog->alt }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" id="f_meta_keywords" class="form-control" value="{{ $blog->meta_keywords }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description <small class="text-muted">(160 chars)</small></label>
                        <textarea id="f_meta_description" class="form-control" rows="3" maxlength="320">{{ $blog->meta_description }}</textarea>
                        <small class="text-muted"><span id="metaDescLen">{{ strlen($blog->meta_description ?? '') }}</span> / 160 chars</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SEO Schema (JSON-LD)</label>
                        <textarea id="f_seo_schema" class="form-control font-monospace" rows="4" style="font-size:12px;">{{ $blog->seo_schema }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-secondary text-white fw-semibold">Categorization & Status</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Primary Tag</label>
                        <input type="text" id="f_tag" class="form-control" value="{{ $blog->tag }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">All Tags <small class="text-muted">(comma separated)</small></label>
                        <input type="text" id="f_tags" class="form-control" value="{{ is_array($blog->tags) ? implode(', ', $blog->tags) : $blog->tags }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select id="f_status" class="form-select">
                            <option value="draft"     {{ $blog->status == 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $blog->status == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Language Code</label>
                        <input type="text" id="f_language" class="form-control" value="{{ $blog->language }}" placeholder="e.g. en">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── RIGHT: Blog Body ── --}}
        <div class="col-md-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white fw-semibold">Blog Body</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" id="f_title" class="form-control" value="{{ $blog->title }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Slug</label>
                            <input type="text" id="f_slug" class="form-control" value="{{ $blog->slug }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Blog Summary <small class="text-muted">(short excerpt)</small></label>
                        <textarea id="f_blog_summary" class="form-control" rows="2">{{ $blog->blog_summary }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Outline</label>
                        <textarea id="f_outline" class="form-control" rows="3">{{ is_array($blog->outline) ? json_encode($blog->outline, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : $blog->outline }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alternate Slug</label>
                        <input type="text" id="f_alternate_slug" class="form-control" value="{{ $blog->alternate_slug }}">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">
                            HTML Content <span class="text-danger">*</span>
                            <span class="badge bg-info text-dark ms-2" id="contentSizeLabel" style="font-size:11px;"></span>
                        </label>
                        <textarea id="editor">{{ $blog->content_html }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end align-items-center py-2">
                <span id="saveStatusBottom" class="text-muted small"></span>
                <button id="btnSaveAll2" type="button" class="btn btn-success btn-lg px-5 shadow">
                    💾 Save All Changes
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Toast container --}}
<div id="dsd-tc" style="position:fixed;top:18px;right:18px;z-index:99999;display:flex;flex-direction:column;gap:10px;"></div>

<script>
(function () {
    var AUTOSAVE_URL = '{{ route("blog_editor.autosave", $blog->id) }}';
    var METADATA_URL = '{{ route("blog_editor.save_metadata", $blog->id) }}';
    var CSRF         = '{{ csrf_token() }}';

    // ── Toast ────────────────────────────────────────────────────
    function toast(msg, type) {
        var c = document.getElementById('dsd-tc');
        var t = document.createElement('div');
        var colors = { success:'#166534', error:'#991b1b', info:'#1e40af' };
        t.style.cssText = 'min-width:260px;padding:12px 18px;border-radius:10px;font-size:14px;font-weight:600;color:#fff;background:'+(colors[type]||colors.info)+';box-shadow:0 4px 18px rgba(0,0,0,.2);display:flex;align-items:center;gap:10px;';
        t.innerHTML = '<span>' + (type==='success'?'✓':type==='error'?'✕':'ℹ') + '</span><span>' + msg + '</span>';
        c.appendChild(t);
        setTimeout(function(){ t.style.opacity='0'; t.style.transition='opacity .4s'; setTimeout(function(){ t.remove(); },400); }, 4000);
    }

    // ── Status badges ────────────────────────────────────────────
    function setStatus(msg, type) {
        ['saveStatus','saveStatusBottom'].forEach(function(id){
            var el = document.getElementById(id);
            if (!el) return;
            el.textContent = msg;
            if (el.tagName === 'SPAN' && el.classList.contains('badge')) {
                el.className = 'badge bg-' + (type==='success'?'success':type==='error'?'danger':type==='saving'?'warning text-dark':'secondary');
                el.style.fontSize = '13px'; el.style.padding = '7px 14px';
            } else {
                el.className = 'text-muted small';
            }
        });
    }

    // ── Get TinyMCE content ──────────────────────────────────────
    // format:'html' (default) lets TinyMCE decode its own mce:protected
    // comments back to real <style> blocks before returning the content.
    // valid_elements:'*[*]' + verify_html:false (set in tinymce.init)
    // prevent the serialiser from stripping inline CSS.
    function getContent() {
        var ed = (typeof tinymce !== 'undefined') ? tinymce.get('editor') : null;
        return ed ? ed.getContent() : document.getElementById('editor').value;
    }

    // ── AJAX helper ──────────────────────────────────────────────
    // content_html is base64-encoded so hosting WAF (ModSecurity) does not
    // mistake the HTML payload for an XSS attack and return 403 Forbidden.
    function post(url, payload) {
        if (payload.content_html !== undefined) {
            payload.content_html = btoa(unescape(encodeURIComponent(payload.content_html)));
            payload._b64 = 1;
        }
        return fetch(url, {
            method:  'POST',
            headers: { 'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN': CSRF },
            body:    JSON.stringify(payload),
        }).then(function(r) {
            if (!r.ok) {
                return r.text().then(function(t) {
                    throw new Error('HTTP ' + r.status + ' — ' + t.substring(0, 120));
                });
            }
            return r.json();
        });
    }

    // ── Collect all metadata fields ──────────────────────────────
    function getMeta() {
        return {
            title:            document.getElementById('f_title').value,
            slug:             document.getElementById('f_slug').value,
            featured_image:   document.getElementById('f_featured_image').value,
            alt:              document.getElementById('f_alt').value,
            meta_description: document.getElementById('f_meta_description').value,
            meta_keywords:    document.getElementById('f_meta_keywords').value,
            tag:              document.getElementById('f_tag').value,
            tags:             document.getElementById('f_tags').value,
            outline:          document.getElementById('f_outline').value,
            seo_schema:       document.getElementById('f_seo_schema').value,
            blog_summary:     document.getElementById('f_blog_summary').value,
            language:         document.getElementById('f_language').value,
            alternate_slug:   document.getElementById('f_alternate_slug').value,
            status:           document.getElementById('f_status').value,
        };
    }

    // ── Main save (two-step) ─────────────────────────────────────
    function saveAll() {
        if (!document.getElementById('f_title').value.trim()) {
            toast('Title is required.', 'error'); return;
        }

        setStatus('Saving content…', 'saving');
        ['btnSaveAll','btnSaveAll2'].forEach(function(id){
            var b = document.getElementById(id); if(b) b.disabled = true;
        });

        // Step 1 — save content_html only (potentially large)
        post(AUTOSAVE_URL, { content_html: getContent() })
            .then(function(r1) {
                if (r1.status !== 'success') throw new Error(r1.message || 'Content save failed');
                setStatus('Saving settings…', 'saving');

                // Step 2 — save all other small metadata fields
                return post(METADATA_URL, getMeta());
            })
            .then(function(r2) {
                if (r2.status !== 'success') throw new Error(r2.message || 'Metadata save failed');
                setStatus('All saved ✓', 'success');
                var el = document.getElementById('lastSavedAt'); if(el) el.textContent = r2.saved_at;
                toast('Blog saved successfully!', 'success');
                dirty = false;
            })
            .catch(function(err) {
                setStatus('Save failed ✕', 'error');
                toast('Save failed: ' + err.message, 'error');
            })
            .finally(function() {
                ['btnSaveAll','btnSaveAll2'].forEach(function(id){
                    var b = document.getElementById(id); if(b) b.disabled = false;
                });
            });
    }

    // ── Auto-save content every 60 s ─────────────────────────────
    setInterval(function(){
        var c = getContent();
        if (!c) return;
        post(AUTOSAVE_URL, { content_html: c }).then(function(r){
            if (r.status === 'success') {
                setStatus('Auto-saved ' + r.saved_at, 'secondary');
                var lbl = document.getElementById('contentSizeLabel');
                if (lbl && r.size_kb) lbl.textContent = r.size_kb + ' KB';
            }
        }).catch(function(){});
    }, 60000);

    // ── Meta description char counter ────────────────────────────
    var mdEl = document.getElementById('f_meta_description');
    var mlEl = document.getElementById('metaDescLen');
    if (mdEl && mlEl) mdEl.addEventListener('input', function(){
        mlEl.textContent = this.value.length;
        mlEl.style.color = this.value.length > 160 ? '#dc2626' : '';
    });

    // ── Bind buttons ─────────────────────────────────────────────
    document.getElementById('btnSaveAll').addEventListener('click',  saveAll);
    document.getElementById('btnSaveAll2').addEventListener('click', saveAll);

    // ── Ctrl+S / Cmd+S ───────────────────────────────────────────
    document.addEventListener('keydown', function(e){
        if ((e.ctrlKey||e.metaKey) && e.key==='s') { e.preventDefault(); saveAll(); }
    });

    // ── Unsaved changes warning ───────────────────────────────────
    var dirty = false;
    document.querySelectorAll('input,textarea,select').forEach(function(el){
        el.addEventListener('change', function(){ dirty = true; });
    });
    window.addEventListener('beforeunload', function(e){
        if (dirty) { e.preventDefault(); e.returnValue = ''; }
    });
})();
</script>
@endsection
