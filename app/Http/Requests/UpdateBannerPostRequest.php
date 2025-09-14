<?php

namespace App\Http\Requests;

use App\Models\BannerPost;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBannerPostRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('banner_post_edit');
    }

    public function rules()
    {
        return [
            'post_id' => [
                'required',
                'integer',
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
