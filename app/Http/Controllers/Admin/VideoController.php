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

class VideoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $videos = Video::all();

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        abort_if(Gate::denies('tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $videoCategory = VideoCategory::all();
        $catTab = 0;
        $locales = config('app.locales');
        return view('admin.videos.create', compact('catTab','locales','videoCategory'));
    }

    public function store(StoreTagRequest $request)
    {
        $video = Video::create($request->all());

        if ($video->youtube_link) {
            $video->saveYouTubeThumbnail();
        }

        return redirect()->route('admin.videos.index');
    }

    public function edit(Video $video)
    {
        abort_if(Gate::denies('tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $videoCategory = VideoCategory::all();

        $catTab = 0;
        $locales = config('app.locales');

        return view('admin.videos.edit', compact('video','catTab','locales','videoCategory'));
    }

    public function update(UpdateTagRequest $request, Video $video)
    {
        $video->update($request->all());

        return redirect()->route('admin.videos.index');
    }

    public function show(Video $video)
    {
        abort_if(Gate::denies('tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.videos.show', compact('video'));
    }

    public function destroy(Video $video)
    {
        abort_if(Gate::denies('video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $video->delete();

        return back();
    }

    public function editSort()
    {
        abort_if(Gate::denies('tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $videos = Video::all();

        return view('admin.videos.editSort', compact('videos'));
    }

    public function updateSort(Request $request){
        if(isset($request->sort_1)){
            Video::query()->where('id',$request->sort_1)->update([
                'sort' => 1
            ]);
        }
        if(isset($request->sort_2)){
            Video::query()->where('id',$request->sort_2)->update([
                'sort' => 2
            ]);
        }
        if(isset($request->sort_3)){
            Video::query()->where('id',$request->sort_3)->update([
                'sort' => 3
            ]);
        }
        if(isset($request->sort_4)){
            Video::query()->where('id',$request->sort_4)->update([
                'sort' => 4
            ]);
        }
        if(isset($request->sort_5)){
            Video::query()->where('id',$request->sort_5)->update([
                'sort' => 5
            ]);
        }
        if(isset($request->sort_6)){
            Video::query()->where('id',$request->sort_6)->update([
                'sort' => 6
            ]);
        }
        if(isset($request->sort_7)){
            Video::query()->where('id',$request->sort_7)->update([
                'sort' => 7
            ]);
        }
        return redirect()->route('admin.videos.index');
    }
}
