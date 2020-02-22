<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Monarobase\CountryList\CountryListFacade as Countries;
use Monarobase\CountryList\CountryNotFoundException;

/**
 * App\Country
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Circuit[] $circuits
 * @property-read int|null $circuits_count
 * @property-read string $flag_class
 * @property-read mixed $local_name
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereCreatedAt($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereName($value)
 * @method static Builder|Country whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    /**
     * Get circuits in this country.
     */
    public function circuits()
    {
        return $this->hasMany(Circuit::class);
    }

    /**
     * Get the country name according to the default locale.
     * @throws CountryNotFoundException
     */
    public function getLocalNameAttribute()
    {
        return Countries::getOne($this->code, config('app.locale'));
    }

    /**
     * Get the flag class of this country.
     *
     * @return  string
     */
    public function getFlagClassAttribute()
    {
        return 'flag-icon flag-icon-' . strtolower($this->code);
    }
}
