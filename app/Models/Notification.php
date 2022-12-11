<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';

    protected $primaryKey = 'notificationid' ;

    protected $fillable = [
    		'fromid',
            'toid',
            'notificationtype',
            'req_body',
            'res_body',
            'readstatus',
            'created_at',
    	];

}
