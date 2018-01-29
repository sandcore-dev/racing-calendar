<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
	/**
	 * Get races of this season.
	 */
	public function races()
	{
		return $this->hasMany(Race::class);
	}
	
	/**
	 * Get available locations for this season.
	 */
	public function locations()
	{
		return $this->belongsToMany(Location::class);
	}
}
