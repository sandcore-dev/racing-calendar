<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Race extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'season_id', 'start_time', 'name', 'circuit_id', 'location_id',
    ];

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
		return $this->start_time->formatLocalized('%d %B');
	}

	/**
	 * Get localized date.
	 *
	 * @return	string
	 */
	public function getDateShortAttribute()
	{
		return $this->start_time->formatLocalized('%d %b');
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

	/**
	 * Is the start time within 7 days?
	 *
	 * @return	boolean
	 */
	public function getThisWeekAttribute()
	{
        $diffInDays = $this->start_time->diffInDays(null, false);
		return 0 >= $diffInDays && $diffInDays > -7;
	}

	/**
	 * Scope to season.
	 *
	 * @param	\Illuminate\Database\Eloquent\Builder	$query
	 * @param	\App\Season								$season
	 *
	 * @return	\Illuminate\Database\Eloquent\Builder
	 */
	public function scopeBySeason( Builder $query, Season $season )
	{
		return $query->where( 'season_id', $season->id );
	}
}
