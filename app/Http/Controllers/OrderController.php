<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Deliveryzone;
use App\Models\BranchDeliveryzoneMap;
use App\Models\Category;
use App\Models\Foodgroup;
use App\Models\Food;
use App\Models\Memberinfo;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Orderitemaddon;
use App\Models\Orderlog;
use App\Models\DeliveryInfo;
use App\Models\CustomerAddress;
use Carbon\Carbon;
use App\Http\Requests\OrderRequest;
use DB;
use App\Models\UserKitchenMap;

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

class OrderController extends Controller
{

    private $_profileID = 0 ;

    private function _setProfileInfo()
    {
        $this->_profileID = session()->get('doorstepuser.userid');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $allorder = Order::orderBy('created_at', 'desc')->get();
        $allDeliverystatus = getOrderStatus();
        return view('order.index',compact('allorder','allDeliverystatus'));
    }

    # AJAX for ALL order info 
    public function getOrderInfo(Request $request)
    {
        $allorderStatus = getOrderStatus();
        $allKitchen = getKitchensByUserType();
        $allorderFrom = array(
          '1' => 'Microsite',
          '2' => 'Doorstep',
          '3' => 'Website',
      );

        $columns = array(
            0   => "slno" ,
            1   => "ordernumber" ,
            2   => "customername" ,
            3   => "kitchenname" ,
            4   => "totalprice" ,
            5   => "orderdate" ,
            6   => "orderstatus" ,
            7   => "action" ,
        );

        $DBcolumns = array(
            0   => "orderid" ,
            1   => "ordernumber" ,
            2   => "memberinfo.name" ,
            3   => "kitchen.kitchenname" ,
            4   => "totalamount" ,
            5   => "order.created_at" ,
            6   => "orderstatus" ,
            
        );

        $totalData = Order::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $DBcolumns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $allOrderInfo = Order::leftJoin('memberinfo', 'order.member_id', '=', 'memberinfo.member_id')
            ->leftJoin('kitchen','order.kitchenid','kitchen.kitchenid')
            ->select('order.*','memberinfo.name as membername','kitchen.kitchenname')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else 
        {
            $search = $request->input('search.value'); 
            $searchOrderStatus = 999 ;
            foreach ($allorderStatus as $key => $value) 
            {
                if (strtolower($search) == strtolower($value)) 
                {
                    $searchOrderStatus = $key; 
                    break;
                }
            }


            $searchOrderFrom = 999 ;
            foreach ($allorderFrom as $key => $value) 
            {
                if (strtolower($search) == strtolower($value)) 
                {
                    $searchOrderFrom = $key; 
                    break;
                }
            }

            $allOrderInfo = Order::join('memberinfo', 'order.member_id', '=', 'memberinfo.member_id')
            ->select('order.*','memberinfo.name as membername')
            ->where(function ($query) use ($search,$searchOrderStatus,$searchOrderFrom) {
                $query->where('order.orderstatus', $searchOrderStatus)
                ->orWhere('order.orderfrom', $searchOrderFrom)
                ->orWhere('order.totalamount', $search)
                ->orWhere('memberinfo.name', 'LIKE',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Order::join('memberinfo', 'order.member_id', '=', 'memberinfo.member_id')
            ->select('order.*','memberinfo.name as membername','kitchen.kitchenname' )
            ->where(function ($query) use ($search,$searchOrderStatus,$searchOrderFrom) {
                $query->where('order.orderstatus', $searchOrderStatus)
                ->orWhere('order.orderfrom', $searchOrderFrom)
                ->orWhere('order.totalamount', $search)
                ->orWhere('memberinfo.name', 'LIKE',"%{$search}%");
            })
            ->count();
        }
        $data = array();
        
        if(!empty($allOrderInfo))
        {
        foreach ($allOrderInfo as $orderInfo)
          {
                if($orderInfo->paymentmethod == 1)
                {
                  $paymentmethod = 'Cash';
              }
              else if($orderInfo->paymentmethod == 2)
              {
                  $paymentmethod = 'Card';
              }
              else if($orderInfo->paymentmethod == 3)
              {
                $paymentmethod = 'bKash';
            }

            $viewUrl            = route('order.show',$orderInfo->orderid);
            $deleteUrl          = url('deleteorder',$orderInfo->orderid);
            $editUrl          = url('editorder',$orderInfo->orderid);

            $nestedData['slno']             = ++$start ;
            $nestedData['orderid']          = $orderInfo->orderid;
            $nestedData['kitchenname']      = $orderInfo->kitchenname;
            $nestedData['orderfrom']        = $allorderFrom[$orderInfo->orderfrom];
            $nestedData['paymentmethod']    = $paymentmethod;
            $nestedData['membername']       = $orderInfo->membername;
            $nestedData['totalprice']       = "৳ ".sprintf('%0.2f' ,$orderInfo->totalamount);
            $nestedData['orderdate']        = date('j M Y h:i a',strtotime($orderInfo->created_at));
            $nestedData['orderstatus']      = $allorderStatus[$orderInfo->orderstatus];
            $nestedData['action']           = "&emsp;<a href='{$viewUrl}' class='btn btn-circle btn-xs blue'><i class='fa fa-eye'></i> View </a>
            ";

            $data[] = $nestedData;
        }
    }
    $json_data = array(
        "draw"            => intval($request->input('draw')),  
        "recordsTotal"    => intval($totalData),  
        "recordsFiltered" => intval($totalFiltered), 
        "data"            => $data   
    );

    echo json_encode($json_data); 
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allDeliveryzone = getAllDeliveryzone();
        $tables = DB::table('tableno')->where('is_active',1)->get()->toArray();
        return view('order.create',compact('allDeliveryzone','tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $this->_setProfileInfo();
        $allOrderInput = json_decode($request->input('orderdata')) ;

        $allkitchen_items = $this->group_by($allOrderInput,'kitchenid'); // kitchen wise food items
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
                'locationid'            => $request->input('zone'),
                'tableid'               => $request->input('tableid'),
                'kitchenid'             => $kitchenid,
                'orderstatus'           => 1,
                'orderfrom'             => 2, // doorstep
                'amount'                => $total,
                'totalamount'           => $total,
                'shippingaddress'       => $request->input('zone'),
                'paymentmethod'         => $request->input('paymentmethod'), 
                'paymentstatus'         => 0, 
                'specialinstruction'    => $request->input('specialinstruction'),
                "created_by"            => $this->_profileID
            );
            $orderInfo = Order::create($orderData);
            $orderLogData = array(
                'orderid'               => $orderInfo->orderid,
                'kitchenid'             => $kitchenid,
                'orderstatus'           => 1,
                "created_by"            => $this->_profileID
            );
            $orderLog = Orderlog::insert($orderLogData);

            foreach ($kitchen_items as $key => $kitchen_item) {
             $orderitemData = array(
                'orderid'    => $orderInfo->orderid,
                'ordernumber'=> $orderNumber,
                'foodid'     => $kitchen_item->id,
                'kitchenid'  => $kitchenid,
                'quantity'   => $kitchen_item->quantity,
                'price'      => $kitchen_item->price,
                'totalprice' => $kitchen_item->price * $kitchen_item->quantity,
                'remarks'    => 'Test',
                'itemstatus' => 0, // 0 for not delivered, 1 for delivered
                "created_by" => $this->_profileID
            );              
             $orderitemInfo = Orderitem::create($orderitemData);
            }

         $userList = DB::select("SELECT ui.userid,gcmid FROM userinfo AS ui
            INNER JOIN user_kitchen_map AS ubm
            ON ubm.userid = ui.userid
            WHERE ubm.kitchenid = ".$kitchenid." 
            AND ui.usertype = 2");

         // $orderSummary = DB::select("SELECT 
         //                            order.orderid,order.ordernumber, deliveryzone.zonename, tableno.tablename as 'tableno',
         //                            userinfo.fullname as 'waitername',memberinfo.name as 'membername',userinfo.usertype
         //                        FROM banani_club.order
         //                        INNER JOIN banani_club.deliveryzone ON order.locationid = deliveryzone.zoneid
         //                        INNER JOIN banani_club.tableno ON order.tableid = tableno.tableid
         //                        INNER JOIN banani_club.userinfo ON order.created_by = userinfo.userid
         //                        INNER JOIN banani_club.memberinfo ON order.member_id = memberinfo.member_id
         //                        WHERE order.orderid = '".$orderInfo->orderid."'
         //                        "
         //                    );

         // $summary['orderid'] = $orderSummary[0]->orderid;
         // $summary['ordernumber'] = $orderSummary[0]->ordernumber;
         // $summary['zonename'] = $orderSummary[0]->zonename;
         // $summary['tableno'] = $orderSummary[0]->tableno;
         // $summary['waitername'] = $orderSummary[0]->waitername;
         // $summary['membername'] = $orderSummary[0]->membername;
         // $summary['usertype'] = $orderSummary[0]->usertype;

         $orderSummary = Order::where('orderid',$orderInfo->orderid)
            ->with(['member','waiter'])
            ->get()->toArray();



         $gcmIDS = array();

         foreach ($userList as $user) 
         {
            $gcmIDS[] = $user->gcmid; 
         }

         // dd($this->_getOrderDetail($orderInfo->orderid));
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

    session()->flash('message', 'New Order Placed Successfully !');
    session()->flash('class', '1');
    return redirect()->route('order.index');
  }

    function group_by($data, $group_by) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value->$group_by][] = $value ;
        }
        return $result;
    }


    /**
     * Get the Specific Order details.
     *
     * @param  int  $orderID
     * @return array
     */
    private function _getOrderDetail($orderID)
    {
        $allOrderDetail = Order::where('orderid',$orderID)
            ->with(['orderitem.foodinfo','member','waiter'])
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderDetail = Order::where('orderid',$id)
        ->with(['orderitem.foodinfo','orderitem.orderitemaddon.addonInfo','orderlog','orderlog.kitchen' ])
        ->first();   

        $allDeliverystatus = getOrderStatus();
        $allUserType = getUserType();
        $deliveryInfo = DeliveryInfo::where('orderid',$orderDetail->orderid)->first();
        // dd($deliveryInfo);
        $customeraddress = DB::table('customer_addresses')->where('customerid',$orderDetail->customerid)->get();

        return view('order.viewdetail',compact('orderDetail','allDeliverystatus','allUserType','deliveryInfo','customeraddress'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    // public function getFoodMenuByBranch()
    // {
    //     // $branchID = $request->input('branch_id');
    //     $branchID = 1;


    //     // $allFoodMenuData = Foodgroup::where('branchid',$branchID)->get();

    //     // foreach ($allFoodMenuData as $menu) {
    //     //     print_r("FOOD GROUP :".$menu->foodgroupname);
    //     //     // print_r("<br>");
    //     //     print_r(" -----Number of item ".count($menu->foods));
    //     //     print_r("<br>");
    //     // }



    //     $allCategoryData = Category::where('branchid',$branchID)->get();
    //     $allData = array();
    //     foreach ($allCategoryData as $Category) {

    //         // print_r("Category Name :".$Category->name);
    //         // print_r(" -----Number of Foodgroup ".count($Category->foodgroups) );
    //         $foodgroupData = array();
    //         foreach ($Category->foodgroups as $foodgroup) 
    //         {
    //             // print_r(" -----Number of item ".count($foodgroup->foods));
    //             $foodData = array();
    //             foreach ($foodgroup->foods as $food) 
    //             {
    //                 $foodData[] = array(
    //                     'foodid'        => $food->foodid,
    //                     'foodname'      => $food->foodname,
    //                     'price'         => $food->price,
    //                     'thumbnail'     => $food->thumbnail,
    //                     'vat'           => $food->vat,
    //                     'quantity'      => $food->quantity,
    //                 );
    //             }

    //             $foodgroupData[] = array(
    //                 'foodgroupname' => $foodgroup->foodgroupname,
    //                 'fooddetail'    => $foodgroup->otherdetail,
    //                 'fooddata'      => $foodData,
    //             );
    //         }
    //         $categorywiseMenuList[] = array(
    //                 'categoryName'  => $Category->name ,
    //                 'foodgroupData' => $foodgroupData
    //             );
    //     }
    //     // print_r(json_encode($categorywiseMenuList) );



    //     foreach ($allCategoryData as $Category) 
    //     {

    //         $fullHtml = "<h3>".$Category->name."</h3>";
    //         foreach ($Category->foodgroups as $foodgroup) 
    //         {
    //             $fullHtml .= "<div class='row menuItem'>
    //                             <div class='topmenuItemSection col-md-12'>
    //                                 <h4 class='title'>".$foodgroup->foodgroupname."</h4>
    //                                 <p>".$foodgroup->otherdetail."</p>
    //                             </div>";

    //             foreach ($foodgroup->foods as $food) 
    //             {
    //                 $fullHtml .=    "<div class='subItemSection col-md-12' >
    //                                     <div class='col-md-2 col-sm-2 col-xs-2 subItemImage' >
    //                                         <img src='http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image' alt='preview' id='preview-image' />
    //                                     </div>
    //                                     <div class='col-md-4 col-sm-4 col-xs-4'><strong>".$food->foodname."</strong></div>
    //                                     <div class='col-md-2 col-sm-2 col-xs-2'><strong>1:1</strong></div>
    //                                     <div class='col-md-3 col-sm-3 col-xs-3'><strong>".$food->price." Tk</strong></div>
    //                                     <div class='col-md-1 col-sm-1 col-xs-1' align='right'>
    //                                         <button type='button' class='btn btn-sm red'>Add</button>
    //                                     </div>
    //                                 </div>";

    //             }

    //              $fullHtml .= "</div>";

    //         }

    //     }

    //     return json_encode($fullHtml);

    // }


    public function getFoodMenuByBranch(Request $request)
    {
        $categoryID = $request->input('category_id');
        $fullHtml = "";
        $allCategoryData = Category::where('categoryid',$categoryID)
        ->Active()->get();

        foreach ($allCategoryData as $Category) 
        {
            if (count($Category->activefoodgroups) > 0) {
                $fullHtml .= "<div id='catid-".$Category->categoryid."' > <h3 class='categoryTitle' >".$Category->name."</h3>";
            }else{
                $fullHtml .= "<div id=''> <h3 class='categoryTitle' >No Food Found!</h3>";
            }
            foreach ($Category->activefoodgroups as $foodgroup) 
            {
                $fullHtml .= "<div class='row menuItem'>
                <div class='topmenuItemSection col-md-12'>
                <h4 class='title'>".$foodgroup->foodgroupname."</h4>
                <p>".$foodgroup->otherdetail."</p>
                </div>";

                $foods = Food::where('status',1)
                ->where('foodgroupid',$foodgroup->foodgroupid)
                ->get();

                if (count($foods) == 0){
                    $fullHtml .= "<div> <h4 class='categoryTitle' >No Food Found!</h4></div>";
                }

                foreach ($foods as $food) 
                {
                    if ( $food->thumbnail ) {
                        $imageURL = asset('/upload/menu/thumbnail_images/'.$food->thumbnail);
                    }else{
                        $imageURL = asset('/imageFolder/no_image.jpg') ;
                    }

                    $fullHtml .= "<div class='itemSection col-md-12' id='".$food->foodid."'>
                    <div class='col-md-2 col-sm-2 col-xs-2 itemImage' >
                    <img src='".$imageURL."' alt='preview' id='preview-image' />
                    </div>
                    <div class='col-md-8 col-sm-8 col-xs-8' style='padding-top:6px;'>
                    <div class='col-md-4 col-sm-12 col-xs-12'>
                    <strong data-toggle='popover' data-trigger='hover' title='Detail' data-content='".$food->otherdetail."'>".$food->foodname."</strong></div>
                    <div class='col-md-2 col-sm-12 col-xs-12'><strong>1:1</strong></div>
                    <div class='col-md-3 col-sm-12 col-xs-12'><strong>".$food->price." Tk</strong></div>
                    </div><div class='col-md-2 col-sm-2 col-xs-2' align='right'>";
                    $fullHtml .="<button type='button' class='btn btn-sm red btn-add-to-cart' data-foodgroupid='".$foodgroup->foodgroupid."' data-kitchenid='".$food->kitchenid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."'>Add</button>";
                    $fullHtml .= "</div>
                    </div>";
                }
                $fullHtml .= "</div>";
            }
            $fullHtml .= "</div>";
        }
        if( $fullHtml != "" ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg'       => $msg,
            'data'      => $fullHtml,
        ];
        return json_encode($data);
    }

    public function searchCustomer(Request $request)
    {
        // dd($request->all());
        $contactNo = $request->input('q');
        // dd($contactNo);

        // $contactNo = $request->input('term');

        $allCusInfo = Customerinfo::where('contactno','like', $contactNo.'%')->get();
        $info = array();
        foreach ($allCusInfo as $cusInfo) 
        {
            $info[] = array(
                'id'    => $cusInfo->customerid,
                'text'  => $cusInfo->name.'-'.$cusInfo->contactno,
                'name'  => $cusInfo->name,
                'mobile' => $cusInfo->contactno,
                'address' => $cusInfo->address
            );
        }
        $data["items"] =  $info;
        
        return json_encode($data);
    }

    public function searchMemberByID(Request $request)
    {
        $id = strtoupper($request->input('member_id'));
        $memberData = DB::table('memberinfo')->where('member_id',$id)->first();
        $memberInfo = array();
        if( count($memberData) > 0 ) 
        {
            $imgURL             = url('upload/member_images/'.$memberData->image);
            $msg = "success";
            $memberInfo = array(
                'member_id'  => $memberData->member_id,
                'name'       => $memberData->name,
                'mobile'     => $memberData->contactno,
                'image'      => $imgURL
            );
        } 
        else 
        {
            $msg = "nodata";
        }

        $data = [
            'msg' => $msg,
            'data' => $memberInfo
        ];
        return json_encode($data);
    }
    public function printinvoice($orderid)
    {
        $orderDetail = Order::where('orderid',$orderid)
        ->with(['orderitem.foodinfo','orderitem.orderitemaddon.addonInfo'])
        ->first();
        // dd($orderDetail);                         
        $allDeliverystatus = getOrderStatus();
        $allUserType = getUserType();
        $deliveryInfo = DeliveryInfo::where('orderid',$orderDetail->orderid)->first();
        // dd($deliveryInfo);
        $customeraddress = DB::table('customer_addresses')->where('customerid',$orderDetail->customerid)->get();

        return view('order.invoice',compact('orderDetail','allDeliverystatus','allUserType','deliveryInfo','customeraddress'));

    }
    public function print_copy($orderid)
    {
       $orderDetail = Order::where('orderid',$orderid)
       ->with(['orderitem.foodinfo','orderitem.orderitemaddon.addonInfo'])
       ->first();

       $branchinfo = Branch::where('branchid',$orderDetail['branchid'])->first();
       $branchname = $branchinfo->branchname;
       $branchaddress = $branchinfo->address;
       $branchphone = $branchinfo->contactno;
        // dd($orderDetail);                         
       $allDeliverystatus = getOrderStatus();
       $allUserType = getUserType();
       $deliveryInfo = DeliveryInfo::where('orderid',$orderDetail->orderid)->first();
        // dd($deliveryInfo);
       $customeraddress = DB::table('customer_addresses')->where('customerid',$orderDetail->customerid)->get();

       return view('order.printcopy',compact('orderDetail','allDeliverystatus','allUserType','deliveryInfo','customeraddress','branchname','branchaddress','branchphone'));
   }
   public function deleteorder($ordernumber)
   {
       echo 'jewelll';
   }

   public function editcustomer(Request $req)
   {
     $customerdata = DB::table('order')
     ->where('ordernumber',$req->ordernumber)
     ->Join('customerinfo','order.customerid','=','customerinfo.customerid')
     ->first();
        // return view('order.editcustomer',compact('customerdata'));
     return json_encode($customerdata);
 }
 public function updateordercustomer(Request $req , $customerid)
 {
     Customerinfo::where('customerid', $customerid)->update(array(
        'name'    =>  $req->name,
        'contactno' =>  $req->phone,
        'gender' =>  $req->gender,
        'email' =>  $req->email
    ));

     session()->flash('message', 'Customer Updated Successfully !');
     session()->flash('class', '1');
     return back();
 }
 public function editbillingaddress(Request $req)
 {
    $billingaddress = DB::table('order')->where('ordernumber',$req->ordernumber)->first();
    return json_encode($billingaddress);
}
public function updatebillingaddress(Request $req, $ordernumber)
{
    Order::where('ordernumber', $ordernumber)->update(array(
        'shippingaddress'    =>  $req->billingaddress
    ));
    session()->flash('message', 'Billing Address Updated Successfully !');
    session()->flash('class', '1');
    return back();
}
public function editpayment(Request $req)
{
    $paymentmethod = DB::table('order')->where('ordernumber',$req->ordernumber)->first();
    return json_encode($paymentmethod);
}
public function updatepayment(Request $req , $ordernumber)
{
    Order::where('ordernumber', $ordernumber)->update(array(
        'paymentmethod'    =>  $req->paymentmethod
    ));
    session()->flash('message', 'Payment Method Updated Successfully !');
    session()->flash('class', '1');
    return back();
}
public function editfood($customerid,$ordernumber)
{
    $allDeliveryzone = getAllDeliveryzone();
    $customerinfo = DB::table('customerinfo')->where('customerid',$customerid)->first();
    // $orderData = DB::table('order')->where('ordernumber',$ordernumber)->first();

    $orderData = DB::table('order')
    ->join('branch','order.branchid','branch.branchid')
    ->join('deliveryzone','order.locationid','deliveryzone.zoneid')
    ->where('ordernumber',$ordernumber)->first();

// $orderData = DB::select("
//    SELECT * from order
//    WHERE ordernumber = ".$ordernumber."
//     ");


    return view('order.editfood',compact('allDeliveryzone','customerinfo','orderData'));
}
public function updateorder(OrderRequest $request)
{
    $allOrderInput = json_decode($request->input('orderdata'));
    // dd($allOrderInput);
    // echo $request->cuscontactno;
    // echo $request->customerid;
    // echo $request->myorderno;

    $row = DB::table('order')->where('orderid',$request->orderid)->first();
    $finalamount = $row->amount + $request->input('ordersubtotal');
    $finaltotalamount = $finalamount + $row->deliverycharge - $row->discount;


    Order::where('orderid', $request->orderid)->update(array(
        'amount'         => $finalamount,
        'totalamount'    => $finaltotalamount
    ));

    Orderlog::where('orderid', $request->orderid)->update(array(
        'orderid'    =>  $request->orderid
    ));

    foreach ($allOrderInput as $orderInput) 
    {   
        $orderitemData = array(
            'orderid'    => $request->orderid,
            'foodid'     => $orderInput->id,
            'quantity'   => $orderInput->quantity,
            'price'      => $orderInput->price,
            'totalprice' => $orderInput->totalprice,
            "created_by" => $this->_profileID
        );              
        $orderitemInfo = Orderitem::create($orderitemData);

                // dd($orderitemInfo->orderitemid);
        foreach ($orderInput->topping as $topping) 
        {
            $orderitemaddonData = array(
                'orderid'       => $request->orderid,
                'orderitemid'   => $orderitemInfo->orderitemid,
                'foodid'        => $orderInput->id,
                'addonid'       => $topping->addonid,
                'quantity'      => $topping->toppingqty,
                'price'         => $topping->price,
                "created_by"    => $this->_profileID
            );              
            $orderitemaddonInfo = Orderitemaddon::create($orderitemaddonData);
        }
    }

    // DB::table('order')->where('orderid',$request->orderid)->delete();
    // DB::table('orderitem')->where('orderid',$request->orderid)->delete();
    // DB::table('orderitemaddon')->where('orderid',$request->orderid)->delete();

    session()->flash('message', 'Order Updated Successfully !');
    session()->flash('class', '1');
    return redirect()->route('order.index');
}
public function removeitem($orderitemid)
{
    $row = DB::table('orderitem')->where('orderitemid',$orderitemid)->first();
    $quantity = $row->quantity;
    $totalprice = $row->totalprice;
    $amount = $quantity * $totalprice;

    $orderdata = DB::table('order')->where('orderid',$row->orderid)->first();

    $finalamount = $orderdata->amount - $amount;
    $finaltotalamount = $orderdata->totalamount - $amount;

    Order::where('orderid', $row->orderid)->update(array(
        'amount'    =>  $finalamount,
        'totalamount' => $finaltotalamount
    ));


    DB::table('orderitem')->where('orderitemid',$orderitemid)->delete();
    DB::table('orderitemaddon')->where('orderitemid',$orderitemid)->delete();

    session()->flash('message', 'Item removed Successfully !');
    session()->flash('class', '1');
    return redirect()->back();
}
public function allCategoryAjax(Request $req)
{
    $categories = DB::table('category')->where('is_active',1)->get();
    return json_encode($categories);
}
// public function searchfood(Request $request)
// {

//     $searchString = $request->input('search_string');
//     $branchID = $request->input('branch_id');
//     $categoryID = $request->input('category_id');
//     $fullHtml = "";
//     $allCategoryData = Category::where('branchid',$branchID)
//     ->where('categoryid',$categoryID)
//         // ->where('name', 'like', '%' . $searchString . '%')
//     ->Active()->Withoutaddon()->get();
//     foreach ($allCategoryData as $Category) 
//     {
//         if (count($Category->activefoodgroups) > 0) {
//             $fullHtml .= "<div id='catid-".$Category->categoryid."' > <h3 class='categoryTitle' >".$Category->name."</h3>";
//         }

//         $testfoodgroup = DB::table('foodgroup')
//         ->where('categoryid',$Category->categoryid)
//         ->get();

//         foreach ($testfoodgroup as $foodgroup) 
//         {
//             $fullHtml .= "<div class='row menuItem'>
//             <div class='topmenuItemSection col-md-12'>
//             <h4 class='title'>".$foodgroup->foodgroupname."</h4>
//             <p>".$foodgroup->otherdetail."</p>
//             </div>";

//             $testfood = DB::table('food')
//             ->where('foodname', 'like', '%' . $searchString . '%')
//             ->where('foodgroupid',$foodgroup->foodgroupid)
//             ->get();

//             foreach ($testfood as $food) 
//             {

//                 if ( $food->thumbnail ) {
//                     $imageURL = asset('/upload/menu/thumbnail_images/'.$food->thumbnail);
//                 }else{
//                     $imageURL = 'http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image' ;
//                 }


//                 $toppingInfo = array();

//                 $testaddon = DB::table('food_addon_map')
//                 ->where('foodid',$food->foodid)
//                 ->get();


//                 foreach ($testaddon as $addon ) 
//                 {

//                     if ($addon->activeaddonInfo ) 
//                     {
//                         $toppingInfo[] = $addon->activeaddonInfo;
//                     }
//                 }


//                 $fullHtml .=    "<div class='itemSection col-md-12' id='".$food->foodid."'>
//                 <div class='col-md-2 col-sm-2 col-xs-2 itemImage' >
//                 <img src='".$imageURL."' alt='preview' id='preview-image' />
//                 </div>
//                 <div class='col-md-8 col-sm-8 col-xs-8' style='padding-top:6px;'>
//                 <div class='col-md-4 col-sm-12 col-xs-12'>
//                 <strong data-toggle='popover' data-trigger='hover' title='Detail' data-content='".$food->otherdetail."'>".$food->foodname."</strong>
//                 </div>
//                 <div class='col-md-2 col-sm-12 col-xs-12'><strong>1:1</strong></div>
//                 <div class='col-md-3 col-sm-12 col-xs-12'><strong>".$food->price." Tk</strong></div>
//                 </div>

//                 <div class='col-md-2 col-sm-2 col-xs-2' align='right'>
//                 ";


//                 if (count($toppingInfo) > 0) {
//                     $json_array = htmlspecialchars(json_encode($toppingInfo), ENT_QUOTES, 'UTF-8');
//                     $fullHtml .="<a class='btn btn-sm red btn-add-topping' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping-required='".$food->isaddonrequired."' data-mintopping='".$food->minaddon."' data-maxtopping='".$food->maxaddon."' data-topping='".$json_array."' data-toggle='modal' href='#basic' >Add</a>" ;
//                 }else{
//                     $fullHtml .="<button type='button' class='btn btn-sm red btn-add-to-cart' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping='".json_encode($toppingInfo)."'>Add</button>" ;
//                 }

//                 $fullHtml .=    "    </div>
//                 </div>";

//             }

//             $fullHtml .= "</div>";
//         }

//         $fullHtml .= "</div>";
//     }

//     $deliveryfee = "0.00 Tk";
//     $discount = "0.00 Tk";

//     if( $fullHtml != "" ) {
//         $msg = "success";
//         $branchInfo = Branch::find($branchID);
//         $deliveryfee = $branchInfo->deliveryfee;
//         $discount = $branchInfo->discount;
//     } else {
//         $msg = "nodata";
//     }
//     $data = [
//         'msg'       => $msg,
//         'data'      => $fullHtml,
//         'delfee'    => $deliveryfee,
//         'discount'  => $discount,
//     ];
//     return json_encode($data);
// }

public function orderstatuscancel(Request $req)
{
    $this->_setProfileInfo();
    DB::table('order')->where('ordernumber',$req->ordernumber)->update(array(
       'orderstatus' => '10'
   ));

    $orderdata = DB::table('order')->where('ordernumber',$req->ordernumber)->first();
    $orderLogData = array(
        'orderid'               => $orderdata->orderid,
        'customerid'            => $orderdata->customerid,
        'orderstatus'           => 10,
        "created_by"            => $this->_profileID
    );
    $orderLog = Orderlog::insert($orderLogData);

    $deliveryInfo = DeliveryInfo::where('orderid',$orderdata->orderid)->first();

    $userList = DB::select("SELECT ui.userid,gcmid FROM userinfo AS ui
        INNER JOIN user_branch_map AS ubm
        ON ubm.userid = ui.userid
        WHERE ubm.branchid = ".$orderdata->branchid." 
        AND ui.usertype = 2 OR ui.userid = ".$deliveryInfo->riderid."");

    $gcmIDS = array();
    foreach ($userList as $user) 
    {
        $gcmIDS[] = $user->gcmid; 
    }
    $body = array(
        'status'    => 'success',
        'message'   => 'Order Cancelled',
        'data'      => $this->_getOrderDetail($orderdata->orderid)
    );
    $message = array(
        'title'     => 'Order Cancelled',
        'body'      => $body, 
        'usertype'  => 'branchagent',
        'tag'       => 'order_cancelled'
    );

    $pushNotification = \PushNotification::sendGCM($gcmIDS,$message);

    return json_encode('ok');
}
  public function liveMonitor(Request $request){
    $userID = session()->get('doorstepuser.userid') ;
    $userType = session()->get('doorstepuser.usertype') ;
    
    if($userType == 2){
        $kitchenData = UserKitchenMap::where('userid',$userID)
                                            ->get()
                                            ->toArray();
        $kitchenid = $kitchenData[0]['kitchenid'];
    }else{
        $kitchenid = 'null';
    }
    
    return view('order.livemonitor',compact('kitchenid'));
  }

  function groupByCategory($data, $group_by) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value['orderitem'][0]['food']['category'][$group_by]][] = $value ;
        }
        return $result;
    }

    public function groupByKitchen($data, $group_by){
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value[$group_by]][] = $value ;
        }
        return $result;
    }

  public function ajaxLiveMonitor(Request $request){
    $today  = Carbon::now()->toDateTimeString();
    $from   = date('Y-m-d' . ' 00:00:00', strtotime($today) ); 
    $to     = date('Y-m-d' . ' 23:59:59', strtotime($today) );
    $allOrderDetail = Order::with(['orderitem.foodinfo','member','waiter','orderitem.food.category'])
                           ->where('order.orderstatus','>=',2)
                           ->where('order.orderstatus','<>',5)
                           ->whereBetween('order.created_at', array($from, $to))
                           ->orderBy('order.created_at', 'desc')
                           ->get()
                           ->toArray();
    // $ordersByCategory = $this->groupByCategory($allOrderDetail,'categoryid');
    $groupByKitchen = $this->groupByKitchen($allOrderDetail,'kitchenid');
    return json_encode($groupByKitchen);
  }
}
