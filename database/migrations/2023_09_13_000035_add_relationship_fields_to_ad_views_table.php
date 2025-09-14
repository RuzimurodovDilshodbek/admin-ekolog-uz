<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAdViewsTable extends Migration
{
    public function up()
    {
        Schema::table('ad_views', function (Blueprint $table) {
            $table->unsignedBigInteger('ad_id')->nullable();
            $table->foreign('ad_id', 'ad_fk_8974981')->references('id')->on('ads');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_8974982')->references('id')->on('users');
        });
    }
}
