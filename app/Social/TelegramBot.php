<?php

namespace App\Social;

use GuzzleHttp\Client;

class TelegramBot
{
    private $telegramApiUrl = 'https://api.telegram.org/';
    const BOT_TOKEN = '8271074734:AAEf5xeK4wK0BU-tXaxfAq595WEPTwqMlgo';
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->telegramApiUrl . 'bot' . self::BOT_TOKEN . '/',
        ]);
    }

    /**
     * Send a text message
     */
    public function sendMessage(int $chatId, string $text, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ], $options);

        // Encode reply_markup as JSON if present
        if (isset($params['reply_markup'])) {
            $params['reply_markup'] = json_encode($params['reply_markup']);
        }

        try {
            $response = $this->client->post('sendMessage', [
                'form_params' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram sendMessage error: ' . $e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Send a photo
     */
    public function sendPhoto(int $chatId, string $photo, string $caption = '', array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
            'parse_mode' => 'HTML',
        ], $options);

        // Encode reply_markup as JSON if present
        if (isset($params['reply_markup'])) {
            $params['reply_markup'] = json_encode($params['reply_markup']);
        }

        try {
            $response = $this->client->post('sendPhoto', [
                'form_params' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram sendPhoto error: ' . $e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Edit message text
     */
    public function editMessageText(int $chatId, int $messageId, string $text, array $options = []): array
    {
        $params = array_merge([
            'chat_id' => $chatId,
            'message_id' => $messageId,
            'text' => $text,
            'parse_mode' => 'HTML',
        ], $options);

        // Encode reply_markup as JSON if present
        if (isset($params['reply_markup'])) {
            $params['reply_markup'] = json_encode($params['reply_markup']);
        }

        try {
            $response = $this->client->post('editMessageText', [
                'form_params' => $params
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram editMessageText error: ' . $e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Answer callback query (for inline buttons)
     */
    public function answerCallbackQuery(string $callbackQueryId, string $text = '', bool $showAlert = false): array
    {
        try {
            $response = $this->client->post('answerCallbackQuery', [
                'query' => [
                    'callback_query_id' => $callbackQueryId,
                    'text' => $text,
                    'show_alert' => $showAlert,
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram answerCallbackQuery error: ' . $e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Get file info
     */
    public function getFile(string $fileId): array
    {
        try {
            $response = $this->client->post('getFile', [
                'query' => ['file_id' => $fileId]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            \Log::error('Telegram getFile error: ' . $e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Download file
     */
    public function downloadFile(string $filePath): ?string
    {
        try {
            $url = $this->telegramApiUrl . 'file/bot' . self::BOT_TOKEN . '/' . $filePath;
            $response = $this->client->get($url);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            \Log::error('Telegram downloadFile error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create inline keyboard markup
     */
    public static function inlineKeyboard(array $buttons): array
    {
        return [
            'inline_keyboard' => $buttons
        ];
    }

    /**
     * Create inline button
     */
    public static function inlineButton(string $text, string $callbackData): array
    {
        return [
            'text' => $text,
            'callback_data' => $callbackData
        ];
    }

    /**
     * Create reply keyboard markup
     */
    public static function replyKeyboard(array $buttons, bool $resize = true, bool $oneTime = false): array
    {
        return [
            'keyboard' => $buttons,
            'resize_keyboard' => $resize,
            'one_time_keyboard' => $oneTime,
        ];
    }

    /**
     * Remove keyboard
     */
    public static function removeKeyboard(): array
    {
        return ['remove_keyboard' => true];
    }
}
