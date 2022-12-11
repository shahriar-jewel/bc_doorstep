<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliveryzone extends Model
{
    protected $table = 'deliveryzone';

    protected $primaryKey = 'zoneid' ;

    protected $fillable = [
            'zonename',
            'latitude',
            'longitude',
            'districtid',
            'thanaid',
            'is_active',
            'created_by',
            'updated_by',
    	];


}
