<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Video extends Model  implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    public $table = 'videos';

    protected $guarded = ['id'];


    public function saveYouTubeThumbnail()
    {
        $videoId = getYouTubeVideoId($this->youtube_link);

        if ($videoId) {
            // Extract video ID from YouTube URL
            // Fetch the thumbnail image URL
            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg";

            // Download and store the image using Spatie Media Library
            $media = Http::get($thumbnailUrl);

//            dd($media->body());
            $this->addMediaFromString($media->body())
                ->usingFileName('youtube_thumbnail.jpg')
                ->usingName('youtube_thumbnail')
                ->toMediaCollection('thumbnails');

            // Return a response or redirect as needed
            return "Thumbnail saved as thumbnail.jpg in the media collection";
        }
        return false;
    }
    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }
    public function getYoutubeThumbAttribute()
    {
        return getYouTubeVideoThumb($this->youtube_link);
    }
    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'category_id');
    }
}
