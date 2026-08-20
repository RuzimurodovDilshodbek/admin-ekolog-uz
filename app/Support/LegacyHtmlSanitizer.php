<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

/**
 * Eski (buzib kirilgan) ekolog.uz saytidan olingan HTML kontentni tozalaydi.
 *
 * Oq ro'yxat (whitelist) tamoyili: faqat ruxsat etilgan teglar va atributlar
 * qoldiriladi, qolgani o'chiriladi. Bu hujumchi qo'shgan <script> in'ektsiyasini
 * va boshqa har qanday faol kodni butunlay yo'q qiladi.
 */
class LegacyHtmlSanitizer
{
    /** Ichidagi matni bilan birga butunlay o'chiriladigan teglar */
    private const KILL_TAGS = [
        'script', 'style', 'iframe', 'object', 'embed', 'applet', 'form',
        'input', 'button', 'select', 'option', 'textarea', 'link', 'meta',
        'base', 'svg', 'math', 'noscript', 'frame', 'frameset', 'template',
        'audio', 'canvas', 'map', 'area', 'portal',
    ];

    /** Ruxsat etilgan teglar */
    private const ALLOWED_TAGS = [
        'p', 'br', 'hr', 'strong', 'b', 'em', 'i', 'u', 's', 'strike', 'small',
        'sub', 'sup', 'blockquote', 'pre', 'code', 'span', 'div', 'section',
        'article', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li', 'dl', 'dt', 'dd',
        'a', 'img', 'figure', 'figcaption', 'picture', 'video', 'source',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td', 'caption',
        'colgroup', 'col',
    ];

    /** Har bir teg uchun ruxsat etilgan atributlar */
    private const ALLOWED_ATTRS = [
        'a'      => ['href', 'title'],
        'img'    => ['src', 'alt', 'title', 'width', 'height'],
        'video'  => ['src', 'poster', 'width', 'height', 'controls'],
        'source' => ['src', 'type'],
        'td'     => ['colspan', 'rowspan'],
        'th'     => ['colspan', 'rowspan'],
        'col'    => ['span'],
        'colgroup' => ['span'],
    ];

    /** URL uchun ruxsat etilgan sxemalar */
    private const SAFE_SCHEMES = ['http', 'https', 'mailto', 'tel'];

    private int $removedNodes = 0;

    public function removedCount(): int
    {
        return $this->removedNodes;
    }

    public function sanitize(?string $html): string
    {
        $this->removedNodes = 0;

        if ($html === null || trim($html) === '') {
            return '';
        }

        // Himoya uchun: PHP ochilish teglarini matnga aylantiramiz
        $html = str_replace(['<?php', '<?=', '<?', '?>'], '', $html);

        $doc = new DOMDocument('1.0', 'UTF-8');
        $prev = libxml_use_internal_errors(true);

        $loaded = $doc->loadHTML(
            '<?xml encoding="UTF-8"?><div id="__legacy_root__">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET
        );

        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        if (! $loaded) {
            // Tahlil qilib bo'lmasa - butunlay teglarsiz matn qaytaramiz
            $this->removedNodes++;

            return htmlspecialchars(strip_tags($html), ENT_QUOTES, 'UTF-8');
        }

        $xpath = new DOMXPath($doc);

        // 1. Xavfli teglarni ichidagisi bilan o'chirish
        foreach (self::KILL_TAGS as $tag) {
            $nodes = iterator_to_array($doc->getElementsByTagName($tag));
            foreach ($nodes as $node) {
                if ($node->parentNode) {
                    $replacement = $this->replacementFor($node);
                    if ($replacement !== null) {
                        $node->parentNode->replaceChild($replacement, $node);
                    } else {
                        $node->parentNode->removeChild($node);
                    }
                    $this->removedNodes++;
                }
            }
        }

        // 2. HTML izohlarini o'chirish (ichida kod yashiringan bo'lishi mumkin)
        foreach (iterator_to_array($xpath->query('//comment()')) as $comment) {
            $comment->parentNode?->removeChild($comment);
        }

        // 3. Qolgan teglarni oq ro'yxat bo'yicha tekshirish
        $root = $xpath->query('//div[@id="__legacy_root__"]')->item(0) ?? $doc->documentElement;
        $this->cleanNode($root);

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        return trim($out);
    }

