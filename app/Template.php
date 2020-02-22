<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Template
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|TemplateSession[] $sessions
 * @property-read int|null $sessions_count
 * @method static Builder|Template newModelQuery()
 * @method static Builder|Template newQuery()
 * @method static Builder|Template query()
 * @method static Builder|Template whereCreatedAt($value)
 * @method static Builder|Template whereId($value)
 * @method static Builder|Template whereName($value)
 * @method static Builder|Template whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get sessions of this template.
     */
    public function sessions()
    {
        return $this->hasMany(TemplateSession::class);
    }
}
