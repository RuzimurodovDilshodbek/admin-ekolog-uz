# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 10 content management system (CMS) for a multilingual news/media website (ekolog-uz). The application supports 5 languages (Uzbek Latin - uz, Uzbek Cyrillic - kr, Russian - ru, English - en, Turkish - tr) with automatic translation features via Google Translate API.

**Tech Stack:**
- Laravel 10 (PHP 8.1+)
- MySQL database
- Vite for asset bundling
- Spatie Media Library for file/image management
- JWT Authentication (tymon/jwt-auth)
- Laravel Sanctum for API authentication
- Yajra DataTables for admin tables
- Summernote WYSIWYG editor
- Swiper for carousels

## Commands

### Development
```bash
# Install PHP dependencies
php composer.phar install
# OR if composer is globally installed
composer install

# Install Node dependencies
npm install

# Run development server (Vite)
npm run dev

# Build assets for production
npm run build

# Generate application key (first time setup)
php artisan key:generate

# Run migrations
php artisan migrate

# Run migrations with seeders
php artisan migrate --seed

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Testing
```bash
# Run all tests
./vendor/bin/phpunit

# Run specific test suite
./vendor/bin/phpunit --testsuite Unit
./vendor/bin/phpunit --testsuite Feature

# Run single test file
./vendor/bin/phpunit tests/Unit/ExampleTest.php
```

### Database
```bash
# Create a new migration
php artisan make:migration create_table_name

# Rollback last migration
php artisan migrate:rollback

# Refresh database (drop all tables and re-migrate)
php artisan migrate:refresh

# Create a new seeder
php artisan make:seeder SeederName
```

### Code Generation
```bash
# Create a new controller
php artisan make:controller ControllerName

# Create a model with migration
php artisan make:model ModelName -m

# Create a request class
php artisan make:request RequestName

