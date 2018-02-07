<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

use App\AccessToken;
use App\Season;

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
			'year'			=> [ 'required', 'integer', 'between:1970,9999', 'unique:seasons,year' ],
			'header_image'	=> [ 'nullable', 'image' ],
			'footer_image'	=> [ 'nullable', 'image' ],
        ]);
        
        $data = $request->only('year');
        
		foreach( [ 'header_image', 'footer_image' ] as $field )
			if( $request->file( $field ) )
				$data[$field] = $request->file( $field )->store('public/images');
        
        $season = Season::create($data);
        
        AccessTokenController::generate( $season );
        
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
        return view('admin.season.edit')->with( 'season', $season );
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
        $request->validate([
			'year'				=> [ 'required', 'integer', 'between:1970,9999', 'unique:seasons,year,' . $season->id ],
			'header_image'		=> [ 'nullable', 'image' ],
			'footer_image'		=> [ 'nullable', 'image' ],
			'regenerate_token'	=> [ 'required', 'boolean' ],
			'locations.*'		=> [ 'integer', 'exists:locations,id' ],
        ]);
        
        $data = $request->only('year');
        
		foreach( [ 'header_image', 'footer_image' ] as $field )
			if( $request->file( $field ) )
			{
				if( $data[$field] = $request->file( $field )->store('public/images') )
					Storage::delete( $season->{$field} );
			}
			elseif( $request->input( 'remove_' . $field ) )
				Storage::delete( $season->{$field} );
			
        $season->locations()->sync( $request->input('locations') );
        
		if( $request->input('regenerate_token') )
		{
			$season->access_token->delete();
			
			AccessTokenController::generate( $season );
		}
		
		$season->update( $data );

        return redirect()->route('admin.season.index')->with( 'success', __('The season :season has been edited.', [ 'season' => $season->name ]) );
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
