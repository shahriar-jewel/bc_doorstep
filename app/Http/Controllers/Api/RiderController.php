<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController as ApiController;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use App\Models\Order;
use App\Models\Orderitem;
use App\Models\DeliveryInfo;
use App\Models\Userinfo;
use DB;

class RiderController extends ApiController
{

    /**
     * Get The Nearest Rider List According to Their Location and Availablity .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */

    public function getRiderinfo(Request $request)
    {

        /**
        * validation rules
        */
        $rules = array(
            'kitchenid'             => 'required',
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
            $kitchenID = $request->get('kitchenid');

            $allriderinfo = DB::select(
                                "SELECT DISTINCT u.userid AS riderid,u.fullname,u.contactno, u.email , u.usertype,u.profileImage,u.app_login_status as loginstatus,
                                    rcl.lat,rcl.lng,
                                    ( 6371 * ACOS( COS( RADIANS(b.latitude) ) 
                                                   * COS( RADIANS( lat ) ) 
                                                   * COS( RADIANS( lng ) 
                                                       - RADIANS(b.longitude) ) 
                                                   + SIN( RADIANS(b.latitude) ) 
                                                   * SIN( RADIANS( lat ) ) 
                                                 )
                                    ) AS distance ,
                                    (
                                    SELECT IF ( COUNT(*) = 0 ,'1','2' ) FROM deliveryinfo AS d
                                    WHERE d.riderid = u.userid
                                    AND d.deliverytime IS NULL 
                                    AND DATE(d.created_at) = CURDATE() 
                                    ) AS available ,
                                    (
                                    SELECT COUNT(*) FROM deliveryinfo AS d
                                    WHERE d.riderid = u.userid
                                    AND d.deliverystatus = 1 
                                    ) AS jobcompleted
                                FROM userinfo AS u
                                INNER JOIN user_kitchen_map AS ubm
                                ON ubm.userid = u.userid
                                INNER JOIN kitchen AS b
                                ON b.kitchenid = ubm.kitchenid
                                LEFT JOIN ridercurrentlocation AS rcl
                                ON rcl.riderid = u.userid
                                WHERE ubm.kitchenid = ".$kitchenID."
                                AND u.usertype = 4
                                AND u.isactive = 1
                                GROUP BY riderid
                                ORDER BY available,distance ASC 
                                "
                            );

            if (count($allriderinfo) > 0 ) 
            {
                $msg="All Rider Info";
            }
            else
            {
                $msg="No Data Found !";
            }
            return $this->respondWithSuccess($msg,$allriderinfo,200);
        }
    }


