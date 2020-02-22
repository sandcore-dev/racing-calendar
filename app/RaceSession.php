<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\RaceSession
 *
 * @property int $id
 * @property int $race_id
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string $date
 * @property-read string $date_short
 * @property-read string $time
 * @property-read Race $race
 * @method static Builder|RaceSession newModelQuery()
 * @method static Builder|RaceSession newQuery()
 * @method static Builder|RaceSession query()
 * @method static Builder|RaceSession whereCreatedAt($value)
 * @method static Builder|RaceSession whereEndTime($value)
 * @method static Builder|RaceSession whereId($value)
 * @method static Builder|RaceSession whereName($value)
 * @method static Builder|RaceSession whereRaceId($value)
 * @method static Builder|RaceSession whereStartTime($value)
 * @method static Builder|RaceSession whereUpdatedAt($value)
 * @mixin Eloquent
 */
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
