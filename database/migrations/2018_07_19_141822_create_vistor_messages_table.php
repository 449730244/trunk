<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVistorMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vistor_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sn');
            $table->unsignedInteger('auth_id')->comment('作者ID(访客ID|客服ID)');
            $table->unsignedInteger('to_id')->comment('接收者ID(客服ID|访客ID)');
            $table->boolean('read')->default(true)->comment('是否已读');
            $table->text('content')->nullable();
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
        Schema::dropIfExists('vistor_messages');
    }
}
