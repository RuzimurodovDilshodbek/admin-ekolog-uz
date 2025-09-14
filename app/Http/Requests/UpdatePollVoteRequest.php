<?php

namespace App\Http\Requests;

use App\Models\PollVote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePollVoteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('poll_vote_edit');
    }

    public function rules()
    {
        return [
            'client_ip' => [
                'string',
                'required',
            ],
        ];
    }
}
