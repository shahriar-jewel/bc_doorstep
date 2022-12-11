<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Userinfo;

class ProfileController extends Controller
{
	private $_profileID = 0 ;

    private function _setProfileInfo()
    {
        $this->_profileID = session()->get('doorstepuser.userid');
    }

    public function view()
    {
    	return view('profile.view');
    }

    public function edit(Request $request)
    {	
    	$this->_setProfileInfo(); // set the profile ID from session variable 

    	if( $request->isMethod('post') ) 
    	{
    		/**
	        * validation rules
	        */
	        $rules = array(
	            'fullName'              => 'required|max:150',
	            'mobileNo'              => 'max:20|required',
	        );

	        $validator = Validator::make($request->all(), $rules);

	        if ($validator->fails())
	        {
	            $errors = $validator->messages()->toArray();

	            return  redirect()->back()
	                            ->withErrors($validator)
	                            ->withInput();
	        }
	        else
	        {
	            $dob = convertToMySQLDate( $request->input('dob') ) ;
	            $userID = $request->input('profileId');

	            $data = array(
	                'fullname'        => $request->input('fullName'),
	                'contactno'       => $request->input('mobileNo'),
	                'dateofbirth'     => $dob,
	                'gender'          => $request->input('gender'),
	                'updated_by'      => $this->_profileID,
	            );  

	            if ($this->_profileID == $userID) 
	            {
		            $updateUserinfo = Userinfo::where('userid',$this->_profileID)->update($data);

		            if ($updateUserinfo > 0) {
		                $message = "Profile Updated Successfully !" ;
		                $class = 1;
		                $user = Userinfo::find($this->_profileID)->toArray();
		                session()->put('user',$user);
		            }else{
		                $message = "No user found ! Something went wrong !" ;
		                $class = 2;
		            }
	            }
	            else
	            {
	            	$message = "Error occured ! Something went wrong !" ;
		            $class = 2;
	            }
	            session()->flash('message', $message );
	            session()->flash('class', $class );
	            return redirect()->route('profile.view');
	        }
    	}else
    	{
    		return view('profile.edit');
    	}
    }

    public function changepassword(Request $request)
    {
    	$this->_setProfileInfo(); // set the profile ID from session variable 

    	if( $request->isMethod('post') ) 
    	{
    		/**
	        * validation rules
	        */
	        $rules = array(
	            'oldpassword'           => 'required|min:4',
	            'newpassword'           => 'required|min:4',
                'password_confirmation' => 'min:4|same:newpassword'
	        );

	        $validator = Validator::make($request->all(), $rules);

	        if ($validator->fails())
	        {
	            $errors = $validator->messages()->toArray();

	            return  redirect()->back()
	                            ->withErrors($validator)
	                            ->withInput();
	        }
	        else
	        {
	            $dob = convertToMySQLDate( $request->input('dob') ) ;
	            $webuserID = $request->input('profileId');

	            if ($webuserID == $this->_profileID) 
	            {
		            $userInfo = Userinfo::find($this->_profileID);

		            if (count($userInfo) > 0 && $this->_checkPassword($request->input('oldpassword') ,$userInfo->password ) ) 
		            {
		                $userInfo->password = Hash::make($request->input('newpassword'));
		                $userInfo->modifyBy = $this->_profileID;
		                $userInfo->save();

		                $message = "Password Changed Successfully !" ;
		                $class = 1;
		                $routeName = "profile.view";
		            }
		            else
		            {
		                $message = "Old password does not match !" ;
		                $class = 2;
		                $routeName = "profile.changepassword";
		            }
	            }
	            else
	            {
	            	$message = "Error Occured ! Something went wrong !" ;
	                $class = 2;
	                $routeName = "profile.changepassword";
	            }

	            session()->flash('message', $message );
	            session()->flash('class', $class );
	            return redirect()->route($routeName);
	        }
    	}else
    	{
    		return view('profile.changepassword');
    	}
    }
    private function _checkPassword($inputPass,$userPass)
    {
        if(Hash::check($inputPass, $userPass)){
            return true;
        }else{
            return false;
        }
    }
}
