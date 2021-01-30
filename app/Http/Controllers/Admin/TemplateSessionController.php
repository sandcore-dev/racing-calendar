<?php

namespace App\Http\Controllers\Admin;

use App\Models\Template;
use App\Models\TemplateSession;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TemplateSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Template $template
     * @return Factory|View
     */
    public function index(Template $template)
    {
        return view('admin.template.session.index')->with([
            'template' => $template,
            'sessions' => $template->sessions()->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Template $template
     * @return Factory|View
     */
    public function create(Template $template)
    {
        return view('admin.template.session.create')->with('template', $template);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Template $template
     * @return RedirectResponse
     */
    public function store(Request $request, Template $template)
    {
        $request->validate([
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
        ]);

        $data = $request->only('days', 'start_time', 'end_time', 'name');
        $data['template_id'] = $template->id;

        $session = TemplateSession::create($data);

        return redirect()
            ->route('admin.template.session.index', ['template' => $template->id])
            ->with('success', __('The session :name has been added.', ['name' => $session->name]));
    }

    /**
     * Display the specified resource.
     *
     * @param TemplateSession $templateSession
     */
    public function show(TemplateSession $templateSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Template $template
     * @param TemplateSession $session
     * @return Factory|View
     */
    public function edit(Template $template, TemplateSession $session)
    {
        if ($session->template->id != $template->id) {
            abort(Response::HTTP_BAD_REQUEST, 'This session does not belong to this template');
        }

        return view('admin.template.session.edit')->with([
            'template' => $template,
            'session' => $session,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Template $template
     * @param TemplateSession $session
     * @return RedirectResponse
     */
    public function update(Request $request, Template $template, TemplateSession $session)
    {
        if ($session->template->id != $template->id) {
            abort(Response::HTTP_BAD_REQUEST, 'This session does not belong to this template');
        }

        $request->validate([
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
        ]);

        $session->update($request->only('days', 'start_time', 'end_time', 'name'));

        return redirect()
            ->route('admin.template.session.index', ['template' => $template->id])
            ->with('success', __('The session :name has been edited.', ['name' => $session->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TemplateSession $templateSession
     */
    public function destroy(TemplateSession $templateSession)
    {
        //
    }
}
