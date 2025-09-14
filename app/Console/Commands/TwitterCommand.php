<?php

namespace App\Console\Commands;

use App\Social\ApiManager;
use App\Social\Twitter\SendTwit;
use Illuminate\Console\Command;
use Goutte\Client;

class TwitterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twit {method} {post_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
//        dd('kelli');
        $tw  =new SendTwit();

        $tw->sendPost();
        $method = $this->argument('method');
        $post_id = $this->argument('post_id');

        dd($tw->$method($post_id ?? 99));
    }
}
