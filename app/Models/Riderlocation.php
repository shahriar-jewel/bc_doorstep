<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Riderlocation extends Model
{
    protected $table = 'riderlocation';

    protected $primaryKey = 'id' ;

    protected $fillable = [
            'riderid',
    		'lat',
    		'lng',
    		'lastlocation',
    	];

}
