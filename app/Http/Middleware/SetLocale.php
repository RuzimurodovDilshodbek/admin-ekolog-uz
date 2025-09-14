<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Get the language from the URL segment or the cookie
        $locale = $request->segment(1) ?: $request->cookie('localeAdmin');

        if (in_array($locale, config('app.locales'))) {
            app()->setLocale($locale);
            // Save the selected language to a cookie for 30 days (adjust as needed)
            cookie()->queue(cookie()->forever('localeAdmin', $locale));
        } else {
            // If no valid language is found, use the default locale
            app()->setLocale(config('app.localeAdmin'));
        }

        return $next($request);
    }
}
