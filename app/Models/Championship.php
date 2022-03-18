<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

/**
 * App\Models\Championship
 *
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Season[] $seasons
 * @property-read int|null $seasons_count
 * @method static \Database\Factories\ChampionshipFactory factory(...$parameters)
 * @method static Builder|Championship newModelQuery()
 * @method static Builder|Championship newQuery()
 * @method static Builder|Championship others()
 * @method static Builder|Championship query()
 * @method static Builder|Championship whereCreatedAt($value)
 * @method static Builder|Championship whereDomain($value)
 * @method static Builder|Championship whereId($value)
 * @method static Builder|Championship whereName($value)
 * @method static Builder|Championship whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Championship extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
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
}
