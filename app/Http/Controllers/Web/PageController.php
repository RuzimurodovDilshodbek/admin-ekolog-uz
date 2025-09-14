<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function recent()
    {

        $recentPosts = \App\Models\Post::query()
            ->where("status", 1)
            ->orderBy("publish_date", "DESC")
            ->orderBy("created_at", "DESC")
            ->paginate(10);

        return view("web.pages.recent", compact("recentPosts"));
    }
}
