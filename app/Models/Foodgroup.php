<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foodgroup extends Model
{
    protected $table = 'foodgroup';

    protected $primaryKey = 'foodgroupid' ;

    protected $fillable = [
    		'kitchenid',
            'categoryid',
            'foodgroupname',
            'otherdetail',
            'originalpicture',
            'thumbnail',
            'grouptype', 
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
        return $this->belongsTo('App\Models\Category', 'categoryid')->select('name');
    }

    public function foods()
    {
        return $this->hasMany('App\Models\Food', 'foodgroupid');
    }

    public function activefoods()
    {
        return $this->hasMany('App\Models\Food', 'foodgroupid')->Active();
    }
}
