<?php

namespace App\Http\Requests;

use App\Models\PostView;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostViewRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_view_edit');
    }

    public function rules()
    {
        return [
            'ip' => [
                'string',
                'required',
            ],
            'post_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
