<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Season extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year', 'access_token', 'header_url', 'footer_url',
    ];

	/**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByYear', function (Builder $builder) {
            $builder->orderBy('year', 'desc');
        });
    }
    
    /**
	 * Get races of this season.
	 */
	public function races()
	{
		return $this->hasMany(Race::class);
	}
	
	/**
	 * Get available locations for this season.
	 */
	public function locations()
	{
		return $this->belongsToMany(Location::class);
	}
	
	/**
     * Scope a query to find the given token.
     *
     * @param	\Illuminate\Database\Eloquent\Builder	$query
     * @param	string									$token
     * @return	\Illuminate\Database\Eloquent\Builder
     */
    public function scopeByToken($query, $token)
    {
        return $query->whereNotNull( 'access_token' )->where( 'access_token', $token );
    }
}
