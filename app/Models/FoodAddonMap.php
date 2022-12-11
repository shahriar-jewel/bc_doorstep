<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodAddonMap extends Model
{
    protected $table = 'food_addon_map';

    protected $primaryKey = 'foodaddonmapid' ;

    protected $fillable = [
            'foodid',
            'addonid',
            'created_by',
    	];


    public function addonInfo()
    {
        return $this->belongsTo('App\Models\Food', 'addonid')->select('foodid','foodname','price','quantity');
    }

    public function activeaddonInfo()
    {
        return $this->belongsTo('App\Models\Food', 'addonid')->select('foodid','foodname','price','quantity','discount','discountamount','offerprice')->Active();
    }
}
