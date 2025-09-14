<?php

namespace App\Http\Requests;

use App\Models\DailiyVerse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDailiyVerseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('dailiy_verse_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:dailiy_verses,id',
        ];
    }
}
