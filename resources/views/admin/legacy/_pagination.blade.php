{{--
    Arxiv bo'limi uchun sahifalagich.
    Laravel'ning sukut ko'rinishi Tailwind uchun mo'ljallangan (bu panelda
    Tailwind yo'q, shuning uchun uning SVG belgilari ulkan bo'lib chiqadi).
--}}
@if($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last    = $paginator->lastPage();
        $start   = max(1, min($current - 2, $last - 4));
        $end     = min($last, max($current + 2, 5));
    @endphp

    <nav class="lgp-wrap" @isset($wrapId) id="{{ $wrapId }}" @endisset>
        <div class="lgp-info">
            <b>{{ number_format($paginator->firstItem() ?? 0) }}–{{ number_format($paginator->lastItem() ?? 0) }}</b>
            / {{ number_format($paginator->total()) }} ta
        </div>

        <ul class="lgp">
            <li>
                <a class="lgp-btn {{ $paginator->onFirstPage() ? 'off' : '' }}"
                   href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() }}">
                    <i class="fas fa-chevron-left"></i> Oldingi
                </a>
            </li>

            @if($start > 1)
                <li><a class="lgp-btn" href="{{ $paginator->url(1) }}">1</a></li>
                @if($start > 2)<li><span class="lgp-dots">…</span></li>@endif
            @endif

            @for($p = $start; $p <= $end; $p++)
                <li>
                    <a class="lgp-btn {{ $p === $current ? 'on' : '' }}" href="{{ $paginator->url($p) }}">{{ $p }}</a>
                </li>
            @endfor

            @if($end < $last)
                @if($end < $last - 1)<li><span class="lgp-dots">…</span></li>@endif
                <li><a class="lgp-btn" href="{{ $paginator->url($last) }}">{{ $last }}</a></li>
            @endif

            <li>
                <a class="lgp-btn {{ $paginator->hasMorePages() ? '' : 'off' }}"
                   href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}">
                    Keyingi <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endif
