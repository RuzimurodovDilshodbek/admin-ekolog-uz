<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Jobs\PostViewJob;
use App\Models\Ad;
use App\Models\BannerPost;
use App\Models\Quotation;
use App\Models\Video;
use App\Models\Newsletter;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Section;
use App\Models\Tag;
use App\Models\TutorOpinion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{

    public function home()
    {
        return Redirect::to('login');

        $mainPosts = Post::query()->where('recommended',1)->orderBy("created_at", "DESC")->limit(5)->get();

        $eduSectionIds = Section::query()->where('id', 2)->orWhere('parent_id','2')->pluck('id');
        $newsSectionIds = Section::query()->where('id', 1)->orWhere('parent_id',1)->pluck('id');

        $educationPosts = Post::query()->whereIn('section_ids',$eduSectionIds)->orderBy("created_at", "DESC")->limit(4)->get();
        $recentNewsPosts = Post::query()->whereIn('section_ids',$newsSectionIds)->orderBy("created_at", "DESC")->limit(6)->get();
        $quotations = Quotation::query()->where('status',1)->limit(10)->get();


        $recentPosts = Post::query()
            ->leftJoin('post_views', function ($join) {
                $join->on('posts.id', '=', 'post_views.post_id');
            })
            ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
            ->groupBy('posts.id')
            ->where("status", 1)
            ->where('publish_date', '<=',Carbon::parse()->format('Y-m-d H:i:s'))
            ->orderBy("publish_date", "DESC")
            ->paginate(10);

        $opinions = TutorOpinion::query()
            ->orderBy("sort")
            ->limit(10)
            ->inRandomOrder()
            ->get();

        $ads = Ad::query()
            ->where("position", "in_post_list")
            ->orderBy("sort")
            ->inRandomOrder()
            ->where("status", 1)
            ->take(2)
            ->get();

        return view("web.pages.home", compact("mainPosts",'educationPosts','recentNewsPosts','quotations'));
    }

    public function news($sectionSlug)
    {
        $locale = app()->getLocale();

        $section = Section::query()
            ->where("slug_". $locale, $sectionSlug)
            ->firstOrFail();

        $posts = Post::query()
            ->where("status", 1)
            ->whereRaw("FIND_IN_SET('$section->id', section_ids)")
            ->orderBy("publish_date", "DESC")
            ->paginate(10);

        return view("web.pages.news", compact("section", "posts"));
    }

    public function contact()
    {
        return view("web.pages.contact");
    }


    public function search()
    {
        $search = request()->search;
        $locale = app()->getLocale();

        $section = Section::query()
            ->firstOrFail();

        $posts = Post::query()
            ->where("status", 1)
            ->where("content_". $locale, 'like', '%'.$search.'%')
            ->Orwhere("title_". $locale, 'like', '%'.$search.'%')
            ->orderBy("publish_date", "DESC")
            ->paginate(10);


        return view("web.pages.news", compact("section", "posts",'search'));
    }


    public function newsDetail($sectionSlug, $postSlug)
    {
        $locale = app()->getLocale();

        $section = Section::query()
            ->where("slug_". $locale, $sectionSlug)
            ->first();

        if (!$section) {
            abort(404);
        }
        $post = Post::query()
            ->with("tags")
            ->leftJoin('post_views', function ($join) {
                $join->on('posts.id', '=', 'post_views.post_id');
            })
            ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
            ->groupBy('posts.id')
//            ->where("status", 1)
            ->where("slug_". $locale, $postSlug)
            ->whereRaw("FIND_IN_SET('$section->id', section_ids)")
            ->first();

        if ($post) {
            $ip = request()->ip();
            if ($post) {
                $postView = PostView::query()->where('post_id', $post->id)->where('ip', $ip)->orderBy("created_at", "DESC")->first();

                if (!empty($postView)){
                    if (Carbon::parse($postView->created_at)->diffInHours(now())  > 1){
                        PostView::query()->create([
                            'ip' => $ip,
                            'post_id' => $post->id
                        ]);
                    }
                } else {
                    PostView::query()->create([
                        'ip' => $ip,
                        'post_id' => $post->id
                    ]);
                }
            }
        } else {
            abort(404);
        }


//        PostViewJob::dispatch($post)->onQueue("post_views");


        return view("web.pages.newsDetail", compact("post"));
    }

    public function getNewsList(Request $request)
    {

        $type = $request->get("action");
        switch ($type) {

            case "load_widget_hot_news" :
            {

                $hotPosts = \App\Models\Post::query()
                    ->where("type", "hot")
                    ->where("status", 1)
                    ->orderBy("publish_date", "DESC")
                    ->limit(6)
                    ->inRandomOrder()
                    ->get();
                return view("web.pages.post.hot-list", [
                    "posts" => $hotPosts
                ]);
            }
            case  "load_widget_trendy_news" :
            {
                $trendPosts = \App\Models\Post::query()
                    ->where("type", "trend")
                    ->where("status", 1)
                    ->orderBy("publish_date", "DESC")
                    ->limit(6)
                    ->inRandomOrder()
                    ->get();
                return view("web.pages.post.hot-list", [
                    "posts" => $trendPosts
                ]);
            }
            case  "load_widget_most_watched" :
            {

                $mostViewedPosts = Post::getMostViewedPosts(5);
                return view("web.pages.post.hot-list", [
                    "posts" => $mostViewedPosts
                ]);
            }
        }
    }

    public function newsletter(Request $request)
    {
        $email = $request->get("email");


        $newsletter = Newsletter::where('email', $email)->first();
        if (!$newsletter) {
            $newsletter = Newsletter::create([
                'email' => $email,
                "client_ip" => $request->ip()
            ]);
        }

        return response()->json([
            "error" => 1,
            "text" => __("Muvaffaqiyatli obuna bo'ldingiz!"),
        ]);
    }

    public function prayerTimes()
    {
        return view("web.pages.prayer-times");
    }

    public function changeLang(Request $request)
    {
        $from_route = null;
        $from_locale = null;

        try {
            [$from_route, $from_locale] = explode('--', $request->from_route);
        } catch (\Exception $e) {

        }

        $params = json_decode($request->params);


        switch ($from_route) {
            case 'newsDetail': {
                $section = Section::query()->where('slug_' . $from_locale, $params->section)->first();
                $post = Post::query()->where('slug_' . $from_locale, $params->postSlug)->first();

                return redirect()->route($from_route . '--' . $request->to_locale, [
                    'section' => $section['slug_' . $request->to_locale],
                    'postSlug' => $post['slug_' . $request->to_locale],
                ]);
            }
            case 'newsList': {
                $section = Section::query()->where('slug_' . $from_locale, $params->section)->first();

                return redirect()->route($from_route . '--' . $request->to_locale, [
                    'section' => $section['slug_' . $request->to_locale],
                ]);
            }
            case 'tagsList': {
                $tag = Tag::query()->where('slug_' . $from_locale, $params->tag)->first();

                return redirect()->route($from_route . '--' . $request->to_locale, [
                    'tag' => $tag['slug_' . $request->to_locale],
                ]);
            }
            case 'searchList': {
                return redirect()->route($from_route . '--' . $request->to_locale);
            }
        }

        return redirect()->route('home-' . $request->to_locale);
    }
}
