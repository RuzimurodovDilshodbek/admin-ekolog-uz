<?php

namespace App\Http\Requests;

use App\Models\TutorOpinion;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTutorOpinionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('tutor_opinion_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:tutor_opinions,id',
        ];
    }
}
