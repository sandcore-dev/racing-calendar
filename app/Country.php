<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Monarobase\CountryList\CountryListFacade as Countries;

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
	
	/**
	 * Get the country name according to the default locale.
	 */
	public function getLocalNameAttribute()
	{
		return Countries::getOne( $this->code, config('app.locale') );
	}

	/**
	 * Get the flag class of this country.
	 *
	 * @return	string
	 */
	public function getFlagClassAttribute()
	{
		return 'flag-icon flag-icon-' . strtolower( $this->code );
	}
}
