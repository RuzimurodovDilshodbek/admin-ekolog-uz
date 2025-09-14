<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('post_edit');
    }

    public function rules()
    {
        return [
            'slug' => [
                'string',
                'nullable',
            ],
            'title' => [
                'string',
                'nullable',
            ],
            'tags' => [
                'array',
            ],
            'publish_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'youtube_link' => [
                'string',
                'nullable',
            ],
            'section_ids' => [
                'array',
                'required',
            ],
            'meta_keywords' => [
                'string',
                'nullable',
            ],
        ];
    }
}
