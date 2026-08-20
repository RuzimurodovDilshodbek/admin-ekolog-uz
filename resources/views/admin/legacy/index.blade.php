@extends('layouts.admin')

@section('styles')
<style>
    .lg-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:14px;align-items:start}
    .lg-card{display:flex;flex-direction:column;background:#fff;border:1px solid #e6eaef;border-radius:12px;
        overflow:hidden;text-decoration:none;transition:box-shadow .18s,transform .18s}
    .lg-card:hover{box-shadow:0 8px 24px rgba(44,62,80,.12);transform:translateY(-2px);text-decoration:none}
    .lg-thumb{position:relative;display:block;width:100%;padding-top:58%;background:#eef1f4;overflow:hidden}
    .lg-thumb img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
    .lg-badge{position:absolute;top:8px;left:8px;background:rgba(0,0,0,.62);color:#fff;font-size:10px;
        font-weight:700;padding:3px 8px;border-radius:20px;letter-spacing:.3px}
    /* rasmsiz kartochka: kichik kulrang belgi, ulkan bo'sh joy o'rniga */
    .lg-badge.flat{position:static;display:inline-block;align-self:flex-start;background:#eef1f4;color:#8b97a4;
        margin-bottom:6px;padding:2px 7px}
    .lg-body{display:flex;flex-direction:column;flex:1;padding:12px 14px}
    .lg-card.no-img .lg-body{padding:10px 12px}
    .lg-title{display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;
        font-size:13.5px;font-weight:700;color:#2c3e50;line-height:1.35;margin:0 0 8px}
    .lg-card.no-img .lg-title{-webkit-line-clamp:4;font-size:13px;margin-bottom:6px}
    .lg-meta{margin-top:auto;display:flex;justify-content:space-between;align-items:center;gap:6px;
        font-size:11px;color:#8b97a4}
    .lg-chip{display:inline-block;font-size:10px;font-weight:700;padding:2px 7px;border-radius:5px;letter-spacing:.3px}
    .lg-chip.uz{background:#e8f6ee;color:#1e8449}.lg-chip.ru{background:#e8f0fb;color:#2471a3}
    .lg-chip.kr{background:#f4ecfa;color:#7d3c98}.lg-chip.en{background:#fdf0e6;color:#ca6f1e}

    .lg-filter{background:#fff;border:1px solid #e6eaef;border-radius:12px;padding:14px 16px;margin-bottom:18px}
    .lg-filter label{font-size:11px;font-weight:700;color:#6b7a8d;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;display:block}
    .lg-filter .form-control,.lg-filter select{font-size:13px;border-radius:8px;border:1px solid #dfe4ea;height:36px}
    .lg-mini{background:#fff;border:1px solid #e6eaef;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:10px}
    .lg-mini i{font-size:16px}
    .lg-mini .v{font-size:17px;font-weight:800;color:#2c3e50;line-height:1}
    .lg-mini .l{font-size:11px;color:#8b97a4}
    .lg-warn{background:#fff8e6;border:1px solid #f5dfa6;color:#7a5c12;border-radius:10px;padding:10px 14px;font-size:12.5px}
    .lg-empty{background:#fff;border:1px solid #e6eaef;border-radius:12px;padding:40px;text-align:center;color:#8b97a4}

    .lg-more{padding:22px 0;text-align:center;font-size:12.5px;color:#8b97a4}
    .lg-more .spin{display:inline-block;width:16px;height:16px;border:2px solid #dfe4ea;border-top-color:#27ae60;
        border-radius:50%;animation:lgspin .7s linear infinite;vertical-align:-3px;margin-right:8px}
    @keyframes lgspin{to{transform:rotate(360deg)}}

    .lgp-wrap{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;background:#fff;
        border:1px solid #e6eaef;border-radius:12px;padding:10px 14px;margin-top:6px}
    .lgp-info{font-size:12.5px;color:#8b97a4}.lgp-info b{color:#2c3e50}
    .lgp{display:flex;list-style:none;margin:0;padding:0;gap:4px;flex-wrap:wrap}
    .lgp-btn{display:inline-flex;align-items:center;gap:5px;min-width:34px;height:32px;padding:0 10px;justify-content:center;
        border-radius:7px;font-size:12.5px;font-weight:700;color:#5b6b7a;background:#f4f6f8;text-decoration:none}
    .lgp-btn:hover{background:#e6ebf0;color:#2c3e50;text-decoration:none}
    .lgp-btn.on{background:#27ae60;color:#fff}
    .lgp-btn.off{opacity:.4;pointer-events:none}
    .lgp-btn i{font-size:10px}
    .lgp-dots{display:inline-flex;align-items:center;height:32px;padding:0 4px;color:#b6c0cb;font-size:13px}
</style>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3" style="padding:0 2px;">
    <div>
        <h4 style="font-weight:800;font-size:20px;color:#2c3e50;margin:0;">
            <i class="fas fa-archive" style="color:#27ae60;margin-right:8px;"></i>Eski sayt arxivi
        </h4>
        <p style="color:#6b7a8d;font-size:13px;margin:4px 0 0;">
            2015&ndash;2025 yillardagi ekolog.uz kontenti &mdash; faqat ko'rish uchun
        </p>
    </div>
    <a href="{{ route('admin.legacy.media') }}"
       style="background:linear-gradient(135deg,#3498db,#2471a3);color:#fff;border-radius:9px;padding:10px 18px;font-weight:700;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:8px;box-shadow:0 4px 14px rgba(52,152,219,.32);">
        <i class="fas fa-images"></i> Media galereya
    </a>
</div>

<div class="row mb-3">
    <div class="col-md-3 col-6 mb-2"><div class="lg-mini"><i class="fas fa-newspaper" style="color:#27ae60"></i><div><div class="v">{{ number_format($stats['posts']) }}</div><div class="l">Maqola</div></div></div></div>
    <div class="col-md-3 col-6 mb-2"><div class="lg-mini"><i class="fas fa-file" style="color:#3498db"></i><div><div class="v">{{ number_format($stats['pages']) }}</div><div class="l">Sahifa</div></div></div></div>
    <div class="col-md-3 col-6 mb-2"><div class="lg-mini"><i class="fas fa-image" style="color:#9b59b6"></i><div><div class="v">{{ number_format($stats['images']) }}</div><div class="l">Rasm</div></div></div></div>
    <div class="col-md-3 col-6 mb-2"><div class="lg-mini"><i class="fas fa-tags" style="color:#e67e22"></i><div><div class="v">{{ number_format($stats['terms']) }}</div><div class="l">Rukn / teg</div></div></div></div>
</div>

@if($stats['files_present'] === 0)
    <div class="lg-warn mb-3">
        <i class="fas fa-info-circle"></i>
        Media fayllar hali serverga ko'chirilmagan &mdash; hozircha faqat matn va fayl nomlari ko'rinadi.
    </div>
@endif

<form method="GET" class="lg-filter">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-2">
            <label>Qidiruv</label>
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Sarlavha yoki matn...">
        </div>
        <div class="col-lg-2 col-md-6 mb-2">
            <label>Manba</label>
            <select name="source" class="form-control">
                <option value="">Hammasi</option>
                @foreach(config('legacy.sources') as $key => $cfg)
                    <option value="{{ $key }}" @selected(($filters['source'] ?? '') === $key)>{{ $cfg['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 mb-2">
            <label>Yil</label>
            <select name="year" class="form-control">
                <option value="">Barcha yillar</option>
                @foreach($years as $y => $c)
                    <option value="{{ $y }}" @selected((string)($filters['year'] ?? '') === (string)$y)>{{ $y }} ({{ $c }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 mb-2">
            <label>Til</label>
            <select name="lang" class="form-control">
                <option value="">Barchasi</option>
                <option value="uz" @selected(($filters['lang'] ?? '') === 'uz')>O'zbekcha (lotin)</option>
                <option value="kr" @selected(($filters['lang'] ?? '') === 'kr')>O'zbekcha (kirill)</option>
                <option value="ru" @selected(($filters['lang'] ?? '') === 'ru')>Ruscha</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-4 mb-2">
            <label>Turi</label>
            <select name="type" class="form-control">
                <option value="">Hammasi</option>
                <option value="post" @selected(($filters['type'] ?? '') === 'post')>Maqola</option>
                <option value="page" @selected(($filters['type'] ?? '') === 'page')>Sahifa</option>
            </select>
        </div>
        <div class="col-lg-1 col-md-4 mb-2 d-flex align-items-end">
            <button class="btn btn-block" style="background:#27ae60;color:#fff;font-weight:700;border-radius:8px;height:36px;font-size:13px;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    @if(array_filter($filters ?? []))
        <a href="{{ route('admin.legacy.index') }}" style="font-size:12px;color:#8b97a4;">
            <i class="fas fa-times"></i> Filtrlarni tozalash
        </a>
    @endif
</form>

<div class="d-flex justify-content-between align-items-center mb-2" style="font-size:12.5px;color:#6b7a8d;">
    <div><strong style="color:#2c3e50;">{{ number_format($posts->total()) }}</strong> ta yozuv topildi</div>
    <div id="lg-counter" data-total="{{ $posts->total() }}">{{ $posts->count() }} ta ko'rsatilmoqda</div>
</div>

@if($posts->total() === 0)
    <div class="lg-empty">
        <i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;"></i>
        Hech narsa topilmadi
    </div>
@else
    <div class="lg-grid" id="lg-grid">
        @include('admin.legacy._cards', ['posts' => $posts])
    </div>

    <div class="lg-more" id="lg-more" hidden><span class="spin"></span>Yuklanmoqda...</div>
    <div id="lg-sentinel"></div>

    @include('admin.legacy._pagination', ['paginator' => $posts, 'wrapId' => 'lg-pagination'])
@endif

@endsection

@section('scripts')
@include('admin.legacy._infinite_scroll', ['prefix' => 'lg', 'paginator' => $posts])
@endsection
