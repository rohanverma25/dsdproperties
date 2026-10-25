@extends('admin.layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div>
        <h5 class="mb-0 fw-bold">Quick Content Editor — #{{ $blog->id }}: {{ Str::limit($blog->title, 60) }}</h5>
        <small class="text-muted">
            Auto-saves every 30 s &nbsp;·&nbsp; Last saved: <span id="lastSavedAt">{{ $blog->updated_at?->format('d M Y, H:i:s') ?? '—' }}</span>
        </small>
    </div>
    <div class="d-flex gap-2 align-items-center">
        <span id="saveStatus" class="badge bg-secondary px-3 py-2">Ready</span>
        <a href="{{ route('blog_editor.full_edit', $blog->id) }}" class="btn btn-outline-secondary">⚙ Full Edit</a>
        <a href="{{ route('blog_editor.preview', $blog->id) }}" target="_blank" class="btn btn-outline-info">👁 Preview</a>
        <a href="{{ route('blog_editor.index') }}" class="btn btn-outline-dark">← Back</a>
    </div>
</div>

<textarea id="editor">{{ $blog->content_html }}</textarea>

{{-- Toast container --}}
<div id="dsd-tc" style="position:fixed;top:18px;right:18px;z-index:99999;display:flex;flex-direction:column;gap:10px;"></div>

<script>
(function(){
    var AUTOSAVE_URL = '{{ route("blog_editor.autosave", $blog->id) }}';
    var CSRF         = '{{ csrf_token() }}';
    var lastContent  = '';
    var debTimer     = null;

    function toast(msg, type) {
        var c = document.getElementById('dsd-tc');
        var t = document.createElement('div');
        var colors = { success:'#166534', error:'#991b1b', info:'#1e40af' };
        t.style.cssText = 'min-width:260px;padding:12px 18px;border-radius:10px;font-size:14px;font-weight:600;color:#fff;background:'+(colors[type]||colors.info)+';box-shadow:0 4px 18px rgba(0,0,0,.2);';
        t.textContent = msg;
        c.appendChild(t);
        setTimeout(function(){ t.style.opacity='0'; t.style.transition='opacity .4s'; setTimeout(function(){ t.remove(); },400); }, 4000);
    }

    function setStatus(msg, type) {
        var el = document.getElementById('saveStatus');
        if (!el) return;
        el.textContent = msg;
        el.className = 'badge px-3 py-2 bg-' +
            (type==='success'?'success':type==='error'?'danger':type==='saving'?'warning text-dark':'secondary');
    }

    function doSave() {
        var ed = (typeof tinymce !== 'undefined') ? tinymce.get('editor') : null;
        var content = ed ? ed.getContent() : document.getElementById('editor').value;
        if (content === lastContent) return;
        setStatus('Saving…', 'saving');
        // base64-encode so hosting WAF does not block HTML in POST body
        var encoded = btoa(unescape(encodeURIComponent(content)));
        fetch(AUTOSAVE_URL, {
            method:  'POST',
            headers: { 'Content-Type':'application/json', 'Accept':'application/json', 'X-CSRF-TOKEN': CSRF },
            body:    JSON.stringify({ content_html: encoded, _b64: 1 }),
        })
        .then(function(r) {
            if (!r.ok) return r.text().then(function(t){ throw new Error('HTTP ' + r.status + ' — ' + t.substring(0,120)); });
            return r.json();
        })
        .then(function(data){
            if (data.status === 'success') {
                lastContent = content;
                setStatus('Saved ✓ ' + data.saved_at + (data.size_kb?' ('+data.size_kb+' KB)':''), 'success');
                var el = document.getElementById('lastSavedAt'); if(el) el.textContent = data.saved_at;
            } else {
                setStatus('Error ✕', 'error');
                toast('Save failed: ' + (data.message||'unknown'), 'error');
            }
        })
        .catch(function(){ setStatus('Network error ✕', 'error'); });
    }

    // Auto-save every 30 s
    setInterval(doSave, 30000);

    // Ctrl+S / Cmd+S
    document.addEventListener('keydown', function(e){
        if ((e.ctrlKey||e.metaKey) && e.key==='s') { e.preventDefault(); doSave(); }
    });

    // Debounced save on typing — retry until TinyMCE is ready
    function attachInputListener() {
        var ed = (typeof tinymce !== 'undefined') ? tinymce.get('editor') : null;
        if (ed) {
            ed.on('input keyup', function(){
                clearTimeout(debTimer);
                debTimer = setTimeout(doSave, 5000);
            });
        } else {
            setTimeout(attachInputListener, 400);
        }
    }
    attachInputListener();
})();
</script>
@endsection
