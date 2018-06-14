<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntermediateExcelsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intermediate_excel_1', function (Blueprint $table) {
            $table->increments('id');

            $table->string('person_code', 50)->nullable();
            $table->string('person_group', 50)->nullable();
            $table->string('person_name', 200)->nullable();
            $table->string('person_minor', 50)->nullable();
            $table->string('person_dni', 50)->nullable();
            $table->string('person_phone', 50)->nullable();
            $table->string('person_email', 200)->nullable();
            $table->string('person_photo_name', 300)->nullable();
            $table->string('person_photo_path', 1000)->nullable();

            $table->string('status', 1000)->nullable();

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('cascade');

            $table->integer('import_id')->unsigned();
            $table->foreign('import_id')
                ->references('id')
                ->on('excels')
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
        Schema::dropIfExists('intermediate_excel_1');

    }
}
