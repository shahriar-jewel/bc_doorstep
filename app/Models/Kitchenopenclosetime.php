<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kitchenopenclosetime extends Model
{
    protected $table = 'kitchenopenclosetime';

    protected $primaryKey = 'id' ;

    protected $fillable = [
    		'kitchenid',
            'saturday',
            'saturday_status',
            'sunday',
            'sunday_status',
            'monday',
            'monday_status',
            'tuesday',
            'tuesday_status',
            'wednesday',
            'wednesday_status',
            'thursday',
            'thursday_status',
            'friday',
            'friday_status',
            'created_by',
            'updated_by',
    	];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Kitchen', 'kitchenid')->select('name');
    }
}
