<?php

namespace App\Http\Requests;

use App\Models\Post;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StorePostRequest extends FormRequest
{

    public function authorize()
    {
        return Gate::allows('post_create');
    }

    public function rules(Request $request)
    {
        return [
            'title_kr' => [
                'string',
                'required',
            ],
            'title_uz' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('uz', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.title_uz')]));
                    }
                },
            ],
            'title_ru' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('ru', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.title_ru')]));
                    }
                },
            ],
            'title_en' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('en', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.title_en')]));
                    }
                },
            ],
            'title_tr' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('tr', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.title_tr')]));
                    }
                },
            ],
            'status' => [
                'string',
                'required',
            ],
            'description_uz' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('uz', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.description_uz')]));
                    }
                },
            ],
            'description_kr' => [
                'string',
                'required',
            ],
            'description_ru' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('ru', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.description_en')]));
                    }
                },
            ],
            'description_en' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('en', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.description_en')]));
                    }
                },
            ],
            'description_tr' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('tr', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.description_tr')]));
                    }
                },
            ],
            'image_description_uz' => [
                'string',
                'nullable',
            ],
            'image_description_kr' => [
                'string',
                'nullable',
            ],
            'image_description_ru' => [
                'string',
                'nullable',
            ],
            'image_description_en' => [
                'string',
                'nullable',
            ],
            'image_description_tr' => [
                'string',
                'nullable',
            ],
            'image_base64' => [
                'string',
                'required',
            ],
            'audio_file' => [
                'nullable',
            ],
            'content_uz' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('uz', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.content_uz')]));
                    }
                },
            ],
            'content_kr' => [
                'nullable',
                'string',
                'required',
            ],
            'content_ru' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('ru', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.content_ru')]));
                    }
                },
            ],
            'content_en' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('en', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.content_en')]));
                    }
                },
            ],
            'content_tr' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if (in_array('tr', $request->langs) && empty($value)) {
                        $fail(trans('validation.required', ['attribute' => trans('validation.attributes.content_tr')]));
                    }
                },
            ],
            'section_ids' => [
                'array',
                'required',
            ],
            'tags' => [
                'array',
            ],
            'publish_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'langs' => [
                'array',
                'nullable',
            ],
        ];
    }
}
