@if($googleReviews->isNotEmpty())
@php
    $avgRating = round($googleReviews->avg('rating'), 1);
    $totalReviews = $googleReviews->count();

    $avatarColors = [
        '#4285F4', '#EA4335', '#FBBC05', '#34A853',
        '#8AB4F8', '#F28B82', '#c084fc', '#81C995',
        '#fb923c', '#FF8BCB', '#06b6d4', '#a3e635',
    ];
@endphp

<section class="gr-section">
    <div class="gr-inner">

        {{-- Header row --}}
        <div class="gr-header">
            <div class="gr-header-left">
                <div class="gr-g-logo" aria-hidden="true">
                    <svg width="26" height="26" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                </div>
                <div class="gr-rating-block">
                    <p class="gr-label">Google Reviews</p>
                    <div class="gr-overall">
                        <span class="gr-big-rating">{{ number_format($avgRating, 1) }}</span>
                        <div class="gr-rating-right">
                            <div class="gr-stars-row">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgRating))
                                        <svg class="gr-star gr-star-filled" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    @elseif($i - $avgRating < 1)
                                        <svg class="gr-star gr-star-half" viewBox="0 0 24 24"><defs><linearGradient id="hg{{ $i }}"><stop offset="50%" stop-color="#f59e0b"/><stop offset="50%" stop-color="#d1d5db"/></linearGradient></defs><path fill="url(#hg{{ $i }})" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    @else
                                        <svg class="gr-star gr-star-empty" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="gr-count">{{ $totalReviews }} {{ Str::plural('review', $totalReviews) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="gr-header-right">
                {{-- Scroll arrows --}}
                <button class="gr-arrow" onclick="grScroll(-1)" aria-label="Previous">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="gr-arrow" onclick="grScroll(1)" aria-label="Next">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
                <a href="https://g.page/r/CSKaw-Vi5G_LEBM/review" target="_blank" rel="noopener" class="gr-write-btn">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Write a Review
                </a>
            </div>
        </div>

        {{-- Review Cards --}}
        <div class="gr-track" id="gr-track">
            @foreach($googleReviews as $index => $review)
            @php
                $color = $avatarColors[$index % count($avatarColors)];
                $initial = strtoupper(substr($review->reviewer_name, 0, 1));
                $snippet = Str::limit($review->review_text, 160);
                $fullText = $review->review_text;
                $hasMore = strlen($review->review_text) > 160;
            @endphp
            <div class="gr-card">
                <div class="gr-card-top">
                    <div class="gr-avatar" style="background:{{ $color }}">{{ $initial }}</div>
                    <div class="gr-card-meta">
                        <p class="gr-name">{{ e($review->reviewer_name) }}</p>
                        <p class="gr-card-date">{{ $review->review_date->format('M Y') }}</p>
                    </div>
                    <div class="gr-g-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        </svg>
                    </div>
                </div>

                <div class="gr-card-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="gr-s {{ $i <= $review->rating ? 'gr-s-filled' : 'gr-s-empty' }}" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    @endfor
                </div>

                <p class="gr-text">
                    <span class="gr-snippet-{{ $review->id }}">{{ $snippet }}</span>
                    @if($hasMore)
                        <span class="gr-full-{{ $review->id }}" style="display:none;">{{ $fullText }}</span>
                        <button class="gr-more-btn" onclick="grToggle({{ $review->id }}, this)">more</button>
                    @endif
                </p>
            </div>
            @endforeach
        </div>

        {{-- Bottom CTA --}}
        <div class="gr-footer">
            <a href="https://g.page/r/CSKaw-Vi5G_LEBM/review" target="_blank" rel="noopener" class="gr-footer-link">
                See all reviews on Google
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </div>
</section>

<style>
/* ── Google Reviews Section ── */
.gr-section {
    margin-top: 30px;
    background: linear-gradient(180deg, #f0fdf8 0%, #f8fafc 100%);
    border-top: 1px solid #d1fae5;
    border-bottom: 1px solid #e5e7eb;
    padding: 44px 0 40px;
    position: relative;
}
.gr-section::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #4285F4, #EA4335, #FBBC05, #34A853);
}
.gr-inner {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ── Header ── */
.gr-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}
.gr-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.gr-g-logo {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: #fff;
    border: 1.5px solid #e5e7eb;
    box-shadow: 0 2px 8px rgba(0,0,0,.07);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.gr-rating-block {}
.gr-label {
    font-size: .65rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    color: #6b7280;
    margin: 0 0 5px;
    font-family: 'Poppins', sans-serif;
}
.gr-overall {
    display: flex;
    align-items: center;
    gap: 10px;
}
.gr-big-rating {
    font-size: 2.6rem;
    font-weight: 800;
    color: #111827;
    line-height: 1;
    font-family: 'Poppins', sans-serif;
    letter-spacing: -1px;
}
.gr-rating-right {}
.gr-stars-row {
    display: flex;
    gap: 2px;
    margin-bottom: 3px;
}
.gr-star {
    width: 18px; height: 18px;
}
.gr-star-filled path { fill: #f59e0b; }
.gr-star-empty path  { fill: #d1d5db; }
.gr-count {
    font-size: .75rem;
    color: #6b7280;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}

/* ── Header right ── */
.gr-header-right {
    display: flex;
    align-items: center;
    gap: 8px;
}
.gr-arrow {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #374151;
    transition: all .2s;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
}
.gr-arrow:hover {
    border-color: #4285F4;
    color: #4285F4;
    background: #eff6ff;
    box-shadow: 0 2px 8px rgba(66,133,244,.15);
}
.gr-write-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    border-radius: 9px;
    border: none;
    background: #4285F4;
    color: #fff;
    font-size: .8rem;
    font-weight: 700;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    transition: all .2s;
    box-shadow: 0 3px 12px rgba(66,133,244,.3);
    white-space: nowrap;
}
.gr-write-btn:hover {
    background: #2563eb;
    color: #fff;
    text-decoration: none;
    box-shadow: 0 5px 18px rgba(66,133,244,.4);
    transform: translateY(-1px);
}

/* ── Cards track ── */
.gr-track {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    padding-bottom: 4px;
}
.gr-track::-webkit-scrollbar { display: none; }

/* ── Individual card ── */
.gr-card {
    min-width: 295px;
    max-width: 320px;
    flex-shrink: 0;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 20px 20px 18px;
    scroll-snap-align: start;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: box-shadow .25s, transform .25s;
    position: relative;
    overflow: hidden;
}
.gr-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, #4285F4, #34A853);
    transform: scaleX(0);
    transition: transform .3s;
    transform-origin: left;
}
.gr-card:hover {
    box-shadow: 0 10px 32px rgba(0,0,0,.1);
    transform: translateY(-3px);
}
.gr-card:hover::after {
    transform: scaleX(1);
}

/* Card top row */
.gr-card-top {
    display: flex;
    align-items: center;
    gap: 11px;
    margin-bottom: 13px;
}
.gr-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    color: #fff;
    font-family: 'Poppins', sans-serif;
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.gr-card-meta {
    flex: 1;
    min-width: 0;
}
.gr-name {
    font-size: .88rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-family: 'Poppins', sans-serif;
}
.gr-card-date {
    font-size: .72rem;
    color: #9ca3af;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}
.gr-g-icon {
    flex-shrink: 0;
}

/* Card stars */
.gr-card-stars {
    display: flex;
    gap: 2px;
    margin-bottom: 12px;
}
.gr-s { width: 16px; height: 16px; }
.gr-s-filled path { fill: #f59e0b; }
.gr-s-empty path  { fill: #e5e7eb; }

/* Review text */
.gr-text {
    font-size: .84rem;
    color: #374151;
    line-height: 1.72;
    margin: 0;
    font-family: 'Poppins', sans-serif;
}
.gr-more-btn {
    background: none;
    border: none;
    color: #4285F4;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    margin-left: 2px;
    font-family: 'Poppins', sans-serif;
}
.gr-more-btn:hover { text-decoration: underline; }

/* ── Footer ── */
.gr-footer {
    margin-top: 22px;
    text-align: center;
}
.gr-footer-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .8rem;
    font-weight: 600;
    color: #4285F4;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1.5px solid #bfdbfe;
    background: #eff6ff;
    transition: all .2s;
}
.gr-footer-link:hover {
    background: #4285F4;
    color: #fff;
    border-color: #4285F4;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(66,133,244,.25);
}

/* ── Responsive ── */
@media(max-width:640px) {
    .gr-section { padding: 32px 0 28px; }
    .gr-card { min-width: 260px; }
    .gr-write-btn { display: none; }
    .gr-big-rating { font-size: 2rem; }
    .gr-g-logo { width: 44px; height: 44px; }
}
</style>

<script>
function grScroll(dir) {
    var track = document.getElementById('gr-track');
    if (track) track.scrollBy({ left: dir * 320, behavior: 'smooth' });
}
function grToggle(id, btn) {
    var snippet = document.querySelector('.gr-snippet-' + id);
    var full    = document.querySelector('.gr-full-' + id);
    if (!snippet || !full) return;
    var expanded = full.style.display !== 'none';
    snippet.style.display = expanded ? '' : 'none';
    full.style.display    = expanded ? 'none' : '';
    btn.textContent       = expanded ? 'more' : 'less';
}
</script>
@endif
