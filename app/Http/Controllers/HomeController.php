<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Userinfo;


class HomeController extends Controller
{
	public function privacyPolicy()
    {
    	return view('privacy_policy.policy');
    }    
}
