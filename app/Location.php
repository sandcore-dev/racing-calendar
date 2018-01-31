<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Location extends Model
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

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
