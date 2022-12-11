<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKitchenMap extends Model
{
    protected $table = 'user_kitchen_map';

    protected $primaryKey = 'userkitchenmapid' ;

    protected $fillable = [
            'userid',
    		'restaurantid',
            'kitchenid',
            'created_by',
            'updated_by',
            'is_active',
    	];


    public function kitchen()
    {
        return $this->belongsTo('App\Models\Kitchen', 'kitchenid')->select('kitchenid','kitchenname','address','contactno','email');
    }

}
