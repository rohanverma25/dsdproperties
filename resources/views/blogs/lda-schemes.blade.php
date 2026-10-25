@extends('layouts.user-app')

@section('title', 'LDA Schemes Lucknow – All Active & Upcoming Projects | DSD Properties')
@section('meta_description', 'Browse all Lucknow Development Authority (LDA) housing schemes – CG City, Anant Nagar, Varun Vihar, Wellness City, PMAY flats and more. Check status, pricing, ballot dates and availability.')
@section('meta_keywords', 'LDA schemes Lucknow, LDA housing scheme, Anant Nagar Yojna, CG City IT City, Varun Vihar, Naimish Nagar, Wellness City, LDA plots, LDA flats, PMAY LDA')

@push('head')
<style>
.lda-page { background-color: var(--bg-secondary, #f3f4f6); min-height: 100vh; }

/* Hero */
.lda-hero {
    background: linear-gradient(135deg, #011f4b 0%, #013a75 50%, #008080 100%);
    padding: 3rem 1rem 2.5rem;
    color: #fff;
}
.lda-hero h1 { font-size: clamp(1.4rem, 3vw, 2.1rem); font-weight: 700; margin-bottom: .4rem; }
.lda-hero p  { font-size: .92rem; opacity: .85; max-width: 620px; margin: 0; }
.hero-stats  { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1.4rem; }
.stat-pill {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.22);
    border-radius: 50px;
    padding: .3rem .9rem;
    font-size: .78rem;
    font-weight: 500;
}

/* Controls */
.lda-controls {
    background: var(--bg-primary, #fff);
    border-bottom: 1px solid var(--border-color, #e5e7eb);
    padding: .75rem 1rem;
    position: sticky;
    top: 0;
    z-index: 40;
}
.lda-controls-inner {
    max-width: 1200px; margin: 0 auto;
    display: flex; flex-wrap: wrap; gap: .5rem; align-items: center;
}
.lda-search {
    flex: 1; min-width: 180px;
    padding: .45rem .8rem;
    border: 1px solid var(--border-color, #d1d5db);
    border-radius: 8px;
    font-size: .85rem;
    background: var(--input-bg, #fff);
    color: var(--text-primary, #111827);
    font-family: 'Poppins', sans-serif;
}
.lda-search:focus { outline: none; border-color: #011f4b; box-shadow: 0 0 0 3px rgba(1,31,75,.1); }
.lda-filter-btn {
    padding: .38rem .9rem;
    border: 1px solid var(--border-color, #d1d5db);
    border-radius: 50px;
    font-size: .78rem; font-weight: 500;
    cursor: pointer;
    background: var(--bg-primary, #fff);
    color: var(--text-secondary, #4b5563);
    transition: all .15s;
    font-family: 'Poppins', sans-serif;
    white-space: nowrap;
}
.lda-filter-btn:hover, .lda-filter-btn.active { background: #011f4b; color: #fff; border-color: #011f4b; }
.lda-sort {
    padding: .38rem .7rem;
    border: 1px solid var(--border-color, #d1d5db);
    border-radius: 8px;
    font-size: .8rem;
    background: var(--input-bg, #fff);
    color: var(--text-primary, #111827);
    font-family: 'Poppins', sans-serif;
    cursor: pointer;
}
.lda-count { font-size: .8rem; color: var(--text-tertiary, #6b7280); white-space: nowrap; }

/* Grid */
.lda-grid {
    max-width: 1200px; margin: 0 auto;
    padding: 1.25rem 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 1rem;
}

/* Card */
.lda-card {
    background: var(--card-bg, #fff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 14px; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    display: flex; flex-direction: column;
}
.lda-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(1,31,75,.1); }
.lda-card.featured { border-color: #008080; }

.lda-card-header {
    background: linear-gradient(135deg, #011f4b, #013a75);
    padding: .9rem 1rem .75rem;
    position: relative;
}
.lda-card.auction .lda-card-header { background: linear-gradient(135deg, #6d28d9, #4f46e5); }
.card-id   { font-size: .68rem; color: rgba(255,255,255,.5); letter-spacing: .05em; margin-bottom: .2rem; }
.card-name { font-size: .98rem; font-weight: 600; color: #fff; line-height: 1.35; }
.card-loc  { font-size: .75rem; color: rgba(255,255,255,.68); margin-top: .28rem; display: flex; align-items: center; gap: .25rem; }

.lda-badge {
    position: absolute; top: .85rem; right: .85rem;
    padding: .22rem .65rem; border-radius: 50px;
    font-size: .68rem; font-weight: 600;
    letter-spacing: .04em; text-transform: uppercase;
}
.badge-active    { background: #d1fae5; color: #065f46; }
.badge-upcoming  { background: #fef3c7; color: #92400e; }
.badge-completed { background: #dbeafe; color: #1e40af; }
.badge-paused    { background: #f3f4f6; color: #374151; }

/* Progress */
.lda-progress { padding: .6rem 1rem; border-bottom: 1px solid var(--border-color, #e5e7eb); }
.prog-label   { display: flex; justify-content: space-between; font-size: .7rem; color: var(--text-tertiary, #6b7280); margin-bottom: .28rem; }
.prog-bar     { height: 5px; background: var(--bg-tertiary, #e5e7eb); border-radius: 99px; overflow: hidden; }
.prog-fill    { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #011f4b, #008080); }

/* Meta */
.lda-meta { padding: .65rem 1rem; display: grid; grid-template-columns: 1fr 1fr; gap: .45rem; }
.meta-label { font-size: .67rem; color: var(--text-tertiary, #6b7280); text-transform: uppercase; letter-spacing: .04em; }
.meta-value { font-size: .8rem; font-weight: 600; color: var(--text-primary, #111827); margin-top: 1px; }
.meta-value.avail { color: #059669; }

/* Tags */
.lda-tags { padding: 0 1rem .65rem; display: flex; flex-wrap: wrap; gap: .3rem; }
.lda-tag {
    font-size: .67rem; padding: .18rem .55rem;
    background: var(--bg-secondary, #f3f4f6);
    color: var(--text-secondary, #4b5563);
    border-radius: 50px;
    border: 1px solid var(--border-color, #e5e7eb);
}

/* Description */
.lda-desc { padding: 0 1rem .65rem; font-size: .78rem; color: var(--text-secondary, #4b5563); line-height: 1.55; flex: 1; }

/* Footer */
.lda-card-foot { padding: .65rem 1rem; border-top: 1px solid var(--border-color, #e5e7eb); display: flex; gap: .4rem; }
.btn-primary {
    flex: 1; padding: .45rem .7rem;
    background: #011f4b; color: #fff;
    border: none; border-radius: 8px;
    font-size: .78rem; font-weight: 600;
    cursor: pointer; text-align: center;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: background .15s;
    display: inline-flex; align-items: center; justify-content: center; gap: .3rem;
}
.btn-primary:hover { background: #013a75; color: #fff; text-decoration: none; }
.btn-outline {
    padding: .45rem .7rem;
    background: transparent; color: #011f4b;
    border: 1px solid #011f4b; border-radius: 8px;
    font-size: .78rem; font-weight: 600;
    text-decoration: none; font-family: 'Poppins', sans-serif;
    transition: all .15s;
    display: inline-flex; align-items: center; gap: .3rem;
}
.btn-outline:hover { background: #011f4b; color: #fff; text-decoration: none; }

/* Empty */
.lda-empty { grid-column: 1/-1; text-align: center; padding: 4rem 1rem; color: var(--text-tertiary, #6b7280); }
.lda-empty i { font-size: 2.2rem; margin-bottom: .8rem; display: block; }

/* Dark mode */
[data-theme="dark"] .lda-tag { background: #374151; color: #d1d5db; border-color: #4b5563; }
[data-theme="dark"] .lda-card { border-color: #374151; }
[data-theme="dark"] .prog-bar { background: #374151; }

@media (max-width: 600px) {
    .lda-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="lda-page">

    {{-- Hero --}}
    <section class="lda-hero">
        <div style="max-width:1200px;margin:0 auto;">
            <p style="font-size:.75rem;opacity:.55;margin-bottom:.5rem;">
                <a href="/" style="color:inherit;text-decoration:none;">Home</a> &rsaquo; LDA Schemes
            </p>
            <h1><i class="fas fa-city" style="margin-right:.45rem;"></i>LDA Lucknow – All Schemes</h1>
            <p>Latest housing schemes, plots &amp; township projects by Lucknow Development Authority. Status, pricing &amp; ballot dates updated regularly.</p>
            <div class="hero-stats">
                <span class="stat-pill"><i class="fas fa-check-circle" style="margin-right:.3rem;color:#34d399;"></i>{{ $stats['active'] }} Active</span>
                <span class="stat-pill"><i class="fas fa-clock" style="margin-right:.3rem;color:#fbbf24;"></i>{{ $stats['upcoming'] }} Upcoming</span>
                <span class="stat-pill"><i class="fas fa-home" style="margin-right:.3rem;"></i>{{ $stats['total'] }} Total</span>
                <span class="stat-pill" style="opacity:.7;font-size:.72rem;">
                    <i class="fas fa-sync-alt" style="margin-right:.3rem;"></i>Updated: {{ $lastUpdated }}
                </span>
            </div>
        </div>
    </section>

    {{-- Controls --}}
    <div class="lda-controls">
        <div class="lda-controls-inner">
            <input type="text" id="lda-search" class="lda-search" placeholder="Search schemes, locations…" autocomplete="off">
            <button class="lda-filter-btn active" data-filter="all">All</button>
            <button class="lda-filter-btn" data-filter="Active">Active</button>
            <button class="lda-filter-btn" data-filter="Upcoming">Upcoming</button>
            <button class="lda-filter-btn" data-filter="Completed">Completed</button>
            <select class="lda-sort" id="lda-sort">
                <option value="default">Default order</option>
                <option value="name">Name A–Z</option>
                <option value="price_asc">Price: Low → High</option>
                <option value="price_desc">Price: High → Low</option>
                <option value="progress">Progress %</option>
            </select>
            <span class="lda-count" id="lda-count">{{ count($schemes) }} schemes</span>
        </div>
    </div>

    {{-- Cards grid --}}
    <div class="lda-grid" id="lda-grid">

        @forelse ($schemes as $s)
        @php
            $isAuction = ($s['allotment_type'] ?? '') === 'E-Auction';
            $featured  = ($s['featured'] ?? false) ? 'featured' : '';
            $statusKey = strtolower($s['status'] ?? 'active');
        @endphp

        <div class="lda-card {{ $featured }} {{ $isAuction ? 'auction' : '' }}"
             data-status="{{ $s['status'] }}"
             data-search="{{ strtolower(($s['name'] ?? '') . ' ' . ($s['location'] ?? '') . ' ' . ($s['category'] ?? '')) }}"
             data-price="{{ $s['price_per_sqm'] ?? 0 }}"
             data-progress="{{ $s['progress_pct'] ?? 0 }}"
             data-order="{{ $s['sort_order'] ?? 99 }}">

            {{-- Header --}}
            <div class="lda-card-header">
                <div class="card-id">{{ $s['scheme_id'] ?? '' }} &bull; {{ $s['category'] ?? '' }}</div>
                <div class="card-name">{{ $s['name'] ?? '' }}</div>
                <div class="card-loc">
                    <i class="fas fa-map-marker-alt" style="font-size:.65rem;"></i>
                    {{ $s['location'] ?? '' }}
                </div>
                <span class="lda-badge badge-{{ $statusKey }}">{{ $s['status'] }}</span>
            </div>

            {{-- Progress bar --}}
            @if(($s['progress_pct'] ?? 0) > 0)
            <div class="lda-progress">
                <div class="prog-label">
                    <span>{{ $s['phase'] ?? '' }}</span>
                    <span>{{ $s['progress_pct'] }}% complete</span>
                </div>
                <div class="prog-bar">
                    <div class="prog-fill" style="width:{{ $s['progress_pct'] }}%"></div>
                </div>
            </div>
            @endif

            {{-- Meta grid --}}
            <div class="lda-meta">
                @if(($s['area_acres'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-ruler-combined" style="font-size:.62rem;margin-right:.2rem;"></i>Area</div>
                    <div class="meta-value">{{ number_format($s['area_acres']) }} Acres</div>
                </div>
                @endif

                @if(($s['total_units'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-layer-group" style="font-size:.62rem;margin-right:.2rem;"></i>Total Units</div>
                    <div class="meta-value">{{ number_format($s['total_units']) }}</div>
                </div>
                @endif

                @if(($s['units_available'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-door-open" style="font-size:.62rem;margin-right:.2rem;"></i>Available</div>
                    <div class="meta-value avail">{{ number_format($s['units_available']) }} Units</div>
                </div>
                @endif

                @if(($s['price_per_sqm'] ?? 0) > 0)
                <div>
                    <div class="meta-label"><i class="fas fa-rupee-sign" style="font-size:.62rem;margin-right:.2rem;"></i>Rate</div>
                    <div class="meta-value">₹{{ number_format($s['price_per_sqm']) }}/sqm</div>
                </div>
                @endif

                @if(!empty($s['possession_date']) && !in_array($s['possession_date'], ['N/A', '']))
                <div>
                    <div class="meta-label"><i class="fas fa-calendar-check" style="font-size:.62rem;margin-right:.2rem;"></i>Possession</div>
                    <div class="meta-value">{{ $s['possession_date'] }}</div>
                </div>
                @endif

                @if(!empty($s['ballot_date']) && !in_array($s['ballot_date'], ['N/A', '']))
                <div>
                    <div class="meta-label"><i class="fas fa-dice" style="font-size:.62rem;margin-right:.2rem;"></i>Ballot Date</div>
                    <div class="meta-value">{{ $s['ballot_date'] }}</div>
                </div>
                @endif

                @if(!empty($s['allotment_type']) && $s['allotment_type'] !== 'N/A')
                <div>
                    <div class="meta-label"><i class="fas fa-tag" style="font-size:.62rem;margin-right:.2rem;"></i>Allotment</div>
                    <div class="meta-value">{{ $s['allotment_type'] }}</div>
                </div>
                @endif
            </div>

            {{-- Highlight tags (JSON array) --}}
            @if(!empty($s['highlights']) && is_array($s['highlights']))
            <div class="lda-tags">
                @foreach($s['highlights'] as $tag)
                    @if(trim($tag))
                    <span class="lda-tag">{{ trim($tag) }}</span>
                    @endif
                @endforeach
            </div>
            @endif

            {{-- Description --}}
            @if(!empty($s['description']))
            <div class="lda-desc">{{ $s['description'] }}</div>
            @endif

            {{-- CTA --}}
            <div class="lda-card-foot">
                <a href="{{ $s['official_link'] ?? 'https://ldalucknow.in' }}"
                   target="_blank" rel="noopener" class="btn-primary">
                    <i class="fas fa-external-link-alt" style="font-size:.65rem;"></i>
                    View on LDA
                </a>
                @if(!empty($s['map_link']))
                <a href="{{ $s['map_link'] }}" target="_blank" rel="noopener" class="btn-outline">
                    <i class="fas fa-map" style="font-size:.65rem;"></i> Map
                </a>
                @endif
                @if(!empty($s['brochure_link']))
                <a href="{{ $s['brochure_link'] }}" target="_blank" rel="noopener" class="btn-outline">
                    <i class="fas fa-file-pdf" style="font-size:.65rem;"></i>
                </a>
                @endif
            </div>

        </div>
        @empty
        <div class="lda-empty">
            <i class="fas fa-folder-open"></i>
            <p>No schemes loaded. Please upload the JSON data file.</p>
        </div>
        @endforelse

        <div class="lda-empty" id="no-results" style="display:none;">
            <i class="fas fa-search"></i>
            <p>No schemes match your search.</p>
        </div>
    </div>

    {{-- Disclaimer --}}
    <div style="max-width:1200px;margin:0 auto;padding:.5rem 1rem 2rem;">
        <p style="font-size:.72rem;color:var(--text-tertiary);line-height:1.6;border-top:1px solid var(--border-color);padding-top:.6rem;">
            <i class="fas fa-info-circle" style="margin-right:.3rem;"></i>
            Data sourced from official LDA communications and ldalucknow.in. Prices, availability and dates change — verify directly with LDA before any decision.
            Last refresh: {{ $lastUpdated }}.
        </p>
    </div>

</div>

<script>
(function () {
    const cards  = Array.from(document.querySelectorAll('#lda-grid .lda-card'));
    const grid   = document.getElementById('lda-grid');
    const noRes  = document.getElementById('no-results');
    const count  = document.getElementById('lda-count');
    let filter   = 'all';
    let query    = '';

    function render() {
        let vis = 0;
        cards.forEach(c => {
            const ok = (filter === 'all' || c.dataset.status === filter)
                    && (!query || c.dataset.search.includes(query));
            c.style.display = ok ? '' : 'none';
            if (ok) vis++;
        });
        count.textContent = vis + (vis === 1 ? ' scheme' : ' schemes');
        noRes.style.display = vis === 0 ? 'block' : 'none';
    }

    function sort(by) {
        [...cards].sort((a, b) => {
            if (by === 'name')       return a.dataset.search.localeCompare(b.dataset.search);
            if (by === 'price_asc')  return +a.dataset.price - +b.dataset.price;
            if (by === 'price_desc') return +b.dataset.price - +a.dataset.price;
            if (by === 'progress')   return +b.dataset.progress - +a.dataset.progress;
            return +a.dataset.order - +b.dataset.order;
        }).forEach(c => grid.insertBefore(c, noRes));
    }

    document.querySelectorAll('.lda-filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.lda-filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filter = this.dataset.filter;
            render();
        });
    });

    document.getElementById('lda-search').addEventListener('input', function () {
        query = this.value.toLowerCase().trim();
        render();
    });

    document.getElementById('lda-sort').addEventListener('change', function () {
        sort(this.value);
        render();
    });
})();
</script>
@endsection
