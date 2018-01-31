<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Season;

class CalendarController extends Controller
{
	/**
	 * Show calendar.
	 * 
	 * @param	string|null					$token
	 * @return	\Illuminate\Http\Response
	 */
    public function index( $token = null )
    {
		$season = $this->getSeasonByToken( $token );
		
		return view('index')->with([
			'season'		=> $season,
			'showLocations'	=> Auth::check() || $season->access_token == $token,
		]);
    }
    
    /**
     * Get season by token.
     * 
     * @param	string		$token
     * @return	App\Season
     */
    protected function getSeasonByToken( $token )
    {
		if( !$token )
			return Season::first();
		
		$seasons = Season::byToken( $token )->get();
		
		if( $seasons->isEmpty() )
			abort(404);
		
		return $seasons->first();
    }
}
