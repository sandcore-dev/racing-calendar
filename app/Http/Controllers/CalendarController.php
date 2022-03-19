<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Season;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Race;
use Illuminate\Support\Facades\Lang;
use Inertia\Inertia;
use Inertia\Response;

class CalendarController extends Controller
{
    /**
     * If logged in: redirect to most recent calendar.
     * If not logged in: show most recent calendar without locations.
     */
    public function index(Championship $championship): Response|RedirectResponse
    {
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

        /** @var Season $season */
        $season = $championship->seasons()->firstOrFail();

        return Inertia::render(
            'Index',
            [
                'title' => "{$championship->name} {$season->year}",

                'iconUrl' => $season->icon_url,
                'headerUrl' => $season->header_url,
                'footerUrl' => $season->footer_url,

                'labels' => [
                    'date' => Lang::get('Date'),
                    'race_time' => Lang::get('Race time'),
                    'race' => Lang::get('Race'),
                ],

                'items' => $season->races->map(function (Race $race) {
                    return $race->only(
                        [
                            'id',
                            'start_time',
                            'country_flag',
                            'country_local_name',
                            'circuit_city',
                            'details',
                        ]
                    );
                }),
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
