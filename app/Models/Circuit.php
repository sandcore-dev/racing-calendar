<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * @mixin IdeHelperCircuit
 */
class Circuit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'area',
        'country_id',
    ];

    protected $with = [
        'country',
    ];

    protected $appends = [
        'admin_edit_url',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function races(): HasMany|Race
    {
        return $this->hasMany(Race::class);
    }

    public function country(): BelongsTo|Country
    {
        return $this->belongsTo(Country::class);
    }

    public function getLocationAttribute(): string
    {
        $location = $this->city;

        if ($this->area) {
            $location .= ', ' . $this->area;
        }

        $location .= ', ' . __($this->country->name);

        return $location;
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ', ' . $this->location;
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return Auth::check()
            ? route('admin.circuit.edit', ['circuit' => $this])
            : null;
    }
}
