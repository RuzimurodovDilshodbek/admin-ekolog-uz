<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // GET /api/v1/posts
    public function index(Request $request)
    {
        $query = Post::query();
        // agar section_id yuborilsa filterlash
        if ($request->has('section_id')) {
//            dd($request->all());
            $query->whereJsonContains('section_ids', (int) $request->section_id);
        }

        $posts = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }
}
