<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableNo extends Model
{
    
    protected $table = 'tableno';

    protected $primaryKey = 'tableid' ;

    protected $fillable = [
    		'tablename',
            'is_active',
            'created_by',
            'updated_by',
    	];
}
