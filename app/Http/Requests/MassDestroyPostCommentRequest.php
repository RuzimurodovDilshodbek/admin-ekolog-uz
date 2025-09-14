<?php

namespace App\Http\Requests;

use App\Models\PostComment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPostCommentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('post_comment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:post_comments,id',
        ];
    }
}
