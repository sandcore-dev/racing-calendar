<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperTemplate
 */
class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $with = [
        'sessions',
    ];

    protected $appends = [
        'admin_edit_url',
        'admin_template_session_url',
    ];

    public function sessions(): HasMany|TemplateSession
    {
        return $this->hasMany(TemplateSession::class);
    }

    public function getAdminTemplateSessionUrlAttribute(): ?string
    {
        return Auth::check()
            ? route('admin.template.session.index', ['template' => $this])
            : null;
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return Auth::check()
            ? route('admin.template.edit', ['template' => $this])
            : null;
    }
}
