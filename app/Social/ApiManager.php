<?php

namespace App\Social;


use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\Post;
use App\Models\PostsSendAutoSocialNetwork;
use App\Social\Facebook\Exceptions\FacebookSDKException;
use App\Social\Facebook\Facebook;
use App\Social\Codebird\Codebird;
use App\Social\Facebook\Exceptions\FacebookResponseException;
use Carbon\Carbon;

class ApiManager
{
    public $fb_conf;
    public $tw_conf;

    public function __construct()
    {

//        $this->fb_conf = array(
//            'PAGE_ID'      => '195296313672617', //https://www.facebook.com/pg/azonglobalrasmiy/about/?ref=page_internal azon global rasmiy
//            'API_ID'       => '1506563656790926', //https://developers.facebook.com/apps/1506563656790926/settings/  // azon global
//            'API_SECRET'   => 'cfba7b57c210fc4a4cee39e19492de8b', // azon global
//            'API_VER'      => 'v2.11',
//            'ACCESS_TOKEN' => 'EAAVaNiZBYM44BO4NHkrKQD4weSpR9YUO8jTJ5phO4x5x2p0lng6fykU0Ueshny4ZAuITIE6oitCu8Em486NndHE6bFN6j1Qu3Y68jpGpniXXa581I22rej2avG8OqL0pZAOvpcZAB52H0aUbLZB2ckWJ0QUeK0VJtJGxC1BcCcuI21LBsXzgoNy8x7iMtRGMZD'
//        );

//        $this->fb_conf = array(
//            'PAGE_ID'      => '237221946131177', //https://www.facebook.com/pg/bolakayplus/about/?ref=page_internal bu test kanal
//            'API_ID'       => '441297721553887', //https://developers.facebook.com/apps/995566687533409/settings/ test kanal
//            'API_SECRET'   => '59ad0f4b8c31e4e5fd420bb9798381aa',  // test kanal
//            'API_VER'      => 'v2.11',
//            'ACCESS_TOKEN' => 'EAAGRW6Hu898BO3WEyzCi5pjdC0OpetoeXoODUC6O3sm1oobtfDzjmMZA9OZA04dgLrrrMbWBP8UFIYsJqd3RwMwm7jy45vDBHmdRhoCnfm1JbsaZCeoOZBrLzpMaL6INF1deC76ZCfUuWorsUsZCZCmZBz3jC6sq2kRl2uHkvQjUX8H556367JgfKemKH6YNpJEZD',
//        );

//        $this->tw_conf = array(
//            'CONSUMER_KEY'       => '7zt6WMlbATDD9MwerwcKl5ufI', // https://apps.twitter.com/app/14233020/keys // test
//            'CONSUMER_SECRET'    => '0vvX3kB2OiLKD9Fb1oqnvQmNgDS1VXKfmV01b5unn8cMQxhQcg',
//            'ACCESS_TOKEN'  => '1747602128741535744-kfpI2rPtmRYiWpQclnA1cueVwnibWC',
//            'TOKEN_SECRET'  => 'N43lBxQ4g9TkrowKvpMV0q7eo7ITf0UWoWOpUtw7m5641',
//            'BEARER_TOKEN' => 'AAAAAAAAAAAAAAAAAAAAAMxWsAEAAAAAqZ4zea2D%2FlaKQNozOIyufFI%2F1Qc%3DIe5jdw2q0TQUKZ4FmyX3iL1BcGhV5xBr3JoLKFDzbJWKUK9pUv'
//        );
//        $this->tw_conf = array(
//            'CONSUMER_KEY'       => 'DQL5WbRwMCUvR0oVQAkfK1hIn', // https://apps.twitter.com/app/14233020/keys
//            'CONSUMER_SECRET'    => 'GRuVtAnK0xUDjuNkDwB0VBv10KYaxASiY26WOzYRcmRCVyleog',
//            'ACCESS_TOKEN'  => '1744707437980991488-WrbRuTxbrmKdZMeix4iiF9NbANtd3s',
//            'TOKEN_SECRET'  => 'eZkATOyAeTyPwJDhTQEIbPCV7hhFGmnK8cET7YiIdHIQG',
//            'BEARER_TOKEN' => 'AAAAAAAAAAAAAAAAAAAAAFdjsAEAAAAAeQezaQtYoFaMUGMQ7h%2BvtYZk3cI%3D6V7sJa1EGb3fbj4QESMAUvkJCZsktjf0jtlS1lcIPlpnWvnkOo'
//        );
        $this->tw_conf = array(
            'CONSUMER_KEY'       => '', // https://apps.twitter.com/app/14233020/keys
            'CONSUMER_SECRET'    => '',
            'ACCESS_TOKEN'  => '',
            'TOKEN_SECRET'  => '',
            'BEARER_TOKEN' => ''
        );

//        https://graph.facebook.com/v2.11/oauth/access_token?grant_type=fb_exchange_token&//client_id=441297721553887&client_secret=59ad0f4b8c31e4e5fd420bb9798381aa&//fb_exchange_token={ACCESS_TOKEN}  // uzoq muddatli token olish

    }

