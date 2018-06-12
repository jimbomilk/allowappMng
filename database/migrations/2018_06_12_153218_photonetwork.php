<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Photonetwork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photonetwork', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->nullable();
            $table->unsignedInteger('photo_id');
            $table->foreign('photo_id')
                ->references('id')
                ->on('photos')
                ->onDelete('cascade');

            $table->unsignedInteger('publicationsite_id');
            $table->foreign('publicationsite_id')
                ->references('id')
                ->on('publicationsites')
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
        Schema::dropIfExists('photonetwork');
    }
}
