<?php

namespace App\Http\Requests;

use App\Models\AdView;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdViewRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ad_view_edit');
    }

    public function rules()
    {
        return [
            'client_ip' => [
                'string',
                'required',
            ],
            'ad_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
