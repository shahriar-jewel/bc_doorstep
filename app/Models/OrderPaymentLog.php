<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPaymentLog extends Model
{

    protected $primaryKey = 'order_payment_id';

        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'order_payment_log';

    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
            'order_payment_UUID',
            'orderid',
            'customerid',
            'paid_amount',
            'paid_date',
            'payment_type', // 1=COD, 2=Bkash ; 3=Online/SSL ;
            'tran_log_id',
            'created_by',
            'updated_by',
            'collected_by',
        ];

    public function transactionlog()
    {
        return $this->belongsTo('App\Models\OrderTransactionLog', 'tran_log_id');
    }
}
