<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户ID')->index();
            $table->unsignedInteger('to_user_id')->nullable()->comment('接收者用户ID')->index();
            $table->unsignedInteger('group_id')->nullable()->comment('群ID（群文件）')->index();
            $table->string('name')->comment('文件名')->index();
            $table->string('type')->comment('文件类型');
            $table->string('size')->comment('文件大小');
            $table->string('url')->comment('文件地址');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
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
        Schema::dropIfExists('files');
    }
}
