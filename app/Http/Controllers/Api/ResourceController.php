<?php

namespace App\Http\Controllers\Api;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    protected $response = [
        'success' => true,
        'result' => [],
        'error' => []
    ];

    public function getSections()
    {
        $sections = Section::query()->where("status", 1)->orderBy("sort")->get();

        if (empty($sections)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'msg' => 'sections not found'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'data' => $sections,
                'msg' => 'ok'
            ]);
        }
    }
}
