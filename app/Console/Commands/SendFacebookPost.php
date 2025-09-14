<?php

namespace App\Console\Commands;

use App\Social\ApiManager;
use App\Social\Telegram;
use Illuminate\Console\Command;
use Goutte\Client;

class SendFacebookPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:facebook-posts';

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
        $tg  =new ApiManager();

        $tg->scheduleFacebookSendPosts();
    }
}
