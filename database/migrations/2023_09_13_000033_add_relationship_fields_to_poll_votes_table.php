<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPollVotesTable extends Migration
{
    public function up()
    {
        Schema::table('poll_votes', function (Blueprint $table) {
            $table->unsignedBigInteger('poll_id')->nullable();
            $table->foreign('poll_id', 'poll_fk_8974908')->references('id')->on('polls');
            $table->unsignedBigInteger('poll_variant_id')->nullable();
            $table->foreign('poll_variant_id', 'poll_variant_fk_8974909')->references('id')->on('poll_variants');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_8974911')->references('id')->on('users');
        });
    }
}
