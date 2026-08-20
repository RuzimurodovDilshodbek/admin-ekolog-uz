/**
 * Summernote uchun "toza joylashtirish".
 *
 * Word, Google Docs va boshqa saytlardan nusxa ko'chirilgan matn o'zi bilan
 * font-size / font-family / line-height olib keladi. Natijada bitta maqola
 * ichida bir nechta shrift va o'lcham aralashib ketadi ("tepasi yirik,
 * pasti mayda"). Bu fayl shu uslublarni joylashtirish paytidayoq olib
 * tashlaydi, matn va ma'noli belgilashni esa saqlab qoladi.
 *
 * Hech qanday sozlash talab qilmaydi: Summernote'ning standart
 * callback'iga ulanadi, shuning uchun barcha muharrirlarga ta'sir qiladi.
 */
(function ($) {
    'use strict';

    if (!$ || !$.summernote) {
        return;
    }

    // style ichidan olib tashlanadigan xossalar
    var DROP = /^(font|font-family|font-size|font-size-adjust|font-stretch|font-variant|line-height|letter-spacing|word-spacing|text-autospace|tab-stops|text-indent|text-justify)$/;

    // butunlay o'chiriladigan teglar
    var KILL = 'script, style, meta, link, o\\:p, w\\:sdt, xml, v\\:shapetype, v\\:shape';

    function cleanStyle(el) {
        if (!el.hasAttribute('style')) {
            return;
        }

        var kept = [];
        el.getAttribute('style').split(';').forEach(function (decl) {
            var i = decl.indexOf(':');
            if (i < 0) {
                return;
            }
            var prop = decl.slice(0, i).trim().toLowerCase();
            var val = decl.slice(i + 1).trim();
            if (!prop || !val || DROP.test(prop) || prop.indexOf('mso-') === 0) {
                return;
            }
            kept.push(prop + ': ' + val);
        });

        if (kept.length) {
            el.setAttribute('style', kept.join('; '));
        } else {
            el.removeAttribute('style');
        }
    }

    function cleanClass(el) {
        if (!el.hasAttribute('class')) {
            return;
        }

        var kept = el.getAttribute('class').split(/\s+/).filter(function (c) {
            return c && !/^(Mso|Xl|Char|pw-)/i.test(c);
        });

        if (kept.length) {
            el.setAttribute('class', kept.join(' '));
        } else {
            el.removeAttribute('class');
        }
    }

    function cleanHtml(html) {
        var doc = new DOMParser().parseFromString(html, 'text/html');

        doc.querySelectorAll(KILL).forEach(function (n) {
            n.remove();
        });

        // <font face size color> -> span (rang saqlanadi)
        doc.querySelectorAll('font').forEach(function (f) {
            var color = f.getAttribute('color');
            var repl;
            if (color) {
                repl = doc.createElement('span');
                repl.style.color = color;
            } else {
                repl = doc.createDocumentFragment();
            }
            while (f.firstChild) {
                repl.appendChild(f.firstChild);
            }
            f.parentNode.replaceChild(repl, f);
        });

        doc.body.querySelectorAll('*').forEach(function (el) {
            cleanStyle(el);
            cleanClass(el);
            el.removeAttribute('lang');
            el.removeAttribute('data-testid');
            el.removeAttribute('data-selectable-paragraph');
        });

        // atributsiz qolgan <span>larni yo'qotamiz
        doc.body.querySelectorAll('span').forEach(function (s) {
            if (s.attributes.length === 0) {
                while (s.firstChild) {
                    s.parentNode.insertBefore(s.firstChild, s);
                }
                s.remove();
            }
        });

        return doc.body.innerHTML;
    }

    $.extend($.summernote.options.callbacks, {
        onPaste: function (e) {
            var ev = e.originalEvent || e;
            var cd = ev.clipboardData || window.clipboardData;
            if (!cd) {
                return; // clipboard'ga kira olmasak, standart xatti-harakat
            }

            var html = cd.getData('text/html');
            var text = cd.getData('text/plain');

            if (!html && !text) {
                return;
            }

            e.preventDefault();

            var $note = $(this);
            if (html) {
                $note.summernote('pasteHTML', cleanHtml(html));
            } else {
                $note.summernote('insertText', text);
            }
        }
    });

    // Boshqa skriptlar ham foydalanishi uchun
    window.cleanPastedHtml = cleanHtml;
})(window.jQuery);
