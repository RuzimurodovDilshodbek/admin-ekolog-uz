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
        // Remove Turkish language columns from posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title_tr', 'slug_tr', 'description_tr', 'content_tr', 'image_description_tr']);
        });

        // Remove Turkish language columns from sections table
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn(['title_tr', 'slug_tr']);
        });

        // Remove Turkish language columns from tags table
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn(['title_tr', 'slug_tr']);
        });

        // Remove Turkish language columns from tutor_opinions table
        Schema::table('tutor_opinions', function (Blueprint $table) {
            $table->dropColumn('short_title_tr');
        });

        // Remove Turkish language columns from tutors table
        Schema::table('tutors', function (Blueprint $table) {
            $table->dropColumn('about_tr');
        });

        // Remove Turkish language columns from videos table
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('title_tr');
        });

        // Remove Turkish language columns from quotations table
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['title_tr']);
        });

        // Remove Turkish language columns from video_categories table
        Schema::table('video_categories', function (Blueprint $table) {
            $table->dropColumn('title_tr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back Turkish language columns to posts table
        Schema::table('posts', function (Blueprint $table) {
            $table->text('description_tr')->nullable();
            $table->string('title_tr')->nullable();
            $table->string('slug_tr')->nullable();
            $table->text('content_tr')->nullable();
            $table->text('image_description_tr')->nullable();
        });

        // Add back Turkish language columns to sections table
        Schema::table('sections', function (Blueprint $table) {
            $table->string('title_tr')->nullable();
            $table->string('slug_tr')->nullable();
        });

        // Add back Turkish language columns to tags table
        Schema::table('tags', function (Blueprint $table) {
            $table->string('title_tr')->nullable();
            $table->string('slug_tr')->nullable();
        });

        // Add back Turkish language columns to tutor_opinions table
        Schema::table('tutor_opinions', function (Blueprint $table) {
            $table->text('short_title_tr')->nullable();
        });

        // Add back Turkish language columns to tutors table
        Schema::table('tutors', function (Blueprint $table) {
            $table->text('about_tr')->nullable();
        });

        // Add back Turkish language columns to videos table
        Schema::table('videos', function (Blueprint $table) {
            $table->string('title_tr')->nullable();
        });

        // Add back Turkish language columns to quotations table
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('title_tr')->nullable();
            $table->string('author_name_tr')->nullable();
        });

        // Add back Turkish language columns to video_categories table
        Schema::table('video_categories', function (Blueprint $table) {
            $table->string('title_tr')->nullable();
        });
    }
};
