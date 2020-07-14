<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * App\Season
 *
 * @property int $id
 * @property int $championship_id
 * @property string $year
 * @property string|null $header_image
 * @property string|null $footer_image
 * @property string|null $access_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Championship $championship
 * @property-read string $footer_url
 * @property-read string $header_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Location[] $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Race[] $races
 * @property-read int|null $races_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereChampionshipId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereFooterImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereHeaderImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Season whereYear($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
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
     * Get championship this season belongs to.
     *
     * @return BelongsTo
     */
    public function championship(): BelongsTo
    {
        return $this->belongsTo(Championship::class);
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
     * @param   string  $section
     * @return  string
     */
    protected function getImageUrl($section)
    {
        return $this->{$section . '_image'} ? Storage::url($this->{$section . '_image'}) : '';
    }
}