# Create a middleware
php artisan make:middleware MiddlewareName
```

## Architecture & Structure

### Multilingual System

The application uses a **locale-based multilingual architecture** with database columns suffixed by language codes:
- All translatable fields are stored as separate columns: `title_uz`, `title_kr`, `title_ru`, `title_en`, `title_tr`
- Similarly for slugs: `slug_uz`, `slug_kr`, `slug_ru`, `slug_en`, `slug_tr`
- Models use accessors (`getTitleAttribute()`) to return the appropriate language field based on `app()->getLocale()`
- Mutators auto-generate slugs when setting title attributes
- URL helper `localized_url()` prepends locale to URLs (defined in `app/Helpers/UrlHelper.php`)
- Middleware `SetLocale` handles locale switching
- Translation helper functions: `trs($string, $to_lang)` for HTML content, `trsTitle($string, $to_lang)` for plain text
- Transliteration helpers: `transliterate()` and `transliterateLatin()` for Cyrillic/Latin conversion

### Content Management Flow

**Posts System:**
- Posts can belong to multiple sections (stored as comma-separated IDs in `section_ids`)
- Posts have multiple languages support (stored in `langs` field)
- Auto-generates slugs on title update with ID suffix: `Str::slug($value.'-'.$this->id)`
- Supports archiving/un-archiving via mass actions
- View tracking via `PostView` model with IP-based deduplication
- Media handled through Spatie Media Library with conversions: thumb (60x36), preview (343x197), card (348x202), show_card (866x505)
- Publish date scheduling support
- Related posts logic: first tries tag-based relation, falls back to section-based most viewed

**Section Hierarchy:**
- Sections support parent-child relationships (`parent_id`)
- Each section can have custom URL or auto-generated from slug
- External URLs (http/https) are preserved, internal URLs are localized

**Media Management:**
- Uses Spatie Media Library with `public` disk
- Images stored in `detail_image` collection as single file
- Auto-generates multiple conversions for responsive display
- CKEditor integration for inline images in content

### API Architecture

**Two API versions coexist:**
- `/api/v1` - Legacy API (simple structure)
- `/api/v2` - Current API with authentication support

**Authentication:**
- Web admin uses Laravel's standard auth
- API uses JWT tokens (tymon/jwt-auth) on `/api/v2/auth/*` endpoints
- Sanctum also configured but JWT is primary for API

**Key API Endpoints:**
- `GET /api/v2/home/get-news-home` - Home page news feed
- `GET /api/v2/get-post/{id}` - Single post details
- `GET /api/v2/get-category/{id}` - Posts by category
- `GET /api/v2/get-search` - Search posts
- `GET /api/v2/get-videos` - Video content
- `GET /api/v2/get-tag/{id}` - Posts by tag
- `POST /api/v2/auth/login` - JWT authentication
- `POST /api/v2/auth/register` - User registration

### Admin Panel

Located under `/admin` prefix with auth middleware:
- Uses namespaced controllers under `App\Http\Controllers\Admin`
- Mass actions pattern: `massDestroy`, `massArchiving`, `massUnArchiving`
- Media upload endpoints: `storeMedia`, `storeCKEditorImages`
- AJAX endpoints for dynamic dropdowns (e.g., `getSectionId`, `getSectionIdEdit`)
- RBAC with permissions and roles
- Translation manager integration (barryvdh/laravel-translation-manager)

### Social Media Integration

Found in `app/Social/`:
- `ApiManager.php` - Base API management
- `Telegram.php` - Telegram bot integration
- `Facebook/` - Facebook API integration
- `PostsSendAutoSocialNetwork` model tracks auto-posting to social networks

### Custom Middleware

- `SetLocale` - Sets application locale from URL segment
- `AuthGates` - Defines authorization gates
- `LanguageMiddleware` - Additional language handling

### Helper Functions (app/Helpers/UrlHelper.php)

Auto-loaded via composer.json:
- `localized_url($path)` - Generate URL with locale prefix
- `getLocaleForMonth()` - Returns proper locale format for Carbon date formatting
- `getYouTubeVideoId($url)` - Extract YouTube video ID from various URL formats
- `getYouTubeVideoThumb($url)` - Get YouTube thumbnail URL
- `trs($string, $to_lang)` - Google Translate API wrapper for HTML
- `trsTitle($string, $to_lang)` - Google Translate API wrapper for text
- `transliterate($textcyr, $textlat)` - Bidirectional Cyrillic/Latin conversion
- `transliterateLatin($textcyr)` - Cyrillic to Latin conversion

## Important Patterns

### When Adding New Translatable Content:

1. Create migration with all language columns:
```php
$table->string('title_uz')->nullable();
$table->string('title_kr')->nullable();
$table->string('title_ru')->nullable();
$table->string('title_en')->nullable();
$table->string('title_tr')->nullable();
```

2. Add mutators/accessors in model:
```php
public function getTitleAttribute() {
    return $this->attributes['title_' . app()->getLocale()];
}

public function setTitleUzAttribute($value) {
    $this->attributes['title_uz'] = $value;
    $this->attributes['slug_uz'] = Str::slug($value);
}
// Repeat for each language
```

3. Use `localized_url()` for generating links in views

### When Adding New Admin Resources:

1. Create resource routes in `routes/web.php` under admin group
2. Add mass destroy route: `Route::delete('resource/destroy', 'Controller@massDestroy')`
3. If using media, add: `Route::post('resource/media', 'Controller@storeMedia')`
4. Controller should extend `App\Http\Controllers\Controller`
5. Use namespace: `App\Http\Controllers\Admin`

### Working with Media:

Models implementing media must:
```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Model extends Model implements HasMedia {
    use InteractsWithMedia;

    public function registerMediaCollections(): void {
        $this->addMediaCollection('collection_name')->singleFile();
    }

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')->fit('crop', 60, 36);
    }
}
```

## Environment Setup

Required environment variables (see `.env.example`):
- Database connection (MySQL)
- JWT secret (`JWT_SECRET`)
- Google Translate API key (hardcoded in UrlHelper.php - consider moving to .env)
- Mail configuration for newsletters
- Social media API credentials (Facebook, Telegram)

## Notes

- The project uses `composer.phar` included in repository root
- Route model binding is used extensively
- Soft deletes enabled on most models
- All datetime fields formatted via `serializeDate()` as 'Y-m-d H:i:s'
- IP-based tracking for post views and ad views
- Poll voting system with variants and vote tracking
- Newsletter subscription system
- Daily verse feature for content curation
- Video categories with sorting functionality
