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
        Schema::table('tutors', function (Blueprint $table) {
            $table->renameColumn('about', 'about_uz');
            $table->longText('about_kr')->nullable();
            $table->longText('about_ru')->nullable();
            $table->longText('about_en')->nullable();
            $table->longText('about_tr')->nullable();
        });
    }
};
