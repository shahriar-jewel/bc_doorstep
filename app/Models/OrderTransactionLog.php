<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTransactionLog extends Model
{

    public $timestamps = false;
    
    protected $primaryKey = 'tran_log_id';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'order_transaction_log';
    
    protected $fillable = [
        'tran_log_UUID',
        'customerid',
        'orderid',
        'temporderid',
        'val_id',
        'tran_id', // for bKash invoice ID
        'tran_status',
        'tran_date',
        'tran_payment_id', // for bKash paymentID
        'tran_bank_id', // for bKash trxID
        'tran_amount',
        'store_amount',
        'risk_level',
        'risk_title',
        'json_data',
        'created_at',
        'payment_gateway',
    ];

}
