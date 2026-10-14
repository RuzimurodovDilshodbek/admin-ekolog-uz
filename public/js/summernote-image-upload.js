/**
 * Summernote'dagi rasm tugmasini serverga ulaydi.
 *
 * Summernote onImageUpload ulagichi bo'lmasa rasmni serverga yubormaydi —
 * uni matn ichiga data:image/...;base64 ko'rinishida yopishtirib qo'yadi
 * (summernote-bs4.js: insertImagesAsDataURL). Oqibati:
 *
 *   - yozish paytida maqola HTML'i bir necha megabaytga shishadi va
 *     muharrir oynasi sekinlashadi;
 *   - saqlash so'rovi ham o'sha hajmda ketadi, ya'ni post_max_size ga
 *     urilib qolish xavfi bor;
 *   - rasm faylga faqat saqlangandan keyin, PostObserver tomonidan
 *     chiqariladi — muharrir yuklash o'tgan-o'tmaganini darhol bilmaydi.
 *
 * Bu yerda rasm tanlangan zahoti storeCKEditorImages'ga yuboriladi. O'sha
 * yo'l EditorImage orqali rasmni 1600px gacha siqadi va ck-media to'plamiga
 * yozadi, demak matndagi rasm ContentImages qo'shadigan srcset'ga ham
 * o'z-o'zidan tushadi.
 *
 * Sozlama blade'dan window.summernoteUpload orqali beriladi. U bo'lmasa
 * fayl hech narsani o'zgartirmaydi — Summernote eski xatti-harakatida
 * qolaveradi.
 */
(function (global) {
    'use strict';

    var $ = global.jQuery;

    if (!$ || !$.summernote) {
        return;
    }

    function csrfToken() {
        var meta = global.document.querySelector('meta[name="csrf-token"]');

        return meta ? meta.getAttribute('content') : '';
    }

    /** Bitta faylni yuklaydi. Natija — {id, url} bilan bajariladigan va'da. */
    function send(file, settings) {
        return new Promise(function (resolve, reject) {
            var data = new FormData();
            data.append('upload', file);
            data.append('crud_id', settings.crudId || 0);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', settings.url, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken());
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.responseType = 'json';

            xhr.addEventListener('load', function () {
                var response = xhr.response;

                if (xhr.status !== 201 || !response || !response.url) {
                    reject(new Error(
                        (response && response.message)
                            ? response.message
                            : (xhr.status + ' ' + xhr.statusText)
                    ));

                    return;
                }

                resolve(response);
            });

            xhr.addEventListener('error', function () {
                reject(new Error('tarmoq xatosi'));
            });

            xhr.addEventListener('abort', function () {
                reject(new Error('bekor qilindi'));
            });

            xhr.send(data);
        });
    }

    /**
     * Yangi maqolada rasm crud_id=0 bilan yuklanadi, ya'ni hali hech qaysi
     * maqolaga biriktirilmagan. PostController@store shu yashirin maydonlar
     * orqali ularni yangi maqolaga bog'laydi.
     */
    function remember(id, note) {
        var form = note.closest('form');

        if (!form.length) {
            form = $('#postCreateForm, #postUpdateForm').first();
        }

        if (!form.length) {
            return;
        }

        $('<input>', {
            type: 'hidden',
            name: 'ck-media[]',
            value: id
        }).appendTo(form);
    }

    $.extend($.summernote.options.callbacks, {
        onImageUpload: function (files) {
            var settings = global.summernoteUpload;
            var note = $(this);

            if (!settings || !settings.url) {
                // Sozlama berilmagan — Summernote'ning odatiy yo'li.
                note.summernote('insertImagesAsDataURL', files);

                return;
            }

            // Tanlangan tartibda qo'yilishi uchun ketma-ket yuklaymiz.
            Array.prototype.reduce.call(files, function (chain, file) {
                return chain.then(function () {
                    return send(file, settings)
                        .then(function (response) {
                            remember(response.id, note);
                            note.summernote('insertImage', response.url, file.name);
                        })
                        .catch(function (error) {
                            global.alert(
                                'Rasmni yuklab bo\'lmadi: ' + file.name + '\n\n' + error.message
                            );
                        });
                });
            }, Promise.resolve());
        }
    });
}(window));
