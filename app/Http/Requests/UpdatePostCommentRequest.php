<?php

namespace App\Http\Requests;

use App\Models\PostComment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostCommentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_comment_edit');
    }

    public function rules()
    {
        return [
            'comment' => [
                'required',
            ],
            'client_ip' => [
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
