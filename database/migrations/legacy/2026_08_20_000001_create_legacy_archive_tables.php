<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Eski ekolog.uz (WordPress, 2015-2025) arxivi uchun jadvallar.
 * Faqat "legacy" ulanishida yaratiladi - asosiy sayt bazasiga tegmaydi.
 *
 * Ishga tushirish:
 *   php artisan migrate --database=legacy --path=database/migrations/legacy
 */
return new class extends Migration
{
    protected $connection = 'legacy';

    public function up(): void
    {
        Schema::connection('legacy')->create('legacy_posts', function (Blueprint $table) {
            $table->id();
            $table->string('source', 16)->index();          // old | old2
            $table->unsignedBigInteger('wp_id')->index();   // WordPress'dagi ID
            $table->string('post_type', 32)->index();       // post | page
            $table->string('status', 32)->index();
            $table->text('title')->nullable();
            $table->string('slug', 255)->nullable();
            $table->longText('content')->nullable();        // TOZALANGAN html
            $table->longText('content_raw')->nullable();    // asl nusxa (faqat matn sifatida saqlanadi)
            $table->text('excerpt')->nullable();
            $table->string('lang', 8)->nullable();          // uz | ru | kr | en
            $table->longText('translations')->nullable();   // qTranslate [:xx] bloklari, json
            $table->string('author', 128)->nullable();
            $table->text('guid')->nullable();
            $table->unsignedBigInteger('thumbnail_wp_id')->nullable()->index();
            $table->boolean('is_spam')->default(false)->index();
            $table->boolean('was_sanitized')->default(false);
            $table->unsignedInteger('removed_scripts')->default(0);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('modified_at')->nullable();
            $table->timestamps();

            $table->unique(['source', 'wp_id']);
        });

        Schema::connection('legacy')->create('legacy_media', function (Blueprint $table) {
            $table->id();
            $table->string('source', 16)->index();
            $table->unsignedBigInteger('wp_id')->index();
            $table->text('title')->nullable();
            $table->string('file_path', 512)->nullable();   // masalan: 2019/04/rasm.jpg
            $table->string('mime', 128)->nullable()->index();
            $table->unsignedBigInteger('parent_wp_id')->nullable()->index();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->boolean('file_exists')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();

            $table->unique(['source', 'wp_id']);
        });

        Schema::connection('legacy')->create('legacy_terms', function (Blueprint $table) {
            $table->id();
            $table->string('source', 16)->index();
            $table->unsignedBigInteger('wp_term_id')->index();
            $table->string('taxonomy', 64)->index();        // category | post_tag
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->unsignedInteger('count')->default(0);

            $table->unique(['source', 'wp_term_id', 'taxonomy']);
        });

        Schema::connection('legacy')->create('legacy_post_term', function (Blueprint $table) {
            $table->id();
            $table->string('source', 16)->index();
            $table->unsignedBigInteger('wp_post_id')->index();
            $table->unsignedBigInteger('wp_term_id')->index();
            $table->string('taxonomy', 64)->index();
        });
    }

    public function down(): void
    {
        Schema::connection('legacy')->dropIfExists('legacy_post_term');
        Schema::connection('legacy')->dropIfExists('legacy_terms');
        Schema::connection('legacy')->dropIfExists('legacy_media');
        Schema::connection('legacy')->dropIfExists('legacy_posts');
    }
};
