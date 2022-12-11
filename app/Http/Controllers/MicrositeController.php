<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Category;
use App\Models\Foodgroup;
use App\Models\Food;
use Session;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Orderlog;
use App\Models\Orderitemaddon;

use App\Models\CustomerAddress;

use App\Http\Requests\OrderRequest;

use App\Models\Customerinfo;
use App\Models\TempOrder;
use App\Models\Branch;

use Ramsey\Uuid\Uuid;

class MicrositeController extends Controller
{
	public function index()
	{
		date_default_timezone_set("Asia/Dhaka");
		$currentdatetime =  date("Y-m-d h:i A"); 

		$today = date("l");


		$allDeliveryzone = getAllDeliveryzone();
		return view('Frontend.Microsite.index',compact('allDeliveryzone','currentdatetime','today'));
		
	}
	public function latlngwisebranch(Request $req)
	{
		$lat = $req->get('lat');
		$lng = $req->get('lng');
		$branchinfo = DB::select("
			SELECT b.branchid , b.branchname,
			( 6371 * ACOS( COS( RADIANS(b.latitude) ) 
        * COS( RADIANS( $lat ) ) 
        * COS( RADIANS( $lng ) 
			- RADIANS(b.longitude) ) 
			+ SIN( RADIANS(b.latitude) ) 
        * SIN( RADIANS( $lat ) ) 
			)
			) AS distance
			FROM branch b WHERE b.is_active = 1 having distance <=2 limit 1
			");
		return json_encode($branchinfo);

		
	}
	public function branchwisemenu(Request $req)
	{
		Session::put('MyBranchID',$req->get('branchid'));
		Session::put('MyZoneID',$req->get('locationid'));
		if(Session::has('MyZoneID'))
		{
			$zone = DB::table('deliveryzone')->where('zoneid',Session::get('MyZoneID'))->first();
			Session::put('MyZoneName',$zone->zonename);
		}

		$allCategoryData = Category::where('branchid',Session::get('MyBranchID'))
		->Active()->Withoutaddon()->get();
		
		return view('Frontend.Microsite.food',compact('allCategoryData'));
	}
	
	public function previewcart(Request $request)
	{
		$bid = $request->branchid;
		return view('Frontend.Microsite.previeworder',compact('bid'));
	}
	public function billingdetails(Request $request)
	{
		// $allOrderInput = json_decode($request->input('orderdata'));
		$orderTotal = $request->input('ordertotal');
		$orderSubTotal = $request->input('ordersubtotal');
		$deliverycharge = $request->input('deliverycharge');
		return view('Frontend.Microsite.billingaddress',compact('orderTotal','orderSubTotal','deliverycharge'));
	}
	public function customerorderinfo(Request $request)
	{
		$allOrderInput = json_decode($request->input('orderdata'));

		$orderTotal = $request->input('ordertotal');
		$orderSubTotal = $request->input('ordersubtotal');
		$deliverycharge = $request->input('deliverycharge');

		$customerCheck = Customerinfo::where('contactno',$request->input('contactno'))->first();
		if (count($customerCheck) > 0 ) 
		{
			$customerid = $customerCheck->customerid;
		}
		else
		{
			$customerData = array(
				"name"       => $request->input('name'),
				"contactno"  => $request->input('contactno'),
				"address"    => $request->input('address'),
				"email"      => $request->input('email')
			);

			$customerInfo = Customerinfo::firstOrCreate($customerData);
			$customerid = $customerInfo->customerid;


			$cAddress = new CustomerAddress();
			$cAddress->customerid = $customerInfo->customerid;
			$cAddress->address = $request->input('address');
			$cAddress->save();

		}

		Customerinfo::where('customerid', $customerid)->update(array(
			'address'    => $request->input('address'),
			'name'       => $request->input('name'),
			'email'      => $request->input('email')
		));

		$branch = Session::get('MyBranchID');
		$branchinfo = DB::table('branch')->where('branchid',$branch)->first();
		$branchname = $branchinfo->branchname;

		session()->put('bkash_customerid',$customerid);
		$orderNumber = date("ymd")."".rand(10000,99999);
		$temporderdata = new TempOrder();
		$temporderdata->temporderUUID = (string) Uuid::uuid4();
		$temporderdata->customerid = $customerid;
		$temporderdata->shippingaddress = $request->input('address');
		$temporderdata->specialinstruction = $request->input('specialinstruction');
		$temporderdata->ordernumber = $orderNumber;
		$temporderdata->branchid = $branch;
		$temporderdata->orderdata = $request->input('orderdata');
		$temporderdata->ordersubtotal = $orderSubTotal;
		$temporderdata->ordertotal = $orderTotal;
		$temporderdata->orderfrom = 1; // from Microsite
		$temporderdata->deliverycharge = $deliverycharge;
		if($temporderdata->save())
		{
			$tempdata = DB::table('temp_orders')->where('orderNumber',$temporderdata->ordernumber)->first();
			$temporderid = $tempdata->temporderUUID;
			$ordernumber = $temporderdata->ordernumber;
			$created_at = date_format($temporderdata->created_at,"Y-m-d H:i:s A");

			return view('Frontend.Microsite.credential',compact('orderTotal','temporderid','ordernumber','created_at','branchname'));
		}

		
	}



	/*
	* After successfull payment place order
	*
	* @param $temporderid
	*/
	public function placeOrder($temporderid)
	{
		$tempdata = DB::table('temp_orders')->where('temporderUUID',$temporderid)->first();
		$ordernumber = $tempdata->ordernumber;
		$branchid = $tempdata->branchid;
		$customerdata = DB::table('customerinfo')->where('customerid',$tempdata->customerid)->first();
		$allOrderInput = json_decode($tempdata->orderdata);

		if($tempdata->paymentstatus == 1)
		{
			$orderData = array(
				'ordernumber'           => $tempdata->ordernumber,
				'customerid'            => $tempdata->customerid,
				'branchid'              => $branchid,
				'locationid'            => Session::get('MyZoneID'),
				'orderstatus'           => 1,
                'paymentstatus'         => 1, // paid
                'orderfrom'             => $tempdata->orderfrom,
                'shippingaddress'       => $tempdata->shippingaddress,
                'specialinstruction'    => $tempdata->specialinstruction,
                'paymentmethod'         => 3, // bKash 
                'amount'                => $tempdata->ordersubtotal,
                'deliverycharge'        => $tempdata->deliverycharge,
                'totalamount'           => $tempdata->ordertotal
            );
			$orderInfo = Order::create($orderData);

			$orderLogData = array(
				'orderid'               => $orderInfo->orderid,
				'customerid'            => $tempdata->customerid,
				'orderstatus'           => 1,
				"created_by"            => 2
			);
			$orderLog = Orderlog::insert($orderLogData);

			foreach ($allOrderInput as $orderInput) 
			{   
				$orderitemData = array(
					'orderid'    => $orderInfo->orderid,
					'foodid'     => $orderInput->id,
					'quantity'   => $orderInput->quantity,
					'price'      => $orderInput->price,
					'discount'   => 0,
					'totalprice' => $orderInput->totalprice,
					"created_by" => 2
				);              
				$orderitemInfo = Orderitem::create($orderitemData);

				foreach ($orderInput->topping as $topping) 
				{
					$orderitemaddonData = array(
						'orderid'       => $orderInfo->orderid,
						'orderitemid'   => $orderitemInfo->orderitemid,
						'foodid'        => $orderInput->id,
						'addonid'       => $topping->addonid,
						'quantity'      => $topping->toppingqty,
						'price'         => $topping->price,
						"created_by"    => 2
					);              
					$orderitemaddonInfo = Orderitemaddon::create($orderitemaddonData);
				}
			}

			$userList = DB::select("SELECT ui.userid,gcmid FROM userinfo AS ui
				INNER JOIN user_branch_map AS ubm
				ON ubm.userid = ui.userid
				WHERE ubm.branchid = ".$branchid." 
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
			
			TempOrder::where('temporderUUID', $temporderid)->update(array(
				'paymentstatus'    => 2
				
			));

			$branchinfo = DB::table('branch')->where('branchid',$branchid)->first();
			$branchname = $branchinfo->branchname;

			$created_at = $tempdata->created_at;
			$total = $tempdata->ordertotal;

			$sms = "Your order has been confirmed.\n";
			$sms .= "Order No: $ordernumber\n";
			$sms .= "Outlet: $branchname\n";
			$sms .= "Date Time: $created_at\n";  
			$sms .= "Call: 16606\n";
			$sms .= "Burger King Bangladesh.";
			$mobile_no = $customerdata->contactno;
			$userid = $customerdata->customerid;

			$smsSend = \SMSSend::send($userid,$mobile_no,$sms,2);

			$pushNotification = \PushNotification::sendGCM($gcmIDS,$message);

			return $orderInfo->orderid;
		}
	}

	public function placeOrderWeb($temporderid)
	{
		$tempdata = DB::table('temp_orders')->where('temporderUUID',$temporderid)->first();
		$ordernumber = $tempdata->ordernumber;
		$branchid = $tempdata->branchid;
		$customerdata = DB::table('customerinfo')->where('customerid',$tempdata->customerid)->first();
		$allOrderInput = json_decode($tempdata->orderdata);

		if($tempdata->paymentstatus == 1)
		{
			$orderData = array(
				'ordernumber'           => $tempdata->ordernumber,
				'customerid'            => $tempdata->customerid,
				'branchid'              => $branchid,
				'locationid'            => Session::get('MyZoneID'),
				'orderstatus'           => 1,
                'paymentstatus'         => 1, // paid
                'orderfrom'             => $tempdata->orderfrom,
                'shippingaddress'       => $tempdata->shippingaddress,
                'specialinstruction'    => $tempdata->specialinstruction,
                'paymentmethod'         => 3, // bKash 
                'amount'                => $tempdata->ordersubtotal,
                'deliverycharge'        => $tempdata->deliverycharge,
                'totalamount'           => $tempdata->ordertotal+$tempdata->discountamount,
                'discountamount'        => $tempdata->discountamount
            );
			$orderInfo = Order::create($orderData);

			$orderLogData = array(
				'orderid'               => $orderInfo->orderid,
				'customerid'            => $tempdata->customerid,
				'orderstatus'           => 1,
				"created_by"            => 2
			);
			$orderLog = Orderlog::insert($orderLogData);

			foreach ($allOrderInput as $orderInput) 
			{   
				$orderitemData = array(
					'orderid'    => $orderInfo->orderid,
					'foodid'     => $orderInput->id,
					'quantity'   => $orderInput->quantity,
					'price'      => $orderInput->price,
					'discount'   => 0,
					'totalprice' => $orderInput->totalprice,
					"created_by" => 2
				);              
				$orderitemInfo = Orderitem::create($orderitemData);

				foreach ($orderInput->topping as $topping) 
				{
					$orderitemaddonData = array(
						'orderid'       => $orderInfo->orderid,
						'orderitemid'   => $orderitemInfo->orderitemid,
						'foodid'        => $orderInput->id,
						'addonid'       => $topping->addonid,
						'quantity'      => $topping->toppingqty,
						'price'         => $topping->price,
						"created_by"    => 2
					);              
					$orderitemaddonInfo = Orderitemaddon::create($orderitemaddonData);
				}
			}

			$userList = DB::select("SELECT ui.userid,gcmid FROM userinfo AS ui
				INNER JOIN user_branch_map AS ubm
				ON ubm.userid = ui.userid
				WHERE ubm.branchid = ".$branchid." 
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
			
			TempOrder::where('temporderUUID', $temporderid)->update(array(
				'paymentstatus'    => 2
				
			));

			$branchinfo = DB::table('branch')->where('branchid',$branchid)->first();
			$branchname = $branchinfo->branchname;

			$created_at = $tempdata->created_at;
			$total = $tempdata->ordertotal;

			$sms = "Your order has been confirmed.\n";
			$sms .= "Order No: $ordernumber\n";
			$sms .= "Outlet: $branchname\n";
			$sms .= "Date Time: $created_at\n";  
			$sms .= "Call: 16606\n";
			$sms .= "Burger King Bangladesh.";
			$mobile_no = $customerdata->contactno;
			$userid = $customerdata->customerid;

			$smsSend = \SMSSend::send($userid,$mobile_no,$sms,2);

			$pushNotification = \PushNotification::sendGCM($gcmIDS,$message);

			return $orderInfo->orderid;
		}
	}

	public function paymentsuccess($temporderid)
	{
		
		$tempdata = DB::table('temp_orders')->where('temporderUUID',$temporderid)->first();
		$ordernumber = $tempdata->ordernumber;
		$branchid = $tempdata->branchid;
		
		if($tempdata->paymentstatus == 2)
		{
			$branchinfo = DB::table('branch')->where('branchid',$branchid)->first();
			$branchname = $branchinfo->branchname;
			$created_at = $tempdata->created_at;
			$total = $tempdata->ordertotal;

			return view('Frontend.Microsite.paymentsuccess',compact('ordernumber','branchname','created_at','total'));
		}

	}
	public function paymentcancel()
	{
		return view('Frontend.Microsite.paymentcancel');
	}

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
			$orderDetail['customer']['name'] = $order->customer['name'];
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

	/* New System implementation for placing order in microsite */

	public function locationwisebranch(Request $req)
	{
		$branch = DB::table('branch_deliveryzone_map')
		->join('branchopenclosetime','branch_deliveryzone_map.branchid','=','branchopenclosetime.branchid')
		->join('branch','branchopenclosetime.branchid','=','branch.branchid')
		->where('zoneid',$req->locationid)->first();
		return json_encode($branch);
	}

	public function searchMicrositeFood(Request $request)
	{
		$branchID = $request->branchid;
		$searchString = $request->searchString;
		$categoryid = $request->categoryid;
		$fullHtml = "";
		
		// $allCategoryData = Category::where('branchid',$branchID)
		// ->where('categoryid',$categoryid)
		// ->Active()->Withoutaddon()->get();

		if($categoryid != '')
		{
			$allCategoryData = Category::where('branchid',$branchID)
			->where('categoryid',$categoryid)
			->Active()->Withoutaddon()->get();
		}
		else
		{
			$allCategoryData = Category::where('branchid',$branchID)
			->Active()->Withoutaddon()->get();
		}

		foreach($allCategoryData as $Category)
		{
			$fullHtml .= "<div class='col-md-12 col-sm-12 col-xs-12 productBoxCenter' 
			style='padding-left: 0px; padding-right: 0px'>";

			$testfoodgroup = DB::table('foodgroup')
			->where('categoryid',$Category->categoryid)
			->get();

			foreach ($testfoodgroup as $foodgroup) 
			{
				$fullHtml .= "<div class='col-sm-12 col-md-12 col-xs-12'>  </div>";

				$testfood = Food::where('foodname', 'like', '%' . $searchString . '%')
				// ->join('food_channel_maps','food.foodid','=','food_channel_maps.foodid')
				->where('status',1)
				// ->where('foodchannelid',2)
				->where('foodgroupid',$foodgroup->foodgroupid)
				->get();


				foreach ($testfood as $food)
				{
					if ( $food->thumbnail ) {
						$imageURL = asset('upload/menu/thumbnail_images/'.$food->thumbnail);
					}else{
						$imageURL = 'https://www.placehold.it/80x60/EFEFEF/AAAAAA&amp;text=no+image' ;
					}
					$toppingInfo = array();
					foreach ($food->foodaddon as $addon ) 
					{
						if ($addon->activeaddonInfo ) 
						{
							$toppingInfo[] = $addon->activeaddonInfo;

						}
					}
					$fullHtml .= "<div class='col-md-12 col-sm-12 col-xs-12 pContainer' style='background-color: #ffefdb'>

					
					<div class='col-md-12 col-sm-12 col-xs-12'>
					<img src='".$imageURL."' class='img img-responsive center-block'>
					</div>
					
					<div class='col-md-9 col-sm-9 col-xs-5 pNameNdiscription' style='padding-left:0px;'>
					<h4 style='color:#4C4C4C;font-family:BlockBerth; text-transform: uppercase' class='pPRICE'>  ".$food->foodname."  </h4>
					<p>  ".$food->otherdetail."  </p>        
					</div>
					
					
					
					<div class='col-md-12 col-sm-12 col-xs-6 priceWrapper'>
					<h4 style='color:#4C4C4C;font-family:BlockBerth;
					text-align: right' class='pPRICE'> ".$food->price." <sup>BDT</sup>  </h4>
					</div>";

					if (count($toppingInfo) > 0) {
						$json_array = htmlspecialchars(json_encode($toppingInfo), ENT_QUOTES, 'UTF-8');
						$fullHtml .= "<div class='col-md-12 col-sm-12 col-xs-12 add2CartWrapper'>
						<input type='button' data-image='".$food->thumbnail."'  data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping-required='".$food->isaddonrequired."' data-mintopping='".$food->minaddon."' data-maxtopping='".$food->maxaddon."' data-topping='".$json_array."' id='ad2cart' name='ad2cart' class='btn add2Cart btn-add-topping' style='background-color: #ed7800; margin-top:-10px;
						float: right !important;color:white;margin-bottom:10px; font-family: BlockBerth' value='ADD TO CART' data-featherlight='#mylightbox204'> 
						</div>";
					}else{


						$fullHtml .= "<div class='col-md-12 col-sm-12 col-xs-12 add2CartWrapper'>
						<input type='button' data-image='".$food->thumbnail."' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-itemprice='".$food->price."' data-topping-required='".$food->isaddonrequired."' data-mintopping='".$food->minaddon."' data-maxtopping='".$food->maxaddon."' data-topping='".json_encode($toppingInfo)."' id='ad2cart' name='ad2cart' class='btn add2Cart btn-add-to-cart' style='background-color: #ed7800;float: right !important; color:white; margin-top:-10px;margin-bottom:10px;font-family: BlockBerth' value='ADD TO CART'> 
						</div>";

					}
					$fullHtml .= "</div></div>";
					$fullHtml .= "<div class='col-sm-12 col-md-12 col-xs-12'>
					<hr style='background-color:#98989; border-top: 2px solid #A1A1A1;' >
					</div>";
					$fullHtml .= "</div>";
				}
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
