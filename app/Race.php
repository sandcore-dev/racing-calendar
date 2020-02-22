<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Race
 *
 * @property int $id
 * @property Carbon $start_time
 * @property string $name
 * @property int $season_id
 * @property int $circuit_id
 * @property int|null $location_id
 * @property string $remarks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Circuit $circuit
 * @property-read string $date
 * @property-read string $date_short
 * @property-read bool $this_week
 * @property-read string $time
 * @property-read Location|null $location
 * @property-read Season $season
 * @property-read Collection|RaceSession[] $sessions
 * @property-read int|null $sessions_count
 * @method static Builder|Race bySeason(Season $season)
 * @method static Builder|Race newModelQuery()
 * @method static Builder|Race newQuery()
 * @method static Builder|Race query()
 * @method static Builder|Race whereCircuitId($value)
 * @method static Builder|Race whereCreatedAt($value)
 * @method static Builder|Race whereId($value)
 * @method static Builder|Race whereLocationId($value)
 * @method static Builder|Race whereName($value)
 * @method static Builder|Race whereRemarks($value)
 * @method static Builder|Race whereSeasonId($value)
 * @method static Builder|Race whereStartTime($value)
 * @method static Builder|Race whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Race extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'season_id', 'start_time', 'name', 'circuit_id', 'location_id', 'remarks',
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
	 * Get the sessions of this race.
	 */
	public function sessions()
	{
		return $this->hasMany(RaceSession::class);
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
     * Sanitize and set remarks.
     *
     * @param string $value The value to sanitize.
     */
    public function setRemarksAttribute($value)
    {
        $this->attributes['remarks'] = strip_tags($value);
    }

	/**
	 * Scope to season.
	 *
	 * @param Builder $query
	 * @param Season $season
	 *
	 * @return    Builder
	 */
	public function scopeBySeason( Builder $query, Season $season )
	{
		return $query->where( 'season_id', $season->id );
	}
}
