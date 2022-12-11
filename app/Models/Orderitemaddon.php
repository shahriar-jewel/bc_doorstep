<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderitemaddon extends Model
{
    protected $table = 'orderitemaddon';

    protected $primaryKey = 'orderitemaddonid' ;

    protected $fillable = [
            'orderid',
    		'orderitemid',
            'foodid',
            'addonid',
            'quantity',
            'price',
            'created_by',
            'updated_by',
    	];

    public function addonInfo()
    {
        return $this->belongsTo('App\Models\Food', 'addonid')->select('foodid','foodname','price','quantity as ratio');
    }
}
