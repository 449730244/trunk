<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToVistorMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vistor_messages', function (Blueprint $table) {
            $table->foreign('service_id')->references('id')->on('customer_services')->onDelete('cascade');
            $table->foreign('vistor_id')->references('id')->on('vistors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vistor_messages', function (Blueprint $table) {
            $table->dropForeign('service_id');
            $table->dropForeign('vistor_id');
        });
    }
}
