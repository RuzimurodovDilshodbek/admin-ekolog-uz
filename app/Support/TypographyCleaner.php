<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

/**
 * Word / Google Docs'dan nusxa ko'chirilgan matndagi shrift uslublarini
 * tozalaydi, matnning o'zi va ma'noli belgilashni saqlab qoladi.
 *
 * OLIB TASHLANADI: font-family, font-size, line-height, letter-spacing,
 *                  word-spacing, font, mso-*, MsoNormal kabi klasslar,
 *                  <font> tegi, Word'ning <o:p> teglari.
 * SAQLANADI:       matn, <b>/<i>/<u>, ro'yxatlar, havolalar, rasmlar,
 *                  jadvallar, font-weight, va sozlamaga qarab color/text-align.
 */
class TypographyCleaner
{
    /** style ichidan har doim olib tashlanadigan xossalar */
    private const DROP_PROPS = [
        'font', 'font-family', 'font-size', 'font-size-adjust', 'font-stretch',
        'font-variant', 'line-height', 'letter-spacing', 'word-spacing',
        'text-autospace', 'tab-stops', 'text-indent', 'text-justify',
    ];

    /** ichidagisi bilan birga o'chiriladigan Word teglari */
    private const DROP_TAGS = ['o:p', 'w:sdt', 'v:shapetype', 'v:shape', 'xml'];

    private array $stats = [];

    public function __construct(
        private bool $stripColor = false,
        private bool $stripAlign = false,
    ) {
    }

    /** @return array{html:string,changed:bool,removed:array<string,int>} */
    public function clean(?string $html): array
    {
        $this->stats = [];
        $html = (string) $html;

        if (trim($html) === '') {
            return ['html' => $html, 'changed' => false, 'removed' => []];
        }

        $doc = new DOMDocument('1.0', 'UTF-8');
        $prev = libxml_use_internal_errors(true);

        $loaded = $doc->loadHTML(
            '<?xml encoding="UTF-8"?><div id="__root__">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET
        );

        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        if (! $loaded) {
            return ['html' => $html, 'changed' => false, 'removed' => ['tahlil_qilinmadi' => 1]];
        }

        $xpath = new DOMXPath($doc);
        $root  = $xpath->query('//div[@id="__root__"]')->item(0) ?? $doc->documentElement;

        $this->dropWordTags($doc);
        $this->unwrapFontTags($doc);
        $this->cleanElement($root);
        $this->unwrapBareSpans($root);

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }

        $out = $this->tidy($out);

        return [
            'html'    => $out,
            'changed' => $this->normalize($out) !== $this->normalize($html),
            'removed' => $this->stats,
        ];
    }

    private function count(string $key): void
    {
        $this->stats[$key] = ($this->stats[$key] ?? 0) + 1;
    }

    private function dropWordTags(DOMDocument $doc): void
    {
        foreach (self::DROP_TAGS as $tag) {
            foreach (iterator_to_array($doc->getElementsByTagName($tag)) as $node) {
                $node->parentNode?->removeChild($node);
                $this->count('word_tegi');
            }
        }
    }

    /** <font face size color> -> yo'qotiladi, color saqlanadi */
    private function unwrapFontTags(DOMDocument $doc): void
    {
        foreach (iterator_to_array($doc->getElementsByTagName('font')) as $font) {
            /** @var DOMElement $font */
            $color = $font->getAttribute('color');
            $parent = $font->parentNode;
            if (! $parent) {
                continue;
            }

            if ($color !== '' && ! $this->stripColor) {
                $span = $doc->createElement('span');
                $span->setAttribute('style', 'color: ' . $color);
                while ($font->firstChild) {
                    $span->appendChild($font->firstChild);
                }
                $parent->replaceChild($span, $font);
            } else {
                while ($font->firstChild) {
                    $parent->insertBefore($font->firstChild, $font);
                }
                $parent->removeChild($font);
            }

            $this->count('font_tegi');
        }
    }

    private function cleanElement(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            /** @var DOMElement $child */
            $this->cleanStyle($child);
            $this->cleanClass($child);

            // Word ba'zan <p align="justify"> qo'yadi
            if ($this->stripAlign && $child->hasAttribute('align')) {
                $child->removeAttribute('align');
                $this->count('align_atributi');
            }

            $this->cleanElement($child);
        }
    }

    private function cleanStyle(DOMElement $el): void
    {
        if (! $el->hasAttribute('style')) {
            return;
        }

        $kept = [];
        foreach (explode(';', $el->getAttribute('style')) as $decl) {
            if (trim($decl) === '') {
                continue;
            }

            $parts = explode(':', $decl, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $prop = strtolower(trim($parts[0]));
            $val  = trim($parts[1]);

            if (in_array($prop, self::DROP_PROPS, true) || str_starts_with($prop, 'mso-')) {
                $this->count($prop === 'font-size' || $prop === 'font-family' || $prop === 'line-height'
                    ? $prop
                    : 'boshqa_uslub');
                continue;
            }

            if ($this->stripColor && in_array($prop, ['color', 'background', 'background-color'], true)) {
                $this->count('rang');
                continue;
            }

            if ($this->stripAlign && $prop === 'text-align') {
                $this->count('text-align');
                continue;
            }

            $kept[] = $prop . ': ' . $val;
        }

        if ($kept) {
            $el->setAttribute('style', implode('; ', $kept));
        } else {
            $el->removeAttribute('style');
        }
    }

    private function cleanClass(DOMElement $el): void
    {
        if (! $el->hasAttribute('class')) {
            return;
        }

        $kept = array_filter(
            preg_split('/\s+/', trim($el->getAttribute('class'))) ?: [],
            fn ($c) => $c !== '' && ! preg_match('/^(Mso|Xl|Char)/i', $c)
        );

        if (count($kept) !== count(preg_split('/\s+/', trim($el->getAttribute('class'))) ?: [])) {
            $this->count('word_klassi');
        }

        if ($kept) {
            $el->setAttribute('class', implode(' ', $kept));
        } else {
            $el->removeAttribute('class');
        }
    }

    /** Atributsiz qolgan <span>larni yo'qotadi (matn saqlanadi) */
    private function unwrapBareSpans(DOMNode $node): void
    {
        foreach (iterator_to_array($node->childNodes) as $child) {
            if ($child->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            /** @var DOMElement $child */
            $this->unwrapBareSpans($child);

            if (strtolower($child->nodeName) === 'span' && $child->attributes->length === 0) {
                $parent = $child->parentNode;
                while ($child->firstChild) {
                    $parent->insertBefore($child->firstChild, $child);
                }
                $parent->removeChild($child);
                $this->count('bosh_span');
            }
        }
    }

    /** Ortiqcha bo'shliqlarni yig'ishtiradi */
    private function tidy(string $html): string
    {
        $html = preg_replace('/<p([^>]*)>(\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $html) ?? $html;

        return trim($html);
    }

    private function normalize(string $html): string
    {
        return preg_replace('/\s+/', ' ', $html) ?? $html;
    }
}
