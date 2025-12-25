<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class ConversationState extends Model
{
    protected $table = 'conversation_states';

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get or create conversation state for a telegram user
     */
    public static function getOrCreate(int $telegramId): self
    {
        return self::firstOrCreate(
            ['telegram_id' => $telegramId],
            ['state' => null, 'mode' => null, 'data' => []]
        );
    }

    /**
     * Update state
     */
    public function updateState(string $state, ?string $mode = null, array $data = []): void
    {
        $this->update([
            'state' => $state,
            'mode' => $mode ?? $this->mode,
            'data' => array_merge($this->data ?? [], $data),
        ]);
    }

    /**
     * Clear state
     */
    public function clearState(): void
    {
        $this->update([
            'state' => null,
            'mode' => null,
            'data' => [],
            'message_id' => null,
        ]);
    }

    /**
     * Get data value
     */
    public function getData(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Set data value
     */
    public function setData(string $key, $value): void
    {
        $data = $this->data ?? [];
        $data[$key] = $value;
        $this->update(['data' => $data]);
    }

    /**
     * Check if in specific state
     */
    public function isInState(string $state): bool
    {
        return $this->state === $state;
    }

    /**
     * Check if in manual mode
     */
    public function isManualMode(): bool
    {
        return $this->mode === 'manual';
    }

    /**
     * Check if in auto mode
     */
    public function isAutoMode(): bool
    {
        return $this->mode === 'auto';
    }
}
