<?php

namespace App\Console\Commands;

use App\Social\ApiManager;
use Illuminate\Console\Command;
use Goutte\Client;

class FacebookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fb {method} {post_id}';

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
        $fb  =new ApiManager();

        $fb->fbSendPost();
        $method = $this->argument('method');
        $post_id = $this->argument('post_id');

        dd($fb->$method($post_id ?? 99));
    }
}
