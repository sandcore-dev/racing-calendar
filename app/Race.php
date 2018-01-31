<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Race extends Model
{
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_time'];
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByStartTime', function (Builder $builder) {
            $builder->orderBy('start_time', 'asc');
        });
    }

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
		return $this->belongsTo(Location::class)->withDefault();
	}
	
	/**
	 * Get localized date.
	 * 
	 * @return	string
	 */
	public function getDateAttribute()
	{
		return $this->start_time->formatLocalized('%e %B');
	}
	
	/**
	 * Get localized time.
	 * 
	 * @return	string
	 */
	public function getTimeAttribute()
	{
		return $this->start_time->formatLocalized('%R');
	}
}
