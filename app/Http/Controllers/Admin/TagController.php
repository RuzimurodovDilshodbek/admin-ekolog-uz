<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTagRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = Tag::all();

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        abort_if(Gate::denies('tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catTab = 0;

        $locales = config('app.locales');

        return view('admin.tags.create', compact('catTab','locales'));
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->all());

        return redirect()->route('admin.tags.index');
    }

    public function edit(Tag $tag)
    {
        abort_if(Gate::denies('tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $catTab = 0;

        $locales = config('app.locales');

        return view('admin.tags.edit', compact('tag','catTab','locales'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->all());

        return redirect()->route('admin.tags.index');
    }

    public function show(Tag $tag)
    {
        abort_if(Gate::denies('tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.tags.show', compact('tag'));
    }

    public function destroy(Tag $tag)
    {
        abort_if(Gate::denies('tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tag->delete();

        return back();
    }

    public function massDestroy(MassDestroyTagRequest $request)
    {
        $tags = Tag::find(request('ids'));

        foreach ($tags as $tag) {
            $tag->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function trsTagCreate()
    {
        $data = request('data');
        $result = null;

        try {
            if($data) {
                foreach (config('app.locales') as $key_local => $value_local) {
                    if($value_local !== 'kr' && $value_local !== 'uz') {
                        $result['title_' . $value_local] = trsTitle($data, $value_local);
                    }
                    if($value_local == 'uz') {
                        $result['title_' . $value_local] = transliterate($data);
                    }
                };
            }
            if ($result['title_ru']) {
                $tag = Tag::create([
                    'title_uz' => $result['title_uz'],
                    'title_kr' => $data,
                    'title_ru' => $result['title_ru'],
                    'title_en' => $result['title_en'],
                    'title_tr' => $result['title_tr']
                ]);
                return response()->json(['data' => $tag]);
            }
            return response()->json(['data' => []]);
        } catch (Exception $e) {
            return response()->json(['data' => []]);
        }

    }
}
