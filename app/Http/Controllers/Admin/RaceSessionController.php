<?php

namespace App\Http\Controllers\Admin;

use App\Race;
use App\RaceSession;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class RaceSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Race $race)
    {
        return view('admin.race.session.index')->with([
            'race' => $race,
            'sessions' => $race->sessions()->paginate(),
            'templates' => Template::all(),
         ]);
    }

    /**
     * Apply template to race.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function applyTemplate(Request $request) {
        $request->validate([
            'race'      => [ 'required', 'integer', 'exists:races,id' ],
            'template'  => [ 'required', 'integer', 'exists:templates,id' ],
		]);

        $race = Race::find($request->input('race'));
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

            RaceSession::create([
                'race_id' => $race->id,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'name' => $session->name,
            ]);
        });

        return redirect()->route('admin.race.session.index', [ 'race' => $race->id ])->with( 'success', __('The template has been applied.') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Race $race)
    {
        return view('admin.race.session.create')->with('race', $race);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Templat  $race
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Race $race)
    {
        $ruleUniqueSessionName = Rule::unique('race_sessions')->where(function ($query) use ($race) {
            return $query->where('race_id', $race->id);
        });

        $request->validate([
            'start_time'	=> [ 'required', 'date_format:Y-m-d H:i:s' ],
            'end_time'      => [ 'required', 'date_format:Y-m-d H:i:s' ],
            'name'			=> [ 'required', $ruleUniqueSessionName ],
        ]);

        $data = $request->only('start_time', 'end_time', 'name');
        $data['race_id'] = $race->id;

        $session = raceSession::create($data);

        return redirect()->route('admin.race.session.index', [ 'race' => $race->id ])->with( 'success', __('The session :name has been added.', [ 'name' => $session->name ]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\raceSession  $raceSession
     * @return \Illuminate\Http\Response
     */
    public function show(RaceSession $raceSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\raceSession  $raceSession
     * @return \Illuminate\Http\Response
     */
    public function edit(Race $race, raceSession $session)
    {
        return view('admin.race.session.edit')->with([
            'race' => $race,
            'session' => $session,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\raceSession  $raceSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, race $race, raceSession $session)
    {
        $ruleUniqueSessionName = Rule::unique('race_sessions')->ignore($session->id)->where(function ($query) use ($race) {
            return $query->where('race_id', $race->id);
        });

        $request->validate([
            'start_time'	=> [ 'required', 'date_format:Y-m-d H:i:s' ],
            'end_time'      => [ 'required', 'date_format:Y-m-d H:i:s' ],
            'name'			=> [ 'required', $ruleUniqueSessionName ],
        ]);

        $session->update($request->only('start_time', 'end_time', 'name'));

        return redirect()->route('admin.race.session.index', [ 'race' => $race->id ])->with( 'success', __('The session :name has been edited.', [ 'name' => $session->name ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\raceSession  $raceSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(RaceSession $raceSession)
    {
        //
    }
}