    /**
     * O'chirilayotgan tegning o'rniga qo'yiladigan xavfsiz element.
     *
     * Iframe'lar (YouTube video, Datawrapper diagramma va h.k.) oddiy
     * havolaga aylantiriladi: kod bajarilmaydi, lekin manba yo'qolmaydi.
     */
    private function replacementFor(DOMNode $node): ?DOMNode
    {
        if (! $node instanceof DOMElement || strtolower($node->nodeName) !== 'iframe') {
            return null;
        }

        $src = trim($node->getAttribute('src'));
        if ($src === '' || ! preg_match('~^https?://~i', $src) || ! $this->isSafeUrl($src)) {
            return null;
        }

        $isVideo = (bool) preg_match('~(youtube\.com|youtu\.be|vimeo\.com|rutube\.ru|dailymotion\.com)~i', $src);

        $doc = $node->ownerDocument;
        $p = $doc->createElement('p');
        $a = $doc->createElement('a');
        // Matn createTextNode orqali qo'yiladi: manzildagi "&" belgilari
        // createElement()ning ikkinchi argumentida HTML entity deb o'qilib,
        // xatolikka olib keladi.
        $a->appendChild($doc->createTextNode(
            ($isVideo ? 'Video: ' : 'Tashqi kontent: ') . $this->shorten($src)
        ));
        $a->setAttribute('href', $src);
        $p->appendChild($a);

        return $p;
    }

    /** Juda uzun manzillarni ko'rsatish uchun qisqartiradi */
    private function shorten(string $url, int $max = 90): string
    {
        return mb_strlen($url) > $max ? mb_substr($url, 0, $max) . '…' : $url;
    }

    private function cleanNode(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType === XML_TEXT_NODE) {
                continue;
            }

            if ($child->nodeType !== XML_ELEMENT_NODE) {
                $child->parentNode?->removeChild($child);
                continue;
            }

            /** @var DOMElement $child */
            $tag = strtolower($child->nodeName);

            if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                // Teg ruxsat etilmagan: avval ichini tozalab, keyin tegning
                // o'zini olib tashlaymiz (ichidagi matn saqlanadi).
                $this->cleanNode($child);
                $this->unwrap($child);
                $this->removedNodes++;
                continue;
            }

            $this->cleanAttributes($child, $tag);
            $this->cleanNode($child);
        }
    }

    private function cleanAttributes(DOMElement $el, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRS[$tag] ?? [];

        foreach (iterator_to_array($el->attributes) as $attr) {
            $name = strtolower($attr->nodeName);

            if (! in_array($name, $allowed, true)) {
                $el->removeAttribute($attr->nodeName);
                continue;
            }

            if (in_array($name, ['href', 'src', 'poster'], true)
                && ! $this->isSafeUrl($attr->nodeValue)) {
                $el->removeAttribute($attr->nodeName);
            }
        }

        if ($tag === 'a' && $el->hasAttribute('href')) {
            $el->setAttribute('target', '_blank');
            $el->setAttribute('rel', 'noopener noreferrer nofollow');
        }
    }

    private function isSafeUrl(?string $url): bool
    {
        $url = trim((string) $url);

        if ($url === '') {
            return false;
        }

        // Nisbiy manzillar va anchor'lar xavfsiz
        if (str_starts_with($url, '/') || str_starts_with($url, '#') || str_starts_with($url, './')) {
            return true;
        }

        // "javascript:", "data:", "vbscript:" va bo'shliq/nazorat belgilari bilan yashirilganlari
        $normalized = strtolower(preg_replace('/[\s\x00-\x20]+/', '', $url));
        foreach (['javascript:', 'data:', 'vbscript:', 'file:', 'about:'] as $bad) {
            if (str_starts_with($normalized, $bad)) {
                return false;
            }
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);

        if ($scheme === null) {
            return true; // sxemasiz nisbiy manzil
        }

        return in_array(strtolower($scheme), self::SAFE_SCHEMES, true);
    }

    /** Tegni o'chirib, ichidagi tugunlarni o'rniga qo'yadi */
    private function unwrap(DOMElement $el): void
    {
        $parent = $el->parentNode;
        if (! $parent) {
            return;
        }

        while ($el->firstChild) {
            $parent->insertBefore($el->firstChild, $el);
        }

        $parent->removeChild($el);
    }
}
