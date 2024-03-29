<?php

namespace App\Http\Controllers\Admin;

use App\Models\Championship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\IsRaceNameUnique;
use App\Models\Circuit;
use App\Models\Season;
use App\Models\Race;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class RaceController extends Controller
{
    public function index(Championship $championship, Season $season): Response
    {
        return Inertia::render(
            'Admin/Race/Index',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' ' . $season->year
                    . ' - ' . Lang::get('Races'),

                'labels' => [
                    'title' => "{$championship->name} {$season->year}",
                    'back' => Lang::get('Back to season index'),
                    'copySeason' => Lang::get('Copy races from season'),
                    'date' => Lang::get('Datum'),
                    'startTime' => Lang::get('Start time'),
                    'location' => Lang::get('Location'),
                    'name' => Lang::get('Name'),
                ],

                'adminAddUrl' => route('admin.race.create', ['championship' => $championship, 'season' => $season]),

                'adminCopySeasonUrl' => route(
                    'admin.race.copy-season',
                    ['championship' => $championship, 'season' => $season]
                ),

                'adminBackUrl' => route('admin.season.index', ['championship' => $championship]),

                'previousSeasons' => $championship->seasons()
                    ->where('year', '<', $season->year)
                    ->select(['id', 'year'])
                    ->get(),

                'races' => $season->races()
                    ->select(['id', 'start_time', 'name', 'season_id', 'location_id'])
                    ->with(['season.championship', 'location'])
                    ->paginate(25),
            ]
        );
    }

    public function copySeason(Request $request, Championship $championship, Season $season): RedirectResponse
    {
        $request->validate(
            [
                'seasonId' => [
                    'required',
                    'integer',
                    Rule::exists('seasons', 'id')
                        ->whereNotIn('id', [$season->id]),
                ],
            ]
        );

        $copyFromSeason = Season::find($request->input('seasonId'));

        $copyFromSeason->races->each(function (Race $race) use ($season) {
            $start_time = clone $race->start_time;
            $start_time->year($season->year);

            $season->races()
                ->create(
                    [
                        'start_time' => $start_time,
                        'name' => $race->name,
                        'circuit_id' => $race->circuit_id,
                        'remarks' => '',
                    ]
                );
        });

        return Redirect::route('admin.race.index', ['championship' => $championship, 'season' => $season])
            ->with('success', __('The races from :year have been copied.', ['year' => $copyFromSeason->year]));
    }

    public function create(Championship $championship, Season $season): Response
    {
        return Inertia::render(
            'Admin/Race/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' ' . $season->year
                    . ' - ' . Lang::get('Add race'),

                'header' => Lang::get(
                    'Add race for :championship season :year',
                    [
                        'championship' => $championship->name,
                        'season' => $season->year,
                    ]
                ),

                'url' => route('admin.race.store', ['championship' => $championship, 'season' => $season]),

                'labels' => [
                    'start_time' => Lang::get('Start time'),
                    'name' => Lang::get('Name'),
                    'circuit_id' => Lang::get('Circuit'),
                    'has_sprint' => Lang::get('Has sprint race'),
                    'remarks' => Lang::get('Remarks'),
                    'status' => Lang::get('Status'),
                    'submit' => Lang::get('Add'),
                ],

                'year' => $season->year,
                'locale' => App::currentLocale(),

                'circuits' => Circuit::select(['id', 'name'])->get(),
                'statuses' => $this->getStatuses(),
            ]
        );
    }

    public function store(Request $request, Championship $championship, Season $season): RedirectResponse
    {
        $validated = $request->validate(
            [
                'start_time' => ['required', 'date'],
                'name' => [
                    'required',
                    'min:5',
                    new IsRaceNameUnique($request->input('season_id'), $request->input('start_time')),
                ],
                'circuit_id' => ['required', 'integer', 'exists:circuits,id'],
                'has_sprint' => ['nullable', 'boolean'],
                'remarks' => ['string', 'nullable'],
            ]
        );

        $validated['start_time'] = $request->date('start_time')->setTimezone(config('app.timezone'));

        /** @var Race $race */
        $race = $season->races()->create($validated);

        return Redirect::route(
            'admin.race.index',
            ['championship' => $championship, 'season' => $season, 'race' => $race]
        )
            ->with('success', __('The race :name has been added.', ['name' => $race->name]));
    }

    public function edit(Championship $championship, Season $season, Race $race): Response
    {
        return Inertia::render(
            'Admin/Race/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' ' . $season->year
                    . ' - ' . Lang::get('Edit race'),

                'header' => Lang::get(
                    'Edit race :race for :championship season :season',
                    [
                        'championship' => $championship->name,
                        'season' => $season->year,
                        'race' => $race->name,
                    ]
                ),

                'edit' => true,
                'url' => route(
                    'admin.race.update',
                    ['championship' => $championship, 'season' => $season, 'race' => $race]
                ),

                'labels' => [
                    'start_time' => Lang::get('Start time'),
                    'name' => Lang::get('Name'),
                    'circuit_id' => Lang::get('Circuit'),
                    'has_sprint' => Lang::get('Has sprint race'),
                    'remarks' => Lang::get('Remarks'),
                    'status' => Lang::get('Status'),
                    'location' => Lang::get('Location'),
                    'submit' => Lang::get('Change'),
                ],

                'year' => $season->year,
                'locale' => App::currentLocale(),

                'circuits' => Circuit::select(['id', 'name'])->get(),
                'statuses' => $this->getStatuses(),
                'locations' => $race->season->locations()
                    ->select(['locations.id', 'locations.name'])
                    ->get(),

                'data' => $race->only(
                    [
                        'start_time',
                        'name',
                        'circuit_id',
                        'has_sprint',
                        'remarks',
                        'status',
                        'location_id',
                    ]
                ),
            ]
        );
    }

    public function update(Request $request, Championship $championship, Season $season, Race $race): RedirectResponse
    {
        $validated = $request->validate(
            [
                'start_time' => ['required', 'date'],
                'name' => [
                    'required',
                    'min:5',
                    new IsRaceNameUnique(
                        $request->input('season_id'),
                        $request->input('start_time'),
                        $race->id
                    ),
                ],
                'circuit_id' => ['required', 'integer', 'exists:circuits,id'],
                'has_sprint' => ['nullable'],
                'remarks' => ['string', 'nullable'],
                'status' => ['required', 'string', 'in:scheduled,postponed,cancelled'],
                'location_id' => ['nullable', 'integer', 'exists:locations,id'],
            ]
        );

        $validated['start_time'] = $request->date('start_time')->setTimezone(config('app.timezone'));

        $race->update($validated);

        return Redirect::route('admin.race.index', ['championship' => $championship, 'season' => $season])
            ->with('success', __('The race :name has been changed.', ['name' => $race->name]));
    }

    protected function getStatuses(): array
    {
        return [
            [
                'value' => 'scheduled',
                'text' => Lang::get('Scheduled'),
            ],
            [
                'value' => 'postponed',
                'text' => Lang::get('Postponed'),
            ],
            [
                'value' => 'cancelled',
                'text' => Lang::get('Cancelled'),
            ],
        ];
    }
}
