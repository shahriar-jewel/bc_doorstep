<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Category;
use Session;
use App\Models\Foodgroup;
use App\Models\Food;
use App\Models\Branch;
use App\Models\Customerinfo;
use App\Models\CustomerAddress;
use App\Models\TempOrder;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Orderlog;
use App\Models\Orderitemaddon;
use App\Models\Deliveryzone;

class OnlineOrderController extends Controller
{
	public function landingPage(Request $req)
	{
		// Session::forget('bkash_customerid');
		// return view('Website.layouts.index');
		return redirect()->route('login');
	}
	public function index(Request $req)
	{
		Session::forget('bkash_customerid');
		date_default_timezone_set("Asia/Dhaka");
		$currentdatetime =  date("Y-m-d h:i A"); 
		$today = date("l");
		$allDeliveryzone = Deliveryzone::where('is_active',1)->pluck('zonename','zoneid');
		return view('Website.onlineorder.index',compact('currentdatetime','today','allDeliveryzone'));
	}
	public function onlineFoodMenu(Request $req)
	{
		Session::put('MyBranchID',$req->get('branchid'));
		Session::put('MyZoneID',$req->get('locationid'));
		if(Session::has('MyZoneID'))
		{
			$zone = DB::table('deliveryzone')->where('zoneid',Session::get('MyZoneID'))->first();
			Session::put('MyZoneName',$zone->zonename);
		}

		$allCategoryData = Category::where('branchid',Session::get('MyBranchID'))
		->Active()->Withoutaddon()->orderBy('serialno')->get();
		
		return view('Website.onlineorder.food',compact('allCategoryData'));
	}
	public function onlineFoodAjax(Request $request)
	{

		$branchID = $request->branchid;
		$searchString = $request->searchString;
		$categoryid = $request->categoryid;
		$fullHtml = "";

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
			$testfoodgroup = DB::table('foodgroup')
			->where('categoryid',$Category->categoryid)
			->get();

			foreach ($testfoodgroup as $foodgroup) 
			{

				$testfood = Food::where('foodname', 'like', '%' . $searchString . '%')
				// ->join('food_channel_maps','food.foodid','=','food_channel_maps.foodid')
				->where('status',1)
				// ->where('foodchannelid',3)
				->where('foodgroupid',$foodgroup->foodgroupid)
				->get();

				$lineimage = asset('WebsiteCSSJS/img/line.png');

				foreach ($testfood as $food)
				{
					if ( $food->thumbnail ) {
						$imageURL = asset('upload/menu/thumbnail_images/'.$food->thumbnail);
						
					}else{
						$imageURL = asset('imageFolder/no-image.png') ;
						
					}

					if($Category->categoryid >=36 && $Category->categoryid <=42)
					{
						$otherdetail = $food->otherdetail;
						$categorytype = "Offers";
					}
					else
					{
						$otherdetail = '';
						$categorytype = "";
					}



					$toppingInfo = array();
					foreach ($food->foodaddon as $addon ) 
					{
						if ($addon->activeaddonInfo ) 
						{
							$toppingInfo[] = $addon->activeaddonInfo;

						}
					}

					$mealtoppingInfo = array();
					foreach ($food->foodmealaddon as $addon ) 
					{
						if ($addon->activemealaddonInfo ) 
						{
							$mealtoppingInfo[] = $addon->activemealaddonInfo;

						}
					}


					// $foodprice = "<span class='menu__price__rt'>BDT ".$food->price."</span>";

					if($food->discount == 0 || is_null($food->discount))
					{
						$foodprice = "<span class='menu__price__rt'>BDT ".$food->price."</span>";
					}
					else
					{
						$foodprice = "<span class='menu__price__rt' style='text-decoration: line-through;'>".$food->price." </span>&nbsp;&nbsp;&nbsp;<sup style='font-size:30px'><span class='menu__price__rt'>".$food->offerprice."</span></sup>";
					}



					$fullHtml .= "<div class='row row__food'> 
					<div class='col-md-3 col-xs-12'>
					<img src='".$imageURL."' class='img-responsive col-xs-img' >
					</div>
					<div class='col-md-6 col-xs-6'>
					<div style='' class='menu__name'>".$food->foodname."</div>
					<p>".$otherdetail."</p>
					</div>
					<div class='col-md-3 col-xs-6' style=''>

					<div class='menu__price'>".$foodprice." <br/>";

					if (count($toppingInfo) > 0) {
						$json_array = htmlspecialchars(json_encode($toppingInfo), ENT_QUOTES, 'UTF-8');
						$json_meal_array = htmlspecialchars(json_encode($mealtoppingInfo), ENT_QUOTES, 'UTF-8');
						$fullHtml .= "<input type='button pull-right' data-image='".$food->thumbnail."'  data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-offerprice='".$food->offerprice."' data-discount='".$food->discount."'
						data-discountamount='".$food->discountamount."' data-itemprice='".$food->price."' data-topping-required='".$food->isaddonrequired."' data-mintopping='".$food->minaddon."' data-maxtopping='".$food->maxaddon."' data-topping='".$json_array."' data-mealtopping='".$json_meal_array."' data-categorytype='".$categorytype."' class='btn menu__btn btn-add-topping' value='ADD TO CART' data-toggle='modal' data-target='#myModal'> ";
					}else{


						$fullHtml .= "<input type='button pull-right' data-image='".$food->thumbnail."' data-foodgroupid='".$foodgroup->foodgroupid."' data-itemid='".$food->foodid."' data-catid='".$Category->categoryid."' data-foodgroup='".$foodgroup->foodgroupname."' data-itemname='".$food->foodname."' data-offerprice='".$food->offerprice."' data-discount='".$food->discount."' data-discountamount='".$food->discountamount."' data-itemprice='".$food->price."' data-topping-required='".$food->isaddonrequired."' data-mintopping='".$food->minaddon."' data-maxtopping='".$food->maxaddon."' data-topping='".json_encode($toppingInfo)."' data-mealtopping='".json_encode($mealtoppingInfo)."' data-categorytype='".$categorytype."' class='btn menu__btn btn-add-to-cart' value='ADD TO CART'> ";
					}
					$fullHtml .= "</div></div></div>";
					$fullHtml .= "<div class='row col-xs-line'> 
					<div class='col-md-2'>
					</div>
					<div class='col-md-8'>
					<img src='".$lineimage."' class='img-responsive' style='margin-top: 20px'>
					</div>
					<div class='col-md-2'>
					</div>
					</div>";
				}
			}
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
	public function previewCart(Request $request)
	{
		$bid = $request->branchid;
		return view('Website.onlineorder.previewcart',compact('bid'));
	}
	public function billingDetails(Request $request)
	{
		$orderTotal     = $request->input('ordertotal');
		$orderSubTotal  = $request->input('ordersubtotal');
		$total_discountamount  = $request->input('total_discountamount');
		$deliverycharge = $request->input('deliverycharge');
		return view('Website.onlineorder.billingaddress',compact('orderTotal','orderSubTotal','deliverycharge','total_discountamount'));
	}
	public function customerOrderinfo(Request $request)
	{
		$allOrderInput = json_decode($request->input('orderdata'));

		$orderTotal = $request->input('ordertotal');
		$orderSubTotal = $request->input('ordersubtotal');
		$total_discountamount  = $request->input('total_discountamount');
		$deliverycharge = $request->input('deliverycharge');
		$actualPrice = $orderTotal+$total_discountamount;

		$rules = array(
			'name'  => 'required',
			'contactno'  => 'required',
			'paymentmethod' => 'required'
		);
		$messages = [
			'paymentmethod.required' => __('Select Payment Method to Place Order!'),
		];
		$validation = Validator::make($request->all(),$rules,$messages);
		if($validation->fails())
		{
			$errors = $validation->messages()->toArray();
			return  redirect()->back()->withInput($request->input())->withErrors($validation);
		}
		else
		{
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
			$temporderdata->discountamount = $total_discountamount;
			$temporderdata->paymentmethod = $request->input('paymentmethod');
		$temporderdata->orderfrom = 3; // from website
		$temporderdata->deliverycharge = $deliverycharge;
		if($temporderdata->save())
		{
			$tempdata = DB::table('temp_orders')->where('orderNumber',$temporderdata->ordernumber)->first();
			$temporderid = $tempdata->temporderUUID;
			$paymentmethod = $tempdata->paymentmethod;
			$ordernumber = $temporderdata->ordernumber;
			$created_at = date_format($temporderdata->created_at,"Y-m-d H:i:s A");

			return view('Website.onlineorder.credential',compact('orderTotal','temporderid','ordernumber','created_at','branchname','paymentmethod','total_discountamount','actualPrice'));
		}
	}

}
public function paymentsuccess($temporderid)
{
	$tempdata = DB::table('temp_orders')->where('temporderUUID',$temporderid)->first();
	$ordernumber = $tempdata->ordernumber;
	$orderTotal = $tempdata->ordertotal;
	$branchid = $tempdata->branchid;
	$paymentmethod = $tempdata->paymentmethod;


	if($tempdata->paymentstatus == 2)
	{
		$branchinfo = DB::table('branch')->where('branchid',$branchid)->first();
		$branchname = $branchinfo->branchname;
		$created_at = $tempdata->created_at;
		$total = $tempdata->ordertotal;

		return view('Website.onlineorder.paymentsuccess',compact('ordernumber','branchname','created_at','total','orderTotal','paymentmethod'));
	}
}
public function paymentCancel(Request $req)
{
	return view('Website.onlineorder.paymentcancel');
}
public function cashOnDelivery(Request $req)
{
	$tempdata = DB::table('temp_orders')->where('temporderUUID',$req->temporderid)->first();
	$ordernumber = $tempdata->ordernumber;
	$branchid = $tempdata->branchid;
	$customerdata = DB::table('customerinfo')->where('customerid',$tempdata->customerid)->first();
	$allOrderInput = json_decode($tempdata->orderdata);

	if($tempdata->paymentstatus == 0)
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
                'paymentmethod'         => 1, // Cash on Delivery 
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

		TempOrder::where('temporderUUID', $req->temporderid)->update(array(
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

		return json_encode('order_placed');
	}
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
public function logout()
{
	Session::forget('bkash_customerid');
}
}
