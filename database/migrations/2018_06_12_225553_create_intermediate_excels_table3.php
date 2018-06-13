<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntermediateExcelsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('intermediate_excel_3', function (Blueprint $table) {
            $table->increments('id');

            $table->string('site_code', 50)->nullable();
            $table->string('site_group', 50)->nullable();
            $table->string('site_name', 200)->nullable();
            $table->string('site_url', 200)->nullable();

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

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
        Schema::dropIfExists('intermediate_excel_3');
    }
}
