<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Locations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('accountable');
            $table->string('CIF');
            $table->string('email');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('CP')->nullable();
            $table->string('delegate_name');
            $table->string('delegate_email');
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
        /*$locations = \App\Location::all();
        foreach($locations as $location){

        }*/
        Schema::dropIfExists('locations');
    }
}
