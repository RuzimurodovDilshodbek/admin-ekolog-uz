<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;
    public $table = 'video_categories';

    protected $guarded = ['id'];

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'category_id','id');
    }
}
