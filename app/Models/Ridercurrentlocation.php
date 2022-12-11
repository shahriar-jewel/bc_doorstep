<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ridercurrentlocation extends Model
{
    protected $table = 'ridercurrentlocation';

    protected $primaryKey = 'id' ;

    protected $fillable = [
            'riderid',
    		'lat',
    		'lng',
    		'lastlocation',
    	];

}
