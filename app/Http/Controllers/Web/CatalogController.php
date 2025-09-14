<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class CatalogController extends Controller
{

    public function tag(Request $request, $tag_slug)
    {
        $locale = app()->getLocale();

        $tag = Tag::query()->where("slug_". $locale, $tag_slug)->firstOrFail();

        $posts = Post::query()
            ->leftJoin('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->where("post_tag.tag_id", $tag->id)
            ->where("status", 1)
            ->orderBy("created_at", "DESC")
            ->paginate(10);

        return view("web.catalog.tag", compact('tag', 'posts'));
    }

    public function archive(Request $request, $year, $month)
    {

        $posts = Post::query()
            ->where("status", 1)
            ->orderBy("created_at", "DESC")
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->paginate(10);

        return view("web.catalog.archive",[
            "breadcrumb_title"=>"{$year} - {$month}",
            "posts"=>$posts
        ]);
    }
}
