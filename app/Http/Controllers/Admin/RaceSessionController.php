<?php

namespace App\Http\Controllers\Admin;

use App\Models\Championship;
use App\Models\Race;
use App\Models\RaceSession;
use App\Models\Season;
use App\Models\Template;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RaceSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @return Factory|View
     */
    public function index(Championship $championship, Season $season, Race $race)
    {
        return view('admin.race.session.index')->with([
            'championship' => $championship,
            'season' => $season,
            'race' => $race,
            'sessions' => $race->sessions()->paginate(),
            'templates' => Template::all(),
        ]);
    }

    /**
     * Apply template to race.
     *
     * @param Request $request
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @return RedirectResponse
     */
    public function applyTemplate(Request $request, Championship $championship, Season $season, Race $race)
    {
        $request->validate([
            'template' => ['required', 'integer', 'exists:templates,id'],
        ]);

        $template = Template::find($request->input('template'));

        $template->sessions->each(function ($session) use ($race) {
            $start_time = clone $race->start_time;
            $end_time = clone $race->start_time;

            $start_time->subDays($session->days);
            $end_time->subDays($session->days);

            list($start_hour, $start_min) = explode(':', $session->start_time);
            list($end_hour, $end_min) = explode(':', $session->end_time);

            $start_time->hour($start_hour)->minute($start_min);
            $end_time->hour($end_hour)->minute($end_min);

            $race->sessions()->create([
                'race_id' => $race->id,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'name' => $session->name,
            ]);
        });

        return redirect()
            ->route('admin.race.session.index', ['championship' => $championship, 'season' => $season, 'race' => $race])
            ->with('success', __('The template has been applied.'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @return Factory|View
     */
    public function create(Championship $championship, Season $season, Race $race)
    {
        return view('admin.race.session.create')
            ->with([
                'championship' => $championship,
                'season' => $season,
                'race' => $race,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @return RedirectResponse
     */
    public function store(Request $request, Championship $championship, Season $season, Race $race)
    {
        $ruleUniqueSessionName = Rule::unique('race_sessions')->where(function (Builder $query) use ($race) {
            return $query->where('race_id', $race->id);
        });

        $request->validate([
            'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'name' => ['required', $ruleUniqueSessionName],
        ]);

        $data = $request->only('start_time', 'end_time', 'name');
        $data['race_id'] = $race->id;

        /** @var RaceSession $session */
        $session = $race->sessions()->create($data);

        return redirect()
            ->route('admin.race.session.index', ['championship' => $championship, 'season' => $season, 'race' => $race])
            ->with('success', __('The session :name has been added.', ['name' => $session->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\RaceSession $raceSession
     */
    public function show(RaceSession $raceSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @param RaceSession $session
     * @return Factory|View
     */
    public function edit(Championship $championship, Season $season, Race $race, RaceSession $session)
    {
        return view('admin.race.session.edit')->with([
            'championship' => $championship,
            'season' => $season,
            'race' => $race,
            'session' => $session,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Championship $championship
     * @param Season $season
     * @param Race $race
     * @param RaceSession $session
     * @return RedirectResponse
     */
    public function update(Request $request, Championship $championship, Season $season, Race $race, RaceSession $session)
    {
        $ruleUniqueSessionName = Rule::unique('race_sessions')
            ->ignore($session->id)
            ->where(function (Builder $query) use ($race) {
                return $query->where('race_id', $race->id);
            });

        $request->validate([
            'start_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'name' => ['required', $ruleUniqueSessionName],
        ]);

        $session->update($request->only('start_time', 'end_time', 'name'));

        return redirect()
            ->route('admin.race.session.index', ['championship' => $championship, 'season' => $season, 'race' => $race])
            ->with('success', __('The session :name has been edited.', ['name' => $session->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\RaceSession $raceSession
     */
    public function destroy(RaceSession $raceSession)
    {
        //
    }
}
