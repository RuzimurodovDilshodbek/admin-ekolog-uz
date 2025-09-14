<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAdViewRequest;
use App\Http\Requests\StoreAdViewRequest;
use App\Http\Requests\UpdateAdViewRequest;
use App\Models\Ad;
use App\Models\AdView;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdViewsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ad_view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adViews = AdView::with(['ad', 'user'])->get();

        return view('admin.adViews.index', compact('adViews'));
    }

    public function create()
    {
        abort_if(Gate::denies('ad_view_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ads = Ad::pluck('url', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.adViews.create', compact('ads', 'users'));
    }

    public function store(StoreAdViewRequest $request)
    {
        $adView = AdView::create($request->all());

        return redirect()->route('admin.ad-views.index');
    }

    public function edit(AdView $adView)
    {
        abort_if(Gate::denies('ad_view_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ads = Ad::pluck('url', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $adView->load('ad', 'user');

        return view('admin.adViews.edit', compact('adView', 'ads', 'users'));
    }

    public function update(UpdateAdViewRequest $request, AdView $adView)
    {
        $adView->update($request->all());

        return redirect()->route('admin.ad-views.index');
    }

    public function show(AdView $adView)
    {
        abort_if(Gate::denies('ad_view_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adView->load('ad', 'user');

        return view('admin.adViews.show', compact('adView'));
    }

    public function destroy(AdView $adView)
    {
        abort_if(Gate::denies('ad_view_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $adView->delete();

        return back();
    }

    public function massDestroy(MassDestroyAdViewRequest $request)
    {
        $adViews = AdView::find(request('ids'));

        foreach ($adViews as $adView) {
            $adView->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
