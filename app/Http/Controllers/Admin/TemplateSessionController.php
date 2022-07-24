<?php

namespace App\Http\Controllers\Admin;

use App\Models\Template;
use App\Models\TemplateSession;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class TemplateSessionController extends Controller
{
    public function index(Template $template): Response
    {
        return Inertia::render(
            'Admin/Template/Session/Index',
            [
                'title' => Lang::get('Admin')
                    . ': ' . $template->name
                    . ' - ' . Lang::get('Sessions for template :template', ['template' => $template->name]),

                'labels' => [
                    'title' => Lang::get('Sessions for template :template', ['template' => $template->name]),
                    'back' => Lang::get('Back to template index'),
                    'date' => Lang::get('Datum'),
                    'startTime' => Lang::get('Start time'),
                    'endTime' => Lang::get('End time'),
                    'name' => Lang::get('Name'),
                ],

                'adminAddUrl' => route(
                    'admin.template.session.create',
                    [
                        'template' => $template,
                    ]
                ),

                'adminBackUrl' => route(
                    'admin.template.index',
                    [
                        'template' => $template,
                    ]
                ),

                'templateSessions' => $template->sessions()
                    ->paginate(),
            ]
        );
    }

    public function create(Template $template): Response
    {
        return Inertia::render(
            'Admin/Template/Session/Form',
            [
                'title' => Lang::get('Admin')
                    . ' ' . $template->name
                    . ' - ' . Lang::get('Add session'),

                'header' => Lang::get(
                    'Add template session for :template',
                    [
                        'template' => $template->name,
                    ]
                ),

                'url' => route(
                    'admin.template.session.store',
                    [
                        'template' => $template,
                    ]
                ),

                'labels' => [
                    'days' => Lang::get('Days'),
                    'start_time' => Lang::get('Start time'),
                    'end_time' => Lang::get('End time'),
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Add'),
                ],

                'locale' => App::currentLocale(),
            ]
        );
    }

    public function store(Request $request, Template $template): RedirectResponse
    {
        $request->validate(
            [
                'days' => ['required', 'integer'],
                'start_time' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
                'end_time' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
                'name' => [
                    'required',
                    Rule::unique('template_sessions', 'name')
                        ->where(function (Builder $query) use ($template) {
                            $query->where('template_id', $template->id);
                        }),
                ],
            ]
        );

        $data = $request->only('days', 'start_time', 'end_time', 'name');
        $data['template_id'] = $template->id;

        $session = TemplateSession::create($data);

        return Redirect::route('admin.template.session.index', ['template' => $template->id])
            ->with('success', __('The session :name has been added.', ['name' => $session->name]));
    }

    public function edit(Template $template, TemplateSession $session): Response
    {
        return Inertia::render(
            'Admin/Template/Session/Form',
            [
                'title' => Lang::get('Admin')
                    . ' ' . $template->name
                    . ' - ' . Lang::get('Edit session'),

                'header' => Lang::get(
                    'Edit :template session :session',
                    [
                        'template' => $template->name,
                        'session' => $session->name,
                    ]
                ),

                'edit' => true,
                'url' => route(
                    'admin.template.session.update',
                    [
                        'template' => $template,
                        'session' => $session,
                    ]
                ),

                'labels' => [
                    'days' => Lang::get('Days'),
                    'start_time' => Lang::get('Start time'),
                    'end_time' => Lang::get('End time'),
                    'name' => Lang::get('Name'),
                    'submit' => Lang::get('Edit'),
                ],

                'locale' => App::currentLocale(),

                'data' => $session->only(['days', 'start_time', 'end_time', 'name']),
            ]
        );
    }

    public function update(Request $request, Template $template, TemplateSession $session): RedirectResponse
    {
        $request->validate(
            [
                'days' => ['required', 'integer'],
                'start_time' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
                'end_time' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
                'name' => [
                    'required',
                    Rule::unique('template_sessions', 'name')
                        ->ignore($session->id)
                        ->where(function (Builder $query) use ($template) {
                            $query->where('template_id', $template->id);
                        }),
                ],
            ]
        );

        $session->update($request->only('days', 'start_time', 'end_time', 'name'));

        return Redirect::route('admin.template.session.index', ['template' => $template->id])
            ->with('success', __('The session :name has been edited.', ['name' => $session->name]));
    }
}
