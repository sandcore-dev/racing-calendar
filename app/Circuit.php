<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
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
}
