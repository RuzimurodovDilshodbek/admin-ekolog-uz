<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PollVariant extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'poll_variants';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'poll_id',
        'title',
        'sort',
        'is_coccect',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }


    public function votedCount()
    {
        $totalVariantVotes = PollVote::query()
            ->where("poll_variant_id", $this->id)
            ->count();

        $totalVotedUsers = PollVote::query()
            ->where("poll_id", $this->poll->id)
            ->count();

        return ceil(($totalVariantVotes / $totalVotedUsers) * 100);

    }

    public function isChecked()
    {

        return (bool)PollVote::query()
            ->where('client_ip', request()->ip())
            ->where("poll_variant_id", $this->id)
            ->first();

    }

}
