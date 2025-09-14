<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTutorOpinionRequest;
use App\Http\Requests\StoreTutorOpinionRequest;
use App\Http\Requests\UpdateTutorOpinionRequest;
use App\Models\Post;
use App\Models\TutorOpinion;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TutorOpinionController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('tutor_opinion_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $tutorOpinions = TutorOpinion::with(['post', 'media'])->get();

        return view('admin.tutorOpinions.index', compact('tutorOpinions'));
    }

    public function create()
    {
        abort_if(Gate::denies('tutor_opinion_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title_uz', 'id')->prepend(trans('global.pleaseSelect'), '');

        $catTab = 0;
        $locales = config('app.locales');

        return view('admin.tutorOpinions.create', compact('posts','catTab','locales'));
    }

    public function store(StoreTutorOpinionRequest $request)
    {
//        dd('kelli');

        $tutorOpinion = TutorOpinion::create($request->all());

        if ($request->image_base64) {
            [$imageName, $imageName2] = $this->storeBase64($request->image_base64);
        }

        if ($imageName) {
            $tutorOpinion->addMedia(storage_path('tmp/uploads/' . $imageName))->toMediaCollection('image');
        }

//        if ($request->input('image', false)) {
//            $tutorOpinion->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
//        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $tutorOpinion->id]);
        }

        return redirect()->route('admin.tutor-opinions.index');
    }

    public function edit(TutorOpinion $tutorOpinion)
    {
        abort_if(Gate::denies('tutor_opinion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title_uz', 'id')->prepend(trans('global.pleaseSelect'), '');

        $catTab = 0;
        $locales = config('app.locales');

        $tutorOpinion->load('post');

        return view('admin.tutorOpinions.edit', compact('posts','locales', 'catTab', 'tutorOpinion'));
    }

    public function update(UpdateTutorOpinionRequest $request, TutorOpinion $tutorOpinion)
    {
        $tutorOpinion->update($request->all());

        if ($request->input('image', false)) {
            if (! $tutorOpinion->image || $request->input('image') !== $tutorOpinion->image->file_name) {
                if ($tutorOpinion->image) {
                    $tutorOpinion->image->delete();
                }
                $tutorOpinion->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($tutorOpinion->image) {
            $tutorOpinion->image->delete();
        }

        return redirect()->route('admin.tutor-opinions.index');
    }

    public function show(TutorOpinion $tutorOpinion)
    {
        abort_if(Gate::denies('tutor_opinion_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tutorOpinion->load('post');

        return view('admin.tutorOpinions.show', compact('tutorOpinion'));
    }

    public function destroy(TutorOpinion $tutorOpinion)
    {
        abort_if(Gate::denies('tutor_opinion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tutorOpinion->delete();

        return back();
    }

    public function massDestroy(MassDestroyTutorOpinionRequest $request)
    {
        $tutorOpinions = TutorOpinion::find(request('ids'));

        foreach ($tutorOpinions as $tutorOpinion) {
            $tutorOpinion->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('tutor_opinion_create') && Gate::denies('tutor_opinion_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new TutorOpinion();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
    private function storeBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';
        $imageName2= time().'2.png';
        $path =  storage_path('tmp/uploads/' . $imageName);
        $path2 =  storage_path('tmp/uploads/' . $imageName2);
        file_put_contents($path, $imageBase64);
        file_put_contents($path2, $imageBase64);

        return [$imageName, $imageName2];
    }
}
