<?php

namespace App\Social;


use App\Models\Post;
use App\Models\PostsSendAutoSocialNetwork;
use Carbon\Carbon;
use GuzzleHttp\Client;

class Telegram
{
    private $telegramApiUrl = 'https://api.telegram.org/';
    const BOT_TOKEN = '8271074734:AAEf5xeK4wK0BU-tXaxfAq595WEPTwqMlgo';
    const TEST_CHAT_ID = -1003161074565;
    const BOLALAR_CHANNEL_CHAT_ID = -1003161074565;
    private $client;
    private $chat_id;

    public function __construct($chat = 'bolalarolamiuz')
    {
        $this->chat_id = $chat === 'test' ? self::TEST_CHAT_ID : self::BOLALAR_CHANNEL_CHAT_ID;
        $this->client = new Client([
            'base_uri' => $this->telegramApiUrl . 'bot' . self::BOT_TOKEN . '/',
        ]);
    }

    public function setWebhook() {
        $result = $this->client->post( __FUNCTION__, [
            'query' => [
                'url' => env('APP_URL') . self::BOT_TOKEN
            ]
        ]);
        echo $result->getBody() . PHP_EOL;
    }

    public function getUpdates() {
        $result = $this->client->post( __FUNCTION__);
        echo $result->getBody() . PHP_EOL;
    }

    public function sendMessage($message) {
        $this->client->post( __FUNCTION__, [
            'query' => [
                'chat_id' => $this->chat_id,
                'text' => $message,
                'parse_mode' => 'HTML'
            ]
        ]);
    }
    public function sendPost($post_id) {
        $post = Post::find($post_id);
        try {
            $this->client->post( 'sendPhoto', [
                'query' => [
                    'chat_id' => $this->chat_id,
                    'caption' => "<b>$post->title_uz</b> \n\n $post->description_uz \n\n<b>Batafsil o‘qing:👉</b>  https://ekolog.uz/$post->id \n\n<a href='https://ekolog.uz'>Veb-sayt</a> | <a href='https://t.me/ekologuz'>Telegram</a> | <a href='https://www.youtube.com/@ekologuz'>Youtube</a> | <a href='instagram.com/ekolog.uz'>Instagram</a> | <a href='https://www.facebook.com/ekologuz1'>Facebook</a> | <a href='https://t.me/eklguz_bot'>Aloqa</a> ",
                    'parse_mode' => 'HTML',
                    'photo' => $post->detail_image?->show_card
                ]
            ]);
            if ($auto_send_post = PostsSendAutoSocialNetwork::query()->where('post_id',$post->id)->first()){
                $auto_send_post->update([
                    'is_send_telegram' => 1,
                    'telegram_send' => 1
                ]);
            } else {
                PostsSendAutoSocialNetwork::create([
                    'post_id' => $post->id,
                    'publish_date' => $post->publish_date,
                    'is_send_telegram' => 1,
                    'telegram_send' => 1
                ]);
            }

        } catch (\Exception $e) {
            if ($auto_send_post = PostsSendAutoSocialNetwork::query()->where('post_id',$post->id)->first()){
                $auto_send_post->update([
                    'is_send_telegram' => 0,
                    'telegram_send' => 1
                ]);
            } else {
                PostsSendAutoSocialNetwork::create([
                    'post_id' => $post->id,
                    'publish_date' => $post->publish_date,
                    'is_send_telegram' => 0,
                    'telegram_send' => 1
                ]);
            }

            return 'false';
        }

    }

    public function scheduleSendPosts() {
        $auto_posts = PostsSendAutoSocialNetwork::query()->where('telegram_send',1)->where('is_send_telegram',0)->get();
        foreach ($auto_posts as $auto_post) {
            if (Carbon::parse($auto_post->publish_date)->format('Y-m-d H:i:s') < Carbon::parse()->format('Y-m-d H:i:s')) {
                $this->sendPost($auto_post->post_id);
            }
        }
    }

    public function sendDbBackup() {
        $this->client->post( 'sendDocument', [
            'multipart' => [
                [ 'name' => 'chat_id', 'contents' => self::DB_BACKUP_CHAT_ID],
                [
                    'name' => 'document',
                    'contents' => fopen(storage_path('backups/' .date('d-m-Y').'-alosmartdb4.sql'), 'r')
                ]
            ]
        ]);
    }
}
