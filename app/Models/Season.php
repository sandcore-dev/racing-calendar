<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

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
        'admin_images_url',
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

    public function getIconMimeTypeAttribute(): ?string
    {
        return $this->getImageMimeType('icon');
    }

    public function getIconDimensionsAttribute(): ?string
    {
        return $this->getImageDimensions('icon');
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
            ? Storage::disk('public')->url($this->{$section . '_image'})
            : null;
    }

    protected function getImageMimeType(string $section): ?string
    {
        return $this->{$section . '_image'}
            ? Storage::disk('public')->mimeType($this->{$section . '_image'})
            : null;
    }

    protected function getImageDimensions(string $section): ?string
    {
        $imagePath = $this->{$section . '_image'};

        if (!$imagePath) {
            return null;
        }

        return Cache::remember(
            "{$imagePath}-dimensions",
            86400,
            function () use ($imagePath) {
                $path = Storage::disk('public')->path($imagePath);
                $image = Image::make($path);

                return $image->width() . 'x' . $image->height();
            }
        );
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

    public function getAdminImagesUrlAttribute(): ?string
    {
        return $this->championship_id && Auth::check()
            ? route('admin.image.index', ['championship' => $this->championship, 'season' => $this])
            : null;
    }
}
