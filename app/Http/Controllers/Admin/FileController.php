<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Media;
use App\Models\Post;
use Illuminate\Http\Request;
use MediaUploader;

class FileController extends Controller
{
    public function store()
    {

        $post = Post::query()->where('id', 68)->first();

        $post->addMedia(storage_path('items/' . $post->cms_item_id . '/' . $post->file_photo))->toMediaCollection('detail_image');

        return 1;
    }

    private function storeBase64($imageBase64)
    {

        $imageBase64 = base64_decode($imageBase64);
        $imageName = time() . '.png';

        $path = storage_path('tmp/uploads/' . $imageName);
        file_put_contents($path, $imageBase64);

        return [$imageName];
    }

}
