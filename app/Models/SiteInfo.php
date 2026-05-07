<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    use HasFactory;

    public $table = 'site_info';

    protected $guarded = ['id'];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
