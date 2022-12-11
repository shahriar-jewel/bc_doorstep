<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    protected $table = 'orderitem';

    protected $primaryKey = 'orderitemid' ;

    protected $fillable = [
            'orderid',
            'ordernumber',
            'kitchenid',
            'foodid',
            'quantity',
            'price',
            'discount',
            'totalprice',
            'remarks',
            'itemstatus',
            'created_by',
            'updated_by',
    	];

    public function foodinfo()
    {
        return $this->belongsTo('App\Models\Food', 'foodid')->select('food.foodid','food.foodname','food.price','food.quantity as ratio','food.thumbnail');
    }
    public function food()
    {
        return $this->hasOne('App\Models\Food', 'foodid','foodid')->select('food.foodid','food.foodname','food.price','food.quantity as ratio','food.thumbnail','food.categoryid');
    }

    public function orderitemaddon()
    {
        return $this->hasMany('App\Models\Orderitemaddon', 'orderitemid');
    }

}
