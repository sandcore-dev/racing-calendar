<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use App\AccessToken;
use App\Season;

class AccessTokenController extends Controller
{
    /**
     * Generate a new access token.
     *
     * @param   \App\Season|null
     * @return  \App\AccessToken
     */
    public static function generate(Season $season = null)
    {
        try {
            $access_token = factory(AccessToken::class)->create([
                'season_id' => $season ? $season->id : null,
            ]);
        } catch (QueryException $e) {
            return static::generate($season);
        }
        
        return $access_token;
    }
}
