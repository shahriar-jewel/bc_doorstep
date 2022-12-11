<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodChannel extends Model
{
    protected $table = 'food_channels';

    protected $fillable = [
            'foodchannelid',
            'foodchannelname',
    	];
}
