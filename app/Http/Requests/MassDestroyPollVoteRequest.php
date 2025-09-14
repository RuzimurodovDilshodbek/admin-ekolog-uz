<?php

namespace App\Http\Requests;

use App\Models\PollVote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPollVoteRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('poll_vote_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:poll_votes,id',
        ];
    }
}
