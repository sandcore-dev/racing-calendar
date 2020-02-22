<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\AccessToken
 *
 * @property string $name
 * @property int|null $season_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Season|null $season
 * @method static Builder|AccessToken newModelQuery()
 * @method static Builder|AccessToken newQuery()
 * @method static Builder|AccessToken query()
 * @method static Builder|AccessToken whereCreatedAt($value)
 * @method static Builder|AccessToken whereName($value)
 * @method static Builder|AccessToken whereSeasonId($value)
 * @method static Builder|AccessToken whereUpdatedAt($value)
 * @mixin Eloquent
 */
class AccessToken extends Model
{
    /**
     * Primary key.
     *
     * @var string
     */
    protected $primaryKey = 'name';
    
    /**
     * Primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';
    
    /**
     * Is primary key incrementable?
     *
     * @var boolean
     */
    public $incrementing = false;
    
    /**
     * Eager loading.
     *
     * @var array
     */
    protected $with = [ 'season' ];
    
    /**
     * Get the season for this token.
     */
    public function season()
    {
        return $this->belongsTo(Season::class)->withDefault();
    }
}
