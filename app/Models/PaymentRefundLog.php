<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRefundLog extends Model
{

    protected $primaryKey = 'refund_log_id';

        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payment_refund_log';

    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
            'orderid',
            'refund_type',
            'original_trxid',
            'refund_trxid',
            'refund_req',
            'refund_res',
            'refund_status_req',
            'refund_status_res',
            'created_by',
            'updated_by',
        ];

}
