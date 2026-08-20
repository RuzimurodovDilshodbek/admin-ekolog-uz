@extends('layouts.admin')

@section('styles')
<style>
    .lg-filter{background:#fff;border:1px solid #e6eaef;border-radius:12px;padding:14px 16px;margin-bottom:18px}
    .lg-filter label{font-size:11px;font-weight:700;color:#6b7a8d;text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;display:block}
    .lg-filter .form-control,.lg-filter select{font-size:13px;border-radius:8px;border:1px solid #dfe4ea;height:36px}
    .mg-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px;align-items:start}
    .mg-item{background:#fff;border:1px solid #e6eaef;border-radius:10px;overflow:hidden;transition:box-shadow .18s,transform .18s}
    .mg-item:hover{box-shadow:0 8px 22px rgba(44,62,80,.12);transform:translateY(-2px)}
    .mg-ph{position:relative;padding-top:72%;background:#eef1f4;display:block}
    .mg-ph img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
    .mg-ph .miss{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#b6c0cb;font-size:20px;gap:4px}
    .mg-ph .miss small{font-size:9px;letter-spacing:.3px}
    .mg-cap{padding:7px 9px;font-size:10.5px;color:#6b7a8d;line-height:1.35;word-break:break-all}
    .mg-cap b{display:block;color:#2c3e50;font-size:11px;font-weight:700;margin-bottom:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .lg-mini{background:#fff;border:1px solid #e6eaef;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:10px}
    .lg-mini .v{font-size:17px;font-weight:800;color:#2c3e50;line-height:1}
    .lg-mini .l{font-size:11px;color:#8b97a4}
    .lg-warn{background:#fff8e6;border:1px solid #f5dfa6;color:#7a5c12;border-radius:10px;padding:10px 14px;font-size:12.5px}
    .lg-empty{background:#fff;border:1px solid #e6eaef;border-radius:12px;padding:40px;text-align:center;color:#8b97a4}

    .lg-more{padding:22px 0;text-align:center;font-size:12.5px;color:#8b97a4}
    .lg-more .spin{display:inline-block;width:16px;height:16px;border:2px solid #dfe4ea;border-top-color:#3498db;
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
            <i class="fas fa-images" style="color:#3498db;margin-right:8px;"></i>Arxiv media galereyasi
        </h4>
        <p style="color:#6b7a8d;font-size:13px;margin:4px 0 0;">Eski saytdagi barcha rasm va videolar</p>
    </div>
    <a href="{{ route('admin.legacy.index') }}"
       style="background:linear-gradient(135deg,#27ae60,#1e8449);color:#fff;border-radius:9px;padding:10px 18px;font-weight:700;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-newspaper"></i> Maqolalar
    </a>
</div>

<div class="row mb-3">
    <div class="col-md-4 col-6 mb-2"><div class="lg-mini"><i class="fas fa-image" style="color:#9b59b6"></i><div><div class="v">{{ number_format($stats['images']) }}</div><div class="l">Rasm</div></div></div></div>
    <div class="col-md-4 col-6 mb-2"><div class="lg-mini"><i class="fas fa-film" style="color:#e67e22"></i><div><div class="v">{{ number_format($stats['videos']) }}</div><div class="l">Video</div></div></div></div>
    <div class="col-md-4 col-12 mb-2"><div class="lg-mini"><i class="fas fa-hdd" style="color:#27ae60"></i><div><div class="v">{{ number_format($stats['files_present']) }}</div><div class="l">Fayli mavjud</div></div></div></div>
</div>

@if($stats['files_present'] === 0)
    <div class="lg-warn mb-3">
        <i class="fas fa-info-circle"></i>
        Fayllarning o'zi hali serverga ko'chirilmagan. Ro'yxat va fayl nomlari to'liq.
    </div>
@endif

<form method="GET" class="lg-filter">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-2">
            <label>Qidiruv</label>
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" class="form-control" placeholder="Fayl nomi...">
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
                <option value="">Barchasi</option>
                @foreach($mediaYears as $y)
                    <option value="{{ $y }}" @selected((string)($filters['year'] ?? '') === (string)$y)>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-4 mb-2">
            <label>Turi</label>
            <select name="kind" class="form-control">
                <option value="">Hammasi</option>
                <option value="image" @selected(($filters['kind'] ?? '') === 'image')>Rasm</option>
                <option value="video" @selected(($filters['kind'] ?? '') === 'video')>Video</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-4 mb-2">
            <label>Fayl holati</label>
            <select name="presence" class="form-control">
                <option value="present" @selected($presence === 'present')>Fayli mavjud</option>
                <option value="missing" @selected($presence === 'missing')>Fayli yo'q</option>
                <option value="all" @selected($presence === 'all')>Hammasi</option>
            </select>
        </div>
        <div class="col-lg-1 col-md-4 mb-2 d-flex align-items-end">
            <button class="btn btn-block" style="background:#3498db;color:#fff;font-weight:700;border-radius:8px;height:36px;font-size:13px;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form>

<div class="d-flex justify-content-between align-items-center mb-2" style="font-size:12.5px;color:#6b7a8d;">
    <div><strong style="color:#2c3e50;">{{ number_format($media->total()) }}</strong> ta fayl</div>
    <div id="mg-counter" data-total="{{ $media->total() }}">{{ $media->count() }} ta ko'rsatilmoqda</div>
</div>

@if($media->total() === 0)
    <div class="lg-empty">
        <i class="fas fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;"></i>
        Hech narsa topilmadi
    </div>
@else
    <div class="mg-grid" id="mg-grid">
        @include('admin.legacy._media_items', ['media' => $media])
    </div>

    <div class="lg-more" id="mg-more" hidden><span class="spin"></span>Yuklanmoqda...</div>
    <div id="mg-sentinel"></div>

    @include('admin.legacy._pagination', ['paginator' => $media, 'wrapId' => 'mg-pagination'])
@endif

@endsection

@section('scripts')
@include('admin.legacy._infinite_scroll', ['prefix' => 'mg', 'paginator' => $media])
@endsection
