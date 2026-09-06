<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API rate limiting
    |--------------------------------------------------------------------------
    |
    | The public API is consumed in two very different ways. A browser or a
    | third party is one client and one visitor, so a per-IP bucket is the right
    | shape. The ekolog.uz frontend is not: it renders on the server, so every
    | visitor's page is fetched by one Nuxt process from one IP. Laravel's stock
    | 60/minute per IP therefore capped the entire public site at roughly a
    | dozen page views a minute, after which Nuxt rendered blank articles with
    | HTTP 200 rather than an error.
    |
    | `trusted_ips` lists the origins that are our own rendering layer. They get
    | `trusted_per_minute` instead of the public allowance. Keep loopback in the
    | list: the SSR request can arrive either from the public address or over
    | localhost depending on how the host resolves its own domain.
    |
    */

    'rate_limit' => [
        'per_minute' => env('API_RATE_LIMIT_PER_MINUTE', 60),
        'trusted_per_minute' => env('API_RATE_LIMIT_TRUSTED_PER_MINUTE', 3000),
        'trusted_ips' => env('API_RATE_LIMIT_TRUSTED_IPS', '127.0.0.1,::1'),
    ],

];
