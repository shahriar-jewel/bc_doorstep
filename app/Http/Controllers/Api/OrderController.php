<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController as ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use App\Models\Branch;
use App\Models\Order;
use App\Models\Orderlog;
use App\Models\DeliveryInfo;
use Carbon\Carbon;
use DB ;
use App\Models\Orderitem;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Memberinfo;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

class OrderController extends ApiController
{

    /**
     * Order detail branch wise .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */

    private $config;
    private $API_TIMEOUT;

    public function __construct()
    {
        $this->config = config('club.production');
    }

    public function orderDetail(Request $request)
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

            $kitchenid   = $request->input('kitchenid');
            $fromDate   = $request->input('from_date');
            $toDate     = $request->input('to_date');
            $userID         = $request->input('userid');

            

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
            ->leftJoin('deliveryinfo','order.orderid','=','deliveryinfo.orderid')
            ->with(['orderitem.foodinfo','waiter','deliveryzone','tableno'])
            ->whereBetween('order.created_at', array($from, $to))
            ->orderBy('order.created_at', 'desc');

            if ($kitchenid) {
                $allOrderDetail = $allOrderDetail->where('kitchenid',$kitchenid);
            }else if(!$kitchenid){
                $allOrderDetail = $allOrderDetail->where('order.created_by',$userID);
            }

            $allOrderDetail = $allOrderDetail->get();

            $data = array();
            foreach ($allOrderDetail as $order) 
            {
                $orderDetail = $order->toArray();
                $orderDetail['member'] = $order->member;
                $orderDetail['waiter'] = $order->waiter;
                // if (isset($orderDetail['orderfrom']) && $orderDetail['orderfrom'] == 1) {
                //     $orderDetail['customer']['name'] = $order->customer['name']." (Microsite)";
                // }
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
                $msg= "Order Detail";
            }
            else
            {
                $msg = "No Data Found!";
            }

