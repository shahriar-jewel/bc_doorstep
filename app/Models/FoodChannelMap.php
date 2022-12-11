<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodChannelMap extends Model
{
    protected $table = 'food_channel_maps';

    protected $fillable = [
            'foodid',
            'foodchannelid',
            'created_by',
    	];
}
