<?php

namespace Database\Seeders;

use App\Models\BotUser;
use Illuminate\Database\Seeder;

class BotUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $botUsers = [
            [
                'telegram_id' => 664143932,
                'username' => 'Ruzimurodov_Dilshodbek',
                'first_name' => 'Dilshodbek',
                'last_name' => 'Ro\'zimurodov',
                'is_active' => true,
                'is_admin' => true,
            ],
            // Add more authorized users here
            // Example:
            // [
            //     'telegram_id' => 123456789,
            //     'username' => 'example_user',
            //     'first_name' => 'User',
            //     'last_name' => 'Name',
            //     'is_active' => true,
            //     'is_admin' => false,
            // ],
        ];

        foreach ($botUsers as $user) {
            BotUser::updateOrCreate(
                ['telegram_id' => $user['telegram_id']],
                $user
            );
        }
    }
}
