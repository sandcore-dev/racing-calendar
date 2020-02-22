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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (!Season::count()) {
            return view('empty');
        }

        if (Auth::check() && $season = Season::has('accessToken')->first()) {
            return redirect()->route('calendar', [ 'access_token' => $season->accessToken->name ]);
        }
            
        return view('index')->with([
            'season'        => Season::first(),
            'showLocations' => false,
        ]);
    }
    
    /**
     * Show calendar.
     *
     * @param   \App\AccessToken            $access_token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function calendar(AccessToken $access_token)
    {
        return view('index')->with([
            'season'        => $access_token->season,
            'showLocations' => true,
        ]);
    }
    
    /**
     * Show location edit form.
     *
     * @param   \App\AccessToken    $access_token
     * @param   \App\Race           $race
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editLocation(AccessToken $access_token, Race $race)
    {
        if (!$race->season->is($access_token->season)) {
            abort(404);
        }
        
        return view('location.edit')->with([
            'race' => $race,
        ]);
    }
      
    /**
     * Update location.
     *
     * @param   \App\AccessToken            $access_token
     * @param   \App\Race                   $race
     * @param   \Illuminate\Http\Request    $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLocation(AccessToken $access_token, Race $race, Request $request)
    {
        if (!$race->season->is($access_token->season)) {
            abort(404);
        }
        
        $request->validate([
            'location'          => [ 'integer', 'exists:locations,id' ],
            'erase_location'    => [ 'boolean' ],
        ]);
        
        if ($location = $request->input('location')) {
            $race->location()->associate($location);
        } elseif ($request->input('erase_location')) {
            $race->location()->dissociate();
        }
        
        $race->save();
        
        return redirect()
            ->route('calendar', [ 'access_token' => $race->season->accessToken ]);
    }
}
