<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPollRequest;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Models\Poll;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PollController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('poll_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $polls = Poll::all();

        return view('admin.polls.index', compact('polls'));
    }

    public function create()
    {
        abort_if(Gate::denies('poll_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.polls.create');
    }

    public function store(StorePollRequest $request)
    {
        $poll = Poll::create($request->all());

        return redirect()->route('admin.polls.index');
    }

    public function edit(Poll $poll)
    {
        abort_if(Gate::denies('poll_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.polls.edit', compact('poll'));
    }

    public function update(UpdatePollRequest $request, Poll $poll)
    {
        $poll->update($request->all());

        return redirect()->route('admin.polls.index');
    }

    public function show(Poll $poll)
    {
        abort_if(Gate::denies('poll_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.polls.show', compact('poll'));
    }

    public function destroy(Poll $poll)
    {
        abort_if(Gate::denies('poll_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $poll->delete();

        return back();
    }

    public function massDestroy(MassDestroyPollRequest $request)
    {
        $polls = Poll::find(request('ids'));

        foreach ($polls as $poll) {
            $poll->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
