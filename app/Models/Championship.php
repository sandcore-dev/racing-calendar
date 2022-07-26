<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperChampionship
 */
class Championship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
    ];

    protected $appends = [
        'admin_season_url',
        'admin_edit_url',
    ];

    public function seasons(): HasMany|Season
    {
        return $this->hasMany(Season::class);
    }

    public function scopeOthers(Builder $query): Builder
    {
        return $query
            ->where('domain', '!=', app(Request::class)->getHost())
            ->orderBy('name');
    }

    public function getUrlAttribute(): string
    {
        return route('index', ['championship' => $this]);
    }

    public function getAdminSeasonUrlAttribute(): ?string
    {
        return Auth::check()
            ? route('admin.season.index', ['championship' => $this])
            : null;
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return Auth::check()
            ? route('admin.championship.edit', ['championship' => $this])
            : null;
    }
}
