<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memberinfo extends Model
{
    protected $table = 'memberinfo';

    protected $primaryKey = 'id' ;

    protected $fillable = [
            'member_id',
            'name',
            'type',
            'contactno',
            'image',
            'created_by',
            'updated_by',
            'isactive',
    	];
}
