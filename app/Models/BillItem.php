<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    protected $table = 'bill_item';

    protected $primaryKey = 'bill_item_id';

    protected $fillable = [
            'bill_id',
            'orderid',
            'created_by',
            'updated_by',
    	];

    public function orderitem()
    {
        return $this->hasMany('App\Models\Orderitem', 'orderid','orderid');
    }
    public function order()
    {
        return $this->hasMany('App\Models\Order', 'orderid','orderid');
    }
}
