<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Race
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $start_time
 * @property string $name
 * @property int $season_id
 * @property int $circuit_id
 * @property int|null $location_id
 * @property string|null $remarks
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Circuit $circuit
 * @property-read string $date
 * @property-read string $date_short
 * @property-read bool $this_week
 * @property-read string $time
 * @property-read \App\Models\Location|null $location
 * @property-read Season $season
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RaceSession[] $sessions
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
 * @method static Builder|Race whereStatus($value)
 * @method static Builder|Race whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Race extends Model
{
    use HasFactory;

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
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('sortByStartTime', function (Builder $builder) {
            $builder->orderBy('start_time', 'asc');
        });
    }

    /**
     * Get the season of this race.
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the circuit of this race.
     */
    public function circuit(): BelongsTo
    {
        return $this->belongsTo(Circuit::class);
    }

    /**
     * Get the location of this race.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class)
            ->withDefault();
    }

    /**
     * Get the sessions of this race.
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(RaceSession::class);
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
     * Get localized date.
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
        return $this->start_time->formatLocalized('%R');
    }

    /**
     * Is the start time within 7 days?
     *
     * @return  boolean
     */
    public function getThisWeekAttribute(): bool
    {
        $diffInDays = $this->start_time->diffInDays(null, false);
        return 0 >= $diffInDays && $diffInDays > -7;
    }

    /**
     * Sanitize and set remarks.
     *
     * @param string|null $value The value to sanitize.
     * @return string|null
     */
    public function setRemarksAttribute(?string $value): ?string
    {
        return $this->attributes['remarks'] = $value === null
            ? null
            : strip_tags($value);
    }

    /**
     * Scope to season.
     *
     * @param Builder $query
     * @param Season $season
     *
     * @return Builder
     */
    public function scopeBySeason(Builder $query, Season $season): Builder
    {
        return $query->where('season_id', $season->id);
    }
}
