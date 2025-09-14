<?php

namespace App\Http\Requests;

use App\Models\PollVariant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPollVariantRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('poll_variant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:poll_variants,id',
        ];
    }
}
