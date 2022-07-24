<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * App\Models\TemplateSession
 *
 * @property int $id
 * @property int $template_id
 * @property int $days
 * @property string $start_time
 * @property string $end_time
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Template $template
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession query()
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TemplateSession whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class TemplateSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'days',
        'start_time',
        'end_time',
        'name',
    ];

    protected $appends = [
        'admin_edit_url',
    ];

    public function template(): BelongsTo|Template
    {
        return $this->belongsTo(Template::class);
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return $this->template_id && Auth::check()
            ? route(
                'admin.template.session.edit',
                [
                    'template' => $this->template_id,
                    'session' => $this
                ]
            )
            : null;
    }
}
