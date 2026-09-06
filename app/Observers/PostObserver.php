<?php

namespace App\Observers;

use App\Models\Post;
use App\Support\InlineImageExtractor;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Maqola saqlangandan keyin matnga yopishib kelgan base64 rasmlarni faylga
 * chiqaradi.
 *
 * `posts:extract-inline-images` mavjud maqolalarni bir marta tozalaydi; bu
 * observer esa yangilarining kirishiga yo'l qo'ymaydi. Muharrir rasmni Word'dan
 * yoki brauzerdan nusxa ko'chirganda u `data:image/...;base64,...` bo'lib
 * tushadi, va bitta shunday joylashtirish maqola sahifasini o'nlab megabaytga
 * olib chiqishi mumkin (o'lchangan eng og'iri 73 MB edi).
 *
 * Muharrirga xato ko'rsatilmaydi — rasm baribir kerak, shunchaki to'g'ri joyda
 * saqlanadi. Bu foydalanuvchi uchun ish jarayonini o'zgartirmaydi.
 */
class PostObserver
{
    private const COLUMNS = ['content_uz', 'content_kr', 'content_ru', 'content_en'];

    public function saved(Post $post): void
    {
        $updates = [];
        $extractor = new InlineImageExtractor();

        foreach (self::COLUMNS as $column) {
            $html = (string) $post->getAttribute($column);

            // Deyarli barcha saqlashlar shu tekshiruvda to'xtaydi.
            if ($html === '' || ! str_contains($html, 'data:image/')) {
                continue;
            }

            try {
                $result = $extractor->extract(
                    $html,
                    function (string $binary, string $extension, int $index) use ($post, $column): ?string {
                        $locale = str_replace('content_', '', $column);
                        $name = sprintf('post-%d-%s-%d-%s.%s', $post->id, $locale, $index + 1, now()->format('His'), $extension);

                        return $post->addMediaFromString($binary)
                            ->usingFileName($name)
                            ->usingName(pathinfo($name, PATHINFO_FILENAME))
                            ->toMediaCollection('ck-media')
                            ->getUrl();
                    }
                );
            } catch (Throwable $e) {
                // Rasmni chiqara olmaslik maqolani saqlashni buzmasligi kerak.
                Log::warning('Inline rasmni chiqarib bo\'lmadi', [
                    'post' => $post->id,
                    'column' => $column,
                    'error' => $e->getMessage(),
                ]);

                continue;
            }

            if ($result['changed']) {
                $updates[$column] = $result['html'];
            }
        }

        if (! $updates) {
            return;
        }

        // To'g'ridan-to'g'ri so'rov: model hodisalarini qayta ishga tushirmaydi,
        // ya'ni bu observer o'zini cheksiz chaqirmaydi.
        Post::withoutTimestamps(fn () => Post::where('id', $post->id)->update($updates));

        foreach ($updates as $column => $html) {
            $post->setAttribute($column, $html);
        }

        $post->syncOriginal();
    }
}
