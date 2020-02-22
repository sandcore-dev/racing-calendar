<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\TemplateSession
 *
 * @property int $id
 * @property int $template_id
 * @property int $days
 * @property string $start_time
 * @property string $end_time
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Template $template
 * @method static Builder|TemplateSession newModelQuery()
 * @method static Builder|TemplateSession newQuery()
 * @method static Builder|TemplateSession query()
 * @method static Builder|TemplateSession whereCreatedAt($value)
 * @method static Builder|TemplateSession whereDays($value)
 * @method static Builder|TemplateSession whereEndTime($value)
 * @method static Builder|TemplateSession whereId($value)
 * @method static Builder|TemplateSession whereName($value)
 * @method static Builder|TemplateSession whereStartTime($value)
 * @method static Builder|TemplateSession whereTemplateId($value)
 * @method static Builder|TemplateSession whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TemplateSession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'template_id',
        'days',
        'start_time',
        'end_time',
        'name',
    ];

    /**
     * Get the template of this session.
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
