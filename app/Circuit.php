<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * App\Circuit
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string|null $area
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Country $country
 * @property-read string $full_name
 * @property-read string $location
 * @property-read Collection|Race[] $races
 * @property-read int|null $races_count
 * @method static Builder|Circuit newModelQuery()
 * @method static Builder|Circuit newQuery()
 * @method static Builder|Circuit query()
 * @method static Builder|Circuit whereArea($value)
 * @method static Builder|Circuit whereCity($value)
 * @method static Builder|Circuit whereCountryId($value)
 * @method static Builder|Circuit whereCreatedAt($value)
 * @method static Builder|Circuit whereId($value)
 * @method static Builder|Circuit whereName($value)
 * @method static Builder|Circuit whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Circuit extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'city', 'area', 'country_id',
    ];

	/**
	 * Eager loading.
	 * 
	 * @var array
	 */
	protected $_with = [ 'country' ];
	
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
	 * Get the races held at this circuit.
	 */
	public function races()
	{
		return $this->hasMany(Race::class);
	}
	
	/**
	 * Get the country of this circuit.
	 */
	public function country()
	{
		return $this->belongsTo(Country::class);
	}
	
	/**
	 * Get full location of this circuit.
	 * 
	 * @return string
	 */
	public function getLocationAttribute()
	{
		$location = $this->city;
		
		if( $this->area )
			$location .= ', ' . $this->area;
		
		$location .= ', '. __($this->country->name);
		
		return $location;
	}
	
	/**
	 * Get full name of this circuit.
	 * 
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return $this->name . ', ' . $this->location;
	}
}
