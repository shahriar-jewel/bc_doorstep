<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    protected $table = 'joblist';

    protected $primaryKey = 'joblist_id' ;

    protected $fillable = [
            'orderid',
            'kitchenid',
            'created_by',
            'updated_by',
            'is_active',
    	];
}
