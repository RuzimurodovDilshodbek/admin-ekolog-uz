<?php

namespace App\Providers;

use App\Mixins\ResponseFactoryMixin;
use App\Models\Post;
use App\Observers\PostObserver;
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

        // Matnga yopishib kelgan base64 rasmlarni faylga chiqaradi
        Post::observe(PostObserver::class);

        // PostgreSQL uchun string uzunligi
        if (config('database.default') === 'pgsql') {
            \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        }
    }
}
