<?php

namespace App\Http\Controllers\Admin;

use App\Template;
use App\TemplateSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplateSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Template $template)
    {
        return view('admin.template.session.index')->with([
            'template' => $template,
            'sessions' => TemplateSession::paginate(),
         ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Template $template)
    {
        return view('admin.template.session.create')->with('template', $template);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Template  $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Template $template)
    {
        $request->validate([
            'days'          => [ 'required', 'integer' ],
            'start_time'    => [ 'required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/' ],
            'end_time'      => [ 'required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/' ],
            'name'          => [ 'required', 'unique:template_sessions,name' ],
        ]);

        $data = $request->only('days', 'start_time', 'end_time', 'name');
        $data['template_id'] = $template->id;

        $session = TemplateSession::create($data);

        return redirect()
            ->route('admin.template.session.index', [ 'template' => $template->id ])
            ->with('success', __('The session :name has been added.', [ 'name' => $session->name ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TemplateSession  $templateSession
     */
    public function show(TemplateSession $templateSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TemplateSession  $templateSession
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Template $template, TemplateSession $session)
    {
        return view('admin.template.session.edit')->with([
            'template' => $template,
            'session' => $session,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TemplateSession  $templateSession
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Template $template, TemplateSession $session)
    {
        $request->validate([
            'days'          => [ 'required', 'integer' ],
            'start_time'    => [ 'required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/' ],
            'end_time'      => [ 'required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/' ],
            'name'          => [ 'required', 'unique:template_sessions,name,' . $session->id ],
        ]);

        $session->update($request->only('days', 'start_time', 'end_time', 'name'));

        return redirect()
            ->route('admin.template.session.index', [ 'template' => $template->id ])
            ->with('success', __('The session :name has been edited.', [ 'name' => $session->name ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TemplateSession  $templateSession
     */
    public function destroy(TemplateSession $templateSession)
    {
        //
    }
}
