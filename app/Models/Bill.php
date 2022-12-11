<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bill';

    protected $primaryKey = 'bill_id' ;

    protected $fillable = [
    		'order_ids',
            'member_id',
            'totalbill',
            'totalpaid',
            'currentpaid',
            'paymentmethod',
            'totaldue',
            'status',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
    	];

    public function billitem()
    {
        return $this->hasMany('App\Models\BillItem', 'bill_id','bill_id');
    }
    public function member()
    {
        return $this->hasOne('App\Models\Memberinfo','member_id','member_id')->select('member_id','name','contactno');
    }

}
