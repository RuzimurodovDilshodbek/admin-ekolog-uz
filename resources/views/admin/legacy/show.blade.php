@extends('layouts.admin')

@section('styles')
<style>
    .lg-wrap{background:#fff;border:1px solid #e6eaef;border-radius:12px;padding:24px 28px}
    .lg-h1{font-size:22px;font-weight:800;color:#2c3e50;line-height:1.3;margin:0 0 12px}
    .lg-info{display:flex;flex-wrap:wrap;gap:16px;font-size:12.5px;color:#8b97a4;border-bottom:1px solid #eef1f4;padding-bottom:14px;margin-bottom:18px}
    .lg-info b{color:#2c3e50;font-weight:700}
    .lg-content{font-size:15px;line-height:1.75;color:#33414f;word-wrap:break-word;overflow-wrap:break-word}
    .lg-content img{display:block;max-width:100%;width:auto;height:auto;max-height:460px;border-radius:8px;margin:16px auto}
    .lg-content figure{margin:16px 0;text-align:center}
    .lg-content figcaption{font-size:12.5px;color:#8b97a4;margin-top:6px}
    .lg-content p{margin-bottom:14px}
    .lg-content > *:first-child{margin-top:0}
    .lg-hero{display:block;width:100%;max-height:380px;object-fit:cover;border-radius:10px;margin-bottom:18px}
    .lg-content a{color:#2471a3}
    .lg-content table{max-width:100%;border-collapse:collapse}
    .lg-content td,.lg-content th{border:1px solid #e6eaef;padding:6px 10px}
    .lg-content blockquote{border-left:3px solid #27ae60;padding-left:14px;color:#5b6b7a;margin:14px 0}
    .lg-side{background:#fff;border:1px solid #e6eaef;border-radius:12px;padding:16px 18px;margin-bottom:16px}
    .lg-side h6{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:#8b97a4;margin:0 0 10px}
    .lg-kv{display:flex;justify-content:space-between;gap:10px;font-size:12.5px;padding:5px 0;border-bottom:1px dashed #eef1f4}
    .lg-kv:last-child{border-bottom:0}
    .lg-kv span:first-child{color:#8b97a4}
    .lg-kv span:last-child{color:#2c3e50;font-weight:600;text-align:right;word-break:break-all}
    .lg-gal{display:grid;grid-template-columns:repeat(auto-fill,minmax(90px,1fr));gap:8px}
    .lg-gal a{display:block;position:relative;padding-top:75%;border-radius:7px;overflow:hidden;background:#eef1f4}
    .lg-gal img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
    .lg-gal .miss{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#b6c0cb;font-size:14px}
    .lg-note{background:#eef7ff;border:1px solid #cfe4f7;color:#1b5a86;border-radius:9px;padding:9px 13px;font-size:12.5px;margin-bottom:16px}
    .lg-note.clean{background:#fff8e6;border-color:#f5dfa6;color:#7a5c12}
    .lg-tab{display:inline-block;padding:5px 12px;font-size:12px;font-weight:700;border-radius:7px;background:#f0f2f5;color:#5b6b7a;margin-right:6px;text-decoration:none}
    .lg-tab.active{background:#27ae60;color:#fff}
    .lg-imgmiss{display:flex;align-items:center;gap:8px;background:#f6f8fa;border:1px dashed #dfe4ea;border-radius:9px;
        padding:10px 14px;margin:14px 0;font-size:12.5px;color:#8b97a4;word-break:break-all}
    .lg-imgmiss i{font-size:14px;flex-shrink:0}
</style>
@endsection

@section('scripts')
<script>
// Eski saytdan o'chirib yuborilgan rasmlar o'rnida bo'sh joy qolmasligi uchun
// ularni ixcham izohga almashtiramiz.
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.lg-content img').forEach(function (img) {
        function replace() {
            var name = (img.getAttribute('src') || '').split('/').pop();
            var box = document.createElement('div');
            box.className = 'lg-imgmiss';
            box.innerHTML = '<i class="far fa-image"></i><span></span>';
            box.querySelector('span').textContent = 'Rasm eski saytda saqlanmagan: ' + decodeURIComponent(name);
            if (img.parentNode) { img.parentNode.replaceChild(box, img); }
        }
        img.addEventListener('error', replace);
        if (img.complete && img.naturalWidth === 0) { replace(); }
    });
});
</script>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('admin.legacy.index') }}"
       style="font-size:13px;color:#6b7a8d;text-decoration:none;font-weight:600;">
        <i class="fas fa-arrow-left"></i> Arxivga qaytish
    </a>
    <div>
        @if($prev)
            <a href="{{ route('admin.legacy.show', [$prev->source, $prev->wp_id]) }}" class="lg-tab"><i class="fas fa-chevron-left"></i> Oldingi</a>
        @endif
        @if($next)
            <a href="{{ route('admin.legacy.show', [$next->source, $next->wp_id]) }}" class="lg-tab">Keyingi <i class="fas fa-chevron-right"></i></a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="lg-wrap">

            @if($post->was_sanitized)
                <div class="lg-note clean">
                    <i class="fas fa-shield-alt"></i>
                    Bu postdan <b>{{ $post->removed_scripts }}</b> ta zararli/keraksiz element
                    (masalan hujumchi qo'shgan <code>&lt;script&gt;</code>) olib tashlangan. Quyida tozalangan matn ko'rsatilmoqda.
                </div>
            @endif

            <h1 class="lg-h1">{{ $post->title ?: '(sarlavhasiz)' }}</h1>

            <div class="lg-info">
                <span><i class="far fa-calendar"></i> <b>{{ $post->published_at?->format('d.m.Y H:i') ?? '—' }}</b></span>
                @if($post->author)<span><i class="far fa-user"></i> <b>{{ $post->author }}</b></span>@endif
                <span><i class="fas fa-globe"></i> <b>{{ strtoupper($post->lang) }}</b></span>
                <span><i class="fas fa-database"></i> <b>{{ $post->sourceLabel() }}</b></span>
                <span><i class="fas fa-hashtag"></i> <b>{{ $post->wp_id }}</b></span>
            </div>

            @if($thumbnail)
                @if($thumbnail->file_exists)
                    <a href="{{ $thumbnail->url }}" target="_blank" title="To'liq o'lchamda ochish">
                        <img class="lg-hero" src="{{ $thumbnail->url }}" alt="">
                    </a>
                @else
                    <div style="background:#f6f8fa;border:1px dashed #dfe4ea;border-radius:10px;padding:14px;font-size:12.5px;color:#8b97a4;margin-bottom:18px;">
                        <i class="far fa-image"></i> Bosh rasm: <code>{{ $thumbnail->file_path }}</code> (fayl hali ko'chirilmagan)
                    </div>
                @endif
            @endif

            <div class="lg-content">
                {!! $post->content !!}
            </div>

            @if($post->translations)
                <hr style="margin:24px 0;">
                <h6 style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:#8b97a4;">
                    Boshqa tillardagi variantlari
                </h6>
                @foreach($post->translations as $code => $tr)
                    <div style="border:1px solid #e6eaef;border-radius:9px;padding:14px;margin-bottom:10px;">
                        <span class="lg-tab active" style="margin-bottom:8px;">{{ strtoupper($code) }}</span>
                        @if(!empty($tr['title']))
                            <p style="font-weight:700;color:#2c3e50;margin:8px 0 6px;">{{ $tr['title'] }}</p>
                        @endif
                        @if(!empty($tr['content']))
                            <div class="lg-content" style="font-size:14px;">{!! $tr['content'] !!}</div>
                        @endif
                    </div>
                @endforeach
            @endif

        </div>
    </div>

    <div class="col-lg-4">
        <div class="lg-side">
            <h6>Ma'lumot</h6>
            <div class="lg-kv"><span>Turi</span><span>{{ $post->post_type === 'page' ? 'Sahifa' : 'Maqola' }}</span></div>
            <div class="lg-kv"><span>Holati</span><span>{{ $post->status }}</span></div>
            <div class="lg-kv"><span>Slug</span><span style="font-size:11px;">{{ $post->slug ? urldecode($post->slug) : '—' }}</span></div>
            <div class="lg-kv"><span>O'zgartirilgan</span><span>{{ $post->modified_at?->format('d.m.Y') ?? '—' }}</span></div>
            @if($post->guid)
                <div class="lg-kv"><span>Eski manzil</span><span style="font-size:11px;">{{ $post->guid }}</span></div>
            @endif
        </div>

        @php $terms = $post->terms(); @endphp
        @if($terms->count())
            <div class="lg-side">
                <h6>Ruknlar va teglar</h6>
                @foreach($terms as $t)
                    <a href="{{ route('admin.legacy.index', ['term' => $t->wp_term_id, 'source' => $post->source]) }}"
                       class="lg-tab" style="margin-bottom:6px;">
                        <i class="fas fa-{{ $t->taxonomy === 'category' ? 'folder' : 'tag' }}"></i> {{ $t->name }}
                    </a>
                @endforeach
            </div>
        @endif

        @if($attachments->count())
            <div class="lg-side">
                <h6>Biriktirilgan fayllar ({{ $attachments->count() }})</h6>
                <div class="lg-gal">
                    @foreach($attachments as $m)
                        <a href="{{ $m->file_exists ? $m->url : '#' }}" target="_blank" title="{{ $m->file_path }}">
                            @if($m->file_exists && $m->is_image)
                                <img src="{{ $m->url }}" alt="" loading="lazy">
                            @else
                                <span class="miss"><i class="fas fa-{{ $m->is_video ? 'film' : 'image' }}"></i></span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
