<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * App\Season
 *
 * @property int $id
 * @property string $year
 * @property string|null $header_image
 * @property string|null $footer_image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read AccessToken $access_token
 * @property-read string $footer_url
 * @property-read string $header_url
 * @property-read Collection|Location[] $locations
 * @property-read int|null $locations_count
 * @property-read Collection|Race[] $races
 * @property-read int|null $races_count
 * @method static Builder|Season newModelQuery()
 * @method static Builder|Season newQuery()
 * @method static Builder|Season query()
 * @method static Builder|Season whereCreatedAt($value)
 * @method static Builder|Season whereFooterImage($value)
 * @method static Builder|Season whereHeaderImage($value)
 * @method static Builder|Season whereId($value)
 * @method static Builder|Season whereUpdatedAt($value)
 * @method static Builder|Season whereYear($value)
 * @mixin Eloquent
 */
class Season extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year', 'access_token_id', 'header_image', 'footer_image',
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
		return $this->belongsToMany(Location::class)->withTimestamps();
	}
	
	/**
     * Get the access token associated with this season.
     */
    public function access_token()
    {
        return $this->hasOne(AccessToken::class)->withDefault();
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
