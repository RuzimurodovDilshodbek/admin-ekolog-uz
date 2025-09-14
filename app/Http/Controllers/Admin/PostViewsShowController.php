<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPostViewRequest;
use App\Http\Requests\StorePostViewRequest;
use App\Http\Requests\UpdatePostViewRequest;
use App\Models\Post;
use App\Models\PostView;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PostViewsShowController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('post_view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::query()
            ->leftJoin('post_views', function ($join) {
                $join->on('posts.id', '=', 'post_views.post_id');
            })
            ->select('posts.id','posts.title_kr', DB::raw('COUNT(post_views.id) as view_count'))
            ->where('status',1)
            ->groupBy('posts.id')
            ->orderByDesc('view_count')
            ->get();
        $allView = PostView::all()->count();

        return view('admin.postViewsShow.index', compact('posts','allView'));
    }
}
