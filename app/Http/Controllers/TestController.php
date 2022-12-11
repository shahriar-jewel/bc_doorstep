<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class TestController extends Controller
{

    public function testdropdown(Request $request)
    {
    	if ($request->isMethod('post')) 
    	{
    		return $request->input('my_multi_select1');
    	}
    	else
    	{

    	$bloodgroup = getBloodgroup();
    	return view('test.testdropdown',compact('bloodgroup'));
    	}

    }
   
}
