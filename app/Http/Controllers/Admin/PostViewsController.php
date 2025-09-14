<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPostViewRequest;
use App\Http\Requests\StorePostViewRequest;
use App\Http\Requests\UpdatePostViewRequest;
use App\Models\Post;
use App\Models\PostView;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostViewsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('post_view_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postViews = PostView::with(['post'])->get();

        return view('admin.postViews.index', compact('postViews'));
    }

    public function create()
    {
        abort_if(Gate::denies('post_view_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.postViews.create', compact('posts'));
    }

    public function store(StorePostViewRequest $request)
    {
        $postView = PostView::create($request->all());

        return redirect()->route('admin.post-views.index');
    }

    public function edit(PostView $postView)
    {
        abort_if(Gate::denies('post_view_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $posts = Post::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $postView->load('post');

        return view('admin.postViews.edit', compact('postView', 'posts'));
    }

    public function update(UpdatePostViewRequest $request, PostView $postView)
    {
        $postView->update($request->all());

        return redirect()->route('admin.post-views.index');
    }

    public function show(PostView $postView)
    {
        abort_if(Gate::denies('post_view_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postView->load('post');

        return view('admin.postViews.show', compact('postView'));
    }

    public function destroy(PostView $postView)
    {
        abort_if(Gate::denies('post_view_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $postView->delete();

        return back();
    }

    public function massDestroy(MassDestroyPostViewRequest $request)
    {
        $postViews = PostView::find(request('ids'));

        foreach ($postViews as $postView) {
            $postView->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
