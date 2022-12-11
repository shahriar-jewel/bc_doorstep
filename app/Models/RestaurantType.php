<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantType extends Model
{
    protected $table = 'restauranttype';

    protected $primaryKey = 'typeid' ;

    protected $fillable = [
            'typename',
            'typedetail',
            'is_active',
            'created_by',
            'updated_by',
    	];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

}
