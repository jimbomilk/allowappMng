<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntermediateExcelsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('intermediate_excel_2', function (Blueprint $table) {
            $table->increments('id');

            $table->string('rightholder_code', 50)->nullable();
            $table->string('rightholder_person_code', 50)->nullable();
            $table->string('rightholder_name', 200)->nullable();
            $table->string('rightholder_relation', 50)->nullable();
            $table->string('rightholder_email', 200)->nullable();
            $table->string('rightholder_phone', 50)->nullable();
            $table->string('rightholder_documentId', 50)->nullable();

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

        Schema::dropIfExists('intermediate_excel_2');

    }
}