    /**
     * Assign Rider to Specific Order .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */
    public function assignRider(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'orderid'          => 'required',
            'orderstatus'      => 'required',
            'orderitemid'      => 'required',
            'riderid'          => 'required'
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
            $orderID       = $request->get('orderid');
            $orderstatus   = $request->get('orderstatus');
            $riderID       = $request->get('riderid');
            $userID        = $request->get('userid');
            $orderItemIds  = json_decode($request->input('orderitemid'));


            $deliveryInfo = DeliveryInfo::where('orderid',$orderID)->first();

            if (count($deliveryInfo) > 0 ) 
            {
                if(($deliveryInfo->deliverystatus == 7 || $deliveryInfo->deliverystatus == 1) && $deliveryInfo->orderstatus >= 13){
                    $order = Order::where('orderid',$orderID)->with('orderitem')->get();
                   $orderitems = $order[0]['orderitem']->toArray();
                   $count = 0;
                   foreach($orderitems as $orderitem){
                    if($orderitem['itemstatus'] == 0){
                        $count += 1;
                    }
                   }
                   if(count($orderItemIds) == $count){
                    $orderstatus = 3;    // ready to pickup
                    $deliverystatus = 3; // delivered
                    DeliveryInfo::where('orderid',$orderID)->update(array(
                        'orderstatus' => $orderstatus,
                        'deliverystatus' => $deliverystatus
                    ));
                   }else{
                    $orderstatus = 13;   // partially ready to pickup
                    $deliverystatus = 7; // Partially delivered
                   }

                   if(count($orderItemIds) > 0){
                        Orderitem::whereIn('orderitemid',$orderItemIds)->update([
                        'itemstatus' => 1, // 1 means delivered , 0 means not delivered
                      ]);
                        Order::where('orderid',$orderID)->update([
                        'orderstatus' => $orderstatus,
                      ]);
                    }
                    $msg="Rider Assigned Successfully !";
                    $riderInfo = Userinfo::find($riderID);
                    $gcmIDS = array($riderInfo->gcmid);
                    $body = array(
                        'status'    => 'success',
                        'message'   => 'New Job Assigned',
                        'data'      => $this->_getOrderDetail($orderID)
                    );
                    $message = array(
                        'title'     => 'Incomming Order',
                        'body'      => $body, 
                        'usertype'  => 'rider',
                        'tag'       => 'incoming_order_rider'
                    );

                    $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);
                    $data = $this->_getOrderDetail($orderID);
                }
                return $this->respondWithSuccess($msg,$data,200);
            }
            else 
            {

                if ( ! $this->_checkRiderLoginStatus($riderID) ) 
                {
                    $msg = "Can not change rider ! " ; 
                    $data = [
                        'error_code'    => "704",
                        'error_msg'     => "Rider is offline ! Tell the rider to online first ."
                    ];
                    return $this->respondWithError($msg,$data,200);
                }

                   $order = Order::where('orderid',$orderID)->with('orderitem')->get();
                   $orderitems = $order[0]['orderitem']->toArray();
                   $count = 0;
                   foreach($orderitems as $orderitem){
                    if($orderitem['itemstatus'] == 0){
                        $count += 1;
                    }
                   }
                   if(count($orderItemIds) == $count){
                    $orderstatus = 3;    // ready to pickup
                    $deliverystatus = 3; // delivered
                   }else{
                    $orderstatus = 13;   // partially ready to pickup
                    $deliverystatus = 7; // Partially delivered
                   }

                $data = array(
                    'orderid'        => $orderID,
                    'riderid'        => $riderID,
                    'orderstatus'    => $orderstatus,
                    'deliverystatus' => $deliverystatus,
                    'assigntime'     => date("Y-m-d H:i:s"),
                    'created_by'     => $userID
                );
                $insertDeliveryInfo = DeliveryInfo::insert($data);
                if (count($insertDeliveryInfo) > 0 ) 
                {
                    if(count($orderItemIds) > 0){
                        Orderitem::whereIn('orderitemid',$orderItemIds)->update([
                        'itemstatus' => 1, // 1 means delivered , 0 means not delivered
                      ]);
                        Order::where('orderid',$orderID)->update([
                        'orderstatus' => $orderstatus,
                      ]);
                    }
                    $msg="Rider Assigned Successfully !";
                    $riderInfo = Userinfo::find($riderID);
                    $gcmIDS = array($riderInfo->gcmid);
                    $body = array(
                        'status'    => 'success',
                        'message'   => 'New Job Assigned',
                        'data'      => $this->_getOrderDetail($orderID)
                    );
                    $message = array(
                        'title'     => 'Incomming Order',
                        'body'      => $body, 
                        'usertype'  => 'rider',
                        'tag'       => 'incoming_order_rider'
                    );

                    $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);

                    $data = $this->_getOrderDetail($orderID);
                }
                else
                {
                    $msg="Can Not Assign Rider ! Something went wrong !"; 
                    $data = array();
                }
                
