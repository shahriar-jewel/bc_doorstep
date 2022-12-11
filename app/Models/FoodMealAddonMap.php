<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodMealAddonMap extends Model
{
    protected $table = 'food_meal_addon_map';

    protected $primaryKey = 'foodmealaddonmapid' ;

    protected $fillable = [
            'foodid',
            'mealaddonid',
            'created_by',
    	];


    public function addonInfo()
    {
        return $this->belongsTo('App\Models\Food', 'addonid')->select('foodid','foodname','price','quantity');
    }

    public function activemealaddonInfo()
    {
        return $this->belongsTo('App\Models\Food', 'mealaddonid')->select('foodid','foodname','price','quantity','discount','discountamount','offerprice')->Active();
    }
}
