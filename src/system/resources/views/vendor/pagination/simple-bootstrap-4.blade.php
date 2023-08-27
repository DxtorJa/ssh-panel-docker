@if ($paginator->hasPages())
    <ul class="pager">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="previous disabled">
                <a href="javascript:void(0);" class="waves-effect">
                    <span aria-hidden="true">&larr;</span> 
                    Older
                </a>
            </li>

        @else
            <li class="previous">
                <a href="{{ $paginator->previousPageUrl() }}" class="waves-effect">
                    <span aria-hidden="true">&larr;</span> 
                    Older
                </a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="next">
                <a href="{{ $paginator->nextPageUrl() }}" class="waves-effect">
                    Newer 
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </li>
        @else
            <li class="next">
                <a href="javascript:void(0);" class="waves-effect">
                    Newer 
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </li>
        @endif
    </ul>
@endif
