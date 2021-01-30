<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Season;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Race;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * If logged in: redirect to most recent calendar.
     * If not logged in: show most recent calendar without locations.
     *
     * @param Championship $championship
     * @return Renderable|RedirectResponse
     */
    public function index(Championship $championship)
    {
        if (!$championship->seasons()->count()) {
            return view('empty')->with('championship', $championship);
        }

        if (Auth::check() && $season = $championship->seasons()->whereNotNull('access_token')->first()) {
            return redirect()
                ->route('calendar', [
                    'championship' => $championship,
                    'season' => $season,
                ]);
        }

        return view('index')->with([
            'championship' => $championship,
            'season' => $championship->seasons()->first(),
            'showLocations' => false,
        ]);
    }

    /**
     * Show calendar.
     *
     * @param Championship $championship
     * @param Season $season
     * @return Renderable
     */
    public function calendar(Championship $championship, Season $season)
    {
        return view('index')->with([
            'championship' => $championship,
            'season' => $season,
            'showLocations' => $season->locations()->count() > 0,
        ]);
    }

    /**
     * Show location edit form.
     *
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     *
     * @return Factory|View
     */
    public function editLocation(Championship $championship, Season $season, Race $race)
    {
        return view('location.edit')->with([
            'championship' => $championship,
            'season' => $season,
            'race' => $race,
        ]);
    }

    /**
     * Update location.
     *
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function updateLocation(Championship $championship, Season $season, Race $race, Request $request)
    {
        $request->validate([
            'location' => ['integer', 'exists:locations,id'],
            'erase_location' => ['boolean'],
        ]);

        if ($location = $request->input('location')) {
            $race->location()->associate($location);
        } elseif ($request->input('erase_location')) {
            $race->location()->dissociate();
        }

        $race->save();

        return redirect()
            ->route('calendar', ['championship' => $championship, 'season' => $season]);
    }
}
