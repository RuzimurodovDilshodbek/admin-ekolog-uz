<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFavouriteRequest;
use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Requests\UpdateFavouriteRequest;
use App\Models\Favourite;
use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FavouritesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('favourite_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $favourites = Favourite::with(['user', 'post'])->get();

        return view('admin.favourites.index', compact('favourites'));
    }

    public function create()
    {
        abort_if(Gate::denies('favourite_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.favourites.create', compact('posts', 'users'));
    }

    public function store(StoreFavouriteRequest $request)
    {
        $favourite = Favourite::create($request->all());

        return redirect()->route('admin.favourites.index');
    }

    public function edit(Favourite $favourite)
    {
        abort_if(Gate::denies('favourite_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $favourite->load('user', 'post');

        return view('admin.favourites.edit', compact('favourite', 'posts', 'users'));
    }

    public function update(UpdateFavouriteRequest $request, Favourite $favourite)
    {
        $favourite->update($request->all());

        return redirect()->route('admin.favourites.index');
    }

    public function show(Favourite $favourite)
    {
        abort_if(Gate::denies('favourite_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $favourite->load('user', 'post');

        return view('admin.favourites.show', compact('favourite'));
    }

    public function destroy(Favourite $favourite)
    {
        abort_if(Gate::denies('favourite_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $favourite->delete();

        return back();
    }

    public function massDestroy(MassDestroyFavouriteRequest $request)
    {
        $favourites = Favourite::find(request('ids'));

        foreach ($favourites as $favourite) {
            $favourite->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
