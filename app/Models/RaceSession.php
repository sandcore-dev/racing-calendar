<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\RaceSession
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
 * @property-read \App\Models\Race $race
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession whereRaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|RaceSession whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class RaceSession extends Model
{
    use HasFactory;

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
    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }

    /**
     * Get localized date.
     *
     * @return  string
     */
    public function getDateAttribute(): string
    {
        return $this->start_time->formatLocalized('%d %B');
    }

    /**
     * Get localized short date.)
     *
     * @return  string
     */
    public function getDateShortAttribute(): string
    {
        return $this->start_time->formatLocalized('%d %b');
    }

    /**
     * Get localized time.
     *
     * @return  string
     */
    public function getTimeAttribute(): string
    {
        return $this->start_time->formatLocalized('%R') . '-' . $this->end_time->formatLocalized('%R');
    }
}
