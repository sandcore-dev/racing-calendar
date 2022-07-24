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
 * App\Models\Country
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Circuit[] $circuits
 * @property-read int|null $circuits_count
 * @property-read string $flag_class
 * @property-read string $local_name
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
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
        return 'flag-icon flag-icon-' . strtolower($this->code);
    }

    public function getAdminEditUrlAttribute(): ?string
    {
        return Auth::check()
            ? route('admin.country.edit', ['country' => $this])
            : null;
    }
}
