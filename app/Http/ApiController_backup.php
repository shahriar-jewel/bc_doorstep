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


    public function appsLogin(Request $request)
    {   
        // $userName       = $request->input('username');
        // $userPassword   = $request->input('password');
        // $userInfo       = array();

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
                $msg = 'Session expired!' ;
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

        // $outputJson = [
        //     'status'    => $status ,
        //     'message'   => $msg ,
        //     $objName    => $data ,
        // ];

        // return json_encode($outputJson);


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

    public function respondWithError($message,$data,$statuscode)
    {   
        $status = "failed";
        return Response::json([
            'status'    => $status,
            'message'   => $message,
            'error'     => $data
        ],$statuscode); 
    }

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

    private function _checkPassword($inputPass,$user)
    {
        if(Hash::check($inputPass, $user->password )){
            return true;
        }else{
            return false;
        }
    }

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Ajax function for get the branches according to restaurant.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getbranch(Request $request)
    {
        // return $request;
        $restaurantid = $request->input('res_id');
        $branches = getBranches($restaurantid);

        if( count($branches) > 0 ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg' => $msg,
            'data' => $branches
        ];
        return json_encode($data);
    }

    public function test(){
        return "DOne ";
    }

    public function orderDetail(Request $request)
    {
        /**
        * validation rules
        */
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

            $allOrderDetail = Order::where('branchid',$branchid)
                                    ->with(['orderitem.foodinfo','orderitem.orderitemaddon.addonInfo'])
                                    ->whereBetween('created_at', array($from, $to))
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            $data = array();
            foreach ($allOrderDetail as $order) 
            {
                $orderDetail = $order->toArray();
                $orderDetail['customer'] = $order->customer;
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


    public function orderAcceptDeny(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'orderid'              => 'required',
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
            $orderStatus    = $request->input('orderstatus');
            $userID         = $request->input('userid');

            $updateData = array(
                'orderstatus'   => $orderStatus,
                'updated_by'    => $userID
            );

            $updateinfo = Order::where('orderid',$orderID)->update($updateData);

            $statuscode = 200;
            $data = array();
            if ($updateinfo) 
            {
                $logData = array(
                    'orderid'       => $orderID,
                    'orderstatus'   => $orderStatus,
                    'shortnote'     => $request->has('shortnote') ? $request->input('shortnote') : NULL ,
                    'created_by'    => $userID
                );
                Orderlog::insert($logData);

                $msg = "Updated Successfully !" ; 
                return $this->respondWithSuccess($msg,$data,$statuscode);
            }
            else
            {
                $msg = "Something went wrong ! Can not accept or deny !" ; 
                $data = [
                    'error_code'    => "405",
                    'error_msg'     => "Order not found!"
                ];
                return $this->respondWithError($msg,$data,$statuscode);
            }

        }

    }


    public function menuList(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'branchid'              => 'required',
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

            $allCategory = Category::select()->where('branchid',$branchid)->with('foodgroups.foods')->get();

            $allMenuList = array();

            foreach ($allCategory as $Category ) 
            {
                $foodgroupData = array();
                $exist = false;
                foreach ($Category->foodgroups as $foodgroup ) 
                {
                    $foodData = array();
                    $hasFood = false;
                    foreach ($foodgroup->foods as $food ) 
                    {
                        $exist = true; 
                        $hasFood = true;  // set to true if atleast one food item found within the foodgroup 

                        $foodData[] = array(
                            'foodId'        => $food->foodid,
                            'foodName'      => $food->foodname,
                            'foodDetail'    => $food->otherdetail,
                            'foodPrice'     => sprintf( '%0.2f',$food->price),
                            'foodPicture'   => asset('').'upload/menu/thumbnail_images/'.$food->thumbnail,
                            'foodStatus'    => $food->status,
                        );
                    }
                    if ($hasFood) 
                    {
                        $foodgroupData[] = array(
                            'foodgroupId'       => $foodgroup->foodgroupid,
                            'foodgroupName'     => $foodgroup->foodgroupname,
                            'foodgroupDetail'   => $foodgroup->otherdetail,
                            'foods'             => $foodData
                        );
                    }
                }
                

                $categoryData = array(
                        'categoryId'        => $Category->categoryid,
                        'categoryName'      => $Category->name,
                        'categoryDetail'    => $Category->otherdetail,
                        'categoryType'      => $Category->categorytype,
                        'categoryStatus'    => $Category->is_active,
                        'foodgroups'        => $foodgroupData
                );

                if ( $exist ) 
                {
                    $allMenuList [] = $categoryData ;
                }
            }

            if (count($allMenuList) > 0 ) 
            {
                $msg = "All Menu List " ;
            }
            else
            {
                $msg = "No Data Found !" ;

            }

            return $this->respondWithSuccess($msg,$allMenuList,200);

        }
    }


    public function changeFoodstatus(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'foodid'             => 'required',
            'foodstatus'         => 'required'
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
            $foodID        = $request->input('foodid');
            $foodStatus    = $request->input('foodstatus');
            $userID        = $request->input('userid');

            $updateData = array(
                'status'        => $foodStatus,
                'updated_by'    => $userID
            );

            $updateinfo = Food::where('foodid',$foodID)->update($updateData);

            $statuscode = 200;
            $data = array();
            if ($updateinfo) 
            {
                $msg = "Updated Successfully !" ; 
                return $this->respondWithSuccess($msg,$data,$statuscode);
            }
            else
            {
                $msg = "Something went wrong ! Can not accept or deny !" ; 
                $data = [
                    'error_code'    => "405",
                    'error_msg'     => "Food not found!"
                ];
                return $this->respondWithError($msg,$data,$statuscode);
            }

        }

    }



    public function getRiderinfo(Request $request)
    {

        // $assignTime  = strtotime('2017-02-15 12:45:00');
        //         $currentTime = time();
        //         $subTime = $currentTime - $assignTime;
        //         $y = ($subTime/(60*60*24*365));
        //         $d = ($subTime/(60*60*24))%365;
        //         $h = ($subTime/(60*60))%24;
        //         $m = ($subTime/60)%60;

        //         echo $subTime."<br>".$y."<br>".$d."<br>".$h."<br>".$m."<br>";

        // dd();
        /**
        * validation rules
        */
        $rules = array(
            'branchid'             => 'required',
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
            $branchID = $request->get('branchid');

            $allriderinfo = DB::select(
                                "SELECT DISTINCT u.userid AS riderid,u.fullname,u.contactno, u.email , u.usertype,
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
                                    AND d.returntime IS NULL 
                                    ) AS available ,
                                    (
                                    SELECT COUNT(*) FROM deliveryinfo AS d
                                    WHERE d.riderid = u.userid
                                    AND d.deliverystatus = 1 
                                    ) AS jobcompleted
                                FROM userinfo AS u
                                INNER JOIN user_branch_map AS ubm
                                ON ubm.userid = u.userid
                                INNER JOIN branch AS b
                                ON b.branchid = ubm.branchid
                                INNER JOIN ridercurrentlocation AS rcl
                                ON rcl.riderid = u.userid
                                WHERE ubm.branchid = ".$branchID."
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


    public function assignRider(Request $request)
    {

        /**
        * validation rules
        */
        $rules = array(
            'orderid'          => 'required',
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
            $orderID = $request->get('orderid');
            $riderID = $request->get('riderid');

            $data = array(
                'orderid'       => $orderID,
                'riderid'       => $riderID,
                'orderstatus'   => 3,
                'assigntime'    => date("Y-m-d H:i:s") 
            );

            $updateInfo = DeliveryInfo::where('orderid',$orderID)->updateOrCreate($data);
            

            if (count($updateinfo) > 0 ) 
            {
                $msg="Rider Assigned Successfully !";
            }
            else
            {
                $msg="Can Not Assign Rider !"; 
            }

            return $this->respondWithSuccess($msg,array(),200);
        }
    }


    public function changeRider(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'orderid'          => 'required',
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
            $orderID = $request->get('orderid');
            $riderID = $request->get('riderid');

            $deliveryInfo = DeliveryInfo::where('orderid', $orderID )->first();

            if ( count( $deliveryInfo ) > 0 ) 
            {

                $assignTime  = strtotime('2013-07-03 18:00:00');
                $currentTime = time();
                $subTime = $assignTime - $currentTime;
                $y = ($subTime/(60*60*24*365));
                $d = ($subTime/(60*60*24))%365;
                $h = ($subTime/(60*60))%24;
                $m = ($subTime/60)%60;

                echo $y."<br>".$d."<br>".$h."<br>".$m."<br>";

                if ($deliveryInfo->assigntime ) 
                {
                    # code...
                }
            }

            $data = array(
                'orderid'       => $orderID,
                'riderid'       => $riderID,
                'orderstatus'   => 3,
                'assigntime'    => date("Y-m-d H:i:s") 
            );

            $updateInfo = DeliveryInfo::where('orderid',$orderID)->updateOrCreate($data);
            

            if (count($updateinfo) > 0 ) 
            {
                $msg="Rider Assigned Successfully !";
            }
            else
            {
                $msg="Can Not Assign Rider !"; 
            }

            return $this->respondWithSuccess($msg,array(),200);
        }
    }


    public function statements(Request $request)
    {
        /**
        * validation rules
        */
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

            $allOrderDetail = Order::where('branchid',$branchid)
                                    ->with(['orderitem.foodinfo','orderitem.orderitemaddon.addonInfo'])
                                    ->whereBetween('created_at', array($from, $to))
                                    ->orderBy('created_at', 'desc')
                                    ->get();
            $data = array();
            foreach ($allOrderDetail as $order) 
            {
                $orderDetail = $order->toArray();
                $orderDetail['customer'] = $order->customer;
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

}