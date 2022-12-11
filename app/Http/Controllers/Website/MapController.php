<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class MapController extends Controller
{
    public function location()
    {
       Session::forget('bkash_customerid');
       return view('Website.map.index');
    }
}
