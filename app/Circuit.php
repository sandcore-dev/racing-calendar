<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Circuit
 *
 * @property int $id
 * @property string $name
 * @property string $city
 * @property string|null $area
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Country $country
 * @property-read string $full_name
 * @property-read string $location
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Race[] $races
 * @property-read int|null $races_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circuit whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
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
        
        if ($this->area) {
            $location .= ', ' . $this->area;
        }
        
        $location .= ', ' . __($this->country->name);
        
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
