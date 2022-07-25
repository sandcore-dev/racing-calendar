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
 * @mixin IdeHelperSeason
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
