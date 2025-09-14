<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->text('description_uz')->nullable();
            $table->text('description_kr')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_tr')->nullable();

            $table->renameColumn('title', 'title_uz');
            $table->string('title_kr')->nullable();
            $table->string('title_ru')->nullable();
            $table->string('title_en')->nullable();
            $table->string('title_tr')->nullable();

            $table->renameColumn('slug', 'slug_uz');
            $table->string('slug_kr')->nullable();
            $table->string('slug_ru')->nullable();
            $table->string('slug_en')->nullable();
            $table->string('slug_tr')->nullable();


            $table->renameColumn('content', 'content_uz');
            $table->text('content_kr')->nullable();
            $table->text('content_ru')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_tr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
