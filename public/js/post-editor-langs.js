/**
 * Maqola shaklidagi til tablarini bitta boshqaruvga keltiradi.
 *
 * Sahifada to'rtta alohida tab qatori bor — sarlavha, qisqa xabar, asosiy
 * matn va rasm izohi — va har biri mustaqil ishlaydi. Tilni almashtirish
 * uchun to'rt joyda bosish kerak, bosilmagani esa eski tilda qolib ketadi.
 * Natijada muharrir ruscha matnni ochib turib o'zbekcha sarlavhani
 * tahrirlashi mumkin, buni esa sezmaydi.
 *
 * Qatorlardagi tillar bir xil va bir xil tartibda, shuning uchun id larni
 * tahlil qilmaymiz: qaysi qatorda nechanchi tab bosilgan bo'lsa, qolgan
 * qatorlarda ham o'shanchanchisi ochiladi.
 *
 * Ikkinchidan, har bir til yonida nuqta turadi: shu tilda sarlavha ham,
 * matn ham bormi. Aynan shu ikkisi maqolaning saytda o'sha tilda
 * ko'rinishini hal qiladi (PostLocales), ya'ni nuqta "bu til chiqadi"
 * degan ma'noni beradi.
 */
(function (global) {
    'use strict';

    var $ = global.jQuery;

    if (!$) {
        return;
    }

    var FILLED = '#28a745';
    var EMPTY = '#ced4da';

    function editorCode(field) {
        if (!field.length) {
            return '';
        }

        return field.data('summernote') ? field.summernote('code') : (field.val() || '');
    }

    /**
     * Matn bo'shmi? Summernote bo'sh muharrir uchun ham <p><br></p> qaytaradi,
     * shuning uchun teglarni emas, mazmunni tekshiramiz. Faqat rasmdan iborat
     * matn ham to'ldirilgan hisoblanadi.
     */
    function hasBody(html) {
        var box = $('<div>').html(html || '');
        var text = box.text().replace(/[\s ]+/g, '');

        return text !== '' || box.find('img, iframe, video').length > 0;
    }

    $(function () {
        var form = $('#postUpdateForm, #postCreateForm').first();
        var locales = global.postLocales || [];

        if (!form.length || !locales.length) {
            return;
        }

        var strips = form.find('.nav-tabs');

        if (!strips.length) {
            return;
        }

        // --- Tillarni birga almashtirish ---
        form.on('click', '.nav-tabs a', function (e) {
            e.preventDefault();

            var index = $(this).closest('.nav-tabs').find('a').index(this);

            if (index < 0) {
                return;
            }

            form.find('.nav-tabs').each(function () {
                var target = $(this).find('a').eq(index);

                if (target.length) {
                    target.tab('show');
                }
            });
        });

        // --- Har bir til uchun holat nuqtasi ---
        function dot(link) {
            var mark = link.find('.post-lang-dot');

            if (!mark.length) {
                mark = $('<span>', { 'class': 'post-lang-dot' })
                    .css({ marginLeft: '6px', fontSize: '11px', lineHeight: '1' })
                    .appendTo(link);
            }

            return mark;
        }

        function refresh() {
            form.find('.nav-tabs').each(function () {
                var links = $(this).find('a');

                links.each(function (index) {
                    var locale = locales[index];

                    if (!locale) {
                        return;
                    }

                    var title = (form.find('[name="title_' + locale + '"]').val() || '').trim();
                    var body = hasBody(editorCode(form.find('[name="content_' + locale + '"]')));
                    var ready = title !== '' && body;

                    dot($(this))
                        .text(ready ? '●' : '○')
                        .css('color', ready ? FILLED : EMPTY)
                        .attr('title', ready
                            ? locale.toUpperCase() + ': saytda chiqadi'
                            : locale.toUpperCase() + ': sarlavha yoki matn to\'ldirilmagan');
                });
            });
        }

        refresh();

        form.on('input change', 'input[name^="title_"]', refresh);
        form.find('.summernote').on('summernote.change', refresh);
    });
}(window));
