<?php

namespace App\Console\Commands;

use App\Social\Telegram;
use Illuminate\Console\Command;
use Goutte\Client;

class TelegramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tg {method} {post_id}';

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
        $t = new Telegram('azon_global');
        $method = $this->argument('method');
        $post_id = $this->argument('post_id');

        dd($t->$method($post_id ?? 99));

    }
}
