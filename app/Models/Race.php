<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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
 * @property-read string $circuit_city
 * @property-read string $country_flag
 * @property-read string $country_local_name
 * @property-read string $date
 * @property-read string $date_short
 * @property-read array $details
 * @property-read string|null $location_name
 * @property-read bool $this_week
 * @property-read string $time
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\Season $season
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RaceSession[] $sessions
 * @property-read int|null $sessions_count
 * @method static Builder|Race bySeason(\App\Models\Season $season)
 * @method static \Database\Factories\RaceFactory factory(...$parameters)
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

    protected $fillable = [
        'season_id',
        'start_time',
        'name',
        'circuit_id',
        'location_id',
        'remarks',
        'status',
    ];

    protected $dates = ['start_time'];

    protected $appends = [
        'admin_edit_url',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('orderByStartTime', function (Builder $query) {
            $query->orderBy('start_time');
        });
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function circuit(): BelongsTo
    {
        return $this->belongsTo(Circuit::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class)
            ->withDefault();
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(RaceSession::class);
    }

    public function scopeBySeason(Builder $query, Season $season): Builder
    {
        return $query->where('season_id', $season->id);
    }

    public function getDateAttribute(): string
    {
        return $this->start_time->formatLocalized('%d %B');
    }

    public function getDateShortAttribute(): string
    {
        return $this->start_time->formatLocalized('%d %b');
    }

    public function getTimeAttribute(): string
    {
        return $this->start_time->formatLocalized('%R');
    }

    public function getThisWeekAttribute(): bool
    {
        $diffInDays = $this->start_time->diffInDays(null, false);
        return 0 >= $diffInDays && $diffInDays > -7;
    }

    public function setRemarksAttribute(?string $value): ?string
    {
        return $this->attributes['remarks'] = $value === null
            ? null
            : strip_tags($value);
    }

    public function getCountryFlagAttribute(): string
    {
        return $this->circuit->country->flag_class;
    }

    public function getCountryLocalNameAttribute(): string
    {
        return $this->circuit->country->local_name;
    }

    public function getCircuitCityAttribute(): string
    {
        return $this->circuit->city;
    }

    public function getDetailsAttribute(): array
    {
        return [
            'title' => $this->name,
            'circuit' => $this->circuit->only(
                [
                    'name',
                    'location',
                ]
            ),
            'sessions' => $this->sessions->map(function (RaceSession $session) {
                return $session->only(
                    [
                        'start_time',
                        'end_time',
                        'name',
                    ]
                );
            }),
        ];
    }

    public function getLocationNameAttribute(): ?string
    {
        return $this->location->name;
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return $this->season_id && Auth::check()
            ? route(
                'admin.race.edit',
                [
                    'championship' => $this->season->championship,
                    'season' => $this->season,
                    'race' => $this,
                ]
            )
            : null;
    }
}
