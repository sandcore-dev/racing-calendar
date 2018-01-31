<?php

namespace App\Http\Controllers\Admin;

use App\Season;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('admin.season.index')->with( 'seasons', Season::paginate() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.season.create');
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
			'year'		=> [ 'required', 'integer', 'between:1970,9999', 'unique:seasons,year' ],
			'header'	=> [ 'nullable', 'image' ],
			'footer'	=> [ 'nullable', 'image' ],
        ]);
        
        $data = $request->only('year');
        
        $data['access_token'] = str_random(10);
        
		foreach( [ 'header', 'footer' ] as $image )
			$data[$image . '_url'] = $request->file($image)->store('images');
        
        $season = Season::create($data);
        
        return redirect()->route('admin.season.index')->with( 'success', __('The season :season has been added.', [ 'season' => $season->name ]) );
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function edit(Season $season)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Season $season)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Season  $season
     * @return \Illuminate\Http\Response
     */
    public function destroy(Season $season)
    {
        //
    }
}
