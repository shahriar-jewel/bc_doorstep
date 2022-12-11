<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'food';

    protected $primaryKey = 'foodid' ;

    protected $fillable = [
    		'kitchenid',
            'categoryid',
            'foodgroupid',
            'foodname',
            'otherdetail',
            'originalpicture',
            'thumbnail',
            'price',
            'vat',
            'offerprice',
            'discount',
            'discountamount',
            'quantity',
            'foodtype',
            'hasaddon',
            'maxaddon',
            'minaddon',
            'isaddonrequired',
            'created_by',
            'updated_by',
            'status',
    	];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function kitchen()
    {
        return $this->belongsTo('App\Models\Kitchen', 'kitchenid')->select('kitchenname');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'categoryid');
    }

    public function foodgroup()
    {
        return $this->belongsTo('App\Models\Foodgroup', 'foodgroupid')->select('foodgroupname');
    }

    public function foodaddon()
    {
        return $this->hasMany('App\Models\FoodAddonMap', 'foodid');
    }

    public function foodmealaddon()
    {
        return $this->hasMany('App\Models\FoodMealAddonMap', 'foodid');
    }

}
