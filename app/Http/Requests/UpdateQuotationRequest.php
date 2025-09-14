<?php

namespace App\Http\Requests;

use App\Models\BannerPost;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQuotationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('banner_post_edit');
    }

    public function rules()
    {
        return [
            'status' => [
                'required',
            ],
        ];
    }
}
