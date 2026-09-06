<?php

/*
 * Paketning to'liq konfigi emas — MediaLibraryServiceProvider `mergeConfigFrom`
 * ishlatadi, shuning uchun bu yerda faqat o'zgartiriladigan kalit turadi,
 * qolganlari paketning o'z sozlamalaridan olinadi.
 */

return [

    /*
     * Paketning sukut chegarasi 10 MB. Maqolalar matniga yopishib kelgan eski
     * base64 rasmlar orasida undan kattalari bor edi (eng yirigi 11.66 MB), va
     * `posts:extract-inline-images` ularni faylga chiqara olmay to'xtardi.
     * Chegara shu bir martalik ko'chirish uchun ko'tarilgan.
     *
     * Diqqat: bu faqat saqlashga ruxsat beradi, rasm hajmini kichraytirmaydi.
     * Maqola ichida ko'rsatiladigan rasm ~866 px kenglikda chiziladi, ya'ni
     * bir necha megabaytlik asl nusxa o'quvchiga ortiqcha yuk. Ularni alohida
     * qadamda kichraytirish kerak.
     */
    'max_file_size' => env('MEDIA_MAX_FILE_SIZE', 1024 * 1024 * 32),

];
