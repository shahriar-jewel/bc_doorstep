<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\UserinfostoreRequest;
use App\Http\Requests\UserinfoeditRequest;


use App\Models\Branch;
use App\Models\Order;
use App\Models\Orderlog;
use App\Models\Userinfo;
use App\Models\UserBranchMap;
use App\Models\Category;
use App\Models\Food;

use App\Models\DeliveryInfo;
use App\Models\Riderlocation;
use App\Models\Ridercurrentlocation;

use App\Models\ApiToken;
use Response;
use DB;

class ApiController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alluserType = getUserType(); 
        $alluserGender = getUserGender();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserinfostoreRequest $request)
    {
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userInfo = Userinfo::find($id);
        $alluserType = getUserType(); 

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserinfoeditRequest $request)
    {
        
    }


    

    public function respondWithSuccess($message,$data,$statuscode,$header = [])
    {   
        $status = "success";
        return Response::json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data
        ],$statuscode,$header); 
    }

    public function respondWithSuccessTest($message,$data,$bill=[],$statuscode,$header = [])
    {   
        $status = "success";
        return Response::json([
            'status'    => $status,
            'message'   => $message,
            'data'      => $data,
            'bill'      => $bill
        ],$statuscode,$header); 
    }

    public function respondWithError($message,$data,$statuscode,$header = [])
    {   
        $status = "failed";
        return Response::json([
            'status'    => $status,
            'message'   => $message,
            'error'     => $data
        ],$statuscode,$header); 
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function test(){

        // $to_time = strtotime("now");
        $to_time = time();
        $from_time = strtotime("2018-03-01 16:40:10");
        echo round(abs($to_time - $from_time) / 60,2). " minute <br>";
        echo round(abs($to_time - $from_time) ,2). " Second <br><br>";

        echo ($to_time - $from_time ). " <br>";


        echo   "--------------------------------------------------------------------------- <br> ";


        $to_time = strtotime("now");
            // $to_time = time();
        $from_time = strtotime("2018-03-01 16:30:10");
        echo round(abs($to_time - $from_time) / 60,2). " minute <br>";
        echo round(abs($to_time - $from_time) ,2). " Second <br><br>";

        echo ($to_time - $from_time ). " ";

        // return "DOne ";
    }

    public function sendGCM($gcmids,$message)
    {
        #API access key from Google API's Console
        $API_ACCESS_KEY = env('PUSH_NOTIFICATION_API_ACCESS_KEY') ;
        $API_URL        = env('PUSH_NOTIFICATION_SEND_URL') ;
        // define( 'API_ACCESS_KEY', 'YOUR-SERVER-API-ACCESS-KEY-GOES-HERE' );
        $registrationIds = $gcmids;
        #prep the bundle
        
        $fields = array
                (
                    // 'to'                => $GCMID // for single device push 
                    'registration_ids'  => $registrationIds , // for multiple deice push
                    'data'              => $message
                );
        $headers = array
                (
                    'Authorization: key=' . $API_ACCESS_KEY,
                    'Content-Type: application/json'
                );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        // curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_URL, $API_URL );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        #Echo Result Of FireBase Server
        return  json_decode($result);
    }

    public function pushtest()
    {
        #API access key from Google API's Console
        define( 'API_ACCESS_KEY', 'YOUR-SERVER-API-ACCESS-KEY-GOES-HERE' );
        $userinfo = Userinfo::find(9);
        $registrationIds = array( 'fK43k8Vv0JU:APA91bHVMQSzvd9jCaMId8TBlw1OaNskJ0BDvzF87zB4rHfbZUhY9CkOL_SyeEkWP01PiWsEX-C87UOv6d3_NYZhfdElrdZwEX0Ug_EcLT5YAMKnEazEaRMPvB_mMjpPH5l86pjdradV' ,
    'fK43k8Vv0JU:APA91bHVMQSzvd9jCaMId8TBlw1OaNskJ0BDvzF87zB4rHfbZUhY9CkOL_SyeEkWP01PiWsEX-C87UOv6d3_NYZhfdElrdZwEX0Ug_EcLT5YAMKnEazEaRMPvB_mMjpPH5l86pjdradV');
        // $registrationIds = array( $userinfo->gcmid );
        #prep the bundle
         $msg = array
              (
            'body'  => 'Test Push notification',
            'title' => 'Test Push',
            'tag'   => 'new_order_placed'
            // 'icon'  => 'myicon',/*Default Icon*/
            // 'sound' => 'mySound'/*Default sound*/
              );

        $ttl = array('ttl' => '3s');
        $fields = array
                (
                    // 'to'                => $GCMID // for single device push 
                    'registration_ids'  =>  $registrationIds , // for multiple deice push
                    'data'              => $msg,
                    "android"           => $ttl
                );
        
        
        $headers = array
                (
                    // 'Authorization: key=' . 'AAAAdN6q8pk:APA91bFFO44qgVLfPoT3aj572-cGhkvzalAw_VYF_dl3IC3QIkzJ-b_cW2o8w78lJWDQzVuY1i1uQp2v0YnGklYtRiz0nD-U8CARSOq3ECmTAR-QZc3oQeyAOX4A95RgRB6FmCyNpF5v',
                    'Authorization: key=' . env('PUSH_NOTIFICATION_API_ACCESS_KEY'),
                    'Content-Type: application/json'
                );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        // curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_URL, env('PUSH_NOTIFICATION_SEND_URL') );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        #Echo Result Of FireBase Server
        // echo $result;
        $jsonResult = json_decode($result);
        // dd($jsonResult->results);

        // logNotification(1,$registrationIds,$msg,$jsonResult->results,'new_order_placed');
    }




}
