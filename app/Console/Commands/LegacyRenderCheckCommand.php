<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\LegacyArchiveController;
use App\Models\Legacy\LegacyPost;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * Arxiv sahifalarini veb-server ishga tushirmasdan render qilib tekshiradi.
 * Natija: storage/app/legacy-render/*.html
 *
 *   php artisan legacy:render-check
 */
class LegacyRenderCheckCommand extends Command
{
    protected $signature = 'legacy:render-check';

    protected $description = 'Arxiv sahifalarini offline render qilib, xatolik yo\'qligini tekshiradi';

    public function handle(): int
    {
        // Tekshiruv uchun ruxsatni ochamiz (faqat shu buyruq doirasida).
        // ?User type-hint mehmon foydalanuvchiga ham ruxsat berish uchun kerak.
        Gate::define('post_access', fn (?\App\Models\User $user) => true);

        $dir = storage_path('app/legacy-render');
        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $controller = new LegacyArchiveController();
        $ok = true;

        $cases = [
            'index'          => fn () => $controller->index(Request::create('/admin/arxiv', 'GET')),
            'index-filtered' => fn () => $controller->index(Request::create('/admin/arxiv', 'GET', ['source' => 'old', 'year' => '2019'])),
            'media'          => fn () => $controller->media(Request::create('/admin/arxiv/media', 'GET')),
        ];

        $sample = LegacyPost::where('was_sanitized', true)->orderByDesc('removed_scripts')->first()
            ?? LegacyPost::first();

        if ($sample) {
            $cases['show'] = fn () => $controller->show($sample->source, $sample->wp_id);
        }

        foreach ($cases as $name => $fn) {
            try {
                $html = $fn()->render();
                file_put_contents("{$dir}/{$name}.html", $html);

                $dangerous = [];
                foreach (['<script>alert', 'javascript:', 'onerror=', '<iframe'] as $needle) {
                    if (stripos($html, $needle) !== false) {
                        $dangerous[] = $needle;
                    }
                }

                $this->line(sprintf(
                    '  %-16s OK  (%s KB)%s',
                    $name,
                    number_format(strlen($html) / 1024, 1),
                    $dangerous ? '  DIQQAT: ' . implode(', ', $dangerous) : ''
                ));

                if ($dangerous) {
                    $ok = false;
                }
            } catch (\Throwable $e) {
                $ok = false;
                $this->error(sprintf('  %-16s XATO: %s', $name, $e->getMessage()));
                $this->line('     ' . $e->getFile() . ':' . $e->getLine());
            }
        }

        $this->line('');
        $this->line($ok ? 'Barcha sahifalar muammosiz render bo\'ldi.' : 'Muammolar topildi.');
        $this->comment("HTML fayllar: {$dir}");

        return $ok ? self::SUCCESS : self::FAILURE;
    }
}