    public function fbSendPost($post_id = null)
    {

        if (!$post_id) {
            return false;
        }
        $post = Post::find($post_id);

        $fb = new Facebook([
            'app_id' => $this->fb_conf['API_ID'],
            'app_secret' => $this->fb_conf['API_SECRET'],
            'default_graph_version' => $this->fb_conf['API_VER'],
        ]);

        $linkData['message'] = $post->title_kr;
        $linkData['message'] .= "\n\n" . strip_tags($post->description_kr);
        $linkData['link'] = 'https://bolalarolami.uz/'.$post->id;

        $path = '/feed';

        $pageAccessToken = $this->fb_conf['ACCESS_TOKEN'];

        try {
            $response = $fb->post('/'.$this->fb_conf['PAGE_ID'].$path, $linkData, $pageAccessToken);
            $result =  $response->getGraphNode();

            if ($auto_send_post = PostsSendAutoSocialNetwork::query()->where('post_id',$post->id)->first()){
                $auto_send_post->update([
                    'is_send_facebook' => 1,
                    'facebook_send' => 1
                ]);
            } else {
                PostsSendAutoSocialNetwork::create([
                    'post_id' => $post->id,
                    'publish_date' => $post->publish_date,
                    'is_send_facebook' => 1,
                    'facebook_send' => 1
                ]);
            }
            return  $result;
        }
        catch(FacebookResponseException $e) {
            $e_msg = 'Graph returned an error: '.$e->getMessage();
            $this->log_errors('facebook', $e_msg);
            if ($auto_send_post = PostsSendAutoSocialNetwork::query()->where('post_id',$post->id)->first()){
                $auto_send_post->update([
                    'is_send_facebook' => 0,
                    'facebook_send' => 1
                ]);
            } else {
                PostsSendAutoSocialNetwork::create([
                    'post_id' => $post->id,
                    'publish_date' => $post->publish_date,
                    'is_send_facebook' => 0,
                    'facebook_send' => 1
                ]);
            }
            return FALSE;
        }
        catch(FacebookSDKException $e) {
            $e_msg = 'Facebook SDK returned an error: '.$e->getMessage();
            $this->log_errors('facebook', $e_msg);
            if ($auto_send_post = PostsSendAutoSocialNetwork::query()->where('post_id',$post->id)->first()){
                $auto_send_post->update([
                    'is_send_facebook' => 0,
                    'facebook_send' => 1
                ]);
            } else {
                PostsSendAutoSocialNetwork::create([
                    'post_id' => $post->id,
                    'publish_date' => $post->publish_date,
                    'is_send_facebook' => 0,
                    'facebook_send' => 1
                ]);
            }
            return FALSE;
        }
    }

    public function scheduleFacebookSendPosts() {
        return false;
//        $auto_posts = PostsSendAutoSocialNetwork::query()->where('facebook_send',1)->where('is_send_facebook',0)->get();
//
//        foreach ($auto_posts as $auto_post) {
//            if (Carbon::parse($auto_post->publish_date)->format('Y-m-d H:i:s') < Carbon::parse()->format('Y-m-d H:i:s')) {
//                $this->fbSendPost($auto_post->post_id);
//            }
//        }
    }

    public function twSendPost($post_id = null) {
        if (!$post_id) {
            return false;
        }
        $post = Post::find($post_id);
        $message = $post->title_kr;
        $message .= "\n\n" . 'https://bolalarolami.uz/'.$post->id;
        try {
            $connection = new TwitterOAuth($this->tw_conf['CONSUMER_KEY'], $this->tw_conf['CONSUMER_SECRET'], $this->tw_conf['ACCESS_TOKEN'],$this->tw_conf['TOKEN_SECRET']);

            $connection->post("tweets", ["text" => $message]);

            if ($auto_send_post = PostsSendAutoSocialNetwork::query()->where('post_id',$post->id)->first()){
                $auto_send_post->update([
                    'is_send_twitter' => 1,
                    'twitter_send' => 1
                ]);
            } else {
                PostsSendAutoSocialNetwork::create([
                    'post_id' => $post->id,
                    'publish_date' => $post->publish_date,
                    'is_send_twitter' => 1,
                    'twitter_send' => 1
                ]);
            }
        }
        catch(\Exception $e){

            if ($auto_send_post = PostsSendAutoSocialNetwork::query()->where('post_id',$post->id)->first()){
                $auto_send_post->update([
                    'is_send_twitter' => 0,
                    'twitter_send' => 1
                ]);
            } else {
                PostsSendAutoSocialNetwork::create([
                    'post_id' => $post->id,
                    'publish_date' => $post->publish_date,
                    'is_send_twitter' => 0,
                    'twitter_send' => 1
                ]);
            }
        }
    }

    public function scheduleTwitterSendPosts() {
        $auto_posts = PostsSendAutoSocialNetwork::query()->where('twitter_send',1)->where('is_send_twitter',0)->get();

        foreach ($auto_posts as $auto_post) {
            if (Carbon::parse($auto_post->publish_date)->format('Y-m-d H:i:s') < Carbon::parse()->format('Y-m-d H:i:s')) {
                $this->twSendPost($auto_post->post_id);
            }
        }
    }

    public function log_errors($api, $error)
    {
        dd($error);
        $curdate = date('d.m.Y h:i:s');
        $myFile = 'API-LOGS/api_error_log.txt';
        $fh = fopen($myFile) or die("can't open file");
        fwrite($fh, $curdate.' - '.$api.': '.$error."\n");
        fclose($fh);
    }
}
