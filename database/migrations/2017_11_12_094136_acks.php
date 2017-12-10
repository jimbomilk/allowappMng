<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Acks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acks', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status')->default(-1); //-1 pending , 0 rejected, 1 approved
            $table->string('token');
            $table->string('photo'); // foto pixelada

            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')
                ->references('id')
                ->on('contracts')
                ->onDelete('cascade');

            $table->integer('rightholder_id')->unsigned();
            $table->foreign('rightholder_id')
                ->references('id')
                ->on('rightholders')
                ->onDelete('cascade');

            $table->unique(['contract_id', 'rightholder_id']);

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
        Schema::dropIfExists('acks');
    }
}
