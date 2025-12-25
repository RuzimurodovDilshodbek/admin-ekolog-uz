<?php

namespace App\Providers;

use App\Mixins\ResponseFactoryMixin;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResponseFactory::mixin(new ResponseFactoryMixin());
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // PostgreSQL uchun string uzunligi
        if (config('database.default') === 'pgsql') {
            \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        }
    }
}
