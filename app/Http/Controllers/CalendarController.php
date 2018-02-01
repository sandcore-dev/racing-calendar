<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Season;
use App\Race;

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
		
		if( !$season )
			return view('empty');
		
		if( Auth::check() && !$token )
			return redirect()->route('calendar', [ 'token' => $season->access_token ]);
		
		return view('index')->with([
			'season'		=> $season,
			'showLocations'	=> $season->access_token == $token,
		]);
    }
    
    /**
     * Get season by token.
     * 
     * @param	string			$token
     * @return	App\Season|null
     */
    protected function getSeasonByToken( $token )
    {
		if( !$token )
			return Season::with('races', 'races.circuit.country', 'races.location')->first();
		
		$seasons = Season::with('races', 'races.circuit.country', 'races.location')->byToken( $token )->get();
		
		if( $seasons->isEmpty() )
			abort(404);
		
		return $seasons->first();
    }
    
    /**
     * Show location edit form.
     * 
     * @param	string		$token
     * @param	\App\Race	$race
     * 
     * @return	\Illuminate\Http\Response
     */
    public function editLocation( string $token, Race $race )
    {
		$season = $this->getSeasonByToken( $token );
		
		if( !$race->season->is( $season ) )
			abort(404);
		
		return view('location.edit')->with([
			'race' => $race,
		]);
    }
      
    /**
     * Update location.
     * 
     * @param	string						$token
     * @param	\App\Race					$race
     * @param	\Illuminate\Http\Request	$request
     * 
     * @return	\Illuminate\Http\Response
     */
    public function updateLocation( string $token, Race $race, Request $request )
    {
		$season = $this->getSeasonByToken( $token );
		
		if( !$race->season->is( $season ) )
			abort(404);
		
		$request->validate([
			'location' => [ 'required', 'exists:locations,id' ],
		]);
		
		$race->location()->associate( $request->input('location') );
		
		$race->save();
		
		return redirect()->route('calendar', [ 'token' => $race->season->access_token ]);
    }
}
