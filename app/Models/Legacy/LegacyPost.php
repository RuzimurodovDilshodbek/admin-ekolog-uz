<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

/**
 * Eski ekolog.uz saytining arxiv posti. Alohida "legacy" bazasida turadi,
 * asosiy sayt jadvallariga aloqasi yo'q. Faqat o'qish uchun.
 */
class LegacyPost extends Model
{
    protected $connection = 'legacy';

    protected $table = 'legacy_posts';

    protected $guarded = [];

    protected $casts = [
        'translations'    => 'array',
        'is_spam'         => 'boolean',
        'was_sanitized'   => 'boolean',
        'published_at'    => 'datetime',
        'modified_at'     => 'datetime',
    ];

    /** Postga biriktirilgan media fayllar (manba bo'yicha ham filtrlanadi) */
    public function attachments()
    {
        return LegacyMedia::query()
            ->where('source', $this->source)
            ->where('parent_wp_id', $this->wp_id)
            ->orderBy('published_at')
            ->get();
    }

    public function thumbnail(): ?LegacyMedia
    {
        if (! $this->thumbnail_wp_id) {
            return null;
        }

        return LegacyMedia::query()
            ->where('source', $this->source)
            ->where('wp_id', $this->thumbnail_wp_id)
            ->first();
    }

    public function terms()
    {
        return LegacyTerm::query()
            ->where('legacy_terms.source', $this->source)
            ->join('legacy_post_term as pt', function ($join) {
                $join->on('pt.wp_term_id', '=', 'legacy_terms.wp_term_id')
                    ->on('pt.source', '=', 'legacy_terms.source');
            })
            ->where('pt.wp_post_id', $this->wp_id)
            ->select('legacy_terms.*')
            ->get();
    }

    public function sourceLabel(): string
    {
        return config("legacy.sources.{$this->source}.label", $this->source);
    }
}
