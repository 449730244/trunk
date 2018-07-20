<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceVistorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_vistors', function (Blueprint $table) {
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('vistor_id');
            $table->foreign('service_id')->references('id')->on('customer_services')->onDelete('cascade');
            $table->foreign('vistor_id')->references('id')->on('vistors')->onDelete('cascade');
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
        Schema::dropIfExists('service_vistors');
    }
}
