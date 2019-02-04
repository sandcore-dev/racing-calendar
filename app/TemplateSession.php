<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplateSession extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'template_id',
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
