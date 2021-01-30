<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property int|null $championship_id
 * @property string $year
 * @property string|null $header_image
 * @property string|null $footer_image
 * @property string|null $access_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Championship|null $championship
 * @property-read string $footer_url
 * @property-read string $header_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Race[] $races
 * @property-read int|null $races_count
 * @method static Builder|Season newModelQuery()
 * @method static Builder|Season newQuery()
 * @method static Builder|Season query()
 * @method static Builder|Season whereAccessToken($value)
 * @method static Builder|Season whereChampionshipId($value)
 * @method static Builder|Season whereCreatedAt($value)
 * @method static Builder|Season whereFooterImage($value)
 * @method static Builder|Season whereHeaderImage($value)
 * @method static Builder|Season whereId($value)
 * @method static Builder|Season whereUpdatedAt($value)
 * @method static Builder|Season whereYear($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Season extends Model
{
    use HasFactory;

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
    protected static function boot(): void
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
    public function races(): HasMany
    {
        return $this->hasMany(Race::class);
    }

    /**
     * Get available locations for this season.
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class)
            ->withTimestamps();
    }

    /**
     * Get the URL of the header image.
     *
     * @return string
     */
    public function getHeaderUrlAttribute(): string
    {
        return $this->getImageUrl('header');
    }

    /**
     * Get the URL of the footer image.
     *
     * @return string
     */
    public function getFooterUrlAttribute(): string
    {
        return $this->getImageUrl('footer');
    }

    /**
     * Get the image URL of the section.
     *
     * @param   string  $section
     * @return  string
     */
    protected function getImageUrl(string $section): string
    {
        return $this->{$section . '_image'} ? Storage::url($this->{$section . '_image'}) : '';
    }
}
