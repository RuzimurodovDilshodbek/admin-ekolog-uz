<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsSendAutoSocialNetwork extends Model
{
    use HasFactory;

    public $table = 'posts_send_auto_social_networks';

    protected $guarded = ['id'];

    public function setPublishDateAttribute($value)
    {
        $this->attributes['publish_date'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    protected $dates = [
        'publish_date',
        'created_at',
        'updated_at'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
