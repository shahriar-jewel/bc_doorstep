<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralFood extends Model
{
    protected $table = 'general_foods';

    protected $primaryKey = 'id';

    protected $fillable = [
    		'categoryid',
    		'restaurantid',
            'foodname',
            'foodnamecolor',
    		'otherdetail',
    		'originalpicture',
    		'status',
            'created_by',
    	];
}
