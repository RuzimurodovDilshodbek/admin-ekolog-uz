<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBannerPostsTable extends Migration
{
    public function up()
    {
        Schema::table('banner_posts', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->nullable();
            $table->foreign('post_id', 'post_fk_8974570')->references('id')->on('posts');
        });
    }
}
