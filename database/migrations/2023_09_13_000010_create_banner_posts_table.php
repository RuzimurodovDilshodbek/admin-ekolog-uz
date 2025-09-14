<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerPostsTable extends Migration
{
    public function up()
    {
        Schema::create('banner_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->integer('sort')->nullable();
            $table->boolean('status')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
