<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Season extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year', 'access_token', 'header_image', 'footer_image',
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
    
    /**
     * Get the URL of the header image.
     * 
     * @return string
     */
    public function getHeaderUrlAttribute()
    {
		return $this->getImageUrl('header');
    }
    
    /**
     * Get the URL of the footer image.
     * 
     * @return string
     */
    public function getFooterUrlAttribute()
    {
		return $this->getImageUrl('footer');
    }
    
    /**
     * Get the image URL of the section.
     * 
     * @param	string	$section
     * @return	string
     */
    protected function getImageUrl( $section )
    {
		return $this->{$section . '_image'} ? Storage::url( $this->{$section . '_image'} ) : '';
    }
}
