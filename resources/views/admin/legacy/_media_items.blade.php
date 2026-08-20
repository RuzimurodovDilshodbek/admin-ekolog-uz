{{-- Media galereya elementlari. Cheksiz aylantirishda ham shu qism qaytariladi. --}}
@foreach($media as $m)
    <div class="mg-item">
        <a class="mg-ph" href="{{ $m->file_exists ? $m->url : '#' }}" target="{{ $m->file_exists ? '_blank' : '_self' }}">
            @if($m->file_exists && $m->is_image)
                <img src="{{ $m->url }}" alt="" loading="lazy">
            @else
                <span class="miss">
                    <i class="fas fa-{{ $m->is_video ? 'film' : 'image' }}"></i>
                    @unless($m->file_exists)<small>fayl yo'q</small>@endunless
                </span>
            @endif
        </a>
        <div class="mg-cap">
            <b title="{{ $m->title }}">{{ $m->title ?: basename((string) $m->file_path) }}</b>
            {{ $m->file_path }}
            @if($m->width) <br>{{ $m->width }}&times;{{ $m->height }} @endif
        </div>
    </div>
@endforeach
