<?php

namespace App\Http\Controllers\Admin;

use App\Models\Management;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Video;
use App\Models\User;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class HomeController
{
    public function index()
    {
        $site_status = Management::query()->first()?->site_status;

        $stats = [
            'total_posts'   => Post::count(),
            'active_posts'  => Post::where('status', 1)->count(),
            'today_posts'   => Post::whereDate('created_at', today())->count(),
            'total_views'   => Post::sum('views_count'),
            'total_videos'  => Video::count(),
            'total_users'   => User::count(),
            'week_views'    => PostView::where('created_at', '>=', now()->subDays(7))->count(),
            'month_posts'   => Post::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $recent_posts = Post::with('media')
            ->latest()
            ->take(8)
            ->get();

        $top_posts = Post::orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        return view('home', compact('site_status', 'stats', 'recent_posts', 'top_posts'));
    }

    public function translate(Request $request) {
        $data = [];
        foreach (config('app.locales') as $key_local => $value_local) {
            if($value_local !== 'kr') {
                $translated = trs($request->data, $value_local);
                array_push($data, $translated);
            }
        }

        return response()->json(['data' => $data]);
    }
    public function translateTitle(Request $request) {
        $data = [];
        foreach (config('app.locales') as $key_local => $value_local) {
            if($value_local !== 'kr' && $value_local !== 'uz') {
                $translated = trsTitle($request->data, $value_local);
                array_push($data, $translated);
            }
            if($value_local == 'uz') {
                $translated = transliterateLatin($request->data);
                array_push($data, $translated);
            }
        }

        return response()->json(['data' => $data]);
    }
}
