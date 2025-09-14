<?php

namespace App\Http\Requests;

use App\Models\Poll;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePollRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('poll_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'type' => [
                'required',
            ],
            'sort' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
