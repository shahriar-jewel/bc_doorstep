<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSLog extends Model
{
    public $timestamps = false ;
    
    protected $table = 'smssend';

    protected $primaryKey = 'smssendid' ;

    protected $fillable = [
    		'touserid',
            'mobileno',
            'message',
            'response',
            'smstype',
            'status',
    	];

}
