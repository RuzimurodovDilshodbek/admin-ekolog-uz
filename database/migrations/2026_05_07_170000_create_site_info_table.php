<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_info', function (Blueprint $table) {
            $table->id();
            $table->string('main_title')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_link')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('telegram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->text('address')->nullable();
            $table->text('transport')->nullable();
            $table->text('working_hours')->nullable();
            $table->text('map_embed')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_info');
    }
};
