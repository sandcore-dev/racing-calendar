<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'city', 'area', 'country_id',
    ];

	/**
	 * Eager loading.
	 * 
	 * @var array
	 */
	protected $_with = [ 'country' ];
	
	/**
	 * Get the races held at this circuit.
	 */
	public function races()
	{
		return $this->hasMany(Race::class);
	}
	
	/**
	 * Get the country of this circuit.
	 */
	public function country()
	{
		return $this->belongsTo(Country::class);
	}
	
	/**
	 * Get full location of this circuit.
	 * 
	 * @return string
	 */
	public function getLocationAttribute()
	{
		$location = $this->city;
		
		if( $this->area )
			$location .= ', ' . $this->area;
		
		$location .= ', '. __($this->country->name);
		
		return $location;
	}
	
	/**
	 * Get full name of this circuit.
	 * 
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return $this->name . ', ' . $this->location;
	}
}
