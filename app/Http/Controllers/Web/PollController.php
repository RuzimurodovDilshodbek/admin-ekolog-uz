<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function pollVoting(Request $request)
    {

        $poll = Poll::findOrFail($request->get("poll_id"));

//        if ($poll->isVoted()) {
//            abort(403, "You are already polled! Thanks!");
//        }

        $poll->saveAnswer($request->all());


        return view("web.pages.poll.answered", compact("poll"));
    }
}
