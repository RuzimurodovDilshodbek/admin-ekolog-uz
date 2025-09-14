<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDailiyVerseRequest;
use App\Http\Requests\StoreDailiyVerseRequest;
use App\Http\Requests\UpdateDailiyVerseRequest;
use App\Models\DailiyVerse;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DailiyVerseController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('dailiy_verse_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dailiyVerses = DailiyVerse::all();

        return view('admin.dailiyVerses.index', compact('dailiyVerses'));
    }

    public function create()
    {
        abort_if(Gate::denies('dailiy_verse_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dailiyVerses.create');
    }

    public function store(StoreDailiyVerseRequest $request)
    {
        $dailiyVerse = DailiyVerse::create($request->all());

        return redirect()->route('admin.dailiy-verses.index');
    }

    public function edit(DailiyVerse $dailiyVerse)
    {
        abort_if(Gate::denies('dailiy_verse_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dailiyVerses.edit', compact('dailiyVerse'));
    }

    public function update(UpdateDailiyVerseRequest $request, DailiyVerse $dailiyVerse)
    {
        $dailiyVerse->update($request->all());

        return redirect()->route('admin.dailiy-verses.index');
    }

    public function show(DailiyVerse $dailiyVerse)
    {
        abort_if(Gate::denies('dailiy_verse_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dailiyVerses.show', compact('dailiyVerse'));
    }

    public function destroy(DailiyVerse $dailiyVerse)
    {
        abort_if(Gate::denies('dailiy_verse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dailiyVerse->delete();

        return back();
    }

    public function massDestroy(MassDestroyDailiyVerseRequest $request)
    {
        $dailiyVerses = DailiyVerse::find(request('ids'));

        foreach ($dailiyVerses as $dailiyVerse) {
            $dailiyVerse->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
