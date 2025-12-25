<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Quotation extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = 'quotations';

    protected $appends = [
        'detail_image'
    ];
    protected $fillable = [
        'status',
        'title_uz',
        'title_kr',
        'title_ru',
        'title_en',
        'author_name_uz',
        'author_name_kr',
        'author_name_ru',
        'author_name_en',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('main_image')->fit('crop', 320, 261);
        $this->addMediaConversion('thumb')->fit('crop', 64,53);

    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnails')
            ->useDisk('public') // Choose your disk (usually 'public')
            ->singleFile(); // Only allow one file in this collection
    }
    public function getDetailImageAttribute()
    {
        $file = $this->getMedia('main_image')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->main_image = $file->getUrl('main_image');
            $file->thumbnail = $file->getUrl('thumb');
        }

        return $file;
    }

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }
}
