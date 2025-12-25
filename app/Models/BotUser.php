<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTimeInterface;

class BotUser extends Model
{
    use SoftDeletes;

    protected $table = 'bot_users';

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Check if user has access to the bot
     */
    public function hasAccess(): bool
    {
        return $this->is_active;
    }

    /**
     * Get or create bot user from Telegram data
     */
    public static function getOrCreateFromTelegram(array $telegramUser): self
    {
        return self::updateOrCreate(
            ['telegram_id' => $telegramUser['id']],
            [
                'username' => $telegramUser['username'] ?? null,
                'first_name' => $telegramUser['first_name'] ?? null,
                'last_name' => $telegramUser['last_name'] ?? null,
            ]
        );
    }

    /**
     * Get conversation state for this user
     */
    public function conversationState()
    {
        return $this->hasOne(ConversationState::class, 'telegram_id', 'telegram_id');
    }
}
