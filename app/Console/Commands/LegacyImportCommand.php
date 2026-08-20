<?php

namespace App\Console\Commands;

use App\Models\Legacy\LegacyMedia;
use App\Models\Legacy\LegacyPost;
use App\Models\Legacy\LegacyTerm;
use App\Support\LegacyHtmlSanitizer;
use App\Support\LegacySpamDetector;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Eski ekolog.uz WordPress arxivini "legacy" bazasiga import qiladi.
 *
 * Manba: storage/app/legacy-import/{ekolog_db|ekolog_database}/*.json
 * (bu fayllar mysqldump'dan JSON'ga o'girilgan - SQL bajarilmaydi)
 *
 *   php artisan legacy:import
 *   php artisan legacy:import --fresh        (avval tozalab, qaytadan)
 *   php artisan legacy:import --keep-spam    (spamni ham import qilish)
 */
class LegacyImportCommand extends Command
{
    protected $signature = 'legacy:import
                            {--fresh : Arxiv jadvallarini avval tozalash}
                            {--keep-spam : Spam postlarni ham import qilish}';

    protected $description = 'Eski ekolog.uz WordPress arxivini legacy bazasiga import qiladi';

    private LegacyHtmlSanitizer $sanitizer;

    private LegacySpamDetector $spamDetector;

    /** @var array<int,string> */
    private array $skipped = [];

    public function handle(): int
    {
        $this->sanitizer    = new LegacyHtmlSanitizer();
        $this->spamDetector = new LegacySpamDetector();

        if ($this->option('fresh')) {
            $this->warn('Arxiv jadvallari tozalanmoqda...');
            foreach (['legacy_post_term', 'legacy_terms', 'legacy_media', 'legacy_posts'] as $t) {
                DB::connection('legacy')->table($t)->delete();
            }
        }

        $totals = ['posts' => 0, 'spam' => 0, 'media' => 0, 'terms' => 0, 'links' => 0];

        foreach (config('legacy.sources') as $source => $cfg) {
            $dir = $cfg['json_dir'];

            if (! Storage::disk('local')->exists($dir . '/wp_posts.json')) {
                $this->error("Topilmadi: storage/app/{$dir}/wp_posts.json - o'tkazib yuborildi");
                continue;
            }

            $this->line('');
            $this->info("=== {$cfg['label']}  [{$source}] ===");

            $posts    = $this->readJson($dir . '/wp_posts.json');
            $postmeta = $this->readJson($dir . '/wp_postmeta.json');
            $terms    = $this->readJson($dir . '/wp_terms.json');
            $taxonomy = $this->readJson($dir . '/wp_term_taxonomy.json');
            $rels     = $this->readJson($dir . '/wp_term_relationships.json');
            $users    = $this->readJson($dir . '/wp_users.json');

            $meta = $this->indexMeta($postmeta);

            $totals['terms'] += $this->importTerms($source, $terms, $taxonomy);
            $totals['media'] += $this->importMedia($source, $posts, $meta);

            $res = $this->importPosts($source, $posts, $meta, $users);
            $totals['posts'] += $res['imported'];
            $totals['spam']  += $res['spam'];

            $totals['links'] += $this->importRelations($source, $rels, $taxonomy);
        }

        $this->writeSkipReport();

        $this->line('');
        $this->info('--- YAKUN ---');
        $this->table(
            ['Post', 'Tashlangan spam', 'Media', 'Rukn/teg', 'Bog\'lanish'],
            [[$totals['posts'], $totals['spam'], $totals['media'], $totals['terms'], $totals['links']]]
        );

        if ($totals['spam'] > 0) {
            $this->comment("Tashlangan spam ro'yxati: storage/app/legacy-import/skipped-spam.txt");
        }

        return self::SUCCESS;
    }

    private function readJson(string $path): array
    {
        if (! Storage::disk('local')->exists($path)) {
            return [];
        }

        return json_decode(Storage::disk('local')->get($path), true) ?: [];
    }

