<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $table = 'api_token';

    protected $primaryKey = 'tokenid' ;

    protected $fillable = [
    		'token',
            'userid',
            'created_at',
            'updated_at',
    	];

}
