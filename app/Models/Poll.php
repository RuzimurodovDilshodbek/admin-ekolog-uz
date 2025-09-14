<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poll extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'polls';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'checkbox' => 'Ko\'p belgilanadigan',
        'radio' => 'Faqat bitta tanlanadigan',
    ];

    protected $fillable = [
        'title',
        'type',
        'status',
        'sort',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function variants()
    {
        return $this->hasMany(PollVariant::class, "poll_id");
    }

    public function isVoted()
    {

        $ip = request()->ip();
        return PollVote::query()
            ->where("poll_id", $this->id)
            ->where("client_ip", $ip)
            ->first();

    }

    public function saveAnswer($params)
    {
        if ($this->type == "checkbox") {


            foreach ($params['selectedVariant'] as $vote) {
                PollVote::create([
                    'poll_id' => $this->id,
                    'poll_variant_id' => $vote,
                    'client_ip' => request()->ip()
                ]);
            }

        } else {
            PollVote::create([
                'poll_id' => $this->id,
                'poll_variant_id' => $params['selectedVariant'],
                'client_ip' => request()->ip()
            ]);
        }
    }
}
