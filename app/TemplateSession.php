<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TemplateSession
 *
 * @property int $id
 * @property int $template_id
 * @property int $days
 * @property string $start_time
 * @property string $end_time
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Template $template
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TemplateSession whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
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
