<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $primaryKey = 'categoryid' ;
    
    protected $fillable = [
    		'kitchenid',
            'name',
            'otherdetail',
            'originalpicture',
            'parentid',
            'serialno',
            'created_by',
            'updated_by',
            'categorytype',
            'is_active',
    	];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeWithoutaddon($query)
    {
        return $query->where('categorytype','<>', 3);
    }
        
    public function kitchen()
    {
        return $this->belongsTo('App\Models\Kitchen', 'kitchenid')->select('kitchenname');
    }

    public function foodgroups()
    {
        return $this->hasMany('App\Models\Foodgroup', 'categoryid');
    }

    public function activefoodgroups()
    {
        return $this->hasMany('App\Models\Foodgroup', 'categoryid')->Active();
    }
}
