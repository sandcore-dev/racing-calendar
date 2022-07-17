<?php

namespace App\Http\Controllers\Admin;

use App\Models\Championship;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\IsRaceNameUnique;
use App\Models\Circuit;
use App\Models\Season;
use App\Models\Race;
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
                    'startTime' => Lang::get('Start time'),
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
                    ->select(['id', 'start_time', 'name'])
                    ->paginate(),
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

    /**
     * Show the form for creating a new resource.
     *
     * @param Championship $championship
     * @param Season $season
     * @return Renderable
     */
    public function create(Championship $championship, Season $season)
    {
        return view('admin.race.create')
            ->with(
                [
                    'championship' => $championship,
                    'season' => $season,
                    'circuits' => Circuit::all(),
                ]
            );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Championship $championship
     * @param Season $season
     * @return RedirectResponse
     */
    public function store(Request $request, Championship $championship, Season $season)
    {
        $request->validate([
                               'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
                               'name' => [
                                   'required',
                                   'min:5',
                                   new IsRaceNameUnique($request->input('season_id'), $request->input('start_time')),
                               ],
                               'circuit_id' => ['required', 'integer', 'exists:circuits,id'],
                               'remarks' => ['string', 'nullable'],
                           ]);

        /** @var Race $race */
        $race = $season->races()->create($request->only('start_time', 'name', 'circuit_id', 'remarks'));

        return redirect()
            ->route('admin.race.index', ['championship' => $championship, 'season' => $season, 'race' => $race])
            ->with('success', __('The race :name has been added.', ['name' => $race->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param Race $race
     */
    public function show(Race $race)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @return Renderable
     */
    public function edit(Championship $championship, Season $season, Race $race)
    {
        $statuses = [
            [
                'id' => 'scheduled',
                'name' => __('Scheduled'),
            ],
            [
                'id' => 'postponed',
                'name' => __('Postponed'),
            ],
            [
                'id' => 'cancelled',
                'name' => __('Cancelled'),
            ],
        ];

        return view('admin.race.edit')->with([
                                                 'championship' => $championship,
                                                 'season' => $season,
                                                 'race' => $race,
                                                 'circuits' => Circuit::all(),
                                                 'statuses' => $statuses,
                                             ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @return RedirectResponse
     */
    public function update(Request $request, Championship $championship, Season $season, Race $race)
    {
        $request->validate([
                               'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
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
                               'remarks' => ['string', 'nullable'],
                               'status' => ['required', 'string', 'in:scheduled,postponed,cancelled'],
                           ]);

        $race->update($request->only('start_time', 'name', 'circuit_id', 'remarks', 'status'));

        return redirect()
            ->route('admin.race.index', ['championship' => $championship, 'season' => $season])
            ->with('success', __('The race :name has been changed.', ['name' => $race->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Race $race
     */
    public function destroy(Race $race)
    {
        //
    }
}
