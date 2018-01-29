<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
	/**
	 * Get the season of this race.
	 */
	public function season()
	{
		return $this->belongsTo(Season::class);
	}
	
	/**
	 * Get the circuit of this race.
	 */
	public function circuit()
	{
		return $this->belongsTo(Circuit::class);
	}
	
	/**
	 * Get the location of this race.
	 */
	public function location()
	{
		return $this->belongsTo(Location::class);
	}
}
