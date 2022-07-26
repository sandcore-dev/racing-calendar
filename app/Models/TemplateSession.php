<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperTemplateSession
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
