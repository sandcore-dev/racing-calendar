<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.country.index')->with( 'countries', Country::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'name'		=> [ 'required', 'min:2', 'unique:countries' ],
			'code'		=> [ 'required', 'size:2', 'unique:countries' ],
        ]);
        
        $country = Country::create( $request->only( 'name', 'code' ) );
        
        return redirect()->route('admin.country.index')->with( 'success', __('The country :name has been added.', [ 'name' => $country->name ]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.country.edit')->with( 'country', $country );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
			'name'		=> [ 'required', 'min:2', 'unique:countries,name,' . $country->id ],
			'code'		=> [ 'required', 'size:2', 'unique:countries,code,' . $country->id ],
        ]);
        
        $country->update( $request->only( 'name', 'code' ) );
        
        return redirect()->route('admin.country.index')->with( 'success', __('The country :name has been updated.', [ 'name' => $country->name ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
    }
}
