<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Season
 *
 * @property int $id
 * @property int $championship_id
 * @property string $year
 * @property string|null $header_image
 * @property string|null $icon_image
 * @property string|null $footer_image
 * @property string|null $access_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Championship $championship
 * @property-read string|null $footer_url
 * @property-read string|null $header_url
 * @property-read string|null $icon_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Location[] $locations
 * @property-read int|null $locations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Race[] $races
 * @property-read int|null $races_count
 * @method static \Database\Factories\SeasonFactory factory(...$parameters)
 * @method static Builder|Season newModelQuery()
 * @method static Builder|Season newQuery()
 * @method static Builder|Season query()
 * @method static Builder|Season whereAccessToken($value)
 * @method static Builder|Season whereChampionshipId($value)
 * @method static Builder|Season whereCreatedAt($value)
 * @method static Builder|Season whereFooterImage($value)
 * @method static Builder|Season whereHeaderImage($value)
 * @method static Builder|Season whereIconImage($value)
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

    protected $fillable = [
        'year',
        'access_token',
        'icon_image',
        'header_image',
        'footer_image',
    ];

    protected $appends = [
        'admin_race_url',
        'admin_edit_url',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('sortByYear', function (Builder $builder) {
            $builder->orderBy('year', 'desc');
        });
    }

    /**
     * Get championship this season belongs to.
     */
    public function championship(): BelongsTo|Championship
    {
        return $this->belongsTo(Championship::class);
    }

    /**
     * Get races of this season.
     */
    public function races(): HasMany|Race
    {
        return $this->hasMany(Race::class);
    }

    /**
     * Get available locations for this season.
     */
    public function locations(): BelongsToMany|Location
    {
        return $this->belongsToMany(Location::class)
            ->withTimestamps();
    }

    /**
     * Get the URL of the icon image.
     */
    public function getIconUrlAttribute(): ?string
    {
        return $this->getImageUrl('icon');
    }

    /**
     * Get the URL of the header image.
     */
    public function getHeaderUrlAttribute(): ?string
    {
        return $this->getImageUrl('header');
    }

    /**
     * Get the URL of the footer image.
     */
    public function getFooterUrlAttribute(): ?string
    {
        return $this->getImageUrl('footer');
    }

    /**
     * Get the image URL of the section.
     */
    protected function getImageUrl(string $section): ?string
    {
        return $this->{$section . '_image'}
            ? Storage::url($this->{$section . '_image'})
            : null;
    }

    public function getAdminRaceUrlAttribute(): ?string
    {
        return $this->championship_id && Auth::check()
            ? route('admin.race.index', ['championship' => $this->championship, 'season' => $this])
            : null;
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return $this->championship_id && Auth::check()
            ? route('admin.season.edit', ['championship' => $this->championship, 'season' => $this])
            : null;
    }
}
