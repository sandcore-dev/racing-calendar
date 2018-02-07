<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
	/**
	 * Primary key.
	 * 
	 * @var string
	 */
	protected $primaryKey = 'name';
	
	/**
	 * Primary key type.
	 * 
	 * @var string
	 */
	protected $keyType = 'string';
	
	/**
	 * Is primary key incrementable?
	 * 
	 * @var boolean
	 */
	public $incrementing = false;
	
    /**
     * Eager loading.
     * 
     * @var array
     */
    protected $with = [ 'season' ];
    
    /**
     * Get the season for this token.
     */
    public function season()
    {
		return $this->belongsTo(Season::class)->withDefault();
    }
}
