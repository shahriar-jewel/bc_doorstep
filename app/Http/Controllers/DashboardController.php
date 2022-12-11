<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Userinfo;


class DashboardController extends Controller
{
	public function index()
	{
    	// $totalDonor 			= Userinfo::where('usertype',2)->count();
    	// $totalBloodCollection 	= HealthRecord::where('bloodstatus',1)->count();
    	// $totalWebuser 			= Userinfo::where('usertype',1)->count();
    	// $totalSuperadmin		= Userinfo::where('usertype',-1)->count();
    	// $totalDonorBloodgroupwise = Userinfo::select(
    	// 							DB::raw(
	    // 								"COUNT(IF(bloodgroup = 1  , 1 , NULL)) AS 'O+',
					// 					COUNT(IF(bloodgroup = 2  , 1 , NULL)) AS 'O-',
					// 					COUNT(IF(bloodgroup = 3  , 1 , NULL)) AS 'A+',
					// 					COUNT(IF(bloodgroup = 4  , 1 , NULL)) AS 'A-',
					// 					COUNT(IF(bloodgroup = 5  , 1 , NULL)) AS 'B+',
					// 					COUNT(IF(bloodgroup = 6  , 1 , NULL)) AS 'B-',
					// 					COUNT(IF(bloodgroup = 7  , 1 , NULL)) AS 'AB+',
					// 					COUNT(IF(bloodgroup = 8  , 1 , NULL)) AS 'AB-'
					// 					")
    	// 							)->where('usertype', '=', 2)
				 //                    ->first()
				 //                    ->toArray();

    	// SELECT bloodgroup,count(*) FROM `userinfo` WHERE usertype = 2 GROUP BY `bloodgroup`

    	$date = date('Y-m-d', time()); // today date
    $firstDate = date('Y-m-01'); // current month first date
    $tomorrow = date("Y-m-d", strtotime('tomorrow')); // tomorrow date
    $data = DB::select("SELECT count(*) AS totalOrder,
    	(
    	SELECT SUM(totalamount) FROM banani_club.order 
    	WHERE orderstatus = 5 
    	AND created_at >= '".$date."'
    	) AS totalAmount,
    	(
    	SELECT SUM(totalamount) FROM banani_club.order 
    	WHERE (created_at <= '".$tomorrow."' AND created_at >= '".$firstDate."') 
    	AND orderstatus = 5
    	) AS monthToDateSale,
    	(
    	SELECT count(*) FROM banani_club.order 
    	WHERE (created_at <= '".$tomorrow."' AND created_at >= '".$firstDate."') 
    	) AS monthToDateOrderCount
    	from banani_club.order
    	where created_at >= '".$date."' 
    	");

    $top10Customers = DB::select("SELECT o.member_id,membinfo.name,membinfo.contactno,
    	count(*) AS noOfOrder,
    	SUM(totalamount) AS totalOrderAmountCM
    	FROM banani_club.order AS o
    	INNER JOIN banani_club.memberinfo AS membinfo
    	ON o.member_id = membinfo.member_id
    	WHERE (o.created_at <= '".$tomorrow."' AND o.created_at >= '".$firstDate."')
    	AND orderstatus = 5
    	GROUP BY o.member_id,membinfo.name,membinfo.contactno
    	ORDER BY noOfOrder desc
    	LIMIT 10
    	");

    $paymentMode = DB::select("SELECT paymentmethod, SUM(totalamount) AS totalPaymentMethodAmount
    	FROM banani_club.order
    	WHERE (created_at <= '".$tomorrow."' AND created_at >= '".$firstDate."')
    	AND orderstatus = 5
    	GROUP BY paymentmethod
    	");
    $modeData = array();
    if(!empty($paymentMode)){
    	foreach($paymentMode as $mode){
    		if($mode->paymentmethod == 1){
    			$paymentMode = 'Cashcard';
    		}
    		else if($mode->paymentmethod == 2){
    			$paymentMode = 'Card';
    		}
    		else{
    			$paymentMode = 'Credit';
    		}
    		$modeData[] = array(
    			'mode' => $paymentMode,
    			'value'   =>  $mode->totalPaymentMethodAmount
    		);
    	}
    }
    else{
    	$modeData[] = array(
    		'mode' => 'unknown',
    		'value'   =>  0
    	);
    }

    return view('dashboard.index',[
    	'totalOrder' => $data[0]->totalOrder,
    	'totalAmount' => $data[0]->totalAmount,
    	'monthToDateSale' => $data[0]->monthToDateSale,
    	'monthToDateOrderCount' => $data[0]->monthToDateOrderCount,
    	'modeData' => json_encode($modeData),
    	'customerData' => $top10Customers
    ]);

}    
}
