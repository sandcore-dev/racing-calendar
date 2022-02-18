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
     */
    public function index(Championship $championship): Renderable|RedirectResponse
    {
        if (!$championship->seasons()->count()) {
            return view('empty')->with('championship', $championship);
        }

        if (
            Auth::check()
            && $season = $championship->seasons()
                ->whereNotNull('access_token')
                ->first()
        ) {
            return redirect()
                ->route('calendar', [
                    'championship' => $championship,
                    'season' => $season,
                ]);
        }

        $season = $championship->seasons()->first();

        return view('index')
            ->with(
                [
                    'icon' => $season?->icon_url,
                    'championship' => $championship,
                    'season' => $season,
                    'showLocations' => false,
                ]
            );
    }

    /**
     * Show calendar.
     */
    public function calendar(Championship $championship, Season $season): Renderable
    {
        return view('index')
            ->with(
                [
                    'icon' => $season->icon_url,
                    'championship' => $championship,
                    'season' => $season,
                    'showLocations' => $season->locations()->count() > 0,
                ]
            );
    }

    /**
     * Show location edit form.
     */
    public function editLocation(Championship $championship, Season $season, Race $race): Renderable
    {
        return view('location.edit')
            ->with(
                [
                    'championship' => $championship,
                    'season' => $season,
                    'race' => $race,
                ]
            );
    }

    /**
     * Update location.
     */
    public function updateLocation(
        Championship $championship,
        Season $season,
        Race $race,
        Request $request
    ): RedirectResponse {
        $request->validate(
            [
                'location' => ['integer', 'exists:locations,id'],
                'erase_location' => ['boolean'],
            ]
        );

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
