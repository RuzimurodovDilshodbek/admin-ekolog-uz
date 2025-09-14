<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Get the language from the URL segment or the cookie
        $locale = $request->segment(1) ?: $request->cookie('locale');

        if (in_array($locale, config('app.locales'))) {
            app()->setLocale($locale);
            // Save the selected language to a cookie for 30 days (adjust as needed)
            cookie()->queue(cookie()->forever('locale', $locale));
        } else {
            // If no valid language is found, use the default locale
            app()->setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