            $statuscode = 200;
            return $this->respondWithSuccess($msg,$data,$statuscode);
        }
    }

    public function singleOrderDetail(Request $request){
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
        }else{
            $orderID        = $request->input('orderid');
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
                if( isset( $order->deliveryinfo->rider)) 
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
            $msg = 'Data Found Successfully!';
            $statuscode = 200;
            return $this->respondWithSuccess($msg,$data,$statuscode);
        }
    }
    

    /**
     * Order Accept and Deny function.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON Response
     */

    public function orderAcceptDeny(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'orderid'              => 'required',
            'kitchenid'            => 'required',
            'orderstatus'          => 'required'
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
            $orderID        = $request->input('orderid');
            $kitchenID      = $request->input('kitchenid');
            $orderStatus    = $request->input('orderstatus');
            $userID         = $request->input('userid');
            $statuscode     = 200;
            $data           = array();


            $orderInfo = Order::find($orderID);
            $updateOrderStatus = false ;

            if ( count($orderInfo) > 0 ) 
            {
                if ( $orderStatus == 2 && $orderInfo->orderstatus == 1) 
                {
                    $updateOrderStatus = $this->_updateOrderStatus($request);
                    $this->sendPushToWaiter($orderID,$orderStatus,'confirmed_processing', 'Order is confirmed & processing');
                }elseif($orderStatus == 4 && $orderInfo->orderstatus == 3){
                    $updateData = array(
                        'orderstatus'   => 4,
                        'updated_by'    => $userID
                    );
                    Order::where('orderid',$orderID)->update($updateData);
                    // $deliveryInfo = DeliveryInfo::where('orderid',$orderID)->first();
                    // $deliveryInfo->pickuptime = date('Y-m-d H:i:s');
                    $logData = array(
                        'orderid'       => $orderID,
                        'kitchenid'     => $kitchenID,
                        'orderstatus'   => 4,
                        'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                        'created_by'    => $userID
                    );
                    Orderlog::insert($logData);


                    $this->sendPushToWaiter($orderID,$orderStatus,'order_picked_up','Order picked up');
                    $this->sendPushToBranchAgent($orderID,$orderStatus,'order_picked_up');

                }elseif($orderStatus == 4 && $orderInfo->orderstatus == 13){
                    $updateData = array(
                        'orderstatus'   => 14,
                        'updated_by'    => $userID
                    );
                    Order::where('orderid',$orderID)->update($updateData);
                    $logData = array(
                        'orderid'       => $orderID,
                        'kitchenid'     => $kitchenID,
                        'orderstatus'   => 14,
                        'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                        'created_by'    => $userID
                    );
                    Orderlog::insert($logData);
                    $this->sendPushToWaiter($orderID,14,'order_partially_picked_up','Order partially picked up');
                    $this->sendPushToBranchAgent($orderID,14,'order_partially_picked_up');

                }elseif($orderStatus == 12 && $orderInfo->orderstatus == 14){
                    $updateData = array(
                        'orderstatus'   => 15,
                        'updated_by'    => $userID
                    );
                    Order::where('orderid',$orderID)->update($updateData);
                    $logData = array(
                        'orderid'       => $orderID,
                        'kitchenid'     => $kitchenID,
                        'orderstatus'   => 15,
                        'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                        'created_by'    => $userID
                    );
                    Orderlog::insert($logData);
                    $this->sendPushToWaiter($orderID,15,'order_partially_in_pantry','Order partially in pantry');
                    $this->sendPushToBranchAgent($orderID,15,'order_partially_in_pantry');

                }elseif($orderStatus == 12 && $orderInfo->orderstatus == 4){
                    $updateData = array(
                        'orderstatus'   => 12,
                        'updated_by'    => $userID
                    );
                    Order::where('orderid',$orderID)->update($updateData);
                    $logData = array(
                        'orderid'       => $orderID,
                        'kitchenid'     => $kitchenID,
                        'orderstatus'   => 12,
                        'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                        'created_by'    => $userID
                    );
                    Orderlog::insert($logData);
                    $this->sendPushToWaiter($orderID,12,'order_in_pantry','Order partially in pantry');
                    $this->sendPushToBranchAgent($orderID,12,'order_in_pantry');

                }elseif($orderStatus == 5 && $orderInfo->orderstatus == 12){
                    $updateData = array(
                        'orderstatus'   => 5,
                        'updated_by'    => $userID
                    );
                    Order::where('orderid',$orderID)->update($updateData);
                    $logData = array(
                        'orderid'       => $orderID,
                        'kitchenid'     => $kitchenID,
                        'orderstatus'   => 5,
                        'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                        'created_by'    => $userID
                    );
                    Orderlog::insert($logData);
                    $this->sendPushToBranchAgent($orderID,5,'order_delivered');

                }elseif($orderStatus == 5 && $orderInfo->orderstatus == 15){
                    $updateData = array(
                        'orderstatus'   => 16,
                        'updated_by'    => $userID
                    );
                    Order::where('orderid',$orderID)->update($updateData);
                    $logData = array(
                        'orderid'       => $orderID,
                        'kitchenid'     => $kitchenID,
                        'orderstatus'   => 16,
                        'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                        'created_by'    => $userID
                    );
                    Orderlog::insert($logData);
                    $this->sendPushToBranchAgent($orderID,16,'order_partially_delivered');

                }

                // if ($updateOrderStatus) 
                // {
                //     $msg = "Updated Successfully !" ; 
                //     return $this->respondWithSuccess($msg,$data,$statuscode);
                // }
                // else
                // {
                //     $msg = "Update Error ! " ; 
                //     $data = [
                //         'error_code'    => "405",
                //         'error_msg'     => "Can not change the order status !"
                //     ];
                //     return $this->respondWithError($msg,$data,$statuscode);
                // }
                $msg = "Updated Successfully !" ; 
                return $this->respondWithSuccess($msg,$data,$statuscode);
            }
            else
            {
                $msg = "Can not accept or deny ! Order not found! " ; 
                $data = [
                    'error_code'    => "405",
                    'error_msg'     => "Can not accept or deny ! Order not found!"
                ];
                return $this->respondWithError($msg,$data,$statuscode);
            }

        }

    }

    private function _updateOrderStatus(Request $request)
    {
        $orderID        = $request->input('orderid');
        $kitchenID      = $request->input('kitchenid');
        $orderStatus    = $request->input('orderstatus');
        $userID         = $request->input('userid');

        $updateData = array(
            'orderstatus'   => $orderStatus,
            'updated_by'    => $userID
        );

        $updateinfo = Order::where('orderid',$orderID)->update($updateData);
        if ($updateinfo) 
        {   
            $logData = array(
                'orderid'       => $orderID,
                'kitchenid'     => $kitchenID,
                'orderstatus'   => $orderStatus,
                'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                'created_by'    => $userID
            );
            Orderlog::insert($logData);

            return true ;
        }
        else
        {
            return false;
        }
    }

    private function sendPushToWaiter($orderID,$orderStatus,$tag,$title){

        $orderInfo = Order::find($orderID);
        if ($orderInfo) 
        {
            $userList = DB::select("SELECT userid,gcmid FROM userinfo
                WHERE userid = ".$orderInfo->created_by." 
                AND app_login_status = 1");
            $gcmIDS = array();
            foreach ($userList as $user) 
            {
                $gcmIDS[] = $user->gcmid ; 
            }

            $body = array(
                'status'    => 'success',
                'message'   => $title,
                'data'      => $this->_getOrderDetail($orderInfo->orderid)
            );
            $message = array(
                'title'     => $title,
                'body'      => $body, 
                'usertype'  => 'waiter',
                'tag'       => $tag
            );

            $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);
            $msg = 'Waiter is notified successfully!';
            $statuscode = 200;
            $data = '';
            return $this->respondWithSuccess($msg,$data,$statuscode);
        }else{
            $msg = 'Waiter not notified!';
            $statuscode = 404;
            $data = '';
            return $this->respondWithError($msg,$data,$statuscode);
        }
    }

    private function sendPushToBranchAgent($orderID,$orderStatus,$tag)
    {
        $orderInfo = Order::find($orderID);
        $allOrderStatus = getOrderStatus();

        if ($orderInfo) 
        {
            $userList = DB::select("SELECT ui.userid,gcmid FROM userinfo AS ui
                INNER JOIN user_kitchen_map AS ubm
                ON ubm.userid = ui.userid
                WHERE ubm.kitchenid = ".$orderInfo->kitchenid."
                AND ui.usertype = 2
                AND ui.app_login_status = 1");
            $gcmIDS = array();
            foreach ($userList as $user) 
            {
                $gcmIDS[] = $user->gcmid ; 
            }
            $body = array(
                'status'    => 'success',
                'message'   => 'Order '.$allOrderStatus[$orderStatus].'.Order #'.$orderInfo->ordernumber,
                'data'      => ''
            );
            $message = array(
                'title'     => 'Order has been '.$allOrderStatus[$orderStatus],
                'body'      => $body, 
                'usertype'  => 'branchagent',
                'tag'       => $tag
            );
            $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);
        }
    }


    public function statement(Request $request)
    {
        $rules = array(
            'branchid'              => 'required',
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

            $branchid   = $request->input('branchid');
            $fromDate   = $request->input('from_date');
            $toDate     = $request->input('to_date');

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


            $perDayStatement = DB::select("SELECT 
                DATE_FORMAT(created_at, '%b %d, %Y') AS orderDate , 
                COUNT(*) AS totalOrder ,
                SUM(amount) AS subTotal ,
                SUM(vatamount) AS totalVatamount ,
                SUM(deliverycharge) AS totalDeliverycharge,
                SUM(totalAmount) AS grandTotal
                FROM deliverysystem.order
                WHERE ( orderstatus = 5 OR orderstatus = 8 )
                AND created_at >= '".$from."' 
                AND created_at <= '".$to."' 
                AND branchid = ".$branchid."
                GROUP BY DATE(created_at) 
                ORDER BY created_at DESC "
            );

            $allDayStatement = DB::select("SELECT 
                COUNT(*) AS totalOrder ,
                SUM(amount) AS subTotal ,
                SUM(vatamount) AS totalVatamount ,
                SUM(deliverycharge) AS totalDeliverycharge,
                SUM(totalAmount) AS grandTotal
                FROM deliverysystem.order
                WHERE ( orderstatus = 5 OR orderstatus = 8 )
                AND created_at >= '".$from."' 
                AND created_at <= '".$to."' 
                AND branchid = ".$branchid
            );
            $data = array();

            if ( count($perDayStatement) > 0 && count($allDayStatement) > 0) 
            {
                $data ['total']     = $allDayStatement[0];
                $data ['datewise']  = $perDayStatement;
                $msg= "Statement";
                $statuscode = 200;
                return $this->respondWithSuccess($msg,$data,$statuscode);
            }
            else
            {
                $msg = "No Data Found!";
                $data = [
                    'error_code'    => "406",
                    'error_msg'     => "No Data Found!"
                ];
                
                return $this->respondWithError($msg,$data,200);
            }
            
        }
    }
    public function getMember(Request $request){
        $rules = array(
            'member_id'              => 'required',
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
        }else{
            $member_id = strtoupper($request->input('member_id'));
            
            // $member_check = DB::table('memberinfo')
            // ->where('id','>',1213)
            // ->get();
            $member_check = DB::table('memberinfo')
            ->where('member_id',$member_id)
            ->where('isactive','Y')
            ->first();
            if(count($member_check) > 0){
                $statuscode = 200;
                $msg = "Member Data Found From Local DB!";
                $member_data = array(
                    'member_id'     => $member_check->member_id,
                    'member_name'   => $member_check->name,
                    'member_mobile' => $member_check->contactno,
                    'member_image'  => $member_check->image,
                );
                return $this->respondWithSuccess($msg,$member_data,$statuscode);




                // foreach($member_check as $key => $value){

                //     $head=array(
                //         'Content-Type:application/json'
                //     );
                //     $url = $this->config['apiBaseURL'].'acno='.$value->member_id;
                //     $ch = curl_init();
                //     curl_setopt( $ch,CURLOPT_URL, $url );
                //     curl_setopt( $ch,CURLOPT_POST, false );
                //     curl_setopt( $ch,CURLOPT_HTTPHEADER, $head );
                //     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                //     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                //     $result = curl_exec($ch);
                //     curl_close($ch);

                //     $data = json_decode($result);

                //     $statuscode = 200;
                //     $msg = "Member Data Found From API!";
                //     DB::table('memberinfo')->where('member_id',$value->member_id)
                //                            ->update(array(
                //         'contactno' => $data[0]->mobile,
                //         'image'     => $data[0]->url
                //     ));
                // }
                
                // return $this->respondWithSuccess($msg,'ok',$statuscode);




            }else if(count($member_check) == 0){
                $head=array(
                    'Content-Type:application/json'
                );
                $url = $this->config['apiBaseURL'].'acno='.$member_id;
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, $url );
                curl_setopt( $ch,CURLOPT_POST, false );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $head );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                $result = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($result);

                if(count($data) > 0){
                    $memberData = array(
                        "member_id"     => $data[0]->account,
                        "name"          => $data[0]->name,
                        "type"          => 'type',
                        "contactno"     => $data[0]->mobile != null ? $data[0]->mobile : '00000000000',
                        "image"         => $data[0]->url,
                        "isactive"      => 'Y',
                    );

                    $memberInfo = Memberinfo::firstOrCreate($memberData);

                    $member_data = array(
                        'member_id'     => $memberInfo->member_id,
                        'member_name'   => $memberInfo->name,
                        'member_mobile' => $memberInfo->contactno,
                        'member_image'  => $memberInfo->image,
                    );

                    $statuscode = 200;
                    $msg = "Member Data Found From API!";
                    return $this->respondWithSuccess($msg,$member_data,$statuscode);
                }else{
                    $msg = "Member Not Found!" ;
                    $data = [];
                    return $this->respondWithError($msg,$data,200);
                }  
            }
        }
    }
    public function memberUpdate(Request $request){
        $rules = array(
            'member_id'              => 'required',
            'orderid'                => 'required',
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
        }else{
            $orderid   = $request->get('orderid');
            $member_id = strtoupper($request->input('member_id'));
            $statuscode = 200;
            $member_check = Memberinfo::where('member_id',$member_id)->first();
            if($member_check){
              $billpay = DB::table('order')
                 ->where('orderid',$orderid)
                 ->first();
             if($billpay && $billpay->paymentstatus == 1){
                   $msg = 'Its already paid and not able to update member!';
                   return $this->respondWithError($msg,$data='',200);
             }else{
                $member_update = DB::table('order')
                                    ->where('orderid',$orderid)
                                    ->update(['member_id' => $member_id
                    ]);
               if($member_update){
                $msg = 'Member is found & updated!';
               }else{
                $msg = 'No data to Update!';
               }
             }
              return $this->respondWithSuccess($msg,$data='',$statuscode);
          }else{
            $msg = 'Member not found';
            return $this->respondWithError($msg,$data='',200);
        }
    }
}
public function getAllMembers(Request $request){
    $members = DB::table('memberinfo')
    ->where('isactive','Y')
    ->get();
    if(count($members) > 0){
        $statuscode = 200;
        $msg = "Member List!";
        foreach ($members as $key => $member) {
            $member_data[] = array(
                'member_id' => $member->member_id,
                'member_name' => $member->name,
                'member_mobile' => $member->contactno,
                    // 'member_image' => url('upload/member_images/'.$member->image),
                'member_image' => $member->image,
            );
        }
        return $this->respondWithSuccess($msg,$member_data,$statuscode);
    }else{
        $msg = "No Members Found!";
        $statuscode = 404;
        $data = [
            'error_code'    => "404",
            'error_msg'     => "No Members Found!"
        ];
        return $this->respondWithError($msg,$data,$statuscode);
    }
}
public function getWaiterOrders(Request $request){
    $rules = array(
        'userid'                => 'required',
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
    }else{
        $today  = Carbon::now()->toDateString();
        $from   = date('Y-m-d' . ' 00:00:00', strtotime($today) ); 
        $to     = date('Y-m-d' . ' 23:59:59', strtotime($today) );
        $allOrderDetail = Order::select('order.orderid','order.member_id')
        ->where('created_by',$request->input('userid'))
        ->with(['orderitem.foodinfo'])
        ->whereBetween('order.created_at', array($from, $to))
        ->orderBy('order.created_at', 'desc')
        ->get();

        $data = array();
        foreach ($allOrderDetail as $order) 
        {
            $orderDetail = $order->toArray();
            $orderDetail['member'] = $order->member;
            $data[] = $orderDetail;
        }
        if(count($allOrderDetail) > 0){
            $msg = 'Waiter Per Day Orders';
            $statuscode = 200;
            return $this->respondWithSuccess($msg,$data,$statuscode);
        }else{
            $msg = 'No Order Found!';
            $statuscode = 404;
            $data = '';
            return $this->respondWithError($msg,$data,$statuscode);
        }
    }
}

