@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><a class="page-link">← Previous</a></li>
            @else
                <li class="page-item"><a href="{{ $paginator->previousPageUrl() }}" class="page-link" rel="prev">← Previous</a></li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><a class="page-link">{{ $element }}</a></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">Next →</a></li>
            @else
                <li class="page-itemdisabled"><a class="page-link">Next →</a></li>
            @endif
        </ul>
    </nav>
@endif
