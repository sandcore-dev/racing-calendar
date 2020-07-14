<?php

namespace App\Http\Controllers\Admin;

use App\Championship;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rules\IsRaceNameUnique;
use App\Circuit;
use App\Season;
use App\Race;
use Illuminate\Validation\Rule;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Championship $championship
     * @param Season $season
     * @return Renderable
     */
    public function index(Championship $championship, Season $season)
    {
        return view('admin.race.index')->with([
            'championship' => $championship,
            'previousSeasons' => $championship->seasons()->where('year', '<', $season->year)->get(),
            'season' => $season,
            'races' => $season->races()->paginate(30),
        ]);
    }

    /**
     * Copy races from the given season.
     *
     * @param Request $request
     * @param Championship $championship
     * @param Season $season
     * @return RedirectResponse
     */
    public function copySeason(Request $request, Championship $championship, Season $season)
    {
        $request->validate([
            'copyFromSeason' => ['required', 'integer', 'exists:seasons,id', Rule::notIn([$season->id])],
        ]);

        $copyFromSeason = Season::find($request->input('copyFromSeason'));

        $copyFromSeason->races->each(function (Race $race) use ($season) {
            $start_time = clone $race->start_time;
            $start_time->year($season->year);

            $season->races()->create([
                'start_time' => $start_time,
                'name' => $race->name,
                'circuit_id' => $race->circuit_id,
                'remarks' => '',
            ]);
        });

        return redirect()
            ->route('admin.race.index', ['championship' => $championship, 'season' => $season])
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
        return view('admin.race.create')->with([
            'championship' => $championship,
            'season' => $season,
            'circuits' => Circuit::all(),
        ]);
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
                new IsRaceNameUnique($request->input('season_id'), $request->input('start_time'))
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
                new IsRaceNameUnique($request->input('season_id'), $request->input('start_time'), $race->id)
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
