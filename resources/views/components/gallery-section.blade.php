@php
    $isNews = $gallery->type === 'news_clipping';
@endphp
<section class="dsd-gallery-section" style="margin:36px 0;">
    <style>
        .dsd-gallery-section .dsd-gallery-head {
            font-size:clamp(1.05rem,2.2vw,1.25rem); font-weight:800;
            color:var(--text-primary,#111827); line-height:1.3;
            margin-bottom:18px; font-family:'Poppins',sans-serif;
            display:flex; align-items:center; gap:8px;
        }
        .dsd-gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px; }
        .dsd-gallery-card {
            background:var(--card-bg,#fff); border:1px solid var(--border-color,#e5e7eb);
            border-radius:14px; overflow:hidden; box-shadow:0 3px 14px rgba(0,0,0,.06);
            display:flex; flex-direction:column; transition:transform .2s, box-shadow .2s;
        }
        .dsd-gallery-card:hover { transform:translateY(-3px); box-shadow:0 10px 26px rgba(0,0,0,.1); }
        .dsd-gallery-date-bar {
            display:flex; align-items:center; gap:6px;
            background:#f3f4f6; padding:8px 12px;
            font-size:.75rem; font-weight:800; color:#011f4b;
            font-family:'Poppins',sans-serif; letter-spacing:.2px;
            border-bottom:1px solid var(--border-color,#e5e7eb);
        }
        .dsd-gallery-img-wrap { background:#f3f4f6; }
        .dsd-gallery-card img { width:100%; height:auto; max-height:420px; object-fit:contain; display:block; cursor:zoom-in; }
        .dsd-gallery-body { padding:12px 14px 14px; flex:1; display:flex; flex-direction:column; }
        .dsd-gallery-caption { font-size:.85rem; color:var(--text-secondary,#374151); line-height:1.5; margin:0; }
        .dsd-gallery-lightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,.85); z-index:99999; align-items:center; justify-content:center; padding:20px; }
        .dsd-gallery-lightbox img { max-width:92vw; max-height:88vh; border-radius:6px; }
    </style>

    <div class="dsd-gallery-head">
        {{ $isNews ? '📰' : '📸' }} {{ $gallery->name }}
    </div>

    <div class="dsd-gallery-grid">
        @foreach($gallery->images as $image)
        <div class="dsd-gallery-card">
            @if($isNews && $image->published_on)
            <div class="dsd-gallery-date-bar">
                📅 {{ $image->published_on->format('d M Y') }}
            </div>
            @endif
            <div class="dsd-gallery-img-wrap">
                <img src="{{ $image->url }}" alt="{{ $image->caption ?? $gallery->name }}" loading="lazy"
                     onclick="dsdGalleryOpen(this.src)">
            </div>
            @if(!$isNews && $image->caption)
            <div class="dsd-gallery-body">
                <p class="dsd-gallery-caption">{{ $image->caption }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>

@once
<div class="dsd-gallery-lightbox" id="dsdGalleryLightbox" onclick="this.style.display='none'">
    <img id="dsdGalleryLightboxImg" src="" alt="">
</div>
<script>
    function dsdGalleryOpen(src) {
        var box = document.getElementById('dsdGalleryLightbox');
        var img = document.getElementById('dsdGalleryLightboxImg');
        if (!box || !img) return;
        img.src = src;
        box.style.display = 'flex';
    }
</script>
@endonce
