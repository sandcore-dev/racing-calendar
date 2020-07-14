<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Race
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $start_time
 * @property string $name
 * @property int $season_id
 * @property int $circuit_id
 * @property int|null $location_id
 * @property string $remarks
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Circuit $circuit
 * @property-read string $date
 * @property-read string $date_short
 * @property-read bool $this_week
 * @property-read string $time
 * @property-read \App\Location|null $location
 * @property-read \App\Season $season
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RaceSession[] $sessions
 * @property-read int|null $sessions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race bySeason(\App\Season $season)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereCircuitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereSeasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Race whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Race extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'season_id', 'start_time', 'name', 'circuit_id', 'location_id', 'remarks', 'status',
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
     * @return  string
     */
    public function getDateAttribute()
    {
        return $this->start_time->formatLocalized('%d %B');
    }

    /**
     * Get localized date.
     *
     * @return  string
     */
    public function getDateShortAttribute()
    {
        return $this->start_time->formatLocalized('%d %b');
    }

    /**
     * Get localized time.
     *
     * @return  string
     */
    public function getTimeAttribute()
    {
        return $this->start_time->formatLocalized('%R');
    }

    /**
     * Is the start time within 7 days?
     *
     * @return  boolean
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
    public function scopeBySeason(Builder $query, Season $season)
    {
        return $query->where('season_id', $season->id);
    }
}
