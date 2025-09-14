<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorOpinionsTable extends Migration
{
    public function up()
    {
        Schema::create('tutor_opinions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('short_title');
            $table->integer('sort')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
