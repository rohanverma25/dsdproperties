{{--
    resources/views/news/_pagination.blade.php
    Pager for /news: "Showing 21–40 of 58" + Prev / page numbers / Next on desktop,
    Prev / "Page 2 of 3" / Next on phones. Styles live in news/index.blade.php (.nr-pg).
    Usage: {{ $articles->links('news._pagination') }}
--}}
@if ($paginator->hasPages())
<nav class="nr-pg" role="navigation" aria-label="News pages">
    <p class="nr-pg__info">
        Showing <strong>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</strong> of <strong>{{ $paginator->total() }}</strong> stories
    </p>

    <div class="nr-pg__row">
        @if ($paginator->onFirstPage())
            <span class="nr-pg__btn is-off" aria-disabled="true">← Previous</span>
        @else
            <a class="nr-pg__btn" href="{{ $paginator->previousPageUrl() }}" rel="prev">← Previous</a>
        @endif

        <span class="nr-pg__nums">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="nr-pg__dots">…</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="nr-pg__num is-on" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="nr-pg__num" href="{{ $url }}" aria-label="Page {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </span>
        <span class="nr-pg__mob">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a class="nr-pg__btn nr-pg__btn--next" href="{{ $paginator->nextPageUrl() }}" rel="next">Next →</a>
        @else
            <span class="nr-pg__btn is-off" aria-disabled="true">Next →</span>
        @endif
    </div>
</nav>
@endif
