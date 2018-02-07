<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\AccessToken;
use App\Season;
use App\Race;

class CalendarController extends Controller
{
	/**
	 * If logged in: redirect to most recent calendar.
	 * If not logged in: show most recent calendar without locations.
	 * 
	 * @return	\Illuminate\Http\Response
	 */
    public function index()
    {
		if( !Season::count() )
			return view('empty');

		if( Auth::check() && $season = Season::has('access_token')->first() )
			return redirect()->route('calendar', [ 'access_token' => $season->access_token->name ]);
			
		return view('index')->with([
			'season'		=> Season::first(),
			'showLocations'	=> false,
		]);
    }
    
	/**
	 * Show calendar.
	 * 
	 * @param	\App\AccessToken			$access_token
	 * @return	\Illuminate\Http\Response
	 */
    public function calendar( AccessToken $access_token )
    {
		return view('index')->with([
			'season'		=> $access_token->season,
			'showLocations'	=> true,
		]);
    }
    
    /**
     * Show location edit form.
     * 
     * @param	\App\AccessToken	$access_token
     * @param	\App\Race			$race
     * 
     * @return	\Illuminate\Http\Response
     */
    public function editLocation( AccessToken $access_token, Race $race )
    {
		if( !$race->season->is( $access_token->season ) )
			abort(404);
		
		return view('location.edit')->with([
			'race' => $race,
		]);
    }
      
    /**
     * Update location.
     * 
     * @param	\App\AccessToken			$access_token
     * @param	\App\Race					$race
     * @param	\Illuminate\Http\Request	$request
     * 
     * @return	\Illuminate\Http\Response
     */
    public function updateLocation( AccessToken $access_token, Race $race, Request $request )
    {
		if( !$race->season->is( $access_token->season ) )
			abort(404);
		
		$request->validate([
			'location' => [ 'required', 'exists:locations,id' ],
		]);
		
		$race->location()->associate( $request->input('location') );
		
		$race->save();
		
		return redirect()->route('calendar', [ 'access_token' => $race->season->access_token ]);
    }
}
