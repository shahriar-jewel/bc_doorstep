<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Branch;
use App\Models\Deliveryzone;
use App\Models\BranchDeliveryzoneMap;

use App\Models\Category;
use App\Models\Foodgroup;
use App\Models\Food;

use App\Models\Customerinfo;

use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Orderitemaddon;
use App\Models\Orderlog;
use App\Models\DeliveryInfo;
use App\Models\BkashRefund;

use App\Models\CustomerAddress;

use App\Http\Requests\OrderRequest;

use DB;

use App\Http\Controllers\Api\Bkash\BkashController;
use App\Http\Controllers\Api\Bkash\BkashWebController;

class BkashRefundController extends Controller
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
    public function index()
    {

        // $allorder = Order::whereIn('orderfrom',[1,3])
        //                 // ->where('orderstatus','>',8)
        //                 // ->orderBy('created_at', 'DESC')
        //                 ->get()
        //                 ->toArray();
        // echo "<pre>";
        // print_r($allorder);dd();
        // $allDeliverystatus = getOrderStatus();
        return view('order_refund.index');
        // return view('order_refund.index',compact('allorder','allDeliverystatus'));
    }

    # AJAX for ALL order info 
    public function getOrderInfo(Request $request)
    {
        $allorderStatus = getOrderStatus();
        $allorderFromList = getOrderFromList();
        $allBranch = getBranchesByUserType();
        $allPaymentStatus = $this->getAllPaymentStatus();

        $columns = array(
            0   => "slno" ,
            1   => "ordernumber" ,
            2   => "orderdate" ,
            3   => "orderfrom" ,
            4   => "branchname" ,
            5   => "customername" ,
            6   => "customermobile" ,
            7   => "totalprice" ,
            8   => "orderstatus" ,
            9   => "originaltrxid" ,
            10   => "refundtrxid" ,
            11  => "refunddate" ,
            12  => "bkashmobile" ,
            13  => "refundamount" ,
            14  => "paymentstatus" ,
            15  => "action" ,
        );

        $DBcolumns = array(
            0   => "orderid" ,
            1   => "ordernumber" ,
            2   => "order.created_at" ,
            3   => "orderfrom" ,
            4   => "branch.branchname" ,
            5   => "customerinfo.name" ,
            6   => "customerinfo.contactno" ,
            7   => "totalamount" ,
            8   => "orderstatus" ,
            9   => "bkash_refund.original_trxid" ,
            10   => "bkash_refund.refund_trxid" ,
            11  => "bkash_refund.refund_date" ,
            12  => "bkash_refund.bkash_mobile" ,
            13  => "bkash_refund.refund_amount" ,
            14  => "paymentstatus" ,
            15  => "orderid" ,
        );

        $totalData = Order::whereIn('order.branchid',$allBranch)->whereIn('orderfrom',[1,3])->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $DBcolumns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $allOrderInfo = Order::whereIn('order.branchid',$allBranch)
            ->whereIn('orderfrom',[1,3])
            ->join('branch', 'order.branchid', '=', 'branch.branchid')
            ->join('customerinfo', 'order.customerid', '=', 'customerinfo.customerid')
            ->leftjoin('bkash_refund', 'order.orderid', '=', 'bkash_refund.orderid')
            ->select('order.*','customerinfo.name as customername','customerinfo.contactno as customermobile','branch.branchname','bkash_refund.bkash_mobile','bkash_refund.refund_amount','bkash_refund.refund_date','bkash_refund.original_trxid','bkash_refund.refund_trxid')
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else 
        {
            $search = $request->input('search.value'); 
            $searchOrderStatus = 999 ;
            $searchPaymnetStatus = 999 ;
            foreach ($allorderStatus as $key => $value) 
            {
                if (strtolower($search) == strtolower($value)) 
                {
                    $searchOrderStatus = $key; 
                    break;
                }
            }

            foreach ($allPaymentStatus as $key => $value) 
            {
                if (strtolower($search) == strtolower($value)) 
                {
                    $searchPaymnetStatus = $key; 
                    break;
                }
            }

            $allOrderInfo = Order::whereIn('order.branchid',$allBranch)
            ->whereIn('orderfrom',[1,3])
            ->join('branch', 'order.branchid', '=', 'branch.branchid')
            ->join('customerinfo', 'order.customerid', '=', 'customerinfo.customerid')
            ->leftjoin('bkash_refund', 'order.orderid', '=', 'bkash_refund.orderid')
            ->select('order.*','customerinfo.name as customername','customerinfo.contactno as customermobile','branch.branchname','bkash_refund.bkash_mobile','bkash_refund.refund_amount','bkash_refund.refund_date','bkash_refund.original_trxid','bkash_refund.refund_trxid')
            ->where(function ($query) use ($search,$searchOrderStatus,$searchPaymnetStatus) {
                $query->where('order.ordernumber',$search)
                ->orWhere('order.orderstatus', $searchOrderStatus)
                ->orWhere('order.paymentstatus', $searchPaymnetStatus)
                ->orWhere('order.totalamount', $search)
                ->orWhere('bkash_refund.bkash_mobile', $search)
                ->orWhere('bkash_refund.refund_amount', $search)
                ->orWhere('bkash_refund.original_trxid', $search)
                ->orWhere('bkash_refund.refund_trxid', $search)
                ->orWhere('customerinfo.contactno', $search)
                ->orWhere('customerinfo.name', 'LIKE',"%{$search}%")
                ->orWhere('branch.branchname', 'LIKE',"%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Order::whereIn('order.branchid',$allBranch)
            ->whereIn('orderfrom',[1,3])
            ->join('branch', 'order.branchid', '=', 'branch.branchid')
            ->join('customerinfo', 'order.customerid', '=', 'customerinfo.customerid')
            ->leftjoin('bkash_refund', 'order.orderid', '=', 'bkash_refund.orderid')
            ->select('order.*','customerinfo.name as customername','branch.branchname' )
            ->where(function ($query) use ($search,$searchOrderStatus,$searchPaymnetStatus) {
                $query->where('order.ordernumber',$search)
                ->orWhere('order.orderstatus', $searchOrderStatus)
                ->orWhere('order.paymentstatus', $searchPaymnetStatus)
                ->orWhere('order.totalamount', $search)
                ->orWhere('bkash_refund.bkash_mobile', $search)
                ->orWhere('bkash_refund.refund_amount', $search)
                ->orWhere('bkash_refund.original_trxid', $search)
                ->orWhere('bkash_refund.refund_trxid', $search)
                ->orWhere('customerinfo.contactno', $search)
                ->orWhere('customerinfo.name', 'LIKE',"%{$search}%")
                ->orWhere('branch.branchname', 'LIKE',"%{$search}%");
            })
            ->count();
        }
        $data = array();

        if(!empty($allOrderInfo))
        {
            foreach ($allOrderInfo as $orderInfo)
            {
                $viewUrl            = route('order-refund.show',$orderInfo->ordernumber);
                $deleteUrl          = url('deleteorder',$orderInfo->ordernumber);
                $editUrl          = url('editorder',$orderInfo->ordernumber);
                $refundUrl          = route('order-refund.show',$orderInfo->ordernumber);

                $nestedData['slno']             = ++$start ;
                $nestedData['ordernumber']      = $orderInfo->ordernumber;
                $nestedData['orderfrom']        = $allorderFromList[$orderInfo->orderfrom];
                $nestedData['customername']     = $orderInfo->customername;
                $nestedData['customermobile']   = $orderInfo->customermobile;
                $nestedData['bkashmobile']      = $orderInfo->bkash_mobile;
                $nestedData['branchname']       = $orderInfo->branchname;
                $nestedData['totalprice']       = "৳ ".sprintf('%0.2f' ,$orderInfo->totalamount);
                $nestedData['orderdate']        = date('j M Y h:i a',strtotime($orderInfo->created_at));
                $nestedData['refundamount']     = "৳ ".sprintf('%0.2f' ,$orderInfo->refund_amount);
                $nestedData['refunddate']       = is_null($orderInfo->refund_date) ? '' : date('j M Y h:i a',strtotime($orderInfo->refund_date));
                $nestedData['originaltrxid']    = $orderInfo->original_trxid;
                $nestedData['refundtrxid']      = $orderInfo->refund_trxid;
                $nestedData['orderstatus']      = $allorderStatus[$orderInfo->orderstatus];
                $nestedData['paymentstatus']    = $allPaymentStatus[$orderInfo->paymentstatus];
                // $nestedData['action']           = "&emsp;<a href='{$viewUrl}' class='btn btn-circle btn-xs blue'><i class='fa fa-eye'></i> View </a>"
                if($orderInfo->paymentstatus == 1)
                    $nestedData['action']           = "&emsp;<a href='{$refundUrl}' class='btn btn-circle btn-xs blue'><i class='fa fa-eye'></i> Refund </a>";
                else
                    $nestedData['action'] = "&emsp;<a href='{$refundUrl}' class='btn btn-circle btn-xs green'><i class='fa fa-eye'></i> Detail </a>";

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

    private function getAllPaymentStatus()
    {
        $paymentStatus = array(
            '0'     => 'Pending',
            '1'     => 'Paid',
            '2'     => 'Refunded',
            '3'     => 'Partialy Refunded',
        );

        return $paymentStatus ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allDeliveryzone = getAllDeliveryzone();
        return view('order.create',compact('allDeliveryzone'));
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
        // echo "<pre>";
        // var_dump($request->input('orderdata'));
        $allOrderInput = json_decode($request->input('orderdata')) ;

        // var_dump($allOrderInput );
        // dd($allOrderInput);

        $customerCheck = Customerinfo::where('contactno',$request->input('cuscontactno'))->first();
        if (count($customerCheck) > 0 ) 
        {
            $customerCheck->address=$request->input('address');
            $customerCheck->save();
            $customerInfo = $customerCheck;
        }
        else
        {
            $customerData = array(
                "name"       => $request->input('cusname'),
                "contactno"  => $request->input('cuscontactno'),
                "address"    => $request->input('address'),
                "created_by" => $this->_profileID
            );

            $customerInfo = Customerinfo::firstOrCreate($customerData);

            $cAddress = new CustomerAddress();
            $cAddress->customerid = $customerInfo->customerid;
            $cAddress->address = $request->input('address');
            $cAddress->created_by = $this->_profileID;
            $cAddress->save();

        }

        if(!empty($request->input('customerphone')) && $request->input('address_type') == 'N')
        {
            $cAddress = new CustomerAddress();
            $cAddress->customerid = $request->input('customerid');
            $cAddress->address = $request->input('address');
            $cAddress->created_by = $this->_profileID;
            $cAddress->save();
        }


        if (count($customerInfo) > 0 ) 
        {
            $orderNumber = date("ymd")."".rand(10000,99999);
            $orderModel = new Order;

            $orderData = array(
                'ordernumber'           => $orderNumber,
                'customerid'            => $customerInfo->customerid,
                'branchid'              => $request->input('branch'),
                'locationid'            => $request->input('location'),
                'orderstatus'           => 1,
                'orderfrom'             => 2, // doorstep
                'shippingaddress'       => $request->input('address'),
                'paymentmethod'         => $request->input('paymentmethod'), 
                'amount'                => $request->input('ordersubtotal'),
                'deliverycharge'        => $request->input('orderdlfee'),
                'discount'              => $request->input('discount'),
                'totalamount'           => $request->input('ordertotal'),
                'specialinstruction'    => $request->input('specialinstruction'),
                "created_by"            => $this->_profileID
            );
            $orderInfo = Order::create($orderData);

            $orderLogData = array(
                'orderid'               => $orderInfo->orderid,
                'customerid'            => $customerInfo->customerid,
                'orderstatus'           => 1,
                "created_by"            => $this->_profileID
            );
            $orderLog = Orderlog::insert($orderLogData);

            foreach ($allOrderInput as $orderInput) 
            {   
                $orderitemData = array(
                    'orderid'    => $orderInfo->orderid,
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
                        'orderid'       => $orderInfo->orderid,
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

            $userList = DB::select("SELECT ui.userid,gcmid FROM userinfo AS ui
                INNER JOIN user_branch_map AS ubm
                ON ubm.userid = ui.userid
                WHERE ubm.branchid = ".$request->input('branch')." 
                AND ui.usertype = 2");
            $gcmIDS = array();
            foreach ($userList as $user) 
            {
                $gcmIDS[] = $user->gcmid ; 
            }
            $body = array(
                'status'    => 'success',
                'message'   => 'New Order Placed',
                'data'      => $this->_getOrderDetail($orderInfo->orderid)
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


    /**
     * Get the Specific Order details.
     *
     * @param  int  $orderID
     * @return array
     */
    private function _getOrderDetail($orderID)
    {
        $allOrderDetail = Order::where('orderid',$orderID)
        ->with(['orderitem.foodinfo','orderitem.orderitemaddon.addonInfo' ])
        ->get();

        $data = array();
        foreach ($allOrderDetail as $order) 
        {
            $orderDetail = $order->toArray();
            $orderDetail['customer'] = $order->customer;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderDetail = Order::where('ordernumber',$id)
        ->with(['orderitem.foodinfo','orderitem.orderitemaddon.addonInfo','orderlog','bkashrefund','paymentinfo' ])
        ->first();
        // dd($orderDetail);                         
        $allDeliverystatus = getOrderStatus();
        $allUserType = getUserType();
        $allPaymentStatus = $this->getAllPaymentStatus();
        $deliveryInfo = DeliveryInfo::where('orderid',$orderDetail->orderid)->first();
        // dd($deliveryInfo);
        $customeraddress = DB::table('customer_addresses')->where('customerid',$orderDetail->customerid)->get();

        return view('order_refund.viewdetail',compact('orderDetail','allDeliverystatus','allPaymentStatus','allUserType','deliveryInfo','customeraddress'));
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

    /**
     * initiate refund request
     * 
     * @param Request $request
     */
    public function refundRequest(Request $request)
    {
        /**
        * validation rules
        */
        $rules = array(
            'order_number'      => 'required',
            'refund_amount'     => 'required',
            'refund_reason'     => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
            $errors = $validator->messages()->toArray();
            $msg = "Validation Error!" ;
            $data = [
                'errorCode'        => "402",
                'errorMessage'     => "Missing Required Field"
            ];
            
            $result = json_encode($data);

            // return $data;
            session()->flash('message', 'Missing Required Field!');
            session()->flash('class', '2');
            return redirect()->route('order-refund.index');
        }
        else
        {
            // dd($request->all());
            $orderNumber = $request->input('order_number');
            $amount = $request->input('refund_amount');
            $reason = $request->input('refund_reason');

            $orderDetail = Order::where('ordernumber',$orderNumber)->first();
            if ($orderDetail) {
                $orderID = $orderDetail->orderid;
            }
            else{
                session()->flash('message', 'Order number not found!');
                session()->flash('class', '2');
                return redirect()->route('order-refund.index');
            }
            if ($orderDetail->orderfrom == 1)
                $refund = new BkashController;
            else
                $refund = new BkashWebController;
            $result = $refund->refundPayment($orderID,$amount,$reason);
            if (isset($result['transactionStatus']) && $result['transactionStatus'] == 'Completed') 
            {
                $orderDetail->paymentstatus = 2;
                $orderDetail->save();

                $searchResult = $refund->searchTransaction($result['originalTrxID']);
                $searchResultArray = json_decode($searchResult,true);

                $bkashrefundData = array(
                    'orderid'               => $orderDetail->orderid,
                    'customerid'            => $orderDetail->customerid,
                    'bkash_mobile'          => isset($searchResultArray['customerMsisdn'])?$searchResultArray['customerMsisdn']:null,
                    "refund_amount"         => $result['amount'],
                    "refund_date"           => date('Y-m-d H:i:s'),
                    "original_trxid"        => $result['originalTrxID'],
                    "refund_trxid"          => $result['refundTrxID'],
                    "created_by"            => $this->_profileID
                );
                BkashRefund::insert($bkashrefundData);

                // $orderLogData = array(
                //     'orderid'               => $orderDetail->orderid,
                //     'customerid'            => $orderDetail->customerid,
                //     'orderstatus'           => 1,
                //     "created_by"            => $this->_profileID
                // );
                // $orderLog = Orderlog::insert($orderLogData);

                session()->flash('message', 'Refund request successfully initiated');
                session()->flash('class', '1');
                return redirect()->route('order-refund.index');
            }
            elseif (isset($result['errorMessage'])) {
                session()->flash('message', $result['errorMessage'] );
                session()->flash('class', '2');
                return redirect()->route('order-refund.index');
            }
        }
    }


    public function getBranchByLocation(Request $request)
    {
        $zoneID = $request->input('loc_id');


        $allBranchData = BranchDeliveryzoneMap::select('branch.branchid','branch.branchname')
        ->join('branch', 'branch_deliveryzone_map.branchid', '=', 'branch.branchid')
        ->where('zoneid',$zoneID)
        ->get();



        $allBranch = array();
        foreach ($allBranchData as $branch)
        {
            $allBranch[] = array(
                'branchid'      => $branch->branchid,
                'branchname'    => $branch->branchname,
                // 'branchtype'    => $branch->branchtype
            );    
        }

        if( count($allBranch) > 0 ) {
            $msg = "success";
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg' => $msg,
            'data' => $allBranch
        ];
        return json_encode($data);
    }

    public function getFoodMenuByBranch(Request $request)
    {
        $branchID = $request->input('branch_id');
        $categoryID = $request->input('category_id');
        $fullHtml = "";
        $allCategoryData = Category::where('branchid',$branchID)
        ->where('categoryid',$categoryID)
        ->Active()->Withoutaddon()->get();
        foreach ($allCategoryData as $Category) 
        {
            if (count($Category->activefoodgroups) > 0) {
                $fullHtml .= "<div id='catid-".$Category->categoryid."' > <h3 class='categoryTitle' >".$Category->name."</h3>";
            }
            foreach ($Category->activefoodgroups as $foodgroup) 
            {
                $fullHtml .= "<div class='row menuItem'>
                <div class='topmenuItemSection col-md-12'>
                <h4 class='title'>".$foodgroup->foodgroupname."</h4>
                <p>".$foodgroup->otherdetail."</p>
                </div>";

                foreach ($foodgroup->activefoods as $food) 
                {
                    if ( $food->thumbnail ) {
                        $imageURL = asset('/upload/menu/thumbnail_images/'.$food->thumbnail);
                    }else{
                        $imageURL = 'http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image' ;
                    }
                    $toppingInfo = array();
                    foreach ($food->foodaddon as $addon ) 
                    {
                        if ($addon->activeaddonInfo ) 
                        {
                            $toppingInfo[] = $addon->activeaddonInfo;
                        }
                    }
                    $fullHtml .=    "<div class='itemSection col-md-12' id='".$food->foodid."'>
                    <div class='col-md-2 col-sm-2 col-xs-2 itemImage' >
                    <img src='".$imageURL."' alt='preview' id='preview-image' />
                    </div>
                    <div class='col-md-8 col-sm-8 col-xs-8' style='padding-top:6px;'>
                    <div class='col-md-4 col-sm-12 col-xs-12'>
                    <strong data-toggle='popover' data-trigger='hover' title='Detail' data-content='".$food->otherdetail."'>".$food->foodname."</strong>
                    </div>
                    <div class='col-md-2 col-sm-12 col-xs-12'><strong>1:1</strong></div>
                    <div class='col-md-3 col-sm-12 col-xs-12'><strong>".$food->price." Tk</strong></div>
                    </div>

                    <div class='col-md-2 col-sm-2 col-xs-2' align='right'>
                    ";
                    if (count($toppingInfo) > 0) {
                        $json_array = htmlspecialchars(json_encode($toppingInfo), ENT_QUOTES, 'UTF-8');
                        $fullHtml .="<a class='btn btn-sm red btn-add-topping' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping-required='".$food->isaddonrequired."' data-mintopping='".$food->minaddon."' data-maxtopping='".$food->maxaddon."' data-topping='".$json_array."' data-toggle='modal' href='#basic' >Add</a>" ;
                    }else{
                        $fullHtml .="<button type='button' class='btn btn-sm red btn-add-to-cart' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping='".json_encode($toppingInfo)."'>Add</button>" ;
                    }

                    $fullHtml .=    "    </div>
                    </div>";

                }

                $fullHtml .= "</div>";
            }
            
            $fullHtml .= "</div>";
        }

        $deliveryfee = "0.00 Tk";
        $discount = "0.00 Tk";

        if( $fullHtml != "" ) {
            $msg = "success";
            $branchInfo = Branch::find($branchID);
            $deliveryfee = $branchInfo->deliveryfee;
            $discount = $branchInfo->discount;
        } else {
            $msg = "nodata";
        }
        $data = [
            'msg'       => $msg,
            'data'      => $fullHtml,
            'delfee'    => $deliveryfee,
            'discount'  => $discount,
        ];
        return json_encode($data);

    }

    // public function customeraddresses(Request $req)
    // {
    //     $Addresses = DB::table("customer_addresses")->where("customerid",$req->CustomerID)->get();
    //     return json_encode($Addresses);
    // }
   

    // public function editcustomer(Request $req)
    // {
    //     $customerdata = DB::table('order')
    //     ->where('ordernumber',$req->ordernumber)
    //     ->Join('customerinfo','order.customerid','=','customerinfo.customerid')
    //     ->first();
    //     // return view('order.editcustomer',compact('customerdata'));
    //     return json_encode($customerdata);
    // }


public function brachwisecategory(Request $req)
{
    $categories = DB::table('category')->where('branchid',$req->BranchID)->get();
    return json_encode($categories);
}
public function searchfood(Request $request)
{

    $searchString = $request->input('search_string');
    $branchID = $request->input('branch_id');
    $categoryID = $request->input('category_id');
    $fullHtml = "";
    $allCategoryData = Category::where('branchid',$branchID)
    ->where('categoryid',$categoryID)
        // ->where('name', 'like', '%' . $searchString . '%')
    ->Active()->Withoutaddon()->get();
    foreach ($allCategoryData as $Category) 
    {
        if (count($Category->activefoodgroups) > 0) {
            $fullHtml .= "<div id='catid-".$Category->categoryid."' > <h3 class='categoryTitle' >".$Category->name."</h3>";
        }

        $testfoodgroup = DB::table('foodgroup')
        ->where('categoryid',$Category->categoryid)
        ->get();

        foreach ($testfoodgroup as $foodgroup) 
        {
            $fullHtml .= "<div class='row menuItem'>
            <div class='topmenuItemSection col-md-12'>
            <h4 class='title'>".$foodgroup->foodgroupname."</h4>
            <p>".$foodgroup->otherdetail."</p>
            </div>";

            $testfood = DB::table('food')
            ->where('foodname', 'like', '%' . $searchString . '%')
            ->where('foodgroupid',$foodgroup->foodgroupid)
            ->get();

            foreach ($testfood as $food) 
            {

                if ( $food->thumbnail ) {
                    $imageURL = asset('/upload/menu/thumbnail_images/'.$food->thumbnail);
                }else{
                    $imageURL = 'http://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image' ;
                }


                $toppingInfo = array();

                $testaddon = DB::table('food_addon_map')
                ->where('foodid',$food->foodid)
                ->get();


                foreach ($testaddon as $addon ) 
                {

                    if ($addon->activeaddonInfo ) 
                    {
                        $toppingInfo[] = $addon->activeaddonInfo;
                    }
                }


                $fullHtml .=    "<div class='itemSection col-md-12' id='".$food->foodid."'>
                <div class='col-md-2 col-sm-2 col-xs-2 itemImage' >
                <img src='".$imageURL."' alt='preview' id='preview-image' />
                </div>
                <div class='col-md-8 col-sm-8 col-xs-8' style='padding-top:6px;'>
                <div class='col-md-4 col-sm-12 col-xs-12'>
                <strong data-toggle='popover' data-trigger='hover' title='Detail' data-content='".$food->otherdetail."'>".$food->foodname."</strong>
                </div>
                <div class='col-md-2 col-sm-12 col-xs-12'><strong>1:1</strong></div>
                <div class='col-md-3 col-sm-12 col-xs-12'><strong>".$food->price." Tk</strong></div>
                </div>

                <div class='col-md-2 col-sm-2 col-xs-2' align='right'>
                ";


                if (count($toppingInfo) > 0) {
                    $json_array = htmlspecialchars(json_encode($toppingInfo), ENT_QUOTES, 'UTF-8');
                    $fullHtml .="<a class='btn btn-sm red btn-add-topping' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping-required='".$food->isaddonrequired."' data-mintopping='".$food->minaddon."' data-maxtopping='".$food->maxaddon."' data-topping='".$json_array."' data-toggle='modal' href='#basic' >Add</a>" ;
                }else{
                    $fullHtml .="<button type='button' class='btn btn-sm red btn-add-to-cart' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping='".json_encode($toppingInfo)."'>Add</button>" ;
                }

                $fullHtml .=    "    </div>
                </div>";

            }

            $fullHtml .= "</div>";
        }

        $fullHtml .= "</div>";
    }

    $deliveryfee = "0.00 Tk";
    $discount = "0.00 Tk";

    if( $fullHtml != "" ) {
        $msg = "success";
        $branchInfo = Branch::find($branchID);
        $deliveryfee = $branchInfo->deliveryfee;
        $discount = $branchInfo->discount;
    } else {
        $msg = "nodata";
    }
    $data = [
        'msg'       => $msg,
        'data'      => $fullHtml,
        'delfee'    => $deliveryfee,
        'discount'  => $discount,
    ];
    return json_encode($data);
}




}
