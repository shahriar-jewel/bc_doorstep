<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController as ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use App\Mail\AppForgetPassMail;

use App\Models\Branch;
use App\Models\Userinfo;
use App\Models\UserBranchMap;
use App\Models\ApiToken;

use App\Models\DeliveryInfo;

use App\Models\Riderlocation;
use App\Models\Ridercurrentlocation;

class AuthController extends ApiController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function appsLogin(Request $request)
    {   

        if ( $request->has('token') && $request->has('userid') ) 
        {
            $tokenInfo = ApiToken::where( 'token',$request->input('token'))
                                ->where( 'userid',$request->input('userid'))
                                ->first();

            if (count($tokenInfo) > 0 ) {
                $user = Userinfo::find($request->input('userid'));

                $data = [
                    'apiToken'         => $tokenInfo->token,
                    'userId'           => $user->userid,
                    'fullName'         => $user->fullname,
                    'mobileNo'         => $user->contactno,
                    'userEmail'        => $user->email,
                    'userType'         => $user->usertype,
                    'restaurantInfo'   => $user->usertype == '-1' ? '-1' : $user->restaurantInfo,
                    'branchInfo'       => $user->usertype == '-1' ? '-1' : $this->_getuserBranches($user->userid,$user->usertype,$user->restaurantid),
                ];

                $msg = "Login Successfully!";
                return $this->respondWithSuccess($msg,$data,200);
            }
            else
            {
                $status = 'failed' ;
                $msg = 'Session expired. Please logout and log in again.!' ;
                $data = [
                    'error_code'    => "401",
                    'error_msg'     => "Api token mismatched!"
                ];
                return $this->respondWithError($msg,$data,200);
            }
        }
        else if ( ($user=$this->_checkUser($request))!==false  && $this->_checkPassword($request->input('password'),$user)===true ) 
        {

            $data = [
                'apiToken'         => $this->_updateToken($user->userid),
                'userId'           => $user->userid,
                'fullName'         => $user->fullname,
                'mobileNo'         => $user->contactno,
                'userEmail'        => $user->email,
                'userType'         => $user->usertype,
                'restaurantInfo'   => $user->usertype == '-1' ? '-1' : $user->restaurantInfo,
                'branchInfo'       => $user->usertype == '-1' ? '-1' : $this->_getuserBranches($user->userid,$user->usertype,$user->restaurantid),
            ];
            $this->_updateGCMID($request,$user );
            $user->app_login_status = 1;
            $user->save();
            $msg = "Login Successfully!";
            return $this->respondWithSuccess($msg,$data,200);
        }else{
            $msg = 'Login failed' ;
            $data = [
                'error_code'    => "403",
                'error_msg'     => "Username or Password mismatched!"
            ];
            return $this->respondWithError($msg,$data,200);
        }

    }


    /**
     * Check the specific user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean false or Object $user
     */
    private function _checkUser(Request $request)
    {
        $username = $request->input('username');
        $user = Userinfo::where('isactive', 1)
                    ->where(function($query) use ($username)
                    {
                        $query->where('email', '=', $username )
                              ->orwhere('contactno', $username );
                    })
                    ->first();
        if(count($user)>0){
            return $user;
        }else{
            return false;
        }
    }


    /**
     * Check the specific user password.
     *
     * @param  int  $inputPass
     * @param  object  $user
     * @return boolean true or false
     */
    private function _checkPassword($inputPass,$user)
    {
        if(Hash::check($inputPass, $user->password )){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the specific user branch access.
     *
     * @param  int  $userID
     * @param  int  $userType
     * @param  int  $resID
     * @return array $branches
     */
    private function _getuserBranches($userID,$userType,$resID)
    {
        $branches = array();
        
        if ($userType == 1) 
        {
            $branchInfo = Branch::where('restaurantid',$resID)->get();
            foreach ($branchInfo as $branch ) {
                $branchData = array(
                    'branchId'      => $branch->branchid,
                    'branchName'    => $branch->branchname,
                    'branchAddress' => $branch->address,
                    'branchMobile'  => $branch->contactno,
                    'branchEmail'  => $branch->email
                ); 
                $branches [] = $branchData ;
            }
        }else
        {
            $branchInfo = UserBranchMap::where( 'userid',$userID )->get();
            foreach ($branchInfo as $branch ) {
                $branchData = array(
                    'branchId'      => $branch->branchid,
                    'branchName'    => $branch->branch->branchname,
                    'branchAddress' => $branch->branch->address,    
                    'branchMobile'  => $branch->branch->contactno,
                    'branchEmail'   => $branch->branch->email
                ); 
                $branches [] = $branchData ;
            }
        }
        return $branches;
    }

    /**
     * Update the specific user TOKEN.
     *
     * @param  int  $userID
     * @return $token
     */
    private function _updateToken($userID)
    {
        $token = $this->_quickRandom(64);
        $tokenData = array(
            // 'token'     => sha256(base64_encode($userID."_".time()."_".rand(10000,99999))),
            'token'     => $token,
            'userid'    => $userID
        );
        $ApiToken = ApiToken::updateOrCreate( [ 'userid' => $userID ],$tokenData);

        return $token;
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int  $length
     * @return string
     */
    public static function _quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }

    /**
     * Update the specific user GCMID. This function will execute from Auth method
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  object  $user
     */
    public function _updateGCMID(Request $request ,$user)
    {
        $gcmID = ''; 
        $imei='';
        if ( $request->has('gcm_id') ) 
        {
            $gcmID = $request->input('gcm_id');
        }
        if ( $request->has('imei') ) 
        {
            $imei = $request->input('imei');
        }
        
        if ( trim($gcmID) != "" && $gcmID != $user->gcmid ) 
        {
            $data = array(
                'gcmid' => $gcmID,
                'imei'  => ( trim($imei) != "" && $imei != $user->imei ) ? $imei : $user->imei
            );
            Userinfo::where('userid',$user->userid)->update($data) ;
        }
    }

    /**
     * Update the specific user GCMID. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  object  $user
     */
    public function updateGCMID(Request $request )
    {

        $rules = array(
            'gcm_id'             => 'required',
            'userid'            => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            $msg = "Validation Error!" ;
            $data = [
                'error_code'    => "402",
                'error_msg'     => "Missing Required Field"
            ];
            
            return $this->respondWithError($msg,$data,200);
        }
        else
        {
            $imei='';
            $userID = $request->input('userid');
            $gcmID  = $request->input('gcm_id');

            $userInfo = Userinfo::find($userID);

            if ( $request->has('imei') ) 
            {
                $imei = $request->input('imei');
            }
        
            if ( trim($gcmID) != "" && $gcmID != $userInfo->gcmid ) 
            {
                $data = array(
                    'gcmid' => $gcmID,
                    'imei'  => ( trim($imei) != "" && $imei != $userInfo->imei ) ? $imei : $userInfo->imei
                );

                Userinfo::where('userid',$userID)->update($data) ;
            }
            $msg = "GCMID Updated Successfully !" ;

            return $this->respondWithSuccess($msg,array(),200);
        }
    }

    /**
     * Reset the specific user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $rules = array(
            'old_password'       => 'required|min:4',
            'new_password'       => 'required|min:4',
            'userid'             => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            $msg = "Validation Error!" ;
            $data = [
                'error_code'    => "402",
                'error_msg'     => "Missing Required Field"
            ];
            
            return $this->respondWithError($msg,$data,200);
        }
        else
        {
            $userID = $request->input('userid');
            $userInfo = Userinfo::find($userID);

            if ( $this->_checkPassword($request->input('old_password'),$userInfo) ) 
            {
                if (count($userInfo) > 0 ) 
                {
                    $userInfo->password     = Hash::make($request->input('new_password'));
                    $userInfo->updated_by   = $userID;
                    $userInfo->save();

                    $msg = "Password Changed Successfully !";
                    $statuscode = 200;
                    $data = array();
                    return $this->respondWithSuccess($msg,$data,$statuscode);
                }
            }
            else
            {
                $msg = "Validation Error!" ;
                $data = [
                    'error_code'    => "402",
                    'error_msg'     => "Old Password Not Matched"
                ];
                
                return $this->respondWithError($msg,$data,200);
            }
            
        }
 
    }

    /**
     * Forget password request.  
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Response JSON 
     */
    public function forgetPassword(Request $request)
    {
        $rules = array(
            "username"      => "required",
            "emailormobile" => "required"
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){            
            $errors = $validator->messages()->toArray();

            $msg = "Validation Error!" ;
            $data = [
                'error_code'    => "402",
                'error_msg'     => "Username Required!"
            ];
            
            return $this->respondWithError($msg,$data,200);
        }

        $userInfo =  $this->_checkUser($request);
        if ( $userInfo !==false ) 
        {
            $_token = rand(100000,999999);
            $userInfo->forgetpasswordtoken = $_token;
            $userInfo->save();
            
            if ( $request->input('emailormobile') == 1 ) 
            {
                Mail::to($userInfo->email)->send(new AppForgetPassMail($_token));
            }
            else
            {
                $smsBody = $_token.' is your password reset code.' ; 
                $this->sendSMS($userInfo->userid,$userInfo->contactno,$smsBody,'forgetpassword');
            }


            $msg = "Reset Code Send Successfully !";
            $data = array(
                        'resetcode' => $_token,
                        'userid'    => $userInfo->userid
                    );
            return $this->respondWithSuccess($msg,$data,200);
        }
        else
        {
            $msg = "Invalid username !" ;
            $data = [
                'error_code'    => "403",
                'error_msg'     => "Username does not exist !"
            ];
            
            return $this->respondWithError($msg,$data,200);
        }
    }


    private function sendSMS($id,$mobile_no, $message,$smstype) {

        $encodedMessage= urlencode($message);
        $contextOptions = array(
            "ssl" => array(
                "verify_peer" => FALSE,
                "verify_peer_name" => FALSE,
            ),
        );

        // $cliNumber = "01729024921" ;
        $URL = "https://cmp.grameenphone.com/gpcmpapi/messageplatform/controller.home?username=BANGLATRAC&password=BtracPsd@321&apicode=1&msisdn=$mobile_no&countrycode=880&cli=TIFFINBOX&messagetype=1&message=$encodedMessage&messageid=0";

        $results = file_get_contents($URL, FALSE, stream_context_create($contextOptions));

        $str = explode(",", $results);
        $status = $str[0];

        // if ($status == 200) {
        //      $this->smslog($id,$message,1);
        // } else {
        //      $this->smslog($id,$message,0);
        // }
    }

    // private function smslog($id,$message,$smstype,$status){
    //     $data = array(
    //         'touserid'   => $id,
    //         'smsbody'    => $message,
    //         'smstype'    => $smstype,
    //         'status'     => $status,
    //     );
    //     SMSLog::insert($data);
    // }


    public function passwordReset(Request $request)
    {
        
        $rules = array(
            'resetcode'             => 'required',
            'password'              => 'required|min:4',
            'password_confirmation' => 'min:4|same:password'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();

            $msg = "Validation Error!" ;
            $data = [
                'error_code'    => "402",
                'error_msg'     => "Username Required!"
            ];
            
            return $this->respondWithError($msg,$data,200);
        }
        else
        {
            $resetToken = $request->input('resetcode');
            $userInfo = Userinfo::where('forgetpasswordtoken',$resetToken)->first();

            if (count($userInfo)>0) 
            {
                $userInfo->password             = Hash::make($request->input('password'));
                $userInfo->forgetpasswordtoken  = NULL ;
                $userInfo->save();

                $msg = 'Password Reset Successfully ! Please login !' ;
            }
            else
            {
                $msg = 'Reset code expired or you already reset your password !' ;
            }
        
            return $this->respondWithSuccess($msg,array(),200);
        }
            
    }


    /**
     * Logout the user from app. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Response JSON 
     */
    public function Logout(Request $request)
    {
        $userId = $request->input('userid');
        $userInfo = Userinfo::find($userId);
        if (count($userInfo) > 0 ) 
        {
            $userInfo->app_login_status = 0;
            $userInfo->save();
            $msg = "Logout Successfully !" ;
        }
        else
        {
            $msg = "Can not find the user !" ;
        }

        return $this->respondWithSuccess($msg,array(),200);
    }


    /**
     * Update the specific user location. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Response JSON 
     */
    public function locationUpdate(Request $request )
    {

        $rules = array(
            'lat'             => 'required',
            'lng'             => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            $msg = "Validation Error!" ;
            $data = [
                'error_code'    => "402",
                'error_msg'     => "Missing Required Field"
            ];
            
            return $this->respondWithError($msg,$data,200);
        }
        else
        {
            $lat = $request->input('lat');
            $lng  = $request->input('lng');
            $userID  = $request->input('userid');

            $userInfo = Userinfo::find($userID);
        
            $data = array(
                'riderid'       => $userID,
                'lat'           => $lat,
                'lng'           => $lng,
                'lastlocation'  => $request->input('locationname'),
            );
            Riderlocation::insert($data);
            $riderLocation = Ridercurrentlocation::where('riderid',$userID)->first();


            $updateData = array(
                'last_lat'      => $lat,
                'last_lng'      => $lng
            );

            $deliveryInfo = DeliveryInfo::where('riderid',$userID)
                                        ->whereIn('deliverystatus',array(0,1,2))
                                        ->update($updateData);

            if ( count($riderLocation) > 0 ) 
            {
                Ridercurrentlocation::where('riderid',$userID)->update($data);
            }
            else
            {
                Ridercurrentlocation::insert($data);
            }
            $msg = "Location Updated Successfully !" ;

            return $this->respondWithSuccess($msg,array(),200);
        }
    }

}