<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChampionshipIdToSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->foreignId('championship_id')->after('id')->nullable();

            $table->foreign('championship_id')->references('id')->on('championships');

            $table->unique(['championship_id', 'year']);
        });

        if (!DB::table('seasons')->whereNull('championship_id')->exists()) {
            return;
        }

        if (!DB::table('championships')->exists()) {
            DB::table('championships')->insert([
                'name' => 'championship',
                'domain' => parse_url(config('app.url'), PHP_URL_HOST)
                    ?: 'localhost',
            ]);
        }

        $championship = DB::table('championships')->first();

        DB::table('seasons')
            ->whereNull('championship_id')
            ->update([
                'championship_id' => $championship->id,
            ]);

        Schema::table('seasons', function (Blueprint $table) {
            $table->foreignId('championship_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropUnique(['championship_id', 'year']);

            $table->dropForeign(['championship_id']);
        });
    }
}
