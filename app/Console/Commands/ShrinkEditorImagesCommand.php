<?php

namespace App\Console\Commands;

use App\Support\EditorImage;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Maqola matnidagi rasmlarni o'qishga yetarli o'lchamga tushiradi.
 *
 *   php artisan media:shrink-editor-images --dry-run   ko'rsatadi, tegmaydi
 *   php artisan media:shrink-editor-images             kichraytiradi (zaxira oladi)
 *
 * Fayl nomi o'zgarmaydi, ya'ni post matnidagi havolalarni qayta yozish shart emas.
 */
class ShrinkEditorImagesCommand extends Command
{
    protected $signature = 'media:shrink-editor-images
                            {--dry-run : Faqat ko\'rsatadi, hech narsa o\'zgartirmaydi}
                            {--collection=ck-media : Qaysi kolleksiya}
                            {--max-width= : Eng katta kenglik (standart 1600)}
                            {--quality= : JPEG/WebP sifati (standart 82)}';

    protected $description = 'Matn ichidagi rasmlarni 1600px gacha kichraytiradi (formatni o\'zgartirmaydi)';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $maxWidth = (int) ($this->option('max-width') ?: EditorImage::MAX_WIDTH);
        $quality = (int) ($this->option('quality') ?: EditorImage::QUALITY);
        $collection = (string) $this->option('collection');

        $backupDir = storage_path('app/backups/ck-media-' . now()->format('Ymd-His'));

        $rows = [];
        $before = $after = $scanned = $skipped = 0;
        $errors = [];

        foreach (Media::where('collection_name', $collection)->cursor() as $media) {
            $path = $media->getPath();
            $scanned++;

            $result = EditorImage::shrink($path, $maxWidth, $quality);

            if ($result['error']) {
                $errors[] = "#{$media->id} {$media->file_name}: {$result['error']}";

                continue;
            }

            if (! $result['changed']) {
                $skipped++;

                continue;
            }

            $before += $result['before'];
            $after += $result['after'];

            $rows[] = [
                $media->id,
                mb_substr($media->file_name, 0, 34),
                $result['width_before'] . ' -> ' . $result['width_after'],
                $this->mb($result['before']) . ' -> ' . $this->mb($result['after']),
                round(100 - $result['after'] / $result['before'] * 100) . '%',
            ];

            if ($dry) {
                @unlink($result['temp'] ?? '');

                continue;
            }

            // Asl faylni saqlab qo'yamiz: kichraytirish qaytarib bo'lmaydigan amal
            if (! is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            copy($path, $backupDir . '/' . $media->id . '-' . $media->file_name);

            if (EditorImage::commit($path, $result)) {
                // media.size bazada saqlanadi, uni ham yangilash kerak
                Media::withoutTimestamps(fn () => $media->forceFill(['size' => $result['after']])->saveQuietly());
            }
        }

        $this->line('');
        $this->info($dry ? '=== SINOV REJIMI (hech narsa o\'zgartirilmadi) ===' : '=== KICHRAYTIRILDI ===');
        $this->line("  Ko'rilgan       : {$scanned}");
        $this->line('  O\'zgaradigan    : ' . count($rows));
        $this->line("  Tegilmaydi      : {$skipped} (kengligi {$maxWidth}px dan oshmaydi)");

        if ($rows) {
            $this->line('');
            usort($rows, fn ($a, $b) => (int) $b[0] <=> (int) $a[0]);
            $this->table(['ID', 'Fayl', 'Kenglik', 'Hajm', 'Kamayish'], array_slice($rows, 0, 25));

            if (count($rows) > 25) {
                $this->line('    ... va yana ' . (count($rows) - 25) . ' ta');
            }

            $this->line('');
            $this->line(sprintf(
                '  Jami: %s -> %s  (%d%% kamayadi, %s tejaladi)',
                $this->mb($before),
                $this->mb($after),
                round(100 - $after / $before * 100),
                $this->mb($before - $after)
            ));
        }

        if ($errors) {
            $this->line('');
            $this->warn('  Xatolar:');
            foreach (array_slice($errors, 0, 10) as $e) {
                $this->line('    ' . $e);
            }
        }

        if (! $dry && $rows) {
            $this->line('');
            $this->comment('  Asl fayllar zaxirasi: ' . $backupDir);
            $this->comment('  Qaytarish: fayllarni nomidagi ID prefiksini olib tashlab, o\'z papkasiga qaytarish');
        }

        return self::SUCCESS;
    }

    private function mb(int $bytes): string
    {
        return $bytes >= 1048576
            ? number_format($bytes / 1048576, 1) . ' MB'
            : number_format($bytes / 1024) . ' KB';
    }
}
