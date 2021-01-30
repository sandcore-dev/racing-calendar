<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.location.index')->with('locations', Location::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.location.create');
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
            'name'      => [ 'required', 'min:2', 'unique:locations' ],
        ]);

        $location = Location::create($request->only('name'));

        return redirect()
            ->route('admin.location.index')
            ->with('success', __('The location :name has been added.', [ 'name' => $location->name ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Location $location)
    {
        return view('admin.location.edit')->with('location', $location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name'      => [ 'required', 'min:2', 'unique:locations,name,' . $location->id ],
        ]);

        $location->update($request->only('name', 'code'));

        return redirect()
            ->route('admin.location.index')
            ->with('success', __('The location :name has been updated.', [ 'name' => $location->name ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     */
    public function destroy(Location $location)
    {
        //
    }
}
