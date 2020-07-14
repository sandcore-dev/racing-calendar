<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccessTokenToSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->string('access_token')->nullable()->unique()->after('footer_image');
        });

        if (!DB::table('access_tokens')->exists()) {
            return;
        }

        DB::table('access_tokens')
            ->orderBy('season_id')
            ->each(function (object $accessToken) {
                DB::table('seasons')
                    ->where('id', $accessToken->season_id)
                    ->update(['access_token' => $accessToken->name]);
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
            $table->dropColumn('access_token');
        });
    }
}
