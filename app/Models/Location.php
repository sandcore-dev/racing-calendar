<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperLocation
 */
class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $appends = [
        'admin_edit_url',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function races(): HasMany|Race
    {
        return $this->hasMany(Race::class);
    }

    public function seasons(): BelongsToMany|Season
    {
        return $this->belongsToMany(Season::class)
            ->withTimestamps();
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return $this->exists && Auth::check()
            ? route('admin.location.edit', ['location' => $this])
            : null;
    }
}
