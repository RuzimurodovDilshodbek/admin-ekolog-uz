/**
 * Maqola shaklini brauzer xotirasida qoralama sifatida saqlab boradi.
 *
 * Maqola to'rtta tilda yoziladi va bir o'tirishda bir necha soat ketishi
 * mumkin. Shu vaqt ichida sessiya tugashi, brauzer yopilishi yoki sahifa
 * tasodifan yangilanishi mumkin — hozir bularning har biri yozilgan hamma
 * narsani olib ketadi.
 *
 * Qoralama ataylab serverga emas, localStorage'ga yoziladi. Yo'qolishning
 * eng ko'p uchraydigan sababi — sessiyaning tugashi, o'sha paytda esa
 * serverga saqlash ham ishlamaydi (401 qaytaradi). Brauzer xotirasi aynan
 * shu holatda omon qoladi. Bazaga ham, server kodiga ham tegilmaydi.
 *
 * Qoralama shakl yuborilganda o'chiriladi. Server tekshiruvdan o'tkazmay
 * qaytarsa ham ma'lumot yo'qolmaydi — Laravel old() orqali qaytaradi.
 */
(function (global) {
    'use strict';

    var $ = global.jQuery;

    if (!$) {
        return;
    }

    var PREFIX = 'ekolog:post-draft:';
    var PERIOD = 10000;
    var SETTLE = 1500;

    /** _token va _method qoralamaga kirmaydi: ular sahifa bilan keladi. */
    var SKIP = ['_token', '_method'];

    function storage() {
        try {
            var probe = PREFIX + 'probe';
            global.localStorage.setItem(probe, '1');
            global.localStorage.removeItem(probe);

            return global.localStorage;
        } catch (e) {
            // Maxfiy oyna yoki o'chirilgan xotira — qoralamasiz ishlayveramiz.
            return null;
        }
    }

    /**
     * Fayl va yashirin maydonlar tashlab ketiladi: image_base64 ichida
     * qirqilgan muqova base64 bo'lib yotadi va u localStorage'ning ~5 MB
     * chegarasini bitta o'zi to'ldirib qo'yishi mumkin.
     */
    function fields(form) {
        return form.find('input, select, textarea').filter(function () {
            var el = $(this);
            var name = el.attr('name');

            if (!name || SKIP.indexOf(name) >= 0) {
                return false;
            }

            var type = (el.attr('type') || '').toLowerCase();

            return type !== 'file' && type !== 'hidden';
        });
    }

    function isEditor(el) {
        return el.hasClass('summernote') && !!el.data('summernote');
    }

    function read(form) {
        var data = {};

        fields(form).each(function () {
            var el = $(this);
            var name = el.attr('name');
            var type = (el.attr('type') || '').toLowerCase();

            if (type === 'checkbox') {
                data[name] = el.prop('checked');
            } else if (type === 'radio') {
                if (el.prop('checked')) {
                    data[name] = el.val();
                }
            } else if (isEditor(el)) {
                // Matn muharrir ichida turadi, textarea'da emas.
                data[name] = el.summernote('code');
            } else {
                data[name] = el.val();
            }
        });

        return data;
    }

    function write(form, data) {
        fields(form).each(function () {
            var el = $(this);
            var name = el.attr('name');
            var type = (el.attr('type') || '').toLowerCase();

            if (!Object.prototype.hasOwnProperty.call(data, name)) {
                return;
            }

            if (type === 'checkbox') {
                el.prop('checked', !!data[name]);
            } else if (type === 'radio') {
                el.prop('checked', el.val() === data[name]);
            } else if (isEditor(el)) {
                el.summernote('code', data[name] || '');
            } else {
                el.val(data[name]);

                if (el.hasClass('select2')) {
                    el.trigger('change');
                }
            }
        });
    }

    function when(stamp) {
        var d = new Date(stamp);
        var pad = function (n) {
            return (n < 10 ? '0' : '') + n;
        };

        return pad(d.getHours()) + ':' + pad(d.getMinutes()) + ', ' +
            pad(d.getDate()) + '.' + pad(d.getMonth() + 1) + '.' + d.getFullYear();
    }

    function banner(form, draft, onRestore, onDiscard) {
        var box = $('<div>', {
            'class': 'alert alert-warning d-flex align-items-center justify-content-between',
            role: 'alert'
        });

        var text = $('<span>').text('Saqlanmagan qoralama topildi (' + when(draft.savedAt) + '). Tiklansinmi?');
        var restore = $('<button>', { type: 'button', 'class': 'btn btn-sm btn-primary mr-2' }).text('Tiklash');
        var discard = $('<button>', { type: 'button', 'class': 'btn btn-sm btn-outline-secondary' }).text('O‘chirish');

        restore.on('click', function () {
            onRestore();
            box.remove();
        });

        discard.on('click', function () {
            onDiscard();
            box.remove();
        });

        box.append(text, $('<span>').append(restore, discard));
        form.prepend(box);
    }

    $(function () {
        var form = $('#postUpdateForm, #postCreateForm').first();
        var store = storage();

        if (!form.length || !store) {
            return;
        }

        var key = PREFIX + form.attr('id') + ':' + (global.postDraftId || 0);
        var baseline = JSON.stringify(read(form));
        var submitting = false;
        var timer = null;

        function dirty() {
            return JSON.stringify(read(form)) !== baseline;
        }

        function save() {
            var current = read(form);

            if (JSON.stringify(current) === baseline) {
                // Sahifadagidan farq yo'q — saqlashning hojati ham yo'q.
                store.removeItem(key);

                return;
            }

            try {
                store.setItem(key, JSON.stringify({ savedAt: Date.now(), fields: current }));
            } catch (e) {
                // Joy tugadi. Qoralamasiz davom etamiz, ish to'xtamasin.
            }
        }

        // --- topilgan qoralamani taklif qilish ---
        var stored = store.getItem(key);

        if (stored) {
            try {
                var draft = JSON.parse(stored);

                if (draft && draft.fields && JSON.stringify(draft.fields) !== baseline) {
                    banner(form, draft, function () {
                        write(form, draft.fields);
                    }, function () {
                        store.removeItem(key);
                    });
                } else {
                    store.removeItem(key);
                }
            } catch (e) {
                store.removeItem(key);
            }
        }

        // --- saqlab borish ---
        function schedule() {
            global.clearTimeout(timer);
            timer = global.setTimeout(save, SETTLE);
        }

        form.on('input change', schedule);
        form.find('.summernote').on('summernote.change', schedule);
        global.setInterval(save, PERIOD);

        // --- yuborilganda tozalash ---
        form.on('submit', function () {
            submitting = true;
            store.removeItem(key);
        });

        // --- saqlamay chiqib ketishdan ogohlantirish ---
        global.addEventListener('beforeunload', function (e) {
            if (submitting || !dirty()) {
                return;
            }

            e.preventDefault();
            e.returnValue = '';
        });
    });
}(window));
