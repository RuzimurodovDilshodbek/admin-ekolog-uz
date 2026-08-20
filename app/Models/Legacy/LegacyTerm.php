<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

/**
 * Eski saytdagi rukn (category) yoki teg (post_tag).
 */
class LegacyTerm extends Model
{
    protected $connection = 'legacy';

    protected $table = 'legacy_terms';

    protected $guarded = [];

    public $timestamps = false;

    public function scopeCategories($query)
    {
        return $query->where('taxonomy', 'category');
    }

    public function scopeTags($query)
    {
        return $query->where('taxonomy', 'post_tag');
    }
}
