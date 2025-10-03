<?php

namespace App\Http\Controllers\Api;

use App\Models\BannerPost;
use App\Models\Post;
use App\Models\PostView;
use App\Models\Quotation;
use App\Models\Section;
use App\Models\Tag;
use App\Models\Video;
use App\Models\VideoCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $response = [
        'success' => true,
        'result' => [],
        'error' => []
    ];

    public function getNewsHome(Request $request)
    {

        $newsSectionIds = Section::query()->where('id', 1)->orWhere('parent_id',1)->pluck('id');
        $eduSectionIds = Section::query()->where('id', 2)->orWhere('parent_id','2')->pluck('id');
        $healthSectionIds = Section::query()->where('id', 3)->orWhere('parent_id',3)->pluck('id');
        $legalClinicSectionIds = Section::query()->where('id', 4)->orWhere('parent_id',4)->pluck('id');
        $achchiqtoshSectionIds = Section::query()->where('id', 5)->orWhere('parent_id',5)->pluck('id');
        $usefulSectionIds = Section::query()->where('id', 6)->orWhere('parent_id',6)->pluck('id');


        if ($request->header('Accept-Language')){
            $request_lang = $request->header('Accept-Language');
        }


        if (isset($request_lang) && ($request_lang == 'en' || $request_lang == 'ru')){

            $mainPosts = Post::query()
                ->where('recommended',1)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("created_at", "DESC")
                ->limit(5)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids')
                ->get();

            $educationPosts = Post::query()->whereIn('section_ids',$eduSectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("publish_date", "DESC")->limit(4)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $recentNewsPosts = Post::query()->whereIn('section_ids',$newsSectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("publish_date", "DESC")->limit(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count')
                ->get();
            $achchiqtoshPosts = Post::query()->whereIn('section_ids',$achchiqtoshSectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids')
                ->get();
            $healthPosts = Post::query()->whereIn('section_ids',$healthSectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $legalClinicPosts = Post::query()->whereIn('section_ids',$legalClinicSectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $usefulPosts = Post::query()->whereIn('section_ids',$usefulSectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
        } else {
            $mainBanners = BannerPost::query()->select('banner_posts.id','banner_posts.post_id','banner_posts.header_type','banner_posts.post_id')
                ->where('banner_posts.type', "main")
                ->with(['post'=> function ($query) {
                    $query->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids');
                }])
                ->orderBy("id", "DESC")
                ->limit(10)
                ->get();

            $mainPosts = Post::query()->where('recommended',1)->orderBy("created_at", "DESC")->limit(5)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids')
                ->get();



            $educationPosts = Post::query()->whereIn('section_ids',$eduSectionIds)->orderBy("publish_date", "DESC")->limit(4)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $recentNewsPosts = Post::query()->whereIn('section_ids',$newsSectionIds)->orderBy("publish_date", "DESC")->limit(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count')
                ->get();
            $achchiqtoshPosts = Post::query()->whereIn('section_ids',$achchiqtoshSectionIds)->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids')
                ->get();
            $healthPosts = Post::query()->whereIn('section_ids',$healthSectionIds)->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $legalClinicPosts = Post::query()->whereIn('section_ids',$legalClinicSectionIds)->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $usefulPosts = Post::query()->whereIn('section_ids',$usefulSectionIds)->orderBy("publish_date", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
        }

        $quotations = Quotation::query()->where('status',1)->limit(10)->get();
        $bannerVideos = Video::query()->whereIn('sort',[1,2])
            ->orderBy("sort", "ASC")
            ->get();

        $result = [
        'mainBanners' => $mainBanners,
        'mainPosts' => $mainPosts,
        'educationPosts' => $educationPosts,
        'recentNewsPosts' => $recentNewsPosts,
        'quotations' => $quotations,
        'achchiqtoshPosts' => $achchiqtoshPosts,
        'healthPosts' => $healthPosts,
        'legalClinicPosts' => $legalClinicPosts,
        'usefulPosts' => $usefulPosts,
        'bannerVideos' => $bannerVideos
        ];

        if (empty($result)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'posts not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $result,
                'msg' => 'ok'
            ]);
        }
    }

    public function getPostId(Request $request, $id){
        if ($request->header('Accept-Language')){
            $request_lang = $request->header('Accept-Language');
        }
        if (isset($request_lang) && ($request_lang == 'en' || $request_lang == 'ru')){
            $post = Post::query()
                ->with("tags")
                ->groupBy('posts.id')
                ->where('posts.id',$id)
                ->where("posts.status", 1)
                ->whereNotNull('posts.title_'.$request_lang)
                ->first();
        } else {
            $post = Post::query()
                ->with("tags")
                ->groupBy('posts.id')
                ->where('posts.id',$id)
                ->where("posts.status", 1)
                ->first();
        }


        if ($post) {
            $ip = request()->ip();
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
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'post not found'
            ]);
        }
        $most_read_posts = Post::query()
            ->groupBy('posts.id')
            ->orderBy("views_count", "DESC")->limit(3)
            ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                'description_uz','description_kr','description_ru','description_en','description_tr')
            ->get();

        $post->update([
            'views_count' => 1 + $post->views_count
        ]);
        $result = [
            'post' => $post,
            'mostReadPosts' => $most_read_posts,
        ];
        if (empty($result)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'post not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $result,
                'msg' => 'ok'
            ]);
        }
    }

    public function getCategoryId(Request $request, $id) {
        if ($request->header('Accept-Language')){
            $request_lang = $request->header('Accept-Language');
        }
        $categorySectionIds = Section::query()->where('id', $id)->orWhere('parent_id',$id)->pluck('id');
        if (isset($request_lang) && ($request_lang == 'en' || $request_lang == 'ru')) {
            $bannerPosts = Post::query()->whereIn('section_ids',$categorySectionIds)->where('recommended',1)->whereNotNull('title_'.$request_lang)->orderBy("created_at", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $resentPosts = Post::query()->whereIn('section_ids',$categorySectionIds)
                ->whereNotNull('title_'.$request_lang)->orderBy("publish_date", "DESC")
                ->whereNotIn('id',$bannerPosts->pluck('id'))
                ->limit(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count')
                ->get();
            $mostReadPosts = Post::query()
                ->whereIn('section_ids',$categorySectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->orderBy("views_count", "DESC")->limit(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count')
                ->get();
            $categoryPosts = Post::query()->whereIn('section_ids',$categorySectionIds)
                ->whereNotNull('title_'.$request_lang)
                ->whereNotIn('id',$bannerPosts->pluck('id'))
                ->orderBy("publish_date", "DESC")->offset(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->paginate(16);
        } else {
            $bannerPosts = Post::query()->whereIn('section_ids',$categorySectionIds)->where('recommended',1)->orderBy("created_at", "DESC")->limit(3)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->get();
            $resentPosts = Post::query()->whereIn('section_ids',$categorySectionIds)
                ->whereNotIn('id',$bannerPosts->pluck('id'))
                ->orderBy("publish_date", "DESC")
                ->limit(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count')
                ->get();
            $mostReadPosts = Post::query()->whereIn('section_ids',$categorySectionIds)->orderBy("views_count", "DESC")->limit(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count')
                ->get();
            $categoryPosts = Post::query()
                ->whereIn('section_ids',$categorySectionIds)
                ->whereNotIn('id',$bannerPosts->pluck('id'))
                ->orderBy("publish_date", "DESC")->offset(7)
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->paginate(16);
        }



        if (!($categoryPosts and count($categoryPosts)) > 0) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'post not found'
            ]);
        }

        if (!isset($bannerPosts) or count($bannerPosts) <= 0 ) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'post not found'
            ]);
        }
//        if (!($bannerPosts and count($bannerPosts)) > 0) {
//            $bannerPosts = Post::query()->where('recommended',1)->orderBy("created_at", "DESC")->limit(3)
//                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
//                    'description_uz','description_kr','description_ru','description_en','description_tr')
//                ->get();
//        }
	//dd($bannerPosts);
        $result = [
            'resentPosts' => $resentPosts,
            'bannerPosts' => $bannerPosts,
            'categoryPosts' => $categoryPosts,
            'mostReadPosts' => $mostReadPosts,
        ];
        if (empty($result)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'post not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $result,
                'msg' => 'ok'
            ]);
        }
    }

    public function getSearch(Request $request)
    {
        $search = request()->search;

        if ($request->header('Accept-Language')){
            $request_lang = $request->header('Accept-Language');
        }
        if (isset($request_lang) && ($request_lang == 'en' || $request_lang == 'ru')){
            $posts = Post::query()
                ->where("status", 1)
                ->whereNotNull('title_'.$request_lang)
                ->where("content_uz", 'like', '%'.$search.'%')
                ->Orwhere("content_kr", 'like', '%'.$search.'%')
                ->Orwhere("content_ru", 'like', '%'.$search.'%')
                ->Orwhere("content_en", 'like', '%'.$search.'%')
                ->Orwhere("title_uz", 'like', '%'.$search.'%')
                ->Orwhere("title_ru", 'like', '%'.$search.'%')
                ->Orwhere("title_kr", 'like', '%'.$search.'%')
                ->Orwhere("title_en", 'like', '%'.$search.'%')
                ->orderBy("publish_date", "DESC")
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->paginate(12);
        } else {
            $posts = Post::query()
                ->where("status", 1)
                ->where("content_uz", 'like', '%'.$search.'%')
                ->Orwhere("content_kr", 'like', '%'.$search.'%')
                ->Orwhere("content_ru", 'like', '%'.$search.'%')
                ->Orwhere("content_en", 'like', '%'.$search.'%')
                ->Orwhere("title_uz", 'like', '%'.$search.'%')
                ->Orwhere("title_ru", 'like', '%'.$search.'%')
                ->Orwhere("title_kr", 'like', '%'.$search.'%')
                ->Orwhere("title_en", 'like', '%'.$search.'%')
                ->orderBy("publish_date", "DESC")
                ->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en','section_ids','publish_date','views_count',
                    'description_uz','description_kr','description_ru','description_en','description_tr')
                ->paginate(12);
        }


        $result = [
            'posts' => $posts,
        ];

        if (empty($result)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'posts not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $result,
                'msg' => 'ok'
            ]);
        }
    }

    public function getVideos() {

        $bannerVideos = Video::query()->whereIn('sort',[1,2,3,4,5,6,7])
            ->orderBy("sort", "ASC")
            ->get();
        $videoCategories = VideoCategory::query()->with('videos')->get();
        $result = [
            'bannerVideos' => $bannerVideos,
            'videoCategories' => $videoCategories
        ];

        if (empty($result)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'posts not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $result,
                'msg' => 'ok'
            ]);
        }
    }

    public function getTags(Request $request, $id){

        $tag = Tag::query()->where("id", $id)->first();

        if (empty($tag)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'posts not found'
            ]);
        }

 	if ($request->header('Accept-Language')){
            $request_lang = $request->header('Accept-Language');
        }

        if (isset($request_lang) && ($request_lang == 'en' || $request_lang == 'ru')){
        $posts = Post::query()
            ->leftJoin('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->leftJoin('tags', 'tags.id', '=', 'post_tag.tag_id')
            ->where("post_tag.tag_id", $tag->id)
 	    ->whereNotNull('posts.title_'.$request_lang)
            ->where("posts.status", 1)
            ->orderBy("posts.created_at", "DESC")
            ->select('posts.id','posts.slug_uz','posts.title_uz','posts.title_kr','posts.title_ru','posts.title_en','posts.slug_kr','posts.slug_ru','posts.slug_en','posts.section_ids','posts.publish_date','posts.views_count',
                'description_uz','description_kr','description_ru','description_en','description_tr')
            ->paginate(10);
	} else {
	 $posts = Post::query()
            ->leftJoin('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->leftJoin('tags', 'tags.id', '=', 'post_tag.tag_id')
            ->where("post_tag.tag_id", $tag->id)
            ->where("posts.status", 1)
            ->orderBy("posts.created_at", "DESC")
            ->select('posts.id','posts.slug_uz','posts.title_uz','posts.title_kr','posts.title_ru','posts.title_en','posts.slug_kr','posts.slug_ru','posts.slug_en','posts.section_ids','posts.publish_date','posts.views_count',
                'description_uz','description_kr','description_ru','description_en','description_tr')
            ->paginate(10);
	}

        $result = [
            'posts' => $posts,
        ];
        if (empty($result)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'posts not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $result,
                'msg' => 'ok'
            ]);
        }

    }
}
