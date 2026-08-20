{{-- Arxiv maqolalari kartochkalari. Cheksiz aylantirishda ham shu qism qaytariladi. --}}
@foreach($posts as $post)
    @php $hasImage = $post->thumb && $post->thumb->file_exists; @endphp
    <a class="lg-card {{ $hasImage ? '' : 'no-img' }}"
       href="{{ route('admin.legacy.show', [$post->source, $post->wp_id]) }}">
        @if($hasImage)
            <span class="lg-thumb">
                <img src="{{ $post->thumb->url }}" alt="" loading="lazy">
                <span class="lg-badge">{{ $post->source }}</span>
            </span>
        @endif
        <span class="lg-body">
            @unless($hasImage)
                <span class="lg-badge flat">{{ $post->source }}</span>
            @endunless
            <span class="lg-title">{{ $post->title ?: '(sarlavhasiz)' }}</span>
            <span class="lg-meta">
                <span>{{ $post->published_at?->format('d.m.Y') ?? '—' }}</span>
                <span class="lg-chip {{ $post->lang }}">{{ strtoupper($post->lang) }}</span>
            </span>
        </span>
    </a>
@endforeach
