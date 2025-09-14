<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTagRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Video;
use App\Models\VideoCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VideoCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = VideoCategory::all();

        return view('admin.video-category.index', compact('videos'));
    }

    public function create()
    {
        abort_if(Gate::denies('tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $catTab = 0;
        $locales = config('app.locales');
        return view('admin.video-category.create', compact('catTab','locales'));
    }

    public function store(StoreTagRequest $request)
    {
        VideoCategory::create($request->all());

        return redirect()->route('admin.video-category.index');
    }

    public function edit(VideoCategory $videoCategory)
    {
        abort_if(Gate::denies('tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catTab = 0;
        $locales = config('app.locales');

        return view('admin.video-category.edit', compact('videoCategory','catTab','locales'));
    }

    public function update(UpdateTagRequest $request, VideoCategory $videoCategory)
    {
        $videoCategory->update($request->all());

        return redirect()->route('admin.video-category.index');
    }

    public function show(VideoCategory $videoCategory)
    {
        abort_if(Gate::denies('tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.video-category.show', compact('videoCategory'));
    }

    public function destroy(VideoCategory $videoCategory)
    {
        abort_if(Gate::denies('video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videoCategory->delete();

        return back();
    }
}
