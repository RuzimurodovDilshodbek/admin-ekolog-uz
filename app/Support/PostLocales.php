<?php

namespace App\Support;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Post qaysi tillarda haqiqatan mavjudligini aniqlaydi.
 *
 * `posts.langs` ustuniga ishonib bo'lmaydi: u muharrir tanlagan niyatni
 * saqlaydi, haqiqiy holatni emas — 141 post o'zini ruscha deb e'lon qiladi,
 * aslida ruscha sarlavhasi bori 109 ta. HomeController esa title_{til} bo'sh
 * bo'lsa 404 qaytaradi, ya'ni yo'q tarjimaga havola qilish kraulerni ham,
 * o'quvchini ham boshi berk ko'chaga yuboradi.
 *
 * Bu yagona manba: sitemap ham, maqola sahifasining hreflang teglari ham shu
 * yerdan foydalanadi. Ilgari ular bir-biriga zid gapirardi — sitemap bitta
 * tilni ko'rsatsa, sahifa uchtasini e'lon qilardi.
 *
 * Shart bazaning o'zida bajariladi: content_* ustunlari o'nlab megabayt
 * bo'lishi mumkin, shuning uchun ular uzatilmaydi, faqat 1/0 qaytadi.
 */
final class PostLocales
{
    /** Bazadagi til ustunlari. Qaysilari saytda ko'rsatilishini front hal qiladi. */
    public const LOCALES = ['uz', 'kr', 'ru', 'en'];

    /** So'rov select'iga qo'shiladigan "tarjima bormi" ifodalari */
    public static function selectExpressions(): array
    {
        return array_map(
            fn (string $locale) => DB::raw(
                "(TRIM(COALESCE(title_{$locale}, '')) <> '' AND COALESCE(content_{$locale}, '') <> '') AS has_{$locale}"
            ),
            self::LOCALES
        );
    }

    /** selectExpressions() bilan olingan qatordan tillar ro'yxatini yig'adi */
    public static function fromRow(Model $row): array
    {
        return array_values(array_filter(
            self::LOCALES,
            fn (string $locale) => (bool) $row->getAttribute("has_{$locale}")
        ));
    }

    /** Bitta post uchun alohida yengil so'rov */
    public static function forPost(int $postId): array
    {
        $row = Post::query()->whereKey($postId)->first(self::selectExpressions());

        return $row ? self::fromRow($row) : [];
    }
}
