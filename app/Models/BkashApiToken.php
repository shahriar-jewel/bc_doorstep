<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BkashApiToken extends Model
{

    protected $primaryKey = 'id';

        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bkash_api_token';

	public $timestamps = false;

    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
            'id_token',
            'token_type',
            'expire_in',
            'expire_date',
            'refresh_token',
            'raw_response',
            'created_at',
            'token_for',
        ];

}
