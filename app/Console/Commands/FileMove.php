<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use MediaUploader;

class FileMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:move';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (Post::all() as $post) {
            if (file_exists(storage_path('app/items/' . $post->id . '/' . $post->file_photo))){
                $post->addMedia(storage_path('app/items/' . $post->id . '/' . $post->file_photo))->toMediaCollection('detail_image');
                echo $post->id.' succest '. PHP_EOL;
            } else {
                echo $post->id.' reject '. PHP_EOL;
            }
        }

    }
}
