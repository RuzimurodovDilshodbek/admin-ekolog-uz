<?php

namespace App\Http\Requests;

use App\Models\PollVariant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePollVariantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('poll_variant_edit');
    }

    public function rules()
    {
        return [
            'poll_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'string',
                'nullable',
            ],
            'sort' => [
                'string',
                'nullable',
            ],
        ];
    }
}
