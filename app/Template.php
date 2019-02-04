<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
