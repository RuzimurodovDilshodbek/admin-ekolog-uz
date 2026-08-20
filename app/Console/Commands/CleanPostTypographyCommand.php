<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Support\TypographyCleaner;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Postlar matnidagi Word/Google Docs'dan kelgan shrift uslublarini tozalaydi.
 *
 *   php artisan posts:clean-typography --dry-run     ko'rsatadi, o'zgartirmaydi
 *   php artisan posts:clean-typography               tozalaydi (avval zaxira oladi)
 *   php artisan posts:clean-typography --with-align  text-align (justify) ni ham olib tashlaydi
 *   php artisan posts:clean-typography --with-color  matn ranglarini ham olib tashlaydi
 */
class CleanPostTypographyCommand extends Command
{
    protected $signature = 'posts:clean-typography
                            {--dry-run : Faqat ko\'rsatadi, hech narsa o\'zgartirmaydi}
                            {--with-align : text-align (justify) ni ham olib tashlash}
                            {--with-color : matn ranglarini ham olib tashlash}
                            {--id=* : Faqat shu ID li postlar}';

    protected $description = 'Postlardagi Word/Docs shrift uslublarini tozalaydi (font-size, font-family, line-height, MsoNormal...)';

    private const COLUMNS = ['content_uz', 'content_kr', 'content_ru', 'content_en'];

    public function handle(): int
    {
        $dry     = $this->option('dry-run');
        $cleaner = new TypographyCleaner(
            stripColor: (bool) $this->option('with-color'),
            stripAlign: (bool) $this->option('with-align'),
        );

        $query = Post::query()->select(array_merge(['id', 'title_uz'], self::COLUMNS));
        if ($ids = $this->option('id')) {
            $query->whereIn('id', $ids);
        }

        $totals   = [];
        $changed  = [];
        $backup   = [];
        $scanned  = 0;

        foreach ($query->cursor() as $post) {
            $scanned++;
            $updates = [];
            $before  = [];

            foreach (self::COLUMNS as $col) {
                $res = $cleaner->clean($post->{$col});

                foreach ($res['removed'] as $k => $n) {
                    $totals[$k] = ($totals[$k] ?? 0) + $n;
                }

                if ($res['changed']) {
                    $updates[$col] = $res['html'];
                    $before[$col]  = $post->{$col};
                }
            }

            if (! $updates) {
                continue;
            }

            $changed[] = [
                'id'      => $post->id,
                'title'   => mb_substr((string) $post->title_uz, 0, 46),
                'cols'    => implode(', ', array_map(fn ($c) => str_replace('content_', '', $c), array_keys($updates))),
                'saved'   => $this->saved($before, $updates),
            ];

            if ($dry) {
                continue;
            }

            $backup[$post->id] = $before;
            Post::withoutTimestamps(fn () => Post::where('id', $post->id)->update($updates));
        }

        // --- hisobot ---
        $this->line('');
        $this->info($dry ? '=== SINOV REJIMI (hech narsa o\'zgartirilmadi) ===' : '=== TOZALANDI ===');
        $this->line("  Ko'rilgan postlar : {$scanned}");
        $this->line('  O\'zgaradigan     : ' . count($changed));

        if ($totals) {
            $this->line('');
            $this->line('  Olib tashlanadigan uslublar:');
            arsort($totals);
            foreach ($totals as $k => $n) {
                $this->line(sprintf('    %-16s %6d ta', $k, $n));
            }
        }

        if ($changed) {
            $this->line('');
            $this->table(
                ['ID', 'Sarlavha', 'Ustunlar', 'Kichrayadi'],
                array_map(fn ($c) => [$c['id'], $c['title'], $c['cols'], $c['saved']], array_slice($changed, 0, 25))
            );
            if (count($changed) > 25) {
                $this->line('    ... va yana ' . (count($changed) - 25) . ' ta post');
            }
        }

        if (! $dry && $backup) {
            $file = 'typography-backup-' . now()->format('Ymd-His') . '.json';
            Storage::disk('local')->put($file, json_encode($backup, JSON_UNESCAPED_UNICODE));
            $this->line('');
            $this->comment("  Asl matnlar zaxirasi: storage/app/{$file}");
            $this->comment('  Qaytarish: php artisan posts:restore-typography ' . $file);
        }

        return self::SUCCESS;
    }

    /** Nechta belgi kamayishini ko'rsatadi */
    private function saved(array $before, array $after): string
    {
        $b = array_sum(array_map('strlen', $before));
        $a = array_sum(array_map('strlen', $after));

        return $b > 0 ? number_format($b - $a) . ' belgi (' . round(($b - $a) / $b * 100) . '%)' : '—';
    }
}
