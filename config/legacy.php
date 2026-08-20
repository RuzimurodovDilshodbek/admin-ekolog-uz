<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Eski ekolog.uz arxivi
    |--------------------------------------------------------------------------
    |
    | 2015-2025 yillardagi WordPress saytining arxivi. Alohida "legacy"
    | bazasida saqlanadi va faqat admin panelda ko'rish uchun ishlatiladi.
    |
    */

    'sources' => [
        'old'  => [
            'label'    => 'old.ekolog.uz (2015-2023)',
            'json_dir' => 'legacy-import/ekolog_db',
        ],
        'old2' => [
            'label'    => 'old2.ekolog.uz (2020-2025)',
            'json_dir' => 'legacy-import/ekolog_database',
        ],
    ],

    /*
    | Media fayllar public/ ichida qayerda turadi.
    | Yakuniy yo'l: {media_path}/{source}/{file_path}
    */
    'media_dir' => 'legacy-uploads',

    /*
    | Spam (qimor/kazino) postlarini aniqlash sozlamalari.
    | 2025-10-27 .. 2025-10-31 - hujumchi ommaviy spam qo'shgan oyna.
    */
    'spam' => [
        'window_start' => '2025-10-27',
        'window_end'   => '2025-10-31',
    ],

];
