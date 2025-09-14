<?php

namespace App\Http\Requests;

use App\Models\Tutor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTutorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tutor_edit');
    }

    public function rules()
    {
        return [
            'slug' => [
                'string',
                'required',
            ],
            'firstname' => [
                'string',
                'nullable',
            ],
            'lastname' => [
                'string',
                'nullable',
            ],
            'photo' => [
                'required',
            ],
            'facebook' => [
                'string',
                'nullable',
            ],
            'twitter' => [
                'string',
                'nullable',
            ],
            'gmail' => [
                'string',
                'nullable',
            ],
            'rss' => [
                'string',
                'nullable',
            ],
            'youtube' => [
                'string',
                'nullable',
            ],
            'linkedin' => [
                'string',
                'nullable',
            ],
            'telegram' => [
                'string',
                'nullable',
            ],
            'instagram' => [
                'string',
                'nullable',
            ],
            'sort' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ]
        ];
    }
}
