<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * posts:clean-typography olgan zaxiradan asl matnlarni qaytaradi.
 *
 *   php artisan posts:restore-typography typography-backup-20260821-101500.json
 */
class RestorePostTypographyCommand extends Command
{
    protected $signature = 'posts:restore-typography {file : storage/app ichidagi zaxira fayl nomi}';

    protected $description = 'Tozalashdan oldingi post matnlarini zaxiradan qaytaradi';

    public function handle(): int
    {
        $file = $this->argument('file');

        if (! Storage::disk('local')->exists($file)) {
            $this->error("Topilmadi: storage/app/{$file}");

            return self::FAILURE;
        }

        $data = json_decode(Storage::disk('local')->get($file), true);

        if (! is_array($data) || ! $data) {
            $this->error('Zaxira fayl bo\'sh yoki buzilgan.');

            return self::FAILURE;
        }

        $n = 0;
        foreach ($data as $id => $columns) {
            Post::withoutTimestamps(fn () => Post::where('id', $id)->update($columns));
            $n++;
        }

        $this->info("Qaytarildi: {$n} ta post.");

        return self::SUCCESS;
    }
}
