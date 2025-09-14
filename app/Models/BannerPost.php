<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BannerPost extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'banner_posts';

    protected $appends = [
        'main_image'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'main' => 'Asosiy banner',
        'small' => '2 ta kichik banner',
        'video' => 'Videolar',
    ];

    protected $fillable = [
        'type',
        'post_id',
        'sort',
        'status',
        'header_type',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('main')->fit('crop', 1440, 570);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getMainImageAttribute()
    {
        $file = $this->getMedia('main_image')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->main = $file->getUrl('main');
            $file->preview = $file->getUrl('preview');

        }

        return $file;
    }

    public function getMainBannerImageAttribute()
    {
        $file = $this->getMedia('main_image')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->main = $file->getUrl('main');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
