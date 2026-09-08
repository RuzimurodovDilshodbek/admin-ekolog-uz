<?php

namespace App\Support;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Maqola matnidagi <img> teglariga srcset qo'shadi.
 *
 * Matn muharrirda yoziladi, ya'ni u yerda bitta qat'iy manzildan boshqa hech
 * narsa yo'q. Natijada 360px li telefon ham, 27 dyuymli monitor ham bir xil
 * 1600px faylni yuklaydi. Maqola ustuni esa monitorda 788px, telefonda ~360px.
 *
 * srcset shuni hal qiladi: brauzer ekran kengligi va pikselzichligiga qarab
 * o'zi tanlaydi. Amalda 800px li nusxa eng ko'p ishlatiladi — u oddiy
 * monitorni (788px, 1x) ham, telefonni (360px, 2x = 720px) ham qoplaydi.
 *
 * Almashtirish javob qaytarilayotganda bajariladi, saqlangan matn tegilmaydi:
 * post HTML'ini bazada qayta yozish — konversiya nomlari yoki o'lchamlari
 * o'zgarsa, orqaga qaytarib bo'lmaydigan amal.
 */
final class ContentImages
{
    /** Media::getUrl() bilan mos kelishi kerak bo'lgan konversiyalar */
    private const CONVERSIONS = ['w480' => 480, 'w800' => 800];

    /**
     * Maqola ustuni: monitorda 788px, undan pastda deyarli butun ekran.
     * Ba'zi rasmlar yonma-yon (394px) turadi — ular uchun bu qiymat
     * kattaroq, lekin kam olishdan ko'p olish xavfsizroq: kam bo'lsa rasm
     * cho'zilib xiralashadi.
     */
    private const SIZES = '(min-width: 1024px) 800px, 95vw';

    private const IMG_TAG = '/<img\b[^>]*>/i';

    private const SRC_ATTR = '/\bsrc\s*=\s*"([^"]+)"/i';

    /** /storage/415/post-162-en-9-083855.jpg -> 415 */
    private const MEDIA_ID = '#/storage/(\d+)/[^/]+$#';

    public static function addSrcset(?string $html): ?string
    {
        if (! is_string($html) || ! str_contains($html, '<img')) {
            return $html;
        }

        preg_match_all(self::IMG_TAG, $html, $matches);
        $tags = $matches[0] ?? [];

        if (! $tags) {
            return $html;
        }

        // Avval barcha id larni yig'ib, bitta so'rov bilan olamiz
        $ids = [];
        foreach ($tags as $tag) {
            if ($id = self::mediaId($tag)) {
                $ids[$id] = true;
            }
        }

        if (! $ids) {
            return $html;
        }

        $media = Media::query()
            ->whereIn('id', array_keys($ids))
            ->where('collection_name', 'ck-media')
            ->get()
            ->keyBy('id');

        if ($media->isEmpty()) {
            return $html;
        }

        return preg_replace_callback(
            self::IMG_TAG,
            fn (array $m) => self::rewrite($m[0], $media),
            $html
        );
    }

    private static function rewrite(string $tag, $media): string
    {
        // Muharrir o'zi srcset qo'ygan bo'lsa tegmaymiz
        if (stripos($tag, 'srcset') !== false) {
            return $tag;
        }

        $id = self::mediaId($tag);

        if (! $id || ! $media->has($id)) {
            return $tag;
        }

        $item = $media->get($id);
        $candidates = [];

        foreach (self::CONVERSIONS as $name => $width) {
            // Konversiya yaratilmagan bo'lishi mumkin (eski fayl, xatolik)
            if ($item->hasGeneratedConversion($name)) {
                $candidates[] = $item->getUrl($name) . ' ' . $width . 'w';
            }
        }

        if (! $candidates) {
            return $tag;
        }

        // Asl fayl eng katta nomzod. EditorImage uni 1600px gacha tushiradi,
        // shundan kichigi bo'lsa haqiqiy kengligini yozamiz — noto'g'ri
        // deskriptor brauzerni noto'g'ri tanlovga olib keladi.
        $candidates[] = $item->getUrl() . ' ' . self::originalWidth($item) . 'w';

        return preg_replace(
            '/\s*\/?>$/',
            ' srcset="' . implode(', ', $candidates) . '" sizes="' . self::SIZES . '">',
            $tag
        );
    }

    private static function originalWidth(Media $media): int
    {
        $path = $media->getPath();
        $size = is_file($path) ? @getimagesize($path) : false;

        return $size ? (int) $size[0] : EditorImage::MAX_WIDTH;
    }

    private static function mediaId(string $tag): ?int
    {
        if (! preg_match(self::SRC_ATTR, $tag, $src)) {
            return null;
        }

        return preg_match(self::MEDIA_ID, $src[1], $m) ? (int) $m[1] : null;
    }
}
