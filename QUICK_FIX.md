# PostgreSQL Xatoligini Tuzatish

## Muammo
`SQLSTATE[42704]: Undefined object: 7 ERROR: unrecognized configuration parameter "foreign_key_checks"`

Bu xatolik Laravel MySQL uchun mo'ljallangan buyruqlarni PostgreSQL da ishlatmoqchi bo'lganda yuz beradi.

## Yechim - Quyidagi buyruqlarni ketma-ket bajaring:

### 1. Cache'ni tozalash
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 2. Composer autoload yangilash
```bash
composer dump-autoload
```

### 3. Migratsiyalarni ishga tushirish
```bash
php artisan migrate:fresh
```

### 4. Seeder ishga tushirish
```bash
php artisan db:seed --class=BotUsersTableSeeder
```

## Agar xatolik davom etsa:

### AppServiceProvider ga qo'shish

`app/Providers/AppServiceProvider.php` fayliga quyidagini qo'shing:

```php
public function boot(): void
{
    ResponseFactory::mixin(new ResponseFactoryMixin());
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }

    // PostgreSQL uchun
    if (config('database.default') === 'pgsql') {
        Schema::defaultStringLength(191);
    }
}
```

### Webhook URLni sozlash

```bash
curl -X POST "https://api.telegram.org/bot8271074734:AAEf5xeK4wK0BU-tXaxfAq595WEPTwqMlgo/setWebhook?url=https://ekolog.uz/api/telegram/webhook"
```

## Test qilish

1. Admin panelga kiring: `/admin/bot-users`
2. Bot user yaratilganini tekshiring
3. Telegram botga `/start` yuboring
