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
}
