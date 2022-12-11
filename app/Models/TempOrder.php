<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{
    protected $primaryKey = 'temporderid';

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'temp_orders';

    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
            'temporderUUID',
            'branchid',
            'customerid',
            'shippingaddress',
            'ordernumber',
            'orderdata',
            'paymentstatus',
            'ordertotal',
            'orderfrom',
        ];
}
