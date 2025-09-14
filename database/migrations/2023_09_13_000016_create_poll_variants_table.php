<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('poll_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('sort')->nullable();
            $table->boolean('is_coccect')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
