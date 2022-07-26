<?php

namespace App\Http\Controllers;

use App\Models\Championship;
use App\Models\Season;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Race;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
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
            return Redirect::route('calendar', [
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
                        array_filter(
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
                    )
                    ->get()
                    ->append(
                        array_filter(
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
                                'is_past',
                                'is_scheduled',
                            ]
                        )
                    ),
            ]
        );
    }

    public function editLocation(Championship $championship, Season $season, Race $race): Response|RedirectResponse
    {
        if (!$race->is_scheduled || $race->is_past) {
            return Redirect::back();
        }

        return Inertia::render(
            'Location/Form',
            [
                'title' => $championship->name
                    . ' - ' . $season->year,

                'header' => $season->year
                    . ' - ' . $race->circuit_city
                    . ', ' . $race->country_local_name,

                'edit' => true,
                'url' => URL::route('calendar.location.update', [
                    'championship' => $championship,
                    'season' => $season,
                    'race' => $race,
                ]),

                'labels' => [
                    'nobody' => Lang::get('Nobody'),
                    'submit' => Lang::get('Edit'),
                ],

                'data' => $race->only(['location_id']),

                'locations' => $season->locations()
                    ->select(['locations.id', 'locations.name'])
                    ->get(),
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
                'location_id' => ['nullable', 'integer', 'exists:locations,id'],
            ]
        );

        if ($location = $request->input('location_id')) {
            $race->location()->associate($location);
        } else {
            $race->location()->dissociate();
        }

        $race->save();

        return Redirect::route('calendar', ['championship' => $championship, 'season' => $season]);
    }
}
