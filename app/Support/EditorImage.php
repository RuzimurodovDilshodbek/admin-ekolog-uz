<?php

namespace App\Support;

use Spatie\Image\Image;
use Throwable;

/**
 * Maqola matniga qo'yiladigan rasmlarni o'qishga yaroqli o'lchamga tushiradi.
 *
 * Muharrirlar suratni kameradan yoki telefondan to'g'ridan-to'g'ri tashlaydi —
 * 2560x1920 va undan kattalari odatiy hol. Maqola ustuni esa eng kengi bilan
 * ~800px, ya'ni 2x ekran uchun ham 1600px yetadi. Qolgan piksellar shunchaki
 * yuklab olinadi va tashlab yuboriladi.
 *
 * Ataylab faqat KENGLIK cheklanadi, sifat qayta siqilmaydi: mavjud 199 ta
 * rasmning 173 tasi allaqachon yaxshi siqilgan (0.5 bayt/pikseldan kam), ularni
 * qayta kodlash sifatni yo'qotib, hajmga deyarli ta'sir qilmasdi.
 *
 * Format o'zgarmaydi. PNG ni JPEG ga aylantirish fayl nomini o'zgartirar,
 * post matnidagi havolalar esa eski nomga ishora qilib turibdi.
 */
final class EditorImage
{
    public const MAX_WIDTH = 1600;

    public const QUALITY = 82;

    /** Sifat faqat shu formatlar uchun ma'noga ega */
    private const LOSSY = ['image/jpeg', 'image/webp'];

    /**
     * @return array{changed: bool, before: int, after: int, width_before: int, width_after: int, error: ?string}
     */
    public static function shrink(string $path, int $maxWidth = self::MAX_WIDTH, int $quality = self::QUALITY): array
    {
        $result = [
            'changed' => false,
            'before' => 0,
            'after' => 0,
            'width_before' => 0,
            'width_after' => 0,
            'error' => null,
        ];

        if (! is_file($path)) {
            return $result + ['error' => 'fayl yo\'q'];
        }

        $info = @getimagesize($path);

        if (! $info) {
            // SVG, PDF yoki buzilgan fayl — tegmaymiz
            return $result;
        }

        $result['before'] = $result['after'] = filesize($path);
        $result['width_before'] = $result['width_after'] = $info[0];

        if ($info[0] <= $maxWidth) {
            return $result;
        }

        $temp = tempnam(sys_get_temp_dir(), 'shrink') . '.' . pathinfo($path, PATHINFO_EXTENSION);

        try {
            $image = Image::load($path)->width($maxWidth);

            if (in_array($info['mime'], self::LOSSY, true)) {
                $image->quality($quality);
            }

            $image->save($temp);
        } catch (Throwable $e) {
            @unlink($temp);

            return $result + ['error' => $e->getMessage()];
        }

        // Kattaroq chiqsa — asl faylni qoldiramiz. Kichraytirish hajmni
        // oshirib qo'yishi kamdan-kam, lekin bo'ladigan hol.
        if (! is_file($temp) || filesize($temp) >= $result['before']) {
            @unlink($temp);

            return $result;
        }

        $result['after'] = filesize($temp);
        $result['width_after'] = $maxWidth;
        $result['changed'] = true;
        $result['temp'] = $temp;

        return $result;
    }

    /** shrink() qaytargan vaqtinchalik faylni joyiga qo'yadi */
    public static function commit(string $path, array $result): bool
    {
        if (! ($result['changed'] ?? false) || ! isset($result['temp'])) {
            return false;
        }

        $ok = @rename($result['temp'], $path);

        if (! $ok) {
            // rename fayl tizimlari orasida ishlamaydi
            $ok = @copy($result['temp'], $path);
            @unlink($result['temp']);
        }

        return (bool) $ok;
    }
}
