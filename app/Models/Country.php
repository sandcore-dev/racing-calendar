<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Monarobase\CountryList\CountryListFacade as Countries;
use Monarobase\CountryList\CountryNotFoundException;

/**
 * @mixin IdeHelperCountry
 */
class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
    ];

    protected $appends = [
        'admin_edit_url',
        'flag_class',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function circuits(): HasMany|Circuit
    {
        return $this->hasMany(Circuit::class);
    }

    public function getLocalNameAttribute(): string
    {
        return Countries::getOne($this->code, config('app.locale'));
    }

    public function getFlagClassAttribute(): string
    {
        return 'fi fi-' . strtolower($this->code);
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return Auth::check()
            ? route('admin.country.edit', ['country' => $this])
            : null;
    }
}
