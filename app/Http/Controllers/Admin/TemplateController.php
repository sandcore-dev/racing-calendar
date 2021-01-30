<?php

namespace App\Http\Controllers\Admin;

use App\Models\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.template.index')->with('templates', Template::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => [ 'required', 'unique:templates,name' ],
        ]);

        $template = Template::create($request->only('name'));

        return redirect()
            ->route('admin.template.index')
            ->with('success', __('The template :name has been added.', [ 'name' => $template->name ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Template $template)
    {
        return view('admin.template.edit')->with('template', $template);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name'              => [ 'required', 'unique:templates,name,' . $template->id ],
        ]);

        $template->update($request->only('name'));

        return redirect()
            ->route('admin.template.index')
            ->with('success', __('The template :name has been edited.', [ 'name' => $template->name ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     */
    public function destroy(Template $template)
    {
        //
    }
}
