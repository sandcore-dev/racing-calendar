<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RaceSession
 *
 * @property int $id
 * @property int $race_id
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $date
 * @property-read string $date_short
 * @property-read string $time
 * @property-read \App\Race $race
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RaceSession whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
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
     * @return  string
     */
    public function getDateAttribute()
    {
        return $this->start_time->formatLocalized('%d %B');
    }

    /**
     * Get localized short date.)
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
        return $this->start_time->formatLocalized('%R') . '-' . $this->end_time->formatLocalized('%R');
    }
}