                return $this->respondWithSuccess($msg,$data,200);
            }
        }
    }

    

    public function _changeRider(Request $request,$deliveryInfo)
    {
        
        $orderID = $request->get('orderid');
        $riderID = $request->get('riderid');
        $userID  = $request->get('userid');

        #get the existing rider id
        $existingRiderId = $deliveryInfo->riderid;

        // $assignTime  = strtotime('2013-07-03 18:00:00');
        $assignTime  = strtotime($deliveryInfo->assigntime);
        $currentTime = strtotime("now");
        $subTime = $currentTime - $assignTime ;
        // $y = ($subTime/(60*60*24*365));
        // $d = ($subTime/(60*60*24))%365;
        // $h = ($subTime/(60*60))%24;
        // $m = ($subTime/60)%60;
        $m  = round(abs($subTime) / 60,2) ;
        $s  = round(abs($subTime) ,2) ;

        // echo $y."<br>".$d."<br>".$h."<br>".$m."<br>";
        
        if ($existingRiderId == $riderID) 
        {
            $msg = "Can not assign same rider ! " ; 
            $data = [
                'error_code'    => "700",
                'error_msg'     => "Can not assign same rider !"
            ];
            return $this->respondWithError($msg,$data,200);
        }
        elseif ( $m > 10 ) 
        {
            $msg = "Can not change rider ! " ; 
            $data = [
                'error_code'    => "701",
                'error_msg'     => "Rider changing time expired !"
            ];
            return $this->respondWithError($msg,$data,200);
        }
        elseif ($s < 30 ) 
        {
            $msg = "Can not change rider ! " ; 
            $data = [
                'error_code'    => "702",
                'error_msg'     => "Can not assign rider within 30s !"
            ];
            return $this->respondWithError($msg,$data,200);
        }
        elseif ( ! $this->_checkRiderLoginStatus($riderID) ) 
        {
            $msg = "Can not change rider ! " ; 
            $data = [
                'error_code'    => "704",
                'error_msg'     => "Rider is offline ! Tell the rider to online first ."
            ];
            return $this->respondWithError($msg,$data,200);
        }
        elseif($deliveryInfo->orderstatus == 3 || $deliveryInfo->orderstatus == 4)
        {
            $updateData = array(
                'orderid'           => $orderID,
                'riderid'           => $riderID,
                'orderstatus'       => 3,
                'deliverystatus'    => 0,
                'assigntime'        => date("Y-m-d H:i:s"),
                'updated_by'        => $userID 
            );

            $updateInfo = DeliveryInfo::where('orderid',$orderID)->update($updateData);

            if (count($updateInfo) > 0 ) 
            {
                $msg="Rider Updated Successfully !";
                $data = $this->_getOrderDetail($orderID);
                $riderInfo = Userinfo::find($riderID);
                $gcmIDS = array($riderInfo->gcmid);
                $body = array(
                    'status'    => 'success',
                    'message'   => 'New Job Assigned',
                    'data'      => $data
                );
                $message = array(
                    'title'     => 'Incomming Order',
                    'body'      => $body, 
                    'usertype'  => 'rider',
                    'tag'       => 'incoming_order_rider'
                );

                $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);


                #notification to existing Rider
                $riderInfo = Userinfo::find($existingRiderId);
                $gcmIDS = array($riderInfo->gcmid);
                $body = array(
                    'status'    => 'success',
                    'message'   => 'Job Canceled',
                    'data'      => $data
                );
                $message = array(
                    'title'     => 'Job Canceled',
                    'body'      => $body, 
                    'usertype'  => 'rider',
                    'tag'       => 'job_cancel'
                );

                $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);
            }
            else
            {
                $msg="Can Not Update Rider !"; 
                $data = [
                    'error_code'    => "405",
                    'error_msg'     => "Order not exist !"
                ];
                return $this->respondWithError($msg,$data,200);
            }

            return $this->respondWithSuccess($msg,$data,200);
        }
        else  
        {
            $msg = "Can not change rider ! " ; 
            $data = [
                'error_code'    => "405",
                'error_msg'     => "Order has been processed!"
            ];
            return $this->respondWithError($msg,$data,200);
        }

    }


    private function _checkRiderLoginStatus($riderID)
    {
        $riderInfo = Userinfo::find($riderID);
        if (count($riderInfo) > 0 && $riderInfo->app_login_status == 1 ) 
        {
            return true ;
        }
        else
        {
            return false;
        }
    }

    private function _getOrderDetail($orderID)
    {
        $allOrderDetail = Order::where('orderid',$orderID)
                                ->with(['orderitem.foodinfo','member','waiter','deliveryzone','tableno'])
                                ->get();

        $data = array();
        foreach ($allOrderDetail as $order) 
        {
            $orderDetail = $order->toArray();
            $orderDetail['member'] = $order->member;
            $orderDetail['waiter'] = $order->waiter;
            $riderInfo = NULL;
            if( isset( $order->deliveryinfo->rider ) ) 
            {
                $rider = $order->deliveryinfo->rider;
                $riderInfo = array(
                    'riderid'       => $rider['userid'],
                    'fullname'      => $rider['fullname'],
                    'contactno'     => $rider['contactno'],
                    'profileImage'  => $rider['profileImage']
                );
            }
            $orderDetail['rider'] = $riderInfo;
            $data[] = $orderDetail;
        }
        return $data ;
    }


    /**
     * Get the Rider Job List within a Date Range .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */

    public function riderJobList(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'kitchenid'             => 'required',
            'from_date'             => 'required',
            'to_date'               => 'required'
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

            $kitchenid  = $request->input('kitchenid');
            $fromDate   = $request->input('from_date');
            $toDate     = $request->input('to_date');
            $userID     = $request->input('userid');

            if ( trim($fromDate) == "" || trim($toDate) == "" ) 
            {
                $msg = "Validation Error!" ;
                $data = [
                    'error_code'    => "402",
                    'error_msg'     => "Missing Required Field"
                ];
                
                return $this->respondWithError($msg,$data,200);
            }

            $from   = date('Y-m-d' . ' 00:00:00', strtotime($fromDate) ); 
            $to     = date('Y-m-d' . ' 23:59:59', strtotime($toDate) );

            $allOrderDetail = Order::select('order.*' , 
                                        'deliveryinfo.deliveryid' , 
                                        'deliveryinfo.riderid' , 
                                        'deliveryinfo.assigntime' , 
                                        'deliveryinfo.pickuptime', 
                                        'deliveryinfo.deliverytime' , 
                                        'deliveryinfo.returntime' , 
                                        'deliveryinfo.last_lat' , 
                                        'deliveryinfo.last_lng' ,
                                        'deliveryinfo.deliverystatus' ,
                                        'deliveryinfo.remark')
                                    ->where('kitchenid',$kitchenid)
                                    ->join('deliveryinfo','order.orderid','=','deliveryinfo.orderid')
                                    ->with(['orderitem.foodinfo','waiter'])
                                    ->where('deliveryinfo.riderid',$userID)
                                    // ->whereIn('deliveryinfo.orderstatus',array(3,4) )
                                    ->whereBetween('order.created_at', array($from, $to))
                                    ->orderBy('order.created_at', 'desc')
                                    ->get();
            $data = array();
            foreach ($allOrderDetail as $order) 
            {
                $orderDetail = $order->toArray();
                $orderDetail['member'] = $order->member;
                $orderDetail['waiter'] = $order->waiter;
                $riderInfo = NULL;
                if( isset( $order->deliveryinfo->rider ) ) 
                {
                    $rider = $order->deliveryinfo->rider;
                    $riderInfo = array(
                        'riderid'       => $rider['userid'],
                        'fullname'      => $rider['fullname'],
                        'contactno'     => $rider['contactno'],
                        'profileImage'  => $rider['profileImage']
                    );
                }
                $orderDetail['rider'] = $riderInfo;
                $data[] = $orderDetail;
            }

            if ( count($allOrderDetail) > 0 ) 
            {
                $msg= "Rider Job Detail";
            }
            else
            {
                $msg = "No Data Found!";
            }

            $statuscode = 200;
            return $this->respondWithSuccess($msg,$data,$statuscode);
        }
    }

    /**
     * Accept Job.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */

    public function riderJobAccept(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'orderid'               => 'required',
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

            $orderID   = $request->input('orderid');
            $riderID   = $request->input('userid');

            $deliveryDetail = DeliveryInfo::where('orderid',$orderID)
                                        ->where('riderid',$riderID)
                                        ->first();
            $data = array();
            

            if ( count($deliveryDetail) > 0 ) 
            {
                $msg = "Rider Accepted the Job!";
                $deliveryDetail->deliverystatus = 1 ;
                $deliveryDetail->save();
            }
            else
            {
                $msg = "No Data Found!";
            }

            $statuscode = 200;
            return $this->respondWithSuccess($msg,$data,$statuscode);
        }
    }



}
