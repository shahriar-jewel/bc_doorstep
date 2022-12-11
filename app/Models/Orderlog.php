<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderlog extends Model
{
    protected $table = 'orderlog';

    protected $primaryKey = 'logid' ;

    protected $fillable = [
            'orderid',
            'kitchenid',
            'orderstatus',
            'shortnote',
            'created_by'
    	];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\Userinfo', 'created_by')->select('userinfo.fullname','userinfo.contactno','userinfo.usertype');
    }
    public function kitchen()
    {
        return $this->belongsTo('App\Models\Kitchen', 'kitchenid')->select('kitchen.kitchenid','kitchen.kitchenname');
    }
}
