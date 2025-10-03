<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tag extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'tags';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $guarded = ['id'];

    public function setTitleUzAttribute($value)
    {
        $this->attributes['title_uz'] = $value;
        $this->attributes['slug_uz'] = Str::slug($value); // Generate slug from title
    }


    public function setTitleKrAttribute($value)
    {
        $this->attributes['title_kr'] = $value;
        $this->attributes['slug_kr'] = Str::slug($value); // Generate slug from title
    }

    public function setTitleRuAttribute($value)
    {
        $this->attributes['title_ru'] = $value;
        $this->attributes['slug_ru'] = Str::slug($value); // Generate slug from title
    }

    public function setTitleEnAttribute($value)
    {
        $this->attributes['title_en'] = $value;
        $this->attributes['slug_en'] = Str::slug($value); // Generate slug from title
    }

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }

    public function getSlugAttribute()
    {
        return $this->attributes['slug_' . app()->getLocale()];
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute()
    {
        return localized_url("/tags/$this->slug");
    }
}
