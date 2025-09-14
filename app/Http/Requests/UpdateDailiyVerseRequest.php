<?php

namespace App\Http\Requests;

use App\Models\DailiyVerse;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDailiyVerseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('dailiy_verse_edit');
    }

    public function rules()
    {
        return [
            'sort' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
