@if ($paginator->hasPages())
<nav aria-label="Navigasi halaman">
    <ul class="pagination justify-content-center flex-wrap gap-1 mb-0">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
        <li class="page-item disabled">
            <span class="page-link" style="border-radius:8px;border-color:#ede9f8;color:#aaa;font-size:.85rem;padding:.45rem .85rem">
                <i class="bi bi-chevron-left"></i>
            </span>
        </li>
        @else
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
               style="border-radius:8px;border-color:#ede9f8;color:#6F42C1;font-size:.85rem;padding:.45rem .85rem">
                <i class="bi bi-chevron-left"></i>
            </a>
        </li>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
            <li class="page-item disabled">
                <span class="page-link" style="border-radius:8px;border-color:#ede9f8;font-size:.85rem;padding:.45rem .75rem">
                    {{ $element }}
                </span>
            </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                    <li class="page-item active">
                        <span class="page-link"
                              style="border-radius:8px;background:#6F42C1;border-color:#6F42C1;font-size:.85rem;padding:.45rem .75rem;min-width:36px;text-align:center">
                            {{ $page }}
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}"
                           style="border-radius:8px;border-color:#ede9f8;color:#6F42C1;font-size:.85rem;padding:.45rem .75rem;min-width:36px;text-align:center">
                            {{ $page }}
                        </a>
                    </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
               style="border-radius:8px;border-color:#ede9f8;color:#6F42C1;font-size:.85rem;padding:.45rem .85rem">
                <i class="bi bi-chevron-right"></i>
            </a>
        </li>
        @else
        <li class="page-item disabled">
            <span class="page-link" style="border-radius:8px;border-color:#ede9f8;color:#aaa;font-size:.85rem;padding:.45rem .85rem">
                <i class="bi bi-chevron-right"></i>
            </span>
        </li>
        @endif

    </ul>
</nav>
@endif
