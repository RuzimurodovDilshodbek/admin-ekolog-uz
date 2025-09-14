<?php

namespace App\Http\Requests;

use App\Models\BannerPost;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBannerPostRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('banner_post_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:banner_posts,id',
        ];
    }
}