    /** postmeta'ni post_id bo'yicha guruhlash */
    private function indexMeta(array $rows): array
    {
        $out = [];

        foreach ($rows as $r) {
            $out[$r['post_id']][$r['meta_key']] = $r['meta_value'];
        }

        return $out;
    }

    private function importTerms(string $source, array $terms, array $taxonomy): int
    {
        $byId = [];
        foreach ($terms as $t) {
            $byId[$t['term_id']] = $t;
        }

        $rows = [];
        foreach ($taxonomy as $tx) {
            if (! in_array($tx['taxonomy'], ['category', 'post_tag'], true)) {
                continue;
            }

            $t = $byId[$tx['term_id']] ?? null;
            if (! $t) {
                continue;
            }

            $rows[] = [
                'source'     => $source,
                'wp_term_id' => (int) $tx['term_id'],
                'taxonomy'   => $tx['taxonomy'],
                'name'       => $t['name'] ?? null,
                'slug'       => $t['slug'] ?? null,
                'count'      => (int) ($tx['count'] ?? 0),
            ];
        }

        foreach (array_chunk($rows, 400) as $chunk) {
            LegacyTerm::upsert($chunk, ['source', 'wp_term_id', 'taxonomy'], ['name', 'slug', 'count']);
        }

        $this->line('  rukn/teg: ' . count($rows));

        return count($rows);
    }

