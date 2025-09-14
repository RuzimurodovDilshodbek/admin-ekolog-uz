<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts_send_auto_social_networks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->datetime('publish_date');
            $table->boolean('is_send_telegram')->default(0)->nullable();
            $table->boolean('telegram_send')->default(0)->nullable();
            $table->boolean('facebook_send')->default(0)->nullable();
            $table->boolean('is_send_facebook')->default(0)->nullable();
            $table->boolean('instagram_send')->default(0)->nullable();
            $table->boolean('is_send_instagram')->default(0)->nullable();
            $table->boolean('twitter_send')->default(0)->nullable();
            $table->boolean('is_send_twitter')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
