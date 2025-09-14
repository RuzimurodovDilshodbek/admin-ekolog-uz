<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTutorRequest;
use App\Http\Requests\StoreTutorRequest;
use App\Http\Requests\UpdateTutorRequest;
use App\Models\Tutor;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TutorController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('tutor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tutors = Tutor::with(['media'])->get();

        return view('admin.tutors.index', compact('tutors'));
    }

    public function create()
    {
        abort_if(Gate::denies('tutor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catTab = 0;

        $locales = config('app.locales');

        return view('admin.tutors.create', compact('catTab','locales'));
    }

    public function store(StoreTutorRequest $request)
    {
        $tutor = Tutor::create($request->all());

        if ($request->image_base64) {
            [$imageName, $imageName2] = $this->storeBase64($request->image_base64);
        }

        if ($imageName) {
            $tutor->addMedia(storage_path('tmp/uploads/' . $imageName))->toMediaCollection('photo');
        }

//        if ($request->input('photo', false)) {
//            $tutor->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
//        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $tutor->id]);
        }

        return redirect()->route('admin.tutors.index');
    }

    public function edit(Tutor $tutor)
    {
        abort_if(Gate::denies('tutor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tutors.edit', compact('tutor'));
    }

    public function update(UpdateTutorRequest $request, Tutor $tutor)
    {
        $tutor->update($request->all());

        if ($request->input('photo', false)) {
            if (! $tutor->photo || $request->input('photo') !== $tutor->photo->file_name) {
                if ($tutor->photo) {
                    $tutor->photo->delete();
                }
                $tutor->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($tutor->photo) {
            $tutor->photo->delete();
        }

        return redirect()->route('admin.tutors.index');
    }

    public function show(Tutor $tutor)
    {
        abort_if(Gate::denies('tutor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tutors.show', compact('tutor'));
    }

    public function destroy(Tutor $tutor)
    {
        abort_if(Gate::denies('tutor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tutor->delete();

        return back();
    }

    public function massDestroy(MassDestroyTutorRequest $request)
    {
        $tutors = Tutor::find(request('ids'));

        foreach ($tutors as $tutor) {
            $tutor->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('tutor_create') && Gate::denies('tutor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Tutor();
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
