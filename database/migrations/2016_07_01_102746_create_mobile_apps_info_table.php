<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMobileAppsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_apps_info', function (Blueprint $table) {
            $table->string('appId')->index();
            $table->enum('region',['us', 'kr', 'cn', 'dev', 'stag'])->default('us');
            $table->string('host');
            $table->string('apiVersion');
            $table->string('analytics');
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
        Schema::drop('mobile_apps_info');
    }
}
