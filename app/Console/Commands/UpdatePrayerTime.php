<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;

class UpdatePrayerTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-prayer-time';

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
        try {// Create a new Goutte client
            $client = new Client();// Replace the URL with the actual URL of the website
            $url = 'https://islom.uz';// Make the HTTP request and get the HTML content
            $crawler = $client->request('GET', $url);// Extract p_clock values
            $pClockElements = $crawler->filter('.p_clock');
            $timesArray = [];
            $pClockElements->each(function ($pClockElement) use (&$timesArray) {
                $id = $pClockElement->attr('id');
                $time = $pClockElement->text();
                $timesArray[] = $time;
                echo "ID: $id, Time: $time\n";
            });
            $jsonFile = storage_path('app/times.json');
            file_put_contents($jsonFile, json_encode($timesArray));
        } catch (\Exception $e) {
        }

    }
}
