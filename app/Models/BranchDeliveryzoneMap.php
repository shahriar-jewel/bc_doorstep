<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchDeliveryzoneMap extends Model
{
    protected $table = 'branch_deliveryzone_map';

    protected $primaryKey = 'branch_del_mapid' ;

    protected $fillable = [
            'branchid',
            'zoneid',
            'created_by',
            'updated_by',
    	];

    public function zoneInfo()
    {
        return $this->belongsTo('App\Models\Deliveryzone', 'zoneid');
    }

}
