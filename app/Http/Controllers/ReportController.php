<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kitchen;
use App\Models\Order;
use DB;
use App\Models\Userinfo;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Category;


class ReportController extends Controller
{
    public function waiterSalesReport(Request $req){
    	$waiters = Userinfo::where('usertype',3)->select('userid','fullname','contactno')->get()->toArray();
    	return view('report.waiter_sales',compact('waiters'));

        // AND (order.created_at <= '".$tomorrow."' AND order.created_at >= '".$date."')
    }
    public function waiterSalesReportAjax(Request $req){
        $orderfrom = '';
        $arr = [];
        $from_date   = date('Y-m-d' . ' 00:00:00', strtotime($req->from) ); 
        $to_date     = date('Y-m-d' . ' 23:59:59', strtotime($req->to) );
        $req->session()->forget('excel_data');
        $req->session()->forget('b_id');

        $waiterStatement = DB::select("SELECT 
                                    order.created_by, userinfo.fullname,
                                    COUNT(*) AS totalOrder ,
                                    SUM(amount) AS subTotal ,
                                    SUM(totalamount) AS grandTotal
                                FROM banani_club.order
                                INNER JOIN banani_club.userinfo ON order.created_by = userinfo.userid
                                WHERE ( orderstatus = 5 OR orderstatus = 8 )
                                AND order.created_at >= '".$from_date."' 
                                AND order.created_at <= '".$to_date."' 
                                GROUP BY order.created_by"
                            );

        if(count($waiterStatement) > 0){
            foreach ($waiterStatement as $key => $value) {
                $arr[] = [
                    'Waiter Name' => $value->fullname,
                    'NoOfOrder'   => $value->totalOrder,
                    'Grand Total' => $value->grandTotal
                ];
            }
            $req->session()->put('excel_data',$arr);
        }
        
        return json_encode($waiterStatement);
    }
    public function downloadWaiterSalesReport(Request $req){
            if($req->session()->has('excel_data')){
                $excelData = $req->session()->get('excel_data');
                $req->session()->forget('excel_data');
                return (new FastExcel($excelData))
                       ->download('waiter_report'.'.xlsx');
            }
            else{
                session()->flash('message', 'No Data Found!' );
                session()->flash('class', 0 );
                return redirect()->route('waiter-sales-report');
            }
    }
    public function memberSalesReport(Request $req){
        return view('report.member_sales');

        // AND (order.created_at <= '".$tomorrow."' AND order.created_at >= '".$date."')
    }
    public function memberSalesReportAjax(Request $req){
        $orderfrom = '';
        $arr = [];
        $from_date   = date('Y-m-d' . ' 00:00:00', strtotime($req->from) ); 
        $to_date     = date('Y-m-d' . ' 23:59:59', strtotime($req->to) );
        $req->session()->forget('excel_data');
        $req->session()->forget('b_id');

        $memberStatement = DB::select("SELECT 
                                    order.member_id, memberinfo.name,
                                    COUNT(*) AS totalOrder ,
                                    SUM(amount) AS subTotal ,
                                    SUM(totalamount) AS grandTotal
                                FROM banani_club.order
                                INNER JOIN banani_club.memberinfo ON order.member_id = memberinfo.member_id
                                WHERE ( orderstatus = 5 OR orderstatus = 8 )
                                AND order.created_at >= '".$from_date."' 
                                AND order.created_at <= '".$to_date."' 
                                GROUP BY order.member_id"
                            );

        if(count($memberStatement) > 0){
            foreach ($memberStatement as $key => $value) {
                $arr[] = [
                    'Waiter Name' => $value->name,
                    'NoOfOrder'   => $value->totalOrder,
                    'Grand Total' => $value->grandTotal
                ];
            }
            $req->session()->put('excel_data',$arr);
        }
        
        return json_encode($memberStatement);
    }
    public function downloadMemberSalesReport(Request $req){
            if($req->session()->has('excel_data')){
                $excelData = $req->session()->get('excel_data');
                $req->session()->forget('excel_data');
                return (new FastExcel($excelData))
                       ->download('member_report'.'.xlsx');
            }
            else{
                session()->flash('message', 'No Data Found!' );
                session()->flash('class', 0 );
                return redirect()->route('member-sales-report');
            }
    }
    public function kitchenSalesReport(Request $req){
        $kitchens = Kitchen::where('is_active',1)->select('kitchenid', 'kitchenname')->get()->toArray();
        return view('report.kitchen_sales',compact('kitchens'));

        // AND (order.created_at <= '".$tomorrow."' AND order.created_at >= '".$date."')
    }
    public function kitchenSalesReportAjax(Request $req){
        $orderfrom = '';
        $arr = [];
        $from_date   = date('Y-m-d' . ' 00:00:00', strtotime($req->from) ); 
        $to_date     = date('Y-m-d' . ' 23:59:59', strtotime($req->to) );
        $kitchenid   = $req->kitchenid;

        $kitchenStatement = DB::select("SELECT 
                                    order.orderid,order.ordernumber, order.created_at,
                                    order.member_id,memberinfo.name as 'membername',order.paymentmethod,
                                    order.totalamount,userinfo.fullname as 'waitername'
                                FROM banani_club.order
                                INNER JOIN banani_club.kitchen ON order.kitchenid = kitchen.kitchenid
                                INNER JOIN banani_club.memberinfo ON order.member_id = memberinfo.member_id
                                INNER JOIN banani_club.userinfo ON order.created_by = userinfo.userid
                                WHERE ( orderstatus = 5 OR orderstatus = 8 )
                                AND order.kitchenid = '".$kitchenid."' 
                                AND order.created_at >= '".$from_date."' 
                                AND order.created_at <= '".$to_date."'"
                            );
        
        return json_encode($kitchenStatement);
    }
    public function downloadKitchenSalesReport(Request $req){
            if($req->session()->has('excel_data')){
                $excelData = $req->session()->get('excel_data');
                $req->session()->forget('excel_data');
                return (new FastExcel($excelData))
                       ->download('kitchen_report'.'.xlsx');
            }
            else{
                session()->flash('message', 'No Data Found!' );
                session()->flash('class', 0 );
                return redirect()->route('kitchen-sales-report');
            }
    }
    public function customerList(Request $req){
        return view('report.customerlist');

        // AND (order.created_at <= '".$tomorrow."' AND order.created_at >= '".$date."')
    }
    public function ajaxCustomerList(Request $req){
        $from_date   = date('Y-m-d' . ' 00:00:00', strtotime($req->from) ); 
        $to_date     = date('Y-m-d' . ' 23:59:59', strtotime($req->to) );
        $req->session()->forget('cust_data_excel');

        $data = DB::select("
                SELECT count(*) AS noOfOrder, cinfo.name as `name`,cinfo.email as `email`,cinfo.contactno as `mobile`,GROUP_CONCAT(food.foodname SEPARATOR ', ') as `items`, dz.zonename as location,odr.created_at as `ordertime`,SUM(odr.amount) as `amount` FROM `order` as odr
                    LEFT JOIN customerinfo as cinfo ON odr.customerid = cinfo.customerid
                    LEFT JOIN deliveryzone as dz ON odr.locationid = dz.zoneid
                    LEFT JOIN orderitem as oi ON odr.orderid = oi.orderid
                    LEFT JOIN food ON oi.foodid = food.foodid
                    WHERE (odr.created_at >= '".$from_date."' AND odr.created_at <= '".$to_date."')
                    group by cinfo.contactno
            ");
        if($data){
            $req->session()->put('cust_data_excel',$data);
        }
        return json_encode($data);
    }
    public function downloadCustomerList(Request $req){
        if($req->session()->has('cust_data_excel')){
            $cust_data = $req->session()->get('cust_data_excel');
            // return (new FastExcel($cust_data))
            //            ->download('customer_data.xlsx');
        }else{
            session()->flash('message', 'No Data Found!' );
            session()->flash('class', 0 );
            return redirect()->route('customer-list');
        }
    }
    public function categorySalesReport(Request $req){
        $categories = Category::where('is_active',1)->select('categoryid', 'name')->get()->toArray();
        return view('report.category_sales',compact('categories'));
    }
    function groupByCategory($data, $group_by) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$value['orderitem'][0]['food']['category'][$group_by]][] = $value ;
        }
        return $result;
    }
    public function categorySalesReportAjax(Request $req){
        $orderfrom = '';
        $arr = [];
        $from_date   = date('Y-m-d' . ' 00:00:00', strtotime($req->from) ); 
        $to_date     = date('Y-m-d' . ' 23:59:59', strtotime($req->to) );
        $categoryid   = $req->categoryid;

        $allOrderDetail = Order::with(['orderitem.foodinfo','member','waiter','orderitem.food.category'])
                           ->where('order.orderstatus','=',5)
                           
                           ->whereBetween('order.created_at', array($from_date, $to_date))
                           ->orderBy('order.created_at', 'desc')
                           ->get()
                           ->toArray();
        $ordersByCategory = $this->groupByCategory($allOrderDetail,'categoryid');
        if(count($ordersByCategory) > 0 && in_array($categoryid, array_keys($ordersByCategory))){
            return json_encode($ordersByCategory[$categoryid]);
        }else{
            return json_encode([]);
        }
    }
    public function orderTimelineReport(Request $req){
        return view('report.order_timeline');
    }
    public function orderTimelineReportAjax(Request $req){
        $orderfrom = '';
        $arr = [];
        $from_date   = date('Y-m-d' . ' 00:00:00', strtotime($req->from) ); 
        $to_date     = date('Y-m-d' . ' 23:59:59', strtotime($req->to) );

        $data = Order::with(['orderlog','member','deliveryinfo','deliveryinfo.rider','deliveryzone','tableno'])
                      // ->where('order.branchid',$req->branchid)
                      ->whereBetween('order.created_at', array($from_date, $to_date))
                      ->get();

        if(count($data) > 0){
            return json_encode($data);
        }else{
            return json_encode([]);
        }
    }
}
