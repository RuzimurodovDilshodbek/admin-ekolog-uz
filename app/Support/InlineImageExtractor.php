<?php

namespace App\Support;

/**
 * Maqola matnidagi base64 rasmlarni topib, ularni haqiqiy fayllarga chiqaradi.
 *
 * Muharrirlar rasmni Word'dan yoki brauzerdan nusxa ko'chirganda, u matn ichiga
 * `<img src="data:image/jpeg;base64,...">` ko'rinishida tushib qoladi. Natijada
 * rasm maqola matnining bir qismiga aylanadi: u bazada saqlanadi, har so'rovda
 * API orqali uzatiladi, SSR uni HTML'ga yozadi va Nuxt yana bir marta
 * hidratatsiya payload'iga nusxalaydi. O'lchangan holat: bitta maqola 7.96 MB,
 * eng og'iri 73 MB, va sahifaning 98.9% i shu base64 satrlar.
 *
 * DOMDocument ham, `preg_*` ham bu yerda xavfli: bitta data URI 16 MB gacha
 * chiqadi, DOM butun hujjatni xotirada ushlaydi, ochko'z regex esa katastrofik
 * backtracking beradi. Shuning uchun oddiy chiziqli skaner ishlatilgan —
 * xotirasi ham, vaqti ham matn uzunligiga chiziqli bog'liq.
 */
class InlineImageExtractor
{
    /** MIME turidan fayl kengaytmasiga */
    private const EXTENSIONS = [
        'jpeg' => 'jpg',
        'jpg' => 'jpg',
        'png' => 'png',
        'gif' => 'gif',
        'webp' => 'webp',
        'bmp' => 'bmp',
        'svg+xml' => 'svg',
    ];

    private const MARKER = 'data:image/';

    /**
     * @param  callable(string $binary, string $extension, int $index): ?string  $store
     *         Ikkilik ma'lumotni saqlab, URL qaytaradi. null qaytarsa, o'sha
     *         rasm tegilmay qoladi.
     * @return array{html:string,changed:bool,extracted:int,skipped:int,bytes_before:int,bytes_after:int}
     */
    public function extract(?string $html, callable $store): array
    {
        $html = (string) $html;
        $before = strlen($html);

        if ($before === 0 || ! str_contains($html, self::MARKER)) {
            return [
                'html' => $html,
                'changed' => false,
                'extracted' => 0,
                'skipped' => 0,
                'bytes_before' => $before,
                'bytes_after' => $before,
            ];
        }

        $pieces = [];
        $copiedTo = 0;
        $offset = 0;
        $extracted = 0;
        $skipped = 0;

        while (($start = strpos($html, self::MARKER, $offset)) !== false) {
            $bounds = $this->attributeBounds($html, $start);

            if ($bounds === null) {
                // Atribut chegarasini aniqlay olmadik (tirnoqsiz atribut yoki
                // buzuq HTML) — tegmay o'tamiz, buzilgan URI qoldirgandan ko'ra.
                $skipped++;
                $offset = $start + strlen(self::MARKER);
                continue;
            }

            [$valueStart, $valueEnd] = $bounds;
            $uri = substr($html, $valueStart, $valueEnd - $valueStart);
            $replacement = $this->convert($uri, $store, $extracted);

            if ($replacement === null) {
                $skipped++;
                $offset = $valueEnd;
                continue;
            }

            $pieces[] = substr($html, $copiedTo, $valueStart - $copiedTo);
            $pieces[] = $replacement;
            $copiedTo = $valueEnd;
            $offset = $valueEnd;
            $extracted++;
        }

        if ($extracted === 0) {
            return [
                'html' => $html,
                'changed' => false,
                'extracted' => 0,
                'skipped' => $skipped,
                'bytes_before' => $before,
                'bytes_after' => $before,
            ];
        }

        $pieces[] = substr($html, $copiedTo);
        $result = implode('', $pieces);

        return [
            'html' => $result,
            'changed' => true,
            'extracted' => $extracted,
            'skipped' => $skipped,
            'bytes_before' => $before,
            'bytes_after' => strlen($result),
        ];
    }

    /**
     * Matnda `data:image/` topilgan joydan atribut qiymatining boshi va oxirini
     * aniqlaydi. Ochuvchi tirnoq orqaga qarab, yopuvchisi oldinga qarab
     * qidiriladi — base64 ichida tirnoq bo'lmagani uchun bu ishonchli.
     *
     * @return array{0:int,1:int}|null
     */
    private function attributeBounds(string $html, int $markerStart): ?array
    {
        // Ochuvchi tirnoq marker'dan bir necha belgi oldinda bo'ladi
        // (`src="data:image/...`), shuning uchun uzoqqa qaramaymiz.
        $lookBehind = max(0, $markerStart - 4);
        $prefix = substr($html, $lookBehind, $markerStart - $lookBehind);

        $quotePos = max(strrpos($prefix, '"'), strrpos($prefix, "'"));

        if ($quotePos === false) {
            return null;
        }

        $quote = $prefix[$quotePos];
        $valueStart = $lookBehind + $quotePos + 1;

        if ($valueStart !== $markerStart) {
            // Tirnoq bilan `data:` orasida boshqa narsa bor — bu biz kutgan
            // shakl emas.
            return null;
        }

        $valueEnd = strpos($html, $quote, $markerStart);

        return $valueEnd === false ? null : [$valueStart, $valueEnd];
    }

    /**
     * Bitta data URI ni saqlangan faylning URL'iga aylantiradi.
     *
     * @param  callable(string $binary, string $extension, int $index): ?string  $store
     */
    private function convert(string $uri, callable $store, int $index): ?string
    {
        $comma = strpos($uri, ',');

        if ($comma === false) {
            return null;
        }

        $header = substr($uri, 0, $comma);

        if (! str_contains($header, 'base64')) {
            // `data:image/svg+xml,<svg .../>` kabi kodlanmagan shakl — bular
            // odatda kichik va zarar qilmaydi.
            return null;
        }

        $mime = substr($header, strlen(self::MARKER));
        $mime = strtolower(strtok($mime, ';') ?: '');
        $extension = self::EXTENSIONS[$mime] ?? null;

        if ($extension === null) {
            return null;
        }

        $payload = substr($uri, $comma + 1);
        // Ba'zi muharrirlar base64 ni qatorlarga bo'lib yozadi.
        $payload = preg_replace('/\s+/', '', $payload) ?? $payload;
        $binary = base64_decode($payload, true);

        if ($binary === false || $binary === '') {
            return null;
        }

        $url = $store($binary, $extension, $index);

        return $url === null ? null : htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8', false);
    }
}
