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

        return $this->calendar($championship, $season, false);
    }

    public function calendar(Championship $championship, Season $season, bool $showLocations = true): Response
    {
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
                    'cancelled' => Lang::get('Cancelled'),
                    'postponed' => Lang::get('Postponed'),
                    'location' => Lang::get('Location'),
                ],

                'showLocations' => $showLocations,

                'items' => $season->races()
                    ->select(
                        [
                            'id',
                            'start_time',
                            'season_id',
                            'circuit_id',
                            'status',
                            $showLocations
                                ? 'location_id'
                                : null,
                        ]
                    )
                    ->get()
                    ->append(
                        [
                            'country_flag',
                            'country_local_name',
                            'circuit_city',
                            'details',
                            'this_week',
                            $showLocations
                                ? 'location_name'
                                : null,
                            $showLocations
                                ? 'location_edit_url'
                                : null,
                        ]
                    ),
            ]
        );
    }

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