    private function importMedia(string $source, array $posts, array $meta): int
    {
        $rows = [];

        foreach ($posts as $p) {
            if (($p['post_type'] ?? '') !== 'attachment') {
                continue;
            }

            $id   = (int) $p['ID'];
            $file = $meta[$id]['_wp_attached_file'] ?? null;

            // Hujumchi yuklagan arxiv/skript fayllari (tasodifiy nomli .zip va h.k.)
            // arxivga umuman kiritilmaydi.
            if ($file && preg_match('/\.(zip|rar|gz|bz2|7z|tar|php[0-9]?|phtml|phar|exe|dll|bat|cmd|sh|js|html?|svg)$/i', $file)) {
                $this->skipped[] = sprintf('[%s] MEDIA (xavfli kengaytma) | %s', $source, $file);
                continue;
            }

            $width = $height = null;
            if (! empty($meta[$id]['_wp_attachment_metadata'])) {
                // serialize qilingan qatorni PARSE QILMAYMIZ (xavfsizlik uchun),
                // faqat o'lchamlarni regex bilan ajratamiz
                $s = $meta[$id]['_wp_attachment_metadata'];
                if (preg_match('/"width";i:(\d+);/', $s, $m)) {
                    $width = (int) $m[1];
                }
                if (preg_match('/"height";i:(\d+);/', $s, $m)) {
                    $height = (int) $m[1];
                }
            }

            $abs = $file
                ? public_path(config('legacy.media_dir') . '/' . $source . '/' . ltrim($file, '/'))
                : null;

            $rows[] = [
                'source'       => $source,
                'wp_id'        => $id,
                'title'        => $p['post_title'] ?? null,
                'file_path'    => $file,
                'mime'         => $p['post_mime_type'] ?? null,
                'parent_wp_id' => (int) ($p['post_parent'] ?? 0) ?: null,
                'width'        => $width,
                'height'       => $height,
                'file_exists'  => $abs ? is_file($abs) : false,
                'published_at' => $this->date($p['post_date'] ?? null),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
        }

        foreach (array_chunk($rows, 300) as $chunk) {
            LegacyMedia::upsert(
                $chunk,
                ['source', 'wp_id'],
                ['title', 'file_path', 'mime', 'parent_wp_id', 'width', 'height', 'file_exists', 'published_at', 'updated_at']
            );
        }

        $this->line('  media: ' . count($rows));

        return count($rows);
    }

    private function importPosts(string $source, array $posts, array $meta, array $users): array
    {
        $authors = [];
        foreach ($users as $u) {
            $authors[$u['ID']] = $u['display_name'] ?? $u['user_login'] ?? null;
        }

        $keepSpam = $this->option('keep-spam');
        $rows     = [];
        $spam     = 0;

        foreach ($posts as $p) {
            $type = $p['post_type'] ?? '';
            if (! in_array($type, ['post', 'page'], true)) {
                continue;
            }
            if (in_array($p['post_status'] ?? '', ['inherit', 'auto-draft'], true)) {
                continue;
            }

            $isSpam = $this->spamDetector->isSpam(
                $p['post_title'] ?? null,
                $p['post_content'] ?? null,
                $p['post_date'] ?? null
            );

            if ($isSpam) {
                $spam++;
                $this->skipped[] = sprintf(
                    "[%s] %s | %s | %s",
                    $source,
                    substr((string) ($p['post_date'] ?? ''), 0, 10),
                    $p['ID'],
                    str_replace(["\n", "\r"], ' ', mb_substr((string) ($p['post_title'] ?? '(sarlavhasiz)'), 0, 120))
                );

                if (! $keepSpam) {
                    continue;
                }
            }

            $raw = (string) ($p['post_content'] ?? '');

            // qTranslate markerlari bo'lsa - asosiy blokni ajratamiz,
            // keyin eski saytga ishora qiluvchi rasm manzillarini mahalliy
            // arxiv papkasiga o'zgartiramiz va HTML'ni tozalaymiz.
            $primary = $this->rewriteMediaUrls($this->stripQTranslateMarkers($raw), $source);
            $clean   = $this->sanitizer->sanitize($primary);
            $removed = $this->sanitizer->removedCount();

            $translations = $this->splitQTranslate($p['post_title'] ?? '', $raw, $source);

            $rows[] = [
                'source'          => $source,
                'wp_id'           => (int) $p['ID'],
                'post_type'       => $type,
                'status'          => $p['post_status'] ?? '',
                'title'           => $this->stripQTranslateMarkers($p['post_title'] ?? ''),
                'slug'            => $p['post_name'] ?? null,
                'content'         => $clean,
                'content_raw'     => $raw,
                'excerpt'         => $this->stripQTranslateMarkers($p['post_excerpt'] ?? ''),
                'lang'            => $this->guessLang($p['post_title'] ?? '', $raw),
                'translations'    => $translations ? json_encode($translations, JSON_UNESCAPED_UNICODE) : null,
                'author'          => $authors[$p['post_author'] ?? null] ?? null,
                'guid'            => $p['guid'] ?? null,
                'thumbnail_wp_id' => isset($meta[(int) $p['ID']]['_thumbnail_id'])
                    ? (int) $meta[(int) $p['ID']]['_thumbnail_id']
                    : null,
                'is_spam'         => $isSpam,
                'was_sanitized'   => $removed > 0,
                'removed_scripts' => $removed,
                'published_at'    => $this->date($p['post_date'] ?? null),
                'modified_at'     => $this->date($p['post_modified'] ?? null),
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            LegacyPost::upsert($chunk, ['source', 'wp_id'], [
                'post_type', 'status', 'title', 'slug', 'content', 'content_raw', 'excerpt',
                'lang', 'translations', 'author', 'guid', 'thumbnail_wp_id', 'is_spam',
                'was_sanitized', 'removed_scripts', 'published_at', 'modified_at', 'updated_at',
            ]);
        }

        $this->line('  post/sahifa: ' . count($rows) . '  (spam tashlandi: ' . $spam . ')');

        return ['imported' => count($rows), 'spam' => $spam];
    }

    private function importRelations(string $source, array $rels, array $taxonomy): int
    {
        $txById = [];
        foreach ($taxonomy as $tx) {
            $txById[$tx['term_taxonomy_id']] = $tx;
        }

        $rows = [];
        foreach ($rels as $r) {
            $tx = $txById[$r['term_taxonomy_id']] ?? null;
            if (! $tx || ! in_array($tx['taxonomy'], ['category', 'post_tag'], true)) {
                continue;
            }

            $rows[] = [
                'source'     => $source,
                'wp_post_id' => (int) $r['object_id'],
                'wp_term_id' => (int) $tx['term_id'],
                'taxonomy'   => $tx['taxonomy'],
            ];
        }

        DB::connection('legacy')->table('legacy_post_term')->where('source', $source)->delete();

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::connection('legacy')->table('legacy_post_term')->insert($chunk);
        }

        $this->line("  bog'lanish: " . count($rows));

        return count($rows);
    }

    /**
     * Eski (buzib kirilgan) saytga ishora qiluvchi rasm manzillarini
     * mahalliy arxiv papkasiga o'zgartiradi, shunda admin panel
     * zararlangan hostga so'rov yubormaydi.
     *
     *   http://old.ekolog.uzwp-content/uploads/...  ->  /legacy-uploads/old/...
     *   https://ekolog.uz/wp-content/uploads/...    ->  /legacy-uploads/old2/...
     */
    private function rewriteMediaUrls(string $html, string $source): string
    {
        $base = '/' . trim(config('legacy.media_dir'), '/') . '/' . $source . '/';

        return preg_replace(
            '~(?:https?:)?//[a-z0-9.-]*ekolog\.uz/?wp-content/uploads/~i',
            $base,
            $html
        ) ?? $html;
    }

    /** qTranslate "[:ru]matn[:uz]matn[:]" bloklarini tillarga ajratadi */
    private function splitQTranslate(string $title, string $content, string $source = 'old'): array
    {
        $out = [];

        foreach (['title' => $title, 'content' => $content] as $field => $value) {
            if (! preg_match('/\[:[a-zA-Z]{2}\]/', $value)) {
                continue;
            }

            $parts = preg_split('/\[:([a-zA-Z]{2})\]/', $value, -1, PREG_SPLIT_DELIM_CAPTURE);
            array_shift($parts); // birinchi marker oldidagi bo'sh qism

            for ($i = 0; $i + 1 < count($parts); $i += 2) {
                $lang = strtolower($parts[$i]);
                $text = preg_replace('/\[:\]\s*$/', '', $parts[$i + 1]);
                $text = trim((string) $text);

                if ($text !== '') {
                    $out[$lang][$field] = $field === 'content'
                        ? $this->sanitizer->sanitize($this->rewriteMediaUrls($text, $source))
                        : strip_tags($text);
                }
            }
        }

        return $out;
    }

    private function stripQTranslateMarkers(string $value): string
    {
        if (! preg_match('/\[:[a-zA-Z]{2}\]/', $value)) {
            return $value;
        }

        // Markerlar bo'lsa - birinchi (odatda asosiy) blokni olamiz
        $parts = preg_split('/\[:([a-zA-Z]{2})\]/', $value, -1, PREG_SPLIT_DELIM_CAPTURE);
        array_shift($parts);

        if (count($parts) >= 2) {
            return trim(preg_replace('/\[:\]\s*$/', '', $parts[1]));
        }

        return trim(preg_replace('/\[:[a-zA-Z]{0,2}\]/', ' ', $value));
    }

    private function guessLang(string $title, string $content): string
    {
        $probe = trim($title) !== '' ? $title : mb_substr($content, 0, 400);

        if (preg_match('/[\x{0400}-\x{04FF}]/u', $probe)) {
            // Kirill: o'zbekcha kirill belgilari bo'lsa "kr", aks holda "ru"
            return preg_match('/[\x{049B}\x{0493}\x{04B3}\x{045E}\x{04E9}]/u', $probe) ? 'kr' : 'ru';
        }

        return 'uz';
    }

    private function date(?string $value): ?string
    {
        if (! $value || str_starts_with($value, '0000')) {
            return null;
        }

        return $value;
    }

    private function writeSkipReport(): void
    {
        if (! $this->skipped) {
            return;
        }

        $header = "Import qilinmagan spam postlar - " . now()->toDateTimeString() . "\n"
            . str_repeat('-', 70) . "\n";

        Storage::disk('local')->put(
            'legacy-import/skipped-spam.txt',
            $header . implode("\n", $this->skipped) . "\n"
        );
    }
}
