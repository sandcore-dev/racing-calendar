<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	/**
	 * Get circuits in this country.
	 */
	public function circuits()
	{
		return $this->hasMany(Circuit::class);
	}
}
