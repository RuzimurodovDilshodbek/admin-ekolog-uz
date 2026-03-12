@extends('layouts.admin')
@section('content')

{{-- ═══ WELCOME BAR ════════════════════════════════════════ --}}
<div class="d-flex align-items-center justify-content-between mb-4" style="padding: 0 2px;">
    <div>
        <h4 style="font-weight:800; font-size:20px; color:#2c3e50; margin:0;">
            Xush kelibsiz, <span style="color:#27ae60;">Admin</span> 👋
        </h4>
        <p style="color:#6b7a8d; font-size:13px; margin:4px 0 0;">
            {{ \Carbon\Carbon::now()->locale('ru')->isoFormat('D MMMM YYYY, dddd') }}
        </p>
    </div>
    @can('post_create')
        <a href="{{ route('admin.posts.create') }}"
           style="background:linear-gradient(135deg,#27ae60,#1e8449); color:#fff; border-radius:9px; padding:10px 20px; font-weight:700; font-size:13px; text-decoration:none; display:flex; align-items:center; gap:8px; box-shadow:0 4px 14px rgba(39,174,96,0.35);">
            <i class="fas fa-plus"></i> Yangi post
        </a>
    @endcan
</div>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

{{-- ═══ STAT CARDS ══════════════════════════════════════════ --}}
<div class="row" style="margin-bottom:6px;">

    {{-- Total Posts --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#27ae60 0%,#1e8449 100%);">
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ number_format($stats['total_posts']) }}</div>
                <div class="stat-label">Jami postlar</div>
            </div>
            <div class="stat-bg-icon"><i class="fas fa-file-alt"></i></div>
        </div>
    </div>

    {{-- Active Posts --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#3498db 0%,#2471a3 100%);">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ number_format($stats['active_posts']) }}</div>
                <div class="stat-label">Aktiv postlar</div>
            </div>
            <div class="stat-bg-icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>

    {{-- Total Views --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#9b59b6 0%,#7d3c98 100%);">
            <div class="stat-icon"><i class="fas fa-eye"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ number_format($stats['total_views']) }}</div>
                <div class="stat-label">Jami ko'rishlar</div>
            </div>
            <div class="stat-bg-icon"><i class="fas fa-eye"></i></div>
        </div>
    </div>

    {{-- Today Posts --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#e67e22 0%,#ca6f1e 100%);">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-body">
                <div class="stat-value">{{ $stats['today_posts'] }}</div>
                <div class="stat-label">Bugun qo'shildi</div>
            </div>
            <div class="stat-bg-icon"><i class="fas fa-calendar-day"></i></div>
        </div>
    </div>

</div>

{{-- ═══ SECONDARY STATS ─────────────────────────────────── --}}
<div class="row mb-4">

    <div class="col-md-4 mb-3">
        <div class="mini-stat-card">
            <div class="mini-stat-icon" style="background:#eafaf1; color:#27ae60;">
                <i class="fas fa-video"></i>
            </div>
            <div>
                <div class="mini-stat-value">{{ number_format($stats['total_videos']) }}</div>
                <div class="mini-stat-label">Videolar</div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="mini-stat-card">
            <div class="mini-stat-icon" style="background:#ebf5fb; color:#3498db;">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <div class="mini-stat-value">{{ number_format($stats['total_users']) }}</div>
                <div class="mini-stat-label">Foydalanuvchilar</div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="mini-stat-card">
            <div class="mini-stat-icon" style="background:#f5eef8; color:#9b59b6;">
                <i class="fas fa-eye"></i>
            </div>
            <div>
                <div class="mini-stat-value">{{ number_format($stats['week_views']) }}</div>
                <div class="mini-stat-label">Haftalik ko'rishlar</div>
            </div>
        </div>
    </div>

</div>

{{-- ═══ TABLES ROW ══════════════════════════════════════════ --}}
<div class="row">

    {{-- Recent Posts --}}
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="fas fa-clock" style="color:#27ae60; margin-right:8px;"></i>Oxirgi postlar</span>
                @can('post_access')
                    <a href="{{ route('admin.posts.index') }}" style="font-size:12px; color:#27ae60; font-weight:700; text-decoration:none;">
                        Barchasi <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                    </a>
                @endcan
            </div>
            <div class="card-body" style="padding:0 !important; overflow:hidden;">
                <div class="table-responsive">
                    <table class="table mb-0" style="font-size:13px;">
                        <thead style="background:#f8f9fb;">
                            <tr>
                                <th style="padding:11px 16px; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.4px; color:#6b7a8d; border:none;">#</th>
                                <th style="padding:11px 16px; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.4px; color:#6b7a8d; border:none;">Sarlavha</th>
                                <th style="padding:11px 16px; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.4px; color:#6b7a8d; border:none;">Holat</th>
                                <th style="padding:11px 16px; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.4px; color:#6b7a8d; border:none;">Sana</th>
                                <th style="padding:11px 16px; border:none;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_posts as $i => $post)
                                <tr style="border-top:1px solid #f0f2f5; transition:background 0.15s;" onmouseover="this.style.background='#f7fff8'" onmouseout="this.style.background=''">
                                    <td style="padding:11px 16px; vertical-align:middle; color:#a0aab4; font-size:12px;">{{ $i+1 }}</td>
                                    <td style="padding:11px 16px; vertical-align:middle; max-width:260px;">
                                        <div style="font-weight:600; color:#2c3e50; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:250px;">
                                            {{ $post->title_uz ?: $post->title_ru ?: '—' }}
                                        </div>
                                    </td>
                                    <td style="padding:11px 16px; vertical-align:middle;">
                                        @if($post->status == 1)
                                            <span style="background:#eafaf1; color:#27ae60; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">Aktiv</span>
                                        @else
                                            <span style="background:#fdf2f2; color:#e74c3c; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">Arxiv</span>
                                        @endif
                                    </td>
                                    <td style="padding:11px 16px; vertical-align:middle; color:#6b7a8d; white-space:nowrap; font-size:12px;">
                                        {{ $post->created_at ? $post->created_at->format('d.m.Y') : '—' }}
                                    </td>
                                    <td style="padding:11px 16px; vertical-align:middle; text-align:right;">
                                        @can('post_edit')
                                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                               style="background:#f0f8ff; color:#3498db; padding:5px 10px; border-radius:6px; font-size:11px; font-weight:700; text-decoration:none; white-space:nowrap;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align:center; padding:30px; color:#a0aab4; font-size:13px;">
                                        <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:8px; color:#d1d9e0;"></i>
                                        Hozircha postlar yo'q
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Top Posts by Views --}}
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="fas fa-fire" style="color:#e67e22; margin-right:8px;"></i>Ko'p ko'rilgan
            </div>
            <div class="card-body" style="padding:12px !important;">
                @forelse($top_posts as $i => $post)
                    <div style="display:flex; align-items:center; gap:12px; padding:10px 8px; border-radius:8px; transition:background 0.15s; {{ $i < count($top_posts)-1 ? 'border-bottom:1px solid #f0f2f5;' : '' }}"
                         onmouseover="this.style.background='#f8f9fb'" onmouseout="this.style.background=''">
                        <div style="width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:13px; flex-shrink:0;
                            {{ $i == 0 ? 'background:#fff7e6; color:#e67e22;' : ($i == 1 ? 'background:#f5f5f5; color:#7f8c8d;' : ($i == 2 ? 'background:#fdf2e9; color:#ca6f1e;' : 'background:#f8f9fb; color:#a0aab4;')) }}">
                            {{ $i+1 }}
                        </div>
                        <div style="flex:1; min-width:0;">
                            <div style="font-weight:600; font-size:13px; color:#2c3e50; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $post->title_uz ?: $post->title_ru ?: '—' }}
                            </div>
                            <div style="font-size:11.5px; color:#6b7a8d; margin-top:2px;">
                                <i class="fas fa-eye" style="font-size:10px; margin-right:3px;"></i>
                                {{ number_format($post->views_count) }} marta
                            </div>
                        </div>
                        @can('post_edit')
                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                               style="color:#a0aab4; font-size:12px; text-decoration:none; flex-shrink:0; padding:4px 6px; border-radius:5px; transition:color 0.15s;"
                               onmouseover="this.style.color='#27ae60'" onmouseout="this.style.color='#a0aab4'">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        @endcan
                    </div>
                @empty
                    <div style="text-align:center; padding:30px; color:#a0aab4; font-size:13px;">
                        <i class="fas fa-chart-bar" style="font-size:24px; display:block; margin-bottom:8px; color:#d1d9e0;"></i>
                        Ma'lumot yo'q
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ═══ QUICK LINKS ─────────────────────────────────────── --}}
<div class="card">
    <div class="card-header">
        <i class="fas fa-bolt" style="color:#f39c12; margin-right:8px;"></i>Tezkor havolalar
    </div>
    <div class="card-body" style="padding:16px !important;">
        <div class="row" style="gap:0;">
            @can('post_create')
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('admin.posts.create') }}" class="quick-link-card">
                        <div class="quick-link-icon" style="background:#eafaf1; color:#27ae60;"><i class="fas fa-plus-circle"></i></div>
                        <span>Yangi post</span>
                    </a>
                </div>
            @endcan
            @can('section_access')
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('admin.sections.index') }}" class="quick-link-card">
                        <div class="quick-link-icon" style="background:#ebf5fb; color:#3498db;"><i class="fas fa-sitemap"></i></div>
                        <span>Bo'limlar</span>
                    </a>
                </div>
            @endcan
            @can('video_access')
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('admin.videos.index') }}" class="quick-link-card">
                        <div class="quick-link-icon" style="background:#f5eef8; color:#9b59b6;"><i class="fas fa-video"></i></div>
                        <span>Videolar</span>
                    </a>
                </div>
            @endcan
            @can('user_access')
                <div class="col-6 col-md-3 mb-3">
                    <a href="{{ route('admin.users.index') }}" class="quick-link-card">
                        <div class="quick-link-icon" style="background:#fef9e7; color:#f39c12;"><i class="fas fa-users"></i></div>
                        <span>Foydalanuvchilar</span>
                    </a>
                </div>
            @endcan
        </div>
    </div>
