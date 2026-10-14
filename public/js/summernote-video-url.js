/**
 * Summernote "Video qo'yish" oynasi uchun havola normalizatori.
 *
 * Summernote 0.8.18 YouTube havolasini juda qat'iy qolipga soladi:
 *
 *     //youtu.be/<11 belgi>(?:[?&]t=...)?$
 *
 * Oxiridagi $ sababli video id'dan keyin boshqa hech narsa turolmaydi.
 * YouTube esa 2023 yildan beri "Ulashish -> Havoladan nusxa olish" tugmasi
 * bilan har doim ?si=... qo'shib beradi. Ya'ni muharrir nusxa olgan havola
 * hech qachon qolipga tushmaydi. Shorts, jonli efir va pleylistdan ochilgan
 * video ham boshqa yo'lda turadi.
 *
 * Qolipga tushmasa createVideoNode false qaytaradi, Video.show() esa uni
 * jimgina tashlab ketadi: oyna yopiladi, video qo'yilmaydi, xato ham
 * chiqmaydi. Muharrir tomonidan bu "tugma umuman ishlamaydi" degani.
 *
 * Shuning uchun havolani Summernote o'qishidan oldin kanonik ko'rinishga
 * keltiramiz: https://www.youtube.com/watch?v=<id>[&t=<n>s]
 *
 * Vendor fayliga tegilmaydi — modulning createVideoNode'i o'raladi, demak
 * summernote yangilansa bu fayl o'z-o'zidan ortiqcha bo'lib qoladi, lekin
 * hech narsani buzmaydi.
 */
(function (global) {
    'use strict';

    /* YouTube video id — har doim 11 ta belgi */
    var SOURCES = [
        /youtu\.be\/([\w-]{11})/,
        /youtube(?:-nocookie)?\.com\/(?:watch\?(?:.*&)?v=|embed\/|v\/|shorts\/|live\/)([\w-]{11})/
    ];

    /* ?t=90, ?t=1m30s, &start=90 — YouTube uchalasini ham ishlatadi */
    var TIME = /[?&](?:t|start)=([0-9hms]+)/;

    function seconds(raw) {
        if (/^\d+$/.test(raw)) {
            return parseInt(raw, 10);
        }

        var m = raw.match(/^(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?$/);

        if (!m || !m[0]) {
            return 0;
        }

        return (+(m[1] || 0)) * 3600 + (+(m[2] || 0)) * 60 + (+(m[3] || 0));
    }

    /**
     * YouTube havolasini kanonik ko'rinishga keltiradi.
     * YouTube bo'lmasa havola o'zgarishsiz qaytadi — boshqa manbalarni
     * (Vimeo, Instagram, mp4) Summernote o'zi uddalaydi.
     */
    function normalize(url) {
        if (typeof url !== 'string') {
            return url;
        }

        var trimmed = url.trim();
        var id = null;

        for (var i = 0; i < SOURCES.length; i++) {
            var found = trimmed.match(SOURCES[i]);

            if (found) {
                id = found[1];
                break;
            }
        }

        if (!id) {
            return trimmed;
        }

        var stamp = trimmed.match(TIME);
        var start = stamp ? seconds(stamp[1]) : 0;

        return 'https://www.youtube.com/watch?v=' + id + (start > 0 ? '&t=' + start + 's' : '');
    }

    function patch(context) {
        if (!context || !context.modules || !context.modules.video) {
            return;
        }

        var video = context.modules.video;

        if (video.videoUrlNormalized) {
            return;
        }

        video.videoUrlNormalized = true;

        var create = video.createVideoNode;

        video.createVideoNode = function (url) {
            var node = create.call(this, normalize(url));

            // Summernote tanimagan havolani jimgina tashlab ketadi. Jimlik
            // eng yomon javob: muharrir nima noto'g'ri ekanini bilmaydi.
            if (!node && global.alert) {
                global.alert(
                    'Bu havoladan video aniqlanmadi:\n\n' + url + '\n\n' +
                    'YouTube videosi uchun brauzer manzil qatoridagi to\'liq ' +
                    'havolani yoki "Ulashish" tugmasidan olingan havolani qo\'ying.'
                );
            }

            return node;
        };
    }

    if (typeof module === 'object' && module.exports) {
        module.exports = normalize;
    }

    global.normalizeVideoUrl = normalize;

    var $ = global.jQuery;

    if (!$ || !$.fn || !$.fn.summernote) {
        return;
    }

    // Modul nusxasi faqat initdan keyin paydo bo'ladi, shuning uchun
    // init'ning o'zini o'raymiz.
    var summernote = $.fn.summernote;

    $.fn.summernote = function () {
        var result = summernote.apply(this, arguments);

        this.each(function () {
            patch($(this).data('summernote'));
        });

        return result;
    };

    $.extend($.fn.summernote, summernote);
}(typeof window !== 'undefined' ? window : this));
