<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPollVoteRequest;
use App\Http\Requests\StorePollVoteRequest;
use App\Http\Requests\UpdatePollVoteRequest;
use App\Models\Poll;
use App\Models\PollVariant;
use App\Models\PollVote;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PollVotesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('poll_vote_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollVotes = PollVote::with(['poll', 'poll_variant', 'user'])->get();

        return view('admin.pollVotes.index', compact('pollVotes'));
    }

    public function create()
    {
        abort_if(Gate::denies('poll_vote_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $polls = Poll::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $poll_variants = PollVariant::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.pollVotes.create', compact('poll_variants', 'polls', 'users'));
    }

    public function store(StorePollVoteRequest $request)
    {
        $pollVote = PollVote::create($request->all());

        return redirect()->route('admin.poll-votes.index');
    }

    public function edit(PollVote $pollVote)
    {
        abort_if(Gate::denies('poll_vote_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $polls = Poll::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $poll_variants = PollVariant::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $pollVote->load('poll', 'poll_variant', 'user');

        return view('admin.pollVotes.edit', compact('pollVote', 'poll_variants', 'polls', 'users'));
    }

    public function update(UpdatePollVoteRequest $request, PollVote $pollVote)
    {
        $pollVote->update($request->all());

        return redirect()->route('admin.poll-votes.index');
    }

    public function show(PollVote $pollVote)
    {
        abort_if(Gate::denies('poll_vote_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollVote->load('poll', 'poll_variant', 'user');

        return view('admin.pollVotes.show', compact('pollVote'));
    }

    public function destroy(PollVote $pollVote)
    {
        abort_if(Gate::denies('poll_vote_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pollVote->delete();

        return back();
    }

    public function massDestroy(MassDestroyPollVoteRequest $request)
    {
        $pollVotes = PollVote::find(request('ids'));

        foreach ($pollVotes as $pollVote) {
            $pollVote->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
