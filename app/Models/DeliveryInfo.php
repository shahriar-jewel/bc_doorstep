<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryInfo extends Model
{
    protected $table = 'deliveryinfo';

    protected $primaryKey = 'deliveryid' ;

    protected $fillable = [
    		'orderid',
            'riderid',
    		'orderstatus',
    		'assigntime',
    		'pickuptime',
            'pantrytime',
            'deliverytime',
            'returntime',
            'last_lat',
            'last_lng',
            'deliverystatus',
    		'remark',
            'created_by',
            'updated_by',
    	];

    public function rider()
    {
        return $this->belongsTo('App\Models\Userinfo', 'riderid' );
    }

}
