<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRequestLog extends Model
{

    protected $primaryKey = 'payment_log_id';

        /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payment_request_log';

    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
            'customerid',
            'temporderid',
            'transaction_id',
            'create_payment_req',
            'create_payment_res',
            'execute_payment_res',
            'query_payment_res',
        ];

}
