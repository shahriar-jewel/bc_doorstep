<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    protected $table = 'kitchen';

    protected $primaryKey = 'kitchenid' ;

    protected $fillable = [
    		'restaurantid',
            'kitchenname',
            'contactno',
            'email',
            'address',
            'latitude',
            'longitude',
            'minorderamount',
            'mindeliverytime',
            'deliveryfee',
            'otherdetail',
            'picture',
            'created_by',
            'updated_by',
            'is_active',
    	];

    public function kitchenopentime()
    {
        return $this->hasOne('App\Models\Kitchenopenclosetime', 'kitchenid');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurantid')->select('name');
    }

    public function deliveryzone()
    {
        return $this->hasMany( 'App\Models\BranchDeliveryzoneMap','kitchenid','kitchenid');
    }
}
