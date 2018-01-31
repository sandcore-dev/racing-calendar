<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('races', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('start_time');
            $table->string('name');
            $table->integer('season_id')->unsigned();
            $table->integer('circuit_id')->unsigned();
            $table->integer('location_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('season_id')->references('id')->on('seasons');
            $table->foreign('circuit_id')->references('id')->on('circuits');
            $table->foreign('location_id')->references('id')->on('locations');
            
            $table->unique([ 'start_time', 'name' ]);
            $table->unique([ 'season_id', 'name' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('races');
    }
}
