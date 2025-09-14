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
        Schema::table('tags', function (Blueprint $table) {
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
        });
    }

};
