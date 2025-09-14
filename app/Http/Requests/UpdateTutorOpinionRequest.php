<?php

namespace App\Http\Requests;

use App\Models\TutorOpinion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTutorOpinionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tutor_opinion_edit');
    }

    public function rules()
    {
        return [
            'post_id' => [
                'required',
                'integer',
            ],
            'image' => [
                'required',
            ],
            'short_title_kr' => [
                'string',
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
