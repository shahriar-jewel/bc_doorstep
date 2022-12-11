<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comboitem extends Model
{
    protected $table = 'comboitem';

    protected $primaryKey = 'comboitemid' ;

    protected $fillable = [
            'comboid',
            'itemid',
            'itemname',
            'otherdetail',
            'price',
            'quantity',
            'created_by',
            'updated_by',
            'status',
    	];
}