public function getOrderData(Request $request){
    $rules = array(
        'member_id'              => 'required',
        'locationid'             => 'required',
        'created_by'             => 'required',
        'payload'                => 'required',
    );

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails())
    {
        $errors = $validator->messages()->toArray();
        $msg = "Validation Error!";
        $data = [
            'error_code'    => "402",
            'error_msg'     => "Missing Required Field"
        ];

        return $this->respondWithError($msg,$data,200);
    }else{
        $allOrderData = json_decode($request->input('payload'));
        $credentials = [
            'member_id' => strtoupper($request->input('member_id')),
            'locationid' => $request->input('locationid'),
            'created_by' => $request->input('created_by'),
        ];

        if($allOrderData){
                $allkitchen_items = $this->group_by($allOrderData,'kitchenid'); // kitchen wise food items
                $orderNumber = date("ymd")."".rand(10000,99999);

                foreach ($allkitchen_items as $kitchenid => $kitchen_items) {
                    $orderModel = new Order;
                    $total = 0;
                    foreach ($kitchen_items as $key => $kitchen_item) {
                        $total += $kitchen_item->price * $kitchen_item->quantity;
                    }

                    $orderData = array(
                        'member_id'             => strtoupper($request->input('member_id')),
                        'ordernumber'           => $orderNumber,
                        'kitchenid'             => $kitchenid,
                        'locationid'            => $request->input('locationid'),
                        'tableid'               => $request->input('tableid'),
                        'orderstatus'           => 1,
                        'orderfrom'             => 1, // from app
                        'shippingaddress'       => $request->input('locationid'),
                        'amount'                => $total,
                        'totalamount'           => $total,
                        'paymentmethod'         => 1, // 1 for Card, 2 for Cashcard, 3 for Credit
                        'paymentstatus'         => 0, 
                        'specialinstruction'    => $request->input('specialinstruction'),
                        "created_by"            => $request->input('created_by')
                        );
                    $orderInfo = Order::create($orderData);

                    $orderLogData = array(
                        'orderid'               => $orderInfo->orderid,
                        'kitchenid'             => $kitchenid,
                        'orderstatus'           => 1,
                        "created_by"            => $request->input('created_by')
                    );
                    $orderLog = Orderlog::insert($orderLogData);
                    foreach ($kitchen_items as $key => $kitchen_item) {
                        $orderitemData = array(
                            'orderid'    => $orderInfo->orderid,
                            'ordernumber'=> $orderNumber,
                            'foodid'     => $kitchen_item->foodid,
                            'kitchenid'  => $kitchenid,
                            'quantity'   => $kitchen_item->quantity,
                            'price'      => $kitchen_item->price,
                            'totalprice' => $kitchen_item->price * $kitchen_item->quantity,
                            'remarks'    => $kitchen_item->remarks ? $kitchen_item->remarks : null,
                            'itemstatus' => 0, // 0 for not delivered, 1 for delivered
                            "created_by" => $request->input('created_by')
                        );              
                        $orderitemInfo = Orderitem::create($orderitemData);
                    }

                    $userList = DB::select("SELECT ui.userid,gcmid FROM userinfo AS ui
                        INNER JOIN user_kitchen_map AS ubm
                        ON ubm.userid = ui.userid
                        WHERE ubm.kitchenid = ".$kitchenid." 
                        AND ui.usertype = 2");

                    // $orderSummary = DB::select("SELECT 
                    //                 order.orderid,order.ordernumber, deliveryzone.zonename, tableno.tablename as 'tableno',
                    //                 userinfo.fullname as 'waitername',memberinfo.name as 'membername',userinfo.usertype
                    //             FROM banani_club.order
                    //             INNER JOIN banani_club.deliveryzone ON order.locationid = deliveryzone.zoneid
                    //             INNER JOIN banani_club.tableno ON order.tableid = tableno.tableid
                    //             INNER JOIN banani_club.userinfo ON order.created_by = userinfo.userid
                    //             INNER JOIN banani_club.memberinfo ON order.member_id = memberinfo.member_id
                    //             WHERE order.orderid = '".$orderInfo->orderid."'
                    //             "
                    //         );

                    $orderSummary = Order::where('orderid',$orderInfo->orderid)
                                    ->with(['member','waiter','deliveryzone','tableno'])
                                    ->get();


                    $gcmIDS = array();
                    foreach ($userList as $user) 
                    {
                        $gcmIDS[] = $user->gcmid; 
                    }
                    $body = array(
                        'status'    => 'success',
                        'message'   => 'New Order Placed',
                        'data'      => $orderSummary
                    );
                    $message = array(
                        'title'     => 'New Order Placed',
                        'body'      => $body, 
                        'usertype'  => 'branchagent',
                        'tag'       => 'new_order_placed'
                    );

                    $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);
                }

                $msg = 'Data Found Successfully!';
                $statuscode = 200;
                $data = '';
                return $this->respondWithSuccess($msg,$data,$statuscode);
            }else{
                $msg = 'Data Not Found!';
                $statuscode = 404;
                $data = '';
                return $this->respondWithError($msg,$data,$statuscode);
            }
        }
    }

    function group_by($data, $group_by) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value->$group_by][] = $value ;
        }
        return $result;
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
            if( isset( $order->deliveryinfo->rider)) 
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
    public function getAllDeliveryZone(Request $request){
        $zones = Db::table('deliveryzone')->where('is_active',1)->get()->toArray();
        $tablenos = Db::table('tableno')->where('is_active',1)->get()->toArray();
        $arr = [];
        $tableno = [];
        foreach ($zones as $key => $zone) {
            $arr[] = [
                'id' => $zone->zoneid,
                'zonename' => $zone->zonename
            ];
        }
        foreach ($tablenos as $key => $table) {
            $table_no[] = [
                'tableid' => $table->tableid,
                'tablename' => $table->tablename
            ];
        }
        if(count($zones) > 0){
            $statuscode = 200;
            $msg = 'All Delivery Zones';
            $status = "success";
            return response()->json([
                'status'      => $status,
                'message'     => $msg,
                'zones'       => $arr,
                'tableno'     => $table_no
            ]);
        }else{
            $msg = 'Delivery Zone Not Found!';
            $statuscode = 404;
            $data = '';
            return $this->respondWithError($msg,$data,$statuscode);
        }
    }

    public function getBill(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'kitchenid'             => 'required',
            'member_id'             => 'required',
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
            $kitchenId   = json_decode($request->input('kitchenid'));
            $memberId    = $request->input('member_id');

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
            ->whereIn('order.kitchenid',$kitchenId)
            ->where('order.member_id',$memberId)
            ->where('order.orderstatus',5)
            ->where('order.paymentstatus','<',1)
            ->leftJoin('deliveryinfo','order.orderid','=','deliveryinfo.orderid')
            ->with(['orderitem.foodinfo','deliveryzone','tableno'])
            ->orderBy('order.created_at', 'desc')
            ->get();
            $data = array();
            $totalAmount = 0;
            $totalDue = 0;
            $totalPaid = 0;
            foreach ($allOrderDetail as $order) 
            {
                $orderDetail = $order->toArray();
                $orderDetail['member'] = $order->member;
                
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
                $totalAmount += $orderDetail['totalamount'];
            }
            $billDetails = array(
                'totalamount'  => $totalAmount,
                'totaldue'  => $totalDue,
                'totalpaid'  => $totalPaid
            );
            if ( count($allOrderDetail) > 0 ) 
            {
                $msg= "Billing Details";
            }
            else
            {
                $msg = "No Data Found!";
            }
            $statuscode = 200;

            $status = "success";
            return response()->json([
                'status'      => $status,
                'message'     => $msg,
                'data'        => $data,
                'billDetails' => $billDetails
            ]); 
        }
    }
    public function billClose(Request $request){
        $rules = array(
            'order_ids'             => 'required',
            'member_id'             => 'required',
            'totalbill'             => 'required',
            'userid'                => 'required',
            'paymentmethod'         => 'required',
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
        }else{
            try {
                DB::beginTransaction();
                $orderIds       = json_decode($request->input('order_ids'));
                $memberId       = $request->input('member_id');
                $totalBill      = $request->input('totalbill');
                $userid         = $request->input('userid');
                $paymentMethod  = $request->input('paymentmethod');

                if(count($orderIds) > 0){
                    $billData = [
                        'totalbill' => $totalBill,
                        'order_ids' => json_encode($orderIds),
                        'member_id' => $memberId,
                        'totalpaid' => $totalBill,
                        'currentpaid' => $totalBill,
                        'paymentmethod' => $paymentMethod,
                        'totaldue' => 0,
                        'status'   => 1,  // 1 means paid, 0 means not paid
                        'created_by' =>  $userid
                    ];

                    $bill = Bill::create($billData);
                    DB::commit();
                    if($bill){

                      foreach($orderIds as $orderId){
                        $bill_item_Data = [
                            'bill_id' => $bill->bill_id,
                            'orderid' => $orderId,
                            'created_by' =>  $userid,
                            'updated_by' =>  $userid
                        ];
                        BillItem::insert($bill_item_Data);
                    }  


                    Order::whereIn('orderid',$orderIds)->update([
                        'paymentstatus' => 1, // 1 means paid , 0 means not paid
                        'paymentmethod' => $paymentMethod
                    ]);

                    $msg = 'Payment Done Successfully!';
                    $statuscode = 200;
                    $data = '';
                    return $this->respondWithSuccess($msg,$data,$statuscode);
                }else{
                    $msg = 'Something went wrong!';
                    $statuscode = 404;
                    $data = '';
                    return $this->respondWithSuccess($msg,$data,$statuscode);
                }
            }
        }catch (\Exception $ex){
            DB::rollBack();
            $msg = 'Something went wrong!';
            $statuscode = 404;
            $data = '';
            return $this->respondWithError($msg,$data,$statuscode);
        }  
    }
}

public function billHistory(Request $request){

    $rules = array(
        'userid'                => 'required',
        'member_id'             => 'required'
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
    }else{

        try{
            $msg        = 'Billing History!';
            $statuscode = 200;
            $bills      = Bill::where('bill.member_id',$request->input('member_id'))
            ->with(['billitem','billitem.order.waiter','billitem.order.deliveryzone','member','billitem.orderitem','billitem.orderitem.foodinfo'])
            ->get();
            $data       = $bills;
            return $this->respondWithSuccess($msg,$data,$statuscode);
        }catch (\Exception $ex){
            $msg = 'Something went wrong!';
            $statuscode = 404;
            $data = '';
            return $this->respondWithError($msg,$data,$statuscode);
        }
    }
}
}
