<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->unsignedBigInteger('serial_number_id');
            $table->string('device_id');
            $table->string('ip_address')->nullable();
            $table->string('agent')->nullable();
            $table->timestamps();

            $table->unique(['device_id', 'serial_number_id']);

            $table->foreign('serial_number_id')
                ->references('id')->on('serial_numbers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
