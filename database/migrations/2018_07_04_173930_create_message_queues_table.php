<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户ID');
            $table->string('content')->comment('最新内容');
            $table->unsignedInteger('from_id')->comment('消息来自ID(用户或群)');
            $table->string('name')->comment('消息来自(用户名或群名)');
            $table->enum('type', ['group','user'])->comment('消息类型');
            $table->unsignedSmallInteger('unread')->comment('未读数量');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('message_queues');
    }
}
