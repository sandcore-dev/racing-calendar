<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class IsRaceNameUnique implements Rule
{
    /**
     * Season ID.
     *
     * @var integer
     */
    protected $season_id;
    
    /**
     * Start time.
     *
     * @var string
     */
    protected $start_time;
    
    /**
     * Race ID.
     *
     * @var integer
     */
    protected $race_id = 0;

    /**
     * Create a new rule instance.
     *
     * @param $season_id
     * @param $start_time
     * @param int $race_id
     */
    public function __construct($season_id, $start_time, $race_id = 0)
    {
        $this->season_id    = $season_id;
        $this->start_time   = $start_time;
        $this->race_id      = $race_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return
            !DB::table('races')->where(function (Builder $query) {
                return $query->where('season_id', $this->season_id)->orWhere('start_time', $this->start_time);
            })->where('id', '!=', $this->race_id)->where('name', $value)->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('The race name has already been taken.');
    }
}
