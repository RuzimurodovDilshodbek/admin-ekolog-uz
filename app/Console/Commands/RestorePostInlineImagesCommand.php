<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

/**
 * posts:extract-inline-images olgan zaxiradan asl matnlarni qaytaradi.
 *
 *   php artisan posts:restore-inline-images inline-images-backup-20260906-101500.ndjson
 *
 * Zaxira NDJSON — har qatorda bitta post. Fayl 90 MB atrofida bo'lgani uchun
 * u butunlay xotiraga o'qilmaydi, qatorma-qator ishlanadi.
 *
 * Diqqat: bu faqat matnni qaytaradi. Chiqarilgan rasm fayllari media
 * to'plamida qoladi — ular endi hech qayerdan havola qilinmaydi, lekin
 * o'chirilmaydi, chunki qayta chiqarishda ular yana kerak bo'lishi mumkin.
 */
class RestorePostInlineImagesCommand extends Command
{
    protected $signature = 'posts:restore-inline-images {file : storage/app ichidagi zaxira fayl nomi}';

    protected $description = 'Base64 rasmlarni chiqarishdan oldingi post matnlarini qaytaradi';

    public function handle(): int
    {
        $path = storage_path('app/' . basename($this->argument('file')));

        if (! is_file($path)) {
            $this->error("Topilmadi: {$path}");

            return self::FAILURE;
        }

        $handle = fopen($path, 'r');

        if ($handle === false) {
            $this->error("Faylni ochib bo'lmadi: {$path}");

            return self::FAILURE;
        }

        $restored = 0;
        $bad = 0;

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $row = json_decode($line, true);

            if (! is_array($row) || ! isset($row['id'], $row['columns']) || ! is_array($row['columns'])) {
                $bad++;

                continue;
            }

            Post::withoutTimestamps(fn () => Post::where('id', $row['id'])->update($row['columns']));
            $restored++;
        }

        fclose($handle);

        $this->info("Qaytarildi: {$restored} ta post.");

        if ($bad) {
            $this->warn("O'qib bo'lmagan qatorlar: {$bad}");
        }

        return self::SUCCESS;
    }
}
