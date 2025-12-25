<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'posts';

    protected $appends = [
        'detail_image',
        'section'
    ];

    public const TYPE_SELECT = [
        'hot' => 'Hot',
        'trend' => 'Trend',
        'recommended' => 'Tavsiya qilingan',
    ];

    protected $dates = [
        'publish_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $guarded = ['id'];

//    public function getViewsCountAttribute()
//    {
//        return $this->attributes['views_count'] + PostView::query()->where('post_id',$this->id)->count();
//    }
    public function getTitleAttribute()
    {
        return $this->attributes['title_' . app()->getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . app()->getLocale()];
    }
    public function getContentAttribute()
    {
        return $this->attributes['content_' . app()->getLocale()];
    }
    public function getSlugAttribute()
    {
        return $this->attributes['slug_' . app()->getLocale()];
    }

    public function setTitleUzAttribute($value)
    {
        $this->attributes['title_uz'] = $value;
        $this->attributes['slug_uz'] = Str::slug($value.'-'.$this->id); // Generate slug from title
    }


    public function setTitleKrAttribute($value)
    {
        $this->attributes['title_kr'] = $value;
        $this->attributes['slug_kr'] = Str::slug($value.'-'.$this->id); // Generate slug from title
    }


    public function setTitleRuAttribute($value)
    {
        $this->attributes['title_ru'] = $value;
        $this->attributes['slug_ru'] = Str::slug($value.'-'.$this->id); // Generate slug from title
    }


    public function setTitleEnAttribute($value)
    {
        $this->attributes['title_en'] = $value;
        $this->attributes['slug_en'] = Str::slug($value.'-'.$this->id); // Generate slug from title
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 60, 36);
        $this->addMediaConversion('preview')->fit('crop', 343, 197);
        $this->addMediaConversion('card')->fit('crop', 348, 202);
        $this->addMediaConversion('show_card')->fit('crop', 866, 505);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnails')
            ->useDisk('public') // Choose your disk (usually 'public')
            ->singleFile(); // Only allow one file in this collection
    }


//    public function saveYouTubeThumbnail(): string
//    {
//        $videoId = getYouTubeVideoId($this->youtube_link);
//
//        if ($videoId) {
//            // Extract video ID from YouTube URL
//            // Fetch the thumbnail image URL
//            $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/mqdefault.jpg";
//
//            // Download and store the image using Spatie Media Library
//            $media = Http::get($thumbnailUrl);
//
////            dd($media->body());
//            $this->addMediaFromString($media->body())
//                ->usingFileName('youtube_thumbnail.jpg')
//                ->usingName('youtube_thumbnail')
//                ->toMediaCollection('thumbnails');
//
//            // Return a response or redirect as needed
//            return "Thumbnail saved as thumbnail.jpg in the media collection";
//        }
//        return false;
//    }

    public function setSectionIdsAttribute($value)
    {
        $this->attributes['section_ids'] = $value ? implode(',', $value) : '';
    }

    public function setLangsAttribute($value)
    {
        $this->attributes['langs'] = $value ? implode(',', $value) : '';
    }
    public function getLangsAttribute($value)
    {
        return explode(',', $value);
    }

    public function getSectionIdsAttribute($value)
    {
        return explode(',', $value);
    }

    public function getSectionsAttribute()
    {
        return Section::query()->whereIn('id', ($this->section_ids ?? -1))->get();
    }
    public function getSectionAttribute()
    {
        return Section::query()->whereIn('id', ($this->section_ids ?? -1))->select('id','slug_uz','title_uz','title_kr','title_ru','title_en','slug_kr','slug_ru','slug_en')->first();
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }

    public function getDetailImageAttribute()
    {
        $file = $this->getMedia('detail_image')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
            $file->card = $file->getUrl('card');
            $file->show_card = $file->getUrl('show_card');
        }

        return $file;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getPublishDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPublishDateAttribute($value)
    {
        $this->attributes['publish_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getDetailUrlAttribute()
    {
        $sectionSlug = $this->sections->first()?->slug;
        return localized_url("posts/{$sectionSlug}/{$this->slug}");
    }

    public function getAdAttribute()
    {
        return Ad::query()
            ->where("position", "in_post_detail")
            ->where("status", 1)
            ->orderBy("sort")
            ->first();
    }

    public function getDateAttribute()
    {
        return $this->publish_date ? date("d.m.Y", strtotime($this->publish_date)) : date("d.m.Y", strtotime($this->created_at));
    }

    public function getFullDateTimeAttribute()
    {
        return $this->publish_date ? date("d.m.Y H:i:s", strtotime($this->publish_date)) : date("d.m.Y H:i:s", strtotime($this->created_at));
    }

    public function incrementViews()
    {

        DB::beginTransaction();

        try {
            // Your database operations here
            PostView::create([
                "ip" => request()->ip(),
                "post_id" => $this->id
            ]);
            DB::commit(); // If all queries are successful, commit the transaction
        } catch (\Exception $e) {
            DB::rollback(); // If there's an error, rollback the transaction
        }
    }


    public static function getMostViewedPosts($limit = 5)
    {
        return self::join('post_views', 'posts.id', '=', 'post_views.post_id')
            ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
            ->groupBy('posts.id')
            ->where('posts.publish_date', '<=',Carbon::parse()->format('Y-m-d H:i:s'))
            ->orderByDesc('view_count')
            ->take($limit)
            ->inRandomOrder()
            ->get();
    }


    public static function getRecommendedPosts($limit = 5)
    {
        return self::query()
            ->where("recommended", "1")
            ->where("status", 1)
            ->where('posts.publish_date', '<=',Carbon::parse()->format('Y-m-d H:i:s'))
            ->orderBy("created_at", "DESC")
            ->limit($limit)
            ->inRandomOrder()
            ->get();
    }

    public static function archives()
    {
        $currentYear = date("Y");
        $currentMonth = date("n");
        $archives = [];

        for ($i = $currentMonth; $i >= 1; $i--) {

            $date = Carbon::createFromDate($currentYear, $i, 1);
            $date->setLocale(getLocaleForMonth());
            $monthName = $date->monthName;

            $archives[] = [
                "title" => "$monthName $currentYear",
                "post_count" => rand(1, 60),
                "url" => localized_url("archive/$currentYear/$i")
            ];
        }

        return $archives;

    }

    public function getRelatedPosts()
    {
        $tagIds = self::query()->where('id',$this->id)->with('tags')->first()->tags->pluck('id');
        $posts = self::query()
            ->leftJoin('post_tag', function ($join) use ($tagIds) {
                $join->on('posts.id', '=', 'post_tag.post_id');
            })
            ->whereIn('post_tag.tag_id', $tagIds)
            ->where('posts.id', '!=', $this->id)
            ->limit(2)->get();
         if (count($posts) > 0) {
            return $posts;
         } else {
             $section_id = $this->section_ids[0];
             return self::join('post_views', 'posts.id', '=', 'post_views.post_id')
                 ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
                 ->whereRaw("FIND_IN_SET('$section_id', posts.section_ids)")
                 ->where('posts.id', '!=', $this->id)
                 ->groupBy('posts.id')
                 ->orderByDesc('view_count')
                 ->take(2)
                 ->inRandomOrder()
                 ->get();
         }
    }

}
