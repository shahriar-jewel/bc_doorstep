<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $table = 'userinfo';

    protected $primaryKey = 'userid' ;

    protected $fillable = [
            'fullname',
            'bloodgroup',
            'presentaddress',
            'prthanaid',
            'prdistrictid',
            'prpostcode',
            'permanentaddress',
            'parthanaid',
            'pardistrictid',
            'parpostcode',
            'contactno',
            'contacthome',
            'contactoffice',
            'email',
            'dateofbirth',
            'gender', 
            'maritalstatus',
            'occupation',
            'designation',
            'smsPin',
            'smsPinStatus',
            'profileImage',
            'password',
            'lastactivetime',
            'lastloginipaddress',
            'forgetpasswordtoken',
            'remembermetoken',
            'restaurantid',
            // 'branchid',
            'usertype',
            'created_by',
            'updated_by',
            'isactive',
            'gcmid',
            'imei',
            'app_login_status'
    	];

    public function createdBY()
    {
        return $this->belongsTo('App\Models\Userinfo', 'created_by')->select('fullname');
    }

    public function restaurantInfo()
    {
        return $this->belongsTo('App\Models\Restaurant', 'restaurantid')->select('restaurantid','name','contactno','email','address','websiteurl');
    }

    public function kitchenID()
    {
        return $this->hasMany('App\Models\UserKitchenMap','userid');
    }

}
