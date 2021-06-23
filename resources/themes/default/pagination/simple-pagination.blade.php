@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span class="ne-btn ne-pagination ne-disabled mr-1">{{__('Previous')}}</span>
                </li>
            @else
                <a class="ne-btn ne-pagination mr-1" href="{{ $paginator->previousPageUrl() }}" rel="prev">{{__('Previous')}}</a>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="ne-btn ne-pagination" href="{{ $paginator->nextPageUrl() }}" rel="next">{{__('Next')}}</a>
            @else
                <li class="disabled" aria-disabled="true">
                    <span class="ne-btn ne-pagination ne-disabled">{{__('Next')}}</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
