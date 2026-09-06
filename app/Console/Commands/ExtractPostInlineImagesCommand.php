<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Support\InlineImageExtractor;
use Illuminate\Console\Command;
use Throwable;

/**
 * Maqola matniga yopishib qolgan base64 rasmlarni haqiqiy fayllarga chiqaradi.
 *
 *   php artisan posts:extract-inline-images --dry-run   ko'rsatadi, o'zgartirmaydi
 *   php artisan posts:extract-inline-images             chiqaradi (avval zaxira oladi)
 *   php artisan posts:extract-inline-images --id=104    faqat bitta post
 *
 * Nega kerak: o'lchangan holatda /159 sahifasi 7.96 MB, /ru/56 esa 73 MB edi va
 * hujjatning 98.9% i base64 satrlar. Ular ikki marta uzatiladi — HTML tanasida
 * va Nuxt hidratatsiya payload'ida. Rasmni faylga chiqarish bitta o'zgarish
 * bilan ikkalasini ham yo'q qiladi va brauzerga keshlanadigan rasm beradi.
 */
class ExtractPostInlineImagesCommand extends Command
{
    protected $signature = 'posts:extract-inline-images
                            {--dry-run : Faqat ko\'rsatadi, hech narsa o\'zgartirmaydi}
                            {--id=* : Faqat shu ID li postlar}';

    protected $description = 'Postlar matnidagi base64 rasmlarni media fayllarga chiqaradi';

    private const COLUMNS = ['content_uz', 'content_kr', 'content_ru', 'content_en'];

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $extractor = new InlineImageExtractor();

        $query = Post::query()->select(array_merge(['id', 'title_uz'], self::COLUMNS));

        if ($ids = $this->option('id')) {
            $query->whereIn('id', $ids);
        }

        $backupPath = null;
        $backup = null;

        if (! $dry) {
            $backupPath = storage_path('app/inline-images-backup-' . now()->format('Ymd-His') . '.ndjson');
            $backup = fopen($backupPath, 'w');

            if ($backup === false) {
                $this->error("Zaxira faylini ochib bo'lmadi: {$backupPath}");

                return self::FAILURE;
            }
        }

        $scanned = 0;
        $changedPosts = [];
        $totalExtracted = 0;
        $totalSkipped = 0;
        $bytesBefore = 0;
        $bytesAfter = 0;
        $failed = [];

        // cursor() qatorlarni birma-bir oqizadi. Bu muhim: barcha postlarning
        // matni birgalikda 96 MB, bitta ustun esa 37 MB gacha chiqadi.
        foreach ($query->cursor() as $post) {
            $scanned++;

            $updates = [];
            $original = [];
            $postExtracted = 0;
            $postBefore = 0;
            $postAfter = 0;

            foreach (self::COLUMNS as $column) {
                $html = (string) $post->{$column};

                if (! str_contains($html, 'data:image/')) {
                    continue;
                }

                try {
                    $result = $extractor->extract(
                        $html,
                        fn (string $binary, string $extension, int $index): ?string => $dry
                            ? 'https://example.invalid/dry-run.' . $extension
                            : $this->store($post, $binary, $extension, $column, $index)
                    );
                } catch (Throwable $e) {
                    $failed[] = ['id' => $post->id, 'column' => $column, 'error' => $e->getMessage()];

                    continue;
                }

                $totalSkipped += $result['skipped'];

                if (! $result['changed']) {
                    continue;
                }

                $updates[$column] = $result['html'];
                $original[$column] = $html;
                $postExtracted += $result['extracted'];
                $postBefore += $result['bytes_before'];
                $postAfter += $result['bytes_after'];
            }

            if (! $updates) {
                continue;
            }

            $totalExtracted += $postExtracted;
            $bytesBefore += $postBefore;
            $bytesAfter += $postAfter;

            $changedPosts[] = [
                'id' => $post->id,
                'title' => mb_substr((string) $post->title_uz, 0, 40),
                'images' => $postExtracted,
                'before' => $this->human($postBefore),
                'after' => $this->human($postAfter),
            ];

            if ($dry) {
                continue;
            }

            // Zaxirani yozib bo'lgandan keyingina yangilaymiz, aks holda
            // qaytarib bo'lmaydigan holat yuzaga kelishi mumkin.
            fwrite($backup, json_encode(
                ['id' => $post->id, 'columns' => $original],
                JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
            ) . "\n");
            fflush($backup);

            Post::withoutTimestamps(fn () => Post::where('id', $post->id)->update($updates));
        }

        if ($backup !== null) {
            fclose($backup);
        }

        $this->report($dry, $scanned, $changedPosts, $totalExtracted, $totalSkipped, $bytesBefore, $bytesAfter, $failed, $backupPath);

        return $failed ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Rasmni `ck-media` to'plamiga saqlaydi — muharrir ichidan yuklangan
     * rasmlar ham aynan shu to'plamga tushadi (PostController@storeCKEditorImages).
     */
    private function store(Post $post, string $binary, string $extension, string $column, int $index): ?string
    {
        $locale = str_replace('content_', '', $column);
        $name = sprintf('post-%d-%s-%d.%s', $post->id, $locale, $index + 1, $extension);

        $media = $post->addMediaFromString($binary)
            ->usingFileName($name)
            ->usingName(pathinfo($name, PATHINFO_FILENAME))
            ->toMediaCollection('ck-media');

        return $media->getUrl();
    }

    /** @param array<int, array<string, mixed>> $changed */
    private function report(
        bool $dry,
        int $scanned,
        array $changed,
        int $extracted,
        int $skipped,
        int $bytesBefore,
        int $bytesAfter,
        array $failed,
        ?string $backupPath
    ): void {
        $this->line('');
        $this->info($dry ? '=== SINOV REJIMI (hech narsa o\'zgartirilmadi) ===' : '=== CHIQARILDI ===');
        $this->line("  Ko'rilgan postlar   : {$scanned}");
        $this->line('  O\'zgaradigan        : ' . count($changed));
        $this->line("  Chiqarilgan rasmlar : {$extracted}");

        if ($skipped) {
            $this->line("  O'tkazib yuborilgan : {$skipped} (tanib bo'lmadi, tegilmadi)");
        }

        if ($bytesBefore) {
            $saved = $bytesBefore - $bytesAfter;
            $this->line(sprintf(
                '  Matn hajmi          : %s -> %s  (%s kamaydi, %d%%)',
                $this->human($bytesBefore),
                $this->human($bytesAfter),
                $this->human($saved),
                (int) round($saved / $bytesBefore * 100)
            ));
        }

        if ($changed) {
            usort($changed, fn ($a, $b) => $b['images'] <=> $a['images']);

            $this->line('');
            $this->table(
                ['ID', 'Sarlavha', 'Rasm', 'Oldin', 'Keyin'],
                array_map(fn ($c) => array_values($c), array_slice($changed, 0, 20))
            );

            if (count($changed) > 20) {
                $this->line('    ... va yana ' . (count($changed) - 20) . ' ta post');
            }
        }

        if ($failed) {
            $this->line('');
            $this->error('  Xatolar:');
            foreach ($failed as $f) {
                $this->line("    #{$f['id']} {$f['column']}: {$f['error']}");
            }
        }

        if ($backupPath && file_exists($backupPath) && filesize($backupPath) > 0) {
            $this->line('');
            $this->comment('  Asl matnlar zaxirasi: ' . $backupPath);
            $this->comment('  Qaytarish: php artisan posts:restore-inline-images ' . basename($backupPath));
        }
    }

    private function human(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024) . ' KB';
        }

        return $bytes . ' B';
    }
}
