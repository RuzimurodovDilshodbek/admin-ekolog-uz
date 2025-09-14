<?php

namespace App\Helpers;

class App
{
    public static function todayPrayerTimes()
    {
        try {
            $jsonFile = storage_path('app/times.json');
            $timesData = file_get_contents($jsonFile);
            return json_decode($timesData);
        } catch (\Exception $exception) {
            return false;
        }
    }
}
