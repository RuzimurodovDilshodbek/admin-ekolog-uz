<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Throwable;

/**
 * Front (Nuxt) /sitemap.xml ni shu ro'yxat asosida quradi.
 *
 * Mavjud /api/v1/posts butun qatorni, ya'ni content_uz/kr/ru/en/tr ustunlarini
 * ham qaytaradi. Ba'zi maqolalar ichida rasmlar `data:` URI ko'rinishida yotadi
 * va bitta post o'nlab megabaytga yetadi — sitemap uchun uni tortish bema'nilik.
 * Shuning uchun bu yerda faqat kerakli to'rt maydon tanlanadi.
 */
class SitemapController extends Controller
{
    public function index(): JsonResponse
    {
        // publish_date bazada 'Y-m-d H:i:s' MATN sifatida yotadi (datetime emas).
        // Shu formatda leksikografik taqqoslash xronologik taqqoslash bilan
        // bir xil natija beradi, modeldagi boshqa so'rovlar ham shunday qiladi.
        $now = now()->format('Y-m-d H:i:s');

        $posts = Post::query()
            ->where('status', 1)
            ->where('publish_date', '<=', $now)
            ->orderByDesc('publish_date')
            ->get(['id', 'langs', 'section_ids', 'publish_date', 'is_investigative'])
            ->map(fn (Post $post) => [
                'id' => (int) $post->id,
                // accessor 'uz,ru,en' matnini massivga aylantiradi
                'langs' => array_values(array_filter((array) $post->langs)),
                'sections' => $this->sectionIds($post->getRawOriginal('section_ids')),
                'investigative' => (bool) $post->is_investigative,
                'lastmod' => $this->w3cDate($post->getRawOriginal('publish_date')),
            ])
            ->values();

        return response()->json([
            'success' => true,
            'data' => ['posts' => $posts],
        ]);
    }

    /** section_ids vergul bilan ajratilgan matn: "8" yoki "8,9" -> [8, 9] */
    private function sectionIds(?string $raw): array
    {
        if ($raw === null || trim($raw) === '') {
            return [];
        }

        $ids = array_filter(
            array_map('trim', explode(',', $raw)),
            fn ($value) => $value !== '' && ctype_digit($value)
        );

        return array_values(array_unique(array_map('intval', $ids)));
    }

    /**
     * 'Y-m-d H:i:s' -> '2025-10-03T20:54:28+05:00'.
     *
     * lastmod uchun ataylab publish_date olinadi, updated_at emas: postni
     * o'qish views_count ni oshiradi (HomeController), ya'ni updated_at
     * tahrirni emas, ko'rishni kuzatadi va deyarli har kuni "bugun" bo'lib
     * qoladi. Bunday lastmod qidiruv tizimlari uchun yolg'on signal.
     */
    private function w3cDate(?string $raw): ?string
    {
        if (! $raw) {
            return null;
        }

        try {
            return Carbon::parse($raw, config('app.timezone'))->toW3cString();
        } catch (Throwable) {
            return null;
        }
    }
}
