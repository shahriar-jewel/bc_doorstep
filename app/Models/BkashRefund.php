<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BkashRefund extends Model
{

    protected $primaryKey = 'br_id';

        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bkash_refund';

    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
            'orderid',
            'customerid',
            'bkash_mobile',
            'refund_amount',
            'refund_date',
            'original_trxid',
            'refund_trxid',
            'refund_type',
            'created_by',
        ];

}
