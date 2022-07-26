<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

/**
 * @mixin IdeHelperRace
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
        'admin_race_session_url',
        'admin_edit_url',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('orderByStartTime', function (Builder $query) {
            $query->orderBy('start_time');
        });
    }

    public function season(): BelongsTo|Season
    {
        return $this->belongsTo(Season::class);
    }

    public function circuit(): BelongsTo|Circuit
    {
        return $this->belongsTo(Circuit::class);
    }

    public function location(): BelongsTo|Location
    {
        return $this->belongsTo(Location::class)
            ->withDefault();
    }

    public function sessions(): HasMany|RaceSession
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

    public function getIsPastAttribute(): ?bool
    {
        return $this->exists
            ? $this->start_time->isPast()
            : null;
    }

    public function getIsScheduledAttribute(): bool
    {
        return $this->status === 'scheduled';
    }

    public function getAdminRaceSessionUrlAttribute(): ?string
    {
        return $this->season_id && Auth::check()
            ? URL::route(
                'admin.race.session.index',
                [
                    'championship' => $this->season->championship,
                    'season' => $this->season,
                    'race' => $this,
                ]
            )
            : null;
    }


    public function getAdminEditUrlAttribute(): ?string
    {
        return $this->season_id && Auth::check()
            ? URL::route(
                'admin.race.edit',
                [
                    'championship' => $this->season->championship,
                    'season' => $this->season,
                    'race' => $this,
                ]
            )
            : null;
    }

    public function getLocationEditUrlAttribute(): ?string
    {
        if (!$this->exists) {
            return null;
        }

        return URL::route('calendar.location.edit', [
            'championship' => $this->season->championship,
            'season' => $this->season,
            'race' => $this,
        ]);
    }
}
