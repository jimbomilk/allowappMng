<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RightholderConsents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rightholder_consents', function (Blueprint $table) {
            $table->increments('id');

            $table->mediumText('consents')->nullable();
            $table->smallInteger('status')->default(0);

            $table->integer('rightholder_id')->unsigned();
            $table->foreign('rightholder_id')
                ->references('id')
                ->on('rightholders')
                ->onDelete('cascade');

            $table->integer('consent_id')->unsigned();
            $table->foreign('consent_id')
                ->references('id')
                ->on('consents')
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
        Schema::dropIfExists('rightholder_consents');
    }
}
