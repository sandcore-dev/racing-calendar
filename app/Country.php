<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code',
    ];

	/**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

	/**
	 * Get circuits in this country.
	 */
	public function circuits()
	{
		return $this->hasMany(Circuit::class);
	}
}
