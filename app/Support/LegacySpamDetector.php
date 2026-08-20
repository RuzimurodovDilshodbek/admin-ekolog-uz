<?php

namespace App\Support;

/**
 * Eski saytga hujumchi tomonidan qo'shilgan qimor/kazino SEO-spam postlarini
 * aniqlaydi.
 *
 * Qoida (ehtiyotkor - noto'g'ri belgilashdan qochadi):
 *   1. Sarlavha yoki kontentda kirill harflari bo'lsa  -> spam EMAS
 *   2. O'zbekcha belgilar/so'zlar bo'lsa               -> spam EMAS
 *   3. Qimor kalit so'zlari bo'lsa                     -> SPAM
 *   4. Hujum oynasida (2025-10-27..31) yozilgan bo'lsa -> SPAM
 *
 * 1096 ta post ustida sinaldi: 116 ta spam topildi, noto'g'ri belgilash 0 ta.
 */
class LegacySpamDetector
{
    private const CYRILLIC = '/[\x{0400}-\x{04FF}]/u';

    private const UZBEK_MARKERS = "/[\x{02BB}\x{02BC}\x{2018}\x{2019}]|\b(va|uchun|bilan|haqida|yoki|hamda|ham|boshlandi|qilish|etish|qilindi|etildi|muammo\w*|yilda|yilgi|ekolog\w*|tabiat\w*|chiqindi\w*|suv\w*|daraxt\w*|hayvon\w*|ilon|o'\w+)\b/iu";

    private const GAMBLING = "/(casino|casin\x{f2}|casinos|kasino|bisca|\bbet\b|\bbets\b|betting|22bet|1xbet|bet365|bookmaker|sportsbook|wager|gambl\w*|\bslots?\b|\bspins?\b|jackpot|roulette|blackjack|poker|scommess\w*|azzardo|puntare|gratifica|machine \x{e0} sous|paris sportifs|freispiel|spielautomat|spielbank|apuestas|payout|no-deposit|free spins|\bodds\b|punter|esports|grand prix|verstappen|premier league|bitstarz|interac|viagra|cialis|escort|payday loan)/iu";

    public function isSpam(?string $title, ?string $content, ?string $date): bool
    {
        $title   = trim((string) $title);
        $content = (string) $content;
        $probe   = $title !== '' ? $title : mb_substr($content, 0, 600);

        if (preg_match(self::CYRILLIC, $probe)) {
            return false;
        }

        if (preg_match(self::UZBEK_MARKERS, $probe)) {
            return false;
        }

        if (preg_match(self::GAMBLING, $title) || preg_match(self::GAMBLING, mb_substr($content, 0, 2000))) {
            return true;
        }

        $date = (string) $date;
        $from = config('legacy.spam.window_start');
        $to   = config('legacy.spam.window_end');

        return $date >= $from && $date < $to;
    }
}
