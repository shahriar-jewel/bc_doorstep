<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralCategory extends Model
{
    protected $table = 'general_categories';

    protected $primaryKey = 'id';

    protected $fillable = [
    		'restaurantid',
            'name',
            'namecolor',
    		'otherdetail',
    		'picture',
    		'is_active',
            'created_by',
    	];
}
