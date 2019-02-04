<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaceSession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'race_id',
		'start_time',
		'end_time',
        'name',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_time',
        'end_time',
    ];

    /**
	 * Get the template of this session.
	 */
	public function race()
	{
		return $this->belongsTo(Race::class);
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
	 * Get localized short date.)
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
		return $this->start_time->formatLocalized('%R') . '-' . $this->end_time->formatLocalized('%R');
	}
}
