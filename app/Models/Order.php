<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';

    protected $primaryKey = 'orderid' ;

    protected $fillable = [
    		'member_id',
            'locationid',
            'tableid',
            'ordernumber',
            'kitchenid',
            'orderstatus',
            'orderfrom',
            'shippingaddress',
            'paymentmethod',
            'paymentstatus',
            'amount',
            'discount',
            'discountamount',
            'vat',
            'vatamount',
            'servicecharge',
            'servicechargeamount',
            'deliverycharge',
            'totalamount',
            'orderdetail',
            'remarks',
            'specialinstruction',
            'orderdetail',
            'created_by',
            'updated_by',
            'isapporder',
    	];

    public function member()
    {
        return $this->hasOne('App\Models\Memberinfo','member_id','member_id')->select('member_id','name','contactno');
    }

    public function waiter()
    {
        return $this->hasOne('App\Models\Userinfo','userid','created_by')->select('userid','fullname','contactno');
    }

    public function kitchen()
    {
        return $this->belongsTo('App\Models\Kitchen', 'kitchenid')->select('kitchenname');
    }

    public function deliveryzone()
    {
        return $this->hasOne('App\Models\Deliveryzone', 'zoneid','locationid')->select('zoneid','zonename');
    }

    public function tableno()
    {
        return $this->hasOne('App\Models\TableNo', 'tableid','tableid')->select('tableid','tablename');
    }

    public function orderitem()
    {
        return $this->hasMany('App\Models\Orderitem', 'orderid');
    }

    public function deliveryinfo()
    {
        return $this->hasOne('App\Models\DeliveryInfo', 'orderid','orderid');
    }

    public function orderlog()
    {
        return $this->hasMany('App\Models\Orderlog', 'orderid');
    }

    public function bkashrefund()
    {
        return $this->hasOne('App\Models\BkashRefund', 'orderid','orderid');
    }

    public function paymentinfo()
    {
        return $this->hasOne('App\Models\OrderPaymentLog', 'orderid','orderid');
    }

}
