<?php

namespace App\Http\Controllers\Admin;

use App\Models\Championship;
use App\Models\Race;
use App\Models\RaceSession;
use App\Models\Season;
use App\Models\Template;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class RaceSessionController extends Controller
{
    public function index(Championship $championship, Season $season, Race $race): Response
    {
        return Inertia::render(
            'Admin/Race/Session/Index',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' ' . $season->year
                    . ' - ' . $race->name
                    . ' - ' . Lang::get('Sessions'),

                'labels' => [
                    'title' => "{$championship->name} {$season->year} {$race->name}",
                    'back' => Lang::get('Back to race index'),
                    'date' => Lang::get('Datum'),
                    'startTime' => Lang::get('Start time'),
                    'endTime' => Lang::get('End time'),
                    'name' => Lang::get('Name'),
                    'applyTemplate' => Lang::get('Apply template'),
                ],

                'adminAddUrl' => route(
                    'admin.race.session.create',
                    [
                        'championship' => $championship,
                        'season' => $season,
                        'race' => $race,
                    ]
                ),

                'adminApplyTemplateUrl' => route(
                    'admin.race.session.apply-template',
                    [
                        'championship' => $championship,
                        'season' => $season,
                        'race' => $race,
                    ]
                ),

                'adminBackUrl' => route(
                    'admin.race.index',
                    [
                        'championship' => $championship,
                        'season' => $season,
                        'race' => $race,
                    ]
                ),

                'templates' => Template::select(['id', 'name'])->get(),

                'raceSessions' => $race->sessions()
                    ->paginate(),
            ]
        );
    }

    public function applyTemplate(
        Request $request,
        Championship $championship,
        Season $season,
        Race $race
    ): RedirectResponse {
        $request->validate(
            [
                'templateId' => ['required', 'integer', 'exists:templates,id'],
            ]
        );

        $template = Template::find($request->input('templateId'));

        $template->sessions->each(function ($session) use ($race) {
            $start_time = clone $race->start_time;
            $end_time = clone $race->start_time;

            $start_time->subDays($session->days);
            $end_time->subDays($session->days);

            [$start_hour, $start_min] = explode(':', $session->start_time);
            [$end_hour, $end_min] = explode(':', $session->end_time);

            $start_time->hour($start_hour)->minute($start_min);
            $end_time->hour($end_hour)->minute($end_min);

            $race->sessions()->create(
                [
                    'race_id' => $race->id,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'name' => $session->name,
                ]
            );
        });

        return Redirect::route('admin.race.session.index', [
            'championship' => $championship,
            'season' => $season,
            'race' => $race,
        ])
            ->with('success', __('The template has been applied.'));
    }

    public function create(Championship $championship, Season $season, Race $race): Response
    {
        return Inertia::render(
            'Admin/Race/Session/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' ' . $season->year
                    . ' ' . $race->name
                    . ' - ' . Lang::get('Add session'),

                'header' => Lang::get(
                    'Add race session for :championship season :season :race',
                    [
                        'championship' => $championship->name,
                        'season' => $season->year,
                        'race' => $race->name,
                    ]
                ),

                'url' => route(
                    'admin.race.session.store',
                    [
                        'championship' => $championship,
                        'season' => $season,
                        'race' => $race,
                    ]
                ),

                'labels' => [
                    'start_time' => Lang::get('Start time'),
                    'end_time' => Lang::get('End time'),
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Add'),
                ],

                'locale' => App::currentLocale(),
                'year' => $season->year,
            ]
        );
    }

    public function store(Request $request, Championship $championship, Season $season, Race $race): RedirectResponse
    {
        $ruleUniqueSessionName = Rule::unique('race_sessions')->where(function (Builder $query) use ($race) {
            return $query->where('race_id', $race->id);
        });

        $request->validate(
            [
                'start_time' => ['required', 'date'],
                'end_time' => ['required', 'date'],
                'name' => ['required', $ruleUniqueSessionName],
            ]
        );

        /** @var RaceSession $session */
        $session = $race->sessions()
            ->create(
                [
                    'race_id' => $race->id,
                    'start_time' => $request->date('start_time')->setTimezone(config('app.timezone')),
                    'end_time' => $request->date('end_time')->setTimezone(config('app.timezone')),
                    'name' => $request->input('name'),
                ]
            );

        return Redirect::route(
            'admin.race.session.index',
            ['championship' => $championship, 'season' => $season, 'race' => $race]
        )
            ->with('success', __('The session :name has been added.', ['name' => $session->name]));
    }

    public function edit(Championship $championship, Season $season, Race $race, RaceSession $session): Response
    {
        return Inertia::render(
            'Admin/Race/Session/Form',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $championship->name
                    . ' ' . $season->year
                    . ' ' . $race->name
                    . ' - ' . Lang::get('Add session'),

                'header' => Lang::get(
                    'Edit race session :championship season :season :race :session',
                    [
                        'championship' => $championship->name,
                        'season' => $season->year,
                        'race' => $race->name,
                        'session' => $session->name,
                    ]
                ),

                'edit' => true,
                'url' => route(
                    'admin.race.session.update',
                    [
                        'championship' => $championship,
                        'season' => $season,
                        'race' => $race,
                        'session' => $session,
                    ]
                ),

                'labels' => [
                    'start_time' => Lang::get('Start time'),
                    'end_time' => Lang::get('End time'),
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Edit'),
                ],

                'locale' => App::currentLocale(),
                'year' => $season->year,

                'data' => $session->only(
                    [
                        'start_time',
                        'end_time',
                        'name',
                    ]
                ),
            ]
        );
    }

    public function update(
        Request $request,
        Championship $championship,
        Season $season,
        Race $race,
        RaceSession $session
    ): RedirectResponse {
        $ruleUniqueSessionName = Rule::unique('race_sessions')
            ->ignore($session->id)
            ->where(function (Builder $query) use ($race) {
                return $query->where('race_id', $race->id);
            });

        $request->validate(
            [
                'start_time' => ['required', 'date'],
                'end_time' => ['required', 'date'],
                'name' => ['required', $ruleUniqueSessionName],
            ]
        );

        $session->update(
            [
                'start_time' => $request->date('start_time')->setTimezone(config('app.timezone')),
                'end_time' => $request->date('end_time')->setTimezone(config('app.timezone')),
                'name' => $request->input('name'),
            ]
        );

        return redirect()
            ->route('admin.race.session.index', ['championship' => $championship, 'season' => $season, 'race' => $race])
            ->with('success', __('The session :name has been edited.', ['name' => $session->name]));
    }
}
