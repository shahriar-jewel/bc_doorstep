<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurant';

    protected $primaryKey = 'restaurantid' ;

    protected $fillable = [
            'name',
            'contactno',
            'email',
            'address',
            'otherdetail',
            'picture',
            'created_by',
            'updated_by',
            'is_active',
            'websiteurl',
    	];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function branches()
    {
        return $this->hasMany('App\Models\Kitchen', 'restaurantid' );
    }

    public function restaurantTypes()
    {
        return $this->hasMany( 'App\Models\RestaurantTypeMap','restaurantid','restaurantid');
    }

}
