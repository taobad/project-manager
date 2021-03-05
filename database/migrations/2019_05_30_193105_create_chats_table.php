<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('chatable');
            $table->integer('user_id');
            $table->tinyInteger('inbound')->default(1);
            $table->string('platform')->default('whatsapp');
            $table->text('message');
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->tinyInteger('delivered')->default(0);
            $table->tinyInteger('read')->default(0);
            $table->text('meta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
