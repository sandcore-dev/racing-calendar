<?php

namespace App\Http\Controllers\Admin;

use App\Championship;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ChampionshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('admin.championship.index')->with('championships', Championship::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('admin.championship.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:championships,name'],
            'domain' => ['required', 'string', 'unique:championships,domain'],
        ]);

        $championship = Championship::create($request->only('name', 'domain'));

        return redirect()
            ->route("admin.championship.index")
            ->with('success', __('The championship :name has been added.', [ 'name' => $championship->name ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Championship $championship
     * @return Renderable
     */
    public function edit(Championship $championship)
    {
        return view('admin.championship.edit')->with('championship', $championship);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Championship $championship
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Championship $championship)
    {
        $request->validate([
            'name' => ['required', 'string', Rule::unique('championships', 'name')->ignoreModel($championship)],
            'domain' => ['required', 'string', Rule::unique('championships', 'domain')->ignoreModel($championship)],
        ]);

        $championship->update($request->only('name', 'domain'));

        return redirect()
            ->route("admin.championship.index")
            ->with('success', __('The championship :name has been edited.', [ 'name' => $championship->name ]));
    }
}
