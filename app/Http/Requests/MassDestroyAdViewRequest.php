<?php

namespace App\Http\Requests;

use App\Models\AdView;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAdViewRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ad_view_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:ad_views,id',
        ];
    }
}
