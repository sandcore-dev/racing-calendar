<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperRaceSession
 */
class RaceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'race_id',
        'start_time',
        'end_time',
        'name',
    ];

    protected $dates = [
        'start_time',
        'end_time',
    ];

    protected $appends = [
        'admin_edit_url',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('orderByStartTime', function (Builder $query) {
            return $query->orderBy('start_time');
        });
    }

    public function race(): BelongsTo|Race
    {
        return $this->belongsTo(Race::class);
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
        return $this->start_time->formatLocalized('%R') . '-' . $this->end_time->formatLocalized('%R');
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return $this->race_id && Auth::check()
            ? route(
                'admin.race.session.edit',
                [
                    'championship' => $this->race->season->championship,
                    'season' => $this->race->season,
                    'race' => $this->race,
                    'session' => $this
                ]
            )
            : null;
    }
}
