<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTypeMap extends Model
{
    protected $table = 'restaurant_type_map';

    protected $primaryKey = 'restauranttypemapid' ;

    protected $fillable = [
            'restaurantid',
            'typeid',
            'created_by',
            'updated_by',
    	];

    public function typeInfo()
    {
        return $this->belongsTo('App\Models\RestaurantType', 'typeid')->select('typeid','typename');
    }

}
