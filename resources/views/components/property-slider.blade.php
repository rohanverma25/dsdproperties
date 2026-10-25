@php
    use Illuminate\Support\Str;
    $sliderId = 'pslider-' . Str::random(8);
    $count    = $properties->count();

    // Uppercase known abbreviations so "it-city" → "IT City"
    $abbr = ['it','lda','rera','sez','hcl','up','rwa','cbd','nri'];
    $tagLabel = collect($tags)->map(function($t) use ($abbr) {
        $words = explode(' ', ucwords(str_replace('-', ' ', $t)));
        return implode(' ', array_map(fn($w) => in_array(strtolower($w), $abbr) ? strtoupper($w) : $w, $words));
    })->implode(' & ');

    $heading = $title ?? 'Properties in ' . $tagLabel;
@endphp

@once
<style>
/* ── Property Slider ── */
.pslider{margin:2.5rem 0;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 20px rgba(1,31,75,.08);border:1px solid #e2e8f0;font-family:'Poppins',sans-serif;}

/* header */
.pslider-hd{display:flex;justify-content:space-between;align-items:center;padding:1rem 1.25rem;background:linear-gradient(135deg,#011f4b,#013a7a);border-bottom:3px solid #FF5C00;gap:1rem;}
.pslider-hd-left{display:flex;align-items:center;gap:.65rem;}
.pslider-hd-icon{width:36px;height:36px;background:rgba(255,255,255,.12);border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:.95rem;flex-shrink:0;}
.pslider-hd-title{font-size:.93rem;font-weight:700;margin:0;line-height:1.3;}
.pslider-hd-sub{font-size:.67rem;margin:.1rem 0 0;}
.pslider-btns{display:flex;gap:.38rem;flex-shrink:0;}
.pslider-btn{width:30px;height:30px;border:1px solid rgba(255,255,255,.22);border-radius:8px;background:rgba(255,255,255,.1);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.68rem;transition:all .18s;padding:0;}
.pslider-btn:hover{background:rgba(255,255,255,.25);border-color:rgba(255,255,255,.45);}

/* viewport */
.pslider-vp{overflow-x:auto;padding:.85rem 1.25rem 1rem;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;scrollbar-width:none;scroll-behavior:smooth;}
.pslider-vp::-webkit-scrollbar{display:none;}
.pslider-track{display:flex;gap:14px;}

/* card */
.psc{flex-shrink:0;width:242px;background:#fff;border:1px solid #e8edf3;border-radius:13px;overflow:hidden;scroll-snap-align:start;transition:transform .22s,box-shadow .22s,border-color .22s;display:flex;flex-direction:column;}
.psc:hover{transform:translateY(-3px);box-shadow:0 10px 28px rgba(1,31,75,.12);border-color:#c7d8e8;}

/* ── image ── */
.psc-img-wrap{position:relative;display:block;height:155px;overflow:hidden;text-decoration:none;background:#f1f5f9;}
.psc-img{width:100%;height:100%;object-fit:cover;transition:transform .38s;}
.psc:hover .psc-img{transform:scale(1.06);}
.psc-img-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(1,31,75,.65) 0%,transparent 55%);pointer-events:none;}

/* ── no-image placeholder ── */
.psc-no-img{width:100%;height:155px;background:linear-gradient(160deg,#f0f7f6,#e6f2f5);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.5rem;border-bottom:1px solid #d9eaec;}
.psc-no-img i{font-size:2.2rem;color:#008080;opacity:.35;}
.psc-no-img span{font-size:.62rem;font-weight:600;letter-spacing:.07em;text-transform:uppercase;color:#94a3b8;}

/* ── badges on real image (white text, dark bg overlay) ── */
.psc-badges{position:absolute;bottom:.55rem;left:.55rem;right:.55rem;display:flex;justify-content:space-between;align-items:flex-end;gap:.35rem;}
.psc-txn{font-size:.56rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:.18rem .58rem;border-radius:50px;}
.psc-txn-buy{background:rgba(5,122,85,.88);color:#fff;}
.psc-txn-rent{background:rgba(29,78,216,.88);color:#fff;}
.psc-price-badge{font-size:.8rem;font-weight:800;color:#fff;text-shadow:0 1px 5px rgba(0,0,0,.5);line-height:1;}

/* ── badges on no-image (adapted for light bg) ── */
.psc-no-img~.psc-badges .psc-txn-buy{background:rgba(5,122,85,.1);color:#057a55;border:1px solid rgba(5,122,85,.25);}
.psc-no-img~.psc-badges .psc-txn-rent{background:rgba(29,78,216,.1);color:#1d4ed8;border:1px solid rgba(29,78,216,.2);}
.psc-no-img~.psc-badges .psc-price-badge{color:#011f4b;text-shadow:none;font-size:.85rem;}

/* ── card body ── */
.psc-body{padding:.72rem .88rem .5rem;flex:1;}
.psc-title{font-size:.79rem;font-weight:700;color:#111827;margin:0 0 .3rem;line-height:1.38;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.psc-title a{text-decoration:none;}
.psc-title a:hover{color:#008080;}
.psc-loc{font-size:.68rem;display:flex;align-items:center;gap:.22rem;margin-bottom:.4rem;}
.psc-loc i{font-size:.58rem;flex-shrink:0;}
.psc-specs{display:flex;flex-wrap:wrap;gap:.27rem;}
.psc-spec{font-size:.61rem;background:#f3f7fa;padding:.13rem .48rem;border-radius:50px;display:inline-flex;align-items:center;gap:.2rem;border:1px solid #e4ecf2;}
.psc-spec i{font-size:.53rem;}

/* ── card footer ── */
.psc-foot{padding:.48rem .88rem .62rem;display:flex;justify-content:space-between;align-items:center;margin-top:auto;border-top:1px solid #f1f5f9;}
.psc-type-lbl{font-size:.6rem;font-weight:500;text-transform:capitalize;}
.psc-view{font-size:.67rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.22rem;background:rgba(0,128,128,.09);padding:.24rem .6rem;border-radius:50px;transition:all .18s;}
.psc-view:hover{background:rgba(0,128,128,.18);gap:.38rem;text-decoration:none;}

/* ── bottom bar ── */
.pslider-footer{padding:.6rem 1.25rem;border-top:1px solid #e8edf3;background:#fafbfc;display:flex;align-items:center;justify-content:space-between;}
.pslider-footer-note{font-size:.65rem;display:flex;align-items:center;gap:.32rem;}
.pslider-footer-note i{font-size:.48rem;}
.pslider-all{font-size:.71rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:.28rem;transition:color .15s;}
.pslider-all:hover{text-decoration:none;}

/* ── specificity overrides for .blog-content p/span/li rules ── */
.pslider .pslider-hd-title{color:#fff}
.pslider .pslider-hd-sub{color:rgba(255,255,255,.6)}
.pslider .pslider-btn{color:#fff}
.pslider .psc-price-badge{color:#fff}
.pslider .psc-txn-buy,.pslider .psc-txn-rent{color:#fff}
.pslider .psc-no-img~.psc-badges .psc-txn-buy{color:#057a55}
.pslider .psc-no-img~.psc-badges .psc-txn-rent{color:#1d4ed8}
.pslider .psc-no-img~.psc-badges .psc-price-badge{color:#011f4b}
.pslider .psc-title a{color:#111827}
.pslider .psc-loc{color:#6b7280}
.pslider .psc-loc i{color:#008080}
.pslider .psc-spec{color:#374151}
.pslider .psc-spec i{color:#008080}
.pslider .psc-type-lbl{color:#9ca3af}
.pslider .psc-view{color:#008080}
.pslider .psc-view:hover{color:#006666}
.pslider .pslider-footer-note{color:#9ca3af}
.pslider .pslider-footer-note i{color:#4ade80}
.pslider .pslider-all{color:#011f4b}
.pslider .pslider-all:hover{color:#008080}
.pslider .psc-no-img i{color:#008080}
.pslider .psc-no-img span{color:#94a3b8}

/* ── dark mode ── */
[data-theme=dark] .pslider{background:#1f2937;border-color:#374151;}
[data-theme=dark] .pslider-hd{background:linear-gradient(135deg,#0a1628,#011f4b);}
[data-theme=dark] .psc{background:#1f2937;border-color:#374151;}
[data-theme=dark] .psc-no-img{background:linear-gradient(160deg,#1a3a3a,#1a3045);border-color:#374151;}
[data-theme=dark] .pslider .psc-no-img i{color:#14b8a6}
[data-theme=dark] .pslider .psc-title a{color:#f1f5f9}
[data-theme=dark] .pslider .psc-loc{color:#9ca3af}
[data-theme=dark] .psc-spec{background:#374151;border-color:#4b5563}
[data-theme=dark] .pslider .psc-spec{color:#d1d5db}
[data-theme=dark] .psc-foot{border-color:#374151}
[data-theme=dark] .pslider .psc-type-lbl{color:#6b7280}
[data-theme=dark] .pslider-footer{background:#111827;border-color:#374151;}
[data-theme=dark] .pslider .pslider-footer-note{color:#6b7280}
[data-theme=dark] .pslider .pslider-all{color:#d1d5db}
[data-theme=dark] .pslider .psc-view{background:rgba(0,128,128,.18)}

@media(max-width:600px){.psc{width:220px;}.psc-img-wrap,.psc-no-img{height:138px;}}
</style>
<script>
window.pSliderMove = function(id, dir) {
    var vp = document.querySelector('#' + id + ' .pslider-vp');
    var card = vp && vp.querySelector('.psc');
    if (!card) return;
    vp.scrollBy({ left: dir * (card.offsetWidth + 14) * 2, behavior: 'smooth' });
};
</script>
@endonce

<div class="pslider" id="{{ $sliderId }}">

    {{-- Header --}}
    <div class="pslider-hd">
        <div class="pslider-hd-left">
            <div class="pslider-hd-icon"><i class="fas fa-building" style="color:#fff;"></i></div>
            <div>
                <p class="pslider-hd-title">{{ $heading }}</p>
                <p class="pslider-hd-sub">{{ $count }} {{ $count === 1 ? 'property' : 'properties' }} available &middot; Lucknow</p>
            </div>
        </div>
        @if($count > 1)
        <div class="pslider-btns">
            <button class="pslider-btn" onclick="pSliderMove('{{ $sliderId }}',-1)" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="pslider-btn" onclick="pSliderMove('{{ $sliderId }}',1)" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        @endif
    </div>

    {{-- Cards --}}
    <div class="pslider-vp">
        <div class="pslider-track">
            @foreach($properties as $p)
            @php
                $hasImage = ($p->featured_image && file_exists(public_path($p->featured_image)))
                         || $p->images->isNotEmpty();
                $typeIcon = match(true) {
                    in_array(strtolower($p->property_type ?? ''), ['villa','house','independent house']) => 'fa-house',
                    in_array(strtolower($p->property_type ?? ''), ['plot','land'])                      => 'fa-map',
                    in_array(strtolower($p->property_type ?? ''), ['commercial','shop','office'])       => 'fa-store',
                    default => 'fa-building',
                };
            @endphp
            <div class="psc">

                <a href="{{ route('properties.show', $p->slug) }}" class="psc-img-wrap">
                    @if($hasImage)
                        <img src="{{ $p->getFeaturedImage() }}"
                             alt="{{ e($p->title) }}"
                             class="psc-img"
                             loading="lazy"
                             width="242" height="155">
                        <div class="psc-img-overlay"></div>
                    @else
                        <div class="psc-no-img">
                            <i class="fas {{ $typeIcon }}"></i>
                            <span>{{ $p->getTypeLabel() }}</span>
                        </div>
                    @endif

                    <div class="psc-badges">
                        <span class="psc-txn {{ $p->transaction_type === 'rent' ? 'psc-txn-rent' : 'psc-txn-buy' }}">
                            {{ $p->transaction_type === 'rent' ? 'For Rent' : 'For Sale' }}
                        </span>
                        <span class="psc-price-badge">{{ $p->getPriceDisplay() }}</span>
                    </div>
                </a>

                <div class="psc-body">
                    <p class="psc-title">
                        <a href="{{ route('properties.show', $p->slug) }}">{{ Str::limit($p->title, 60) }}</a>
                    </p>
                    <div class="psc-loc">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $p->locality ?: Str::limit($p->address, 35) }}
                    </div>
                    <div class="psc-specs">
                        @if($p->bedrooms)
                        <span class="psc-spec"><i class="fas fa-bed"></i>{{ $p->bedrooms }} Bed</span>
                        @endif
                        @if($p->bathrooms)
                        <span class="psc-spec"><i class="fas fa-bath"></i>{{ $p->bathrooms }} Bath</span>
                        @endif
                        @if($p->area)
                        <span class="psc-spec"><i class="fas fa-ruler-combined"></i>{{ number_format($p->area) }} {{ $p->getAreaUnitLabel() }}</span>
                        @endif
                    </div>
                </div>

                <div class="psc-foot">
                    <span class="psc-type-lbl">{{ $p->getTypeLabel() }}</span>
                    <a href="{{ route('properties.show', $p->slug) }}" class="psc-view">
                        View <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    {{-- Footer --}}
    <div class="pslider-footer">
        <span class="pslider-footer-note">
            <i class="fas fa-circle"></i> Verified by DSD Properties
        </span>
        <a href="{{ route('properties.index') }}" class="pslider-all">
            View All <i class="fas fa-arrow-right"></i>
        </a>
    </div>

</div>
