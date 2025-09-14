<?php

namespace App\Http\Requests;

use App\Models\Favourite;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFavouriteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('favourite_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'post_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
