<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBannerPostRequest;
use App\Http\Requests\StoreBannerPostRequest;
use App\Http\Requests\UpdateBannerPostRequest;
use App\Models\BannerPost;
use App\Models\Post;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BannerPostController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('banner_post_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bannerPosts = BannerPost::with(['post', 'media'])->get();

        return view('admin.bannerPosts.index', compact('bannerPosts'));
    }

    public function create()
    {
        abort_if(Gate::denies('banner_post_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title_kr', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.bannerPosts.create', compact('posts'));
    }

    public function store(StoreBannerPostRequest $request)
    {
//        dd($request->all());
        $bannerPost = BannerPost::create($request->all());

        if ($request->input('main_image', false)) {
            $bannerPost->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_image'))))->toMediaCollection('main_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $bannerPost->id]);
        }

        return redirect()->route('admin.banner-posts.index');
    }

    public function edit(BannerPost $bannerPost)
    {
        abort_if(Gate::denies('banner_post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title_kr', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bannerPost->load('post');

        return view('admin.bannerPosts.edit', compact('bannerPost', 'posts'));
    }

    public function update(UpdateBannerPostRequest $request, BannerPost $bannerPost)
    {
        $bannerPost->update($request->all());

        if ($request->input('main_image', false)) {
            if (! $bannerPost->main_image || $request->input('main_image') !== $bannerPost->main_image->file_name) {
                if ($bannerPost->main_image) {
                    $bannerPost->main_image->delete();
                }
                $bannerPost->addMedia(storage_path('tmp/uploads/' . basename($request->input('main_image'))))->toMediaCollection('main_image');
            }
        } elseif ($bannerPost->main_image) {
            $bannerPost->main_image->delete();
        }

        return redirect()->route('admin.banner-posts.index');
    }

    public function show(BannerPost $bannerPost)
    {
        abort_if(Gate::denies('banner_post_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bannerPost->load('post');

        return view('admin.bannerPosts.show', compact('bannerPost'));
    }

    public function destroy(BannerPost $bannerPost)
    {
        abort_if(Gate::denies('banner_post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bannerPost->delete();

        return back();
    }

    public function massDestroy(MassDestroyBannerPostRequest $request)
    {
        $bannerPosts = BannerPost::find(request('ids'));

        foreach ($bannerPosts as $bannerPost) {
            $bannerPost->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('banner_post_create') && Gate::denies('banner_post_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BannerPost();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
