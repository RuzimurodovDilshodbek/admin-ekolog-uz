<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            // ekolog.uz is server-rendered: the Nuxt process fetches this API on
            // behalf of every visitor, from one IP. Under a per-IP limit the whole
            // public site shares a single bucket, and once it is spent Nuxt renders
            // articles as empty pages with HTTP 200 - visitors see nothing and Google
            // indexes the blank. The SSR origin therefore gets its own allowance.
            if (in_array($request->ip(), self::trustedApiClients(), true)) {
                return Limit::perMinute((int) config('api.rate_limit.trusted_per_minute'))
                    ->by('ssr:' . $request->ip());
            }

            return Limit::perMinute((int) config('api.rate_limit.per_minute'))
                ->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * IPs whose traffic is our own server-side rendering rather than one visitor.
     *
     * @return array<int, string>
     */
    protected static function trustedApiClients(): array
    {
        return array_values(array_filter(array_map(
            'trim',
            explode(',', (string) config('api.rate_limit.trusted_ips'))
        )));
    }
}
