<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('access_tokens');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('access_tokens', function (Blueprint $table) {
            $table->string('name', 10)->primary();
            $table->integer('season_id')->unsigned()->nullable()->unique();
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
        });

        DB::table('seasons')
            ->whereNotNull('access_token')
            ->orderBy('id')
            ->each(function (object $season) {
                Db::table('access_tokens')
                    ->insert([
                        'name' => $season->access_token,
                        'season_id' => $season->id,
                    ]);
            });
    }
}
