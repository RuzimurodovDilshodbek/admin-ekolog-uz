<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversationStatesTable extends Migration
{
    public function up()
    {
        Schema::create('conversation_states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('telegram_id');
            $table->string('state')->nullable(); // e.g., 'awaiting_title', 'awaiting_description', etc.
            $table->string('mode')->nullable(); // 'manual' or 'auto'
            $table->json('data')->nullable(); // Store temporary post data
            $table->integer('message_id')->nullable(); // For editing messages
            $table->timestamps();

            $table->index('telegram_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversation_states');
    }
}
