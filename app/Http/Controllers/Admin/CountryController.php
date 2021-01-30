<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Countries;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Monarobase\CountryList\CountryNotFoundException;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('admin.country.index')->with('countries', Country::paginate());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws CountryNotFoundException
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'      => [ 'required', 'size:2', 'unique:countries' ],
        ]);

        $country = Country::create([
            'code'  => $request->input('code'),
            'name'  => Countries::getOne($request->input('code'), config('app.locale')),
        ]);

        return redirect()
            ->route('admin.country.index')
            ->with('success', __('The country :name has been added.', [ 'name' => $country->name ]));
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Country $country
     * @return Factory|View
     */
    public function edit(Country $country)
    {
        return view('admin.country.edit')->with('country', $country);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Country $country
     * @return RedirectResponse
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name'      => [ 'required', 'min:2', 'unique:countries,name,' . $country->id ],
            'code'      => [ 'required', 'size:2', 'unique:countries,code,' . $country->id ],
        ]);

        $country->update($request->only('name', 'code'));

        return redirect()
            ->route('admin.country.index')
            ->with('success', __('The country :name has been updated.', [ 'name' => $country->name ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country $country
     */
    public function destroy(Country $country)
    {
        //
    }
}