</div>

<style>
/* ─── Stat Cards ─────────────────────────── */
.stat-card {
    border-radius: 12px;
    padding: 22px 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    align-items: center;
    gap: 16px;
    min-height: 100px;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
}
.stat-icon {
    width: 52px; height: 52px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff; flex-shrink: 0;
}
.stat-body { flex: 1; }
.stat-value {
    font-size: 28px; font-weight: 800; color: #fff;
    line-height: 1.1; letter-spacing: -0.5px;
}
.stat-label {
    font-size: 12.5px; color: rgba(255,255,255,0.82);
    font-weight: 600; margin-top: 3px; letter-spacing: 0.2px;
}
.stat-bg-icon {
    position: absolute; right: -10px; bottom: -10px;
    font-size: 70px; color: rgba(255,255,255,0.1);
    pointer-events: none;
}

/* ─── Mini Stat Cards ────────────────────── */
.mini-stat-card {
    background: #fff;
    border-radius: 10px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    border: 1px solid #f0f2f5;
    transition: transform 0.2s, box-shadow 0.2s;
}
.mini-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 16px rgba(0,0,0,0.1);
}
.mini-stat-icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.mini-stat-value {
    font-size: 22px; font-weight: 800; color: #2c3e50; line-height: 1;
}
.mini-stat-label {
    font-size: 12px; color: #6b7a8d; font-weight: 600; margin-top: 3px;
}

/* ─── Quick Link Cards ───────────────────── */
.quick-link-card {
    display: flex; align-items: center; gap: 12px;
    background: #f8f9fb;
    border: 1.5px solid #e8ecf0;
    border-radius: 10px;
    padding: 14px 16px;
    text-decoration: none;
    color: #2c3e50;
    font-weight: 700;
    font-size: 13.5px;
    transition: all 0.2s;
    width: 100%;
}
.quick-link-card:hover {
    background: #eafaf1;
    border-color: #27ae60;
    color: #1e8449;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(39,174,96,0.15);
}
.quick-link-icon {
    width: 38px; height: 38px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
</style>
@endsection
