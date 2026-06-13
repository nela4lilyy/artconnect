@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:center;gap:.5rem;flex-wrap:wrap;margin-top:2rem">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
    <span style="display:inline-flex;align-items:center;gap:.35rem;padding:.5rem 1rem;border-radius:8px;border:1.5px solid #ede9f8;color:#b0a8d0;font-size:.85rem;font-weight:500;cursor:default;user-select:none">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Sebelumnya
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex;align-items:center;gap:.35rem;padding:.5rem 1rem;border-radius:8px;border:1.5px solid #ede9f8;color:#6F42C1;font-size:.85rem;font-weight:500;text-decoration:none;transition:.2s;background:#fff" onmouseover="this.style.background='#f0ebff'" onmouseout="this.style.background='#fff'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Sebelumnya
    </a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
        <span style="padding:.5rem .6rem;color:#b0a8d0;font-size:.85rem">···</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;background:#6F42C1;color:#fff;font-size:.85rem;font-weight:700;cursor:default">
                    {{ $page }}
                </span>
                @else
                <a href="{{ $url }}" style="display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;border-radius:8px;border:1.5px solid #ede9f8;color:#6F42C1;font-size:.85rem;font-weight:500;text-decoration:none;background:#fff;transition:.2s" onmouseover="this.style.background='#f0ebff';this.style.borderColor='#6F42C1'" onmouseout="this.style.background='#fff';this.style.borderColor='#ede9f8'">
                    {{ $page }}
                </a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex;align-items:center;gap:.35rem;padding:.5rem 1rem;border-radius:8px;border:1.5px solid #ede9f8;color:#6F42C1;font-size:.85rem;font-weight:500;text-decoration:none;transition:.2s;background:#fff" onmouseover="this.style.background='#f0ebff'" onmouseout="this.style.background='#fff'">
        Berikutnya
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </a>
    @else
    <span style="display:inline-flex;align-items:center;gap:.35rem;padding:.5rem 1rem;border-radius:8px;border:1.5px solid #ede9f8;color:#b0a8d0;font-size:.85rem;font-weight:500;cursor:default;user-select:none">
        Berikutnya
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </span>
    @endif

</nav>
@endif
