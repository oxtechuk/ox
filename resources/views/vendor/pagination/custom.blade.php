@if ($paginator->hasPages())
    <nav role="navigation" aria-label="تنقل بين الصفحات" class="ox-pagination-wrapper">
        <div class="ox-pagination-info">
            <span>عرض</span>
            <strong>{{ $paginator->firstItem() }}</strong>
            <span>إلى</span>
            <strong>{{ $paginator->lastItem() }}</strong>
            <span>من إجمالي</span>
            <strong>{{ $paginator->total() }}</strong>
            <span>سجل</span>
        </div>

        <ul class="ox-pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="ox-page-item disabled" aria-disabled="true">
                    <span class="ox-page-link">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(180deg);"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>السابق</span>
                    </span>
                </li>
            @else
                <li class="ox-page-item">
                    <a class="ox-page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transform: rotate(180deg);"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>السابق</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="ox-page-item disabled" aria-disabled="true"><span class="ox-page-link dots">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="ox-page-item active" aria-current="page"><span class="ox-page-link">{{ $page }}</span></li>
                        @else
                            <li class="ox-page-item"><a class="ox-page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="ox-page-item">
                    <a class="ox-page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span>التالي</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                </li>
            @else
                <li class="ox-page-item disabled" aria-disabled="true">
                    <span class="ox-page-link">
                        <span>التالي</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
