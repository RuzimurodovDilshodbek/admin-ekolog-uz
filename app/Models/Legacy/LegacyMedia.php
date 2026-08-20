<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

/**
 * Eski saytdagi media fayl (rasm/video) haqidagi ma'lumot.
 * Faylning o'zi public/{legacy.media_dir}/{source}/{file_path} da turadi.
 */
class LegacyMedia extends Model
{
    protected $connection = 'legacy';

    protected $table = 'legacy_media';

    protected $guarded = [];

    protected $casts = [
        'file_exists'  => 'boolean',
        'published_at' => 'datetime',
    ];

    /** Brauzer uchun URL (fayl mavjud bo'lmasa ham manzil qaytariladi) */
    public function getUrlAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        return asset(config('legacy.media_dir') . '/' . $this->source . '/' . ltrim($this->file_path, '/'));
    }

    /** Diskdagi to'liq yo'l */
    public function getAbsolutePathAttribute(): ?string
    {
        if (! $this->file_path) {
            return null;
        }

        return public_path(config('legacy.media_dir') . '/' . $this->source . '/' . ltrim($this->file_path, '/'));
    }

    public function getIsImageAttribute(): bool
    {
        return str_starts_with((string) $this->mime, 'image/');
    }

    public function getIsVideoAttribute(): bool
    {
        return str_starts_with((string) $this->mime, 'video/');
    }
}
