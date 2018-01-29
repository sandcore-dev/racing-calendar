<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Get races held at this location.
     */
    public function races()
    {
		return $this->hasMany(Race::class);
    }
    
    /**
     * Get seasons this location is eligible for.
     */
    public function seasons()
    {
		return $this->belongsToMany(Season::class);
    }
}
