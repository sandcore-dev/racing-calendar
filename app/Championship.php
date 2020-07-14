<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Championship
 *
 * @property int $id
 * @property string $name
 * @property string $domain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Season[] $seasons
 * @property-read int|null $seasons_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Championship whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Championship extends Model
{
    protected $fillable = ['name', 'domain'];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }
}
