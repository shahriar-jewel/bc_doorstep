<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', 
// 	[
// 		'uses'	=> function () {
//               return view('Website.layouts.index'); },
// 		'as'	=> '/'
// 	]);


Route::match(array('GET', 'POST'),'testdropdown', [
		'uses'	=> 'TestController@testdropdown',
		'as'	=> 'testdropdown'
	]);

Route::get('privacy_policy', [
		'uses'	=> 'HomeController@privacyPolicy',
		'as'	=> 'privacy_policy'
	]);


Route::match(array('GET', 'POST'),'doorstep', [
		'uses'	=> 'AuthController@index',
		'as'	=> 'login'
	]);

Route::match(array('GET', 'POST'),'forgetpassword', [
		'uses'	=> 'AuthController@forgetPassword',
		'as'	=> 'forgetpassword'
	]);

Route::match(array('GET', 'POST'),'password/reset/{resetToken}', [
		'uses'	=> 'AuthController@passwordReset',
		'as'	=> 'password.reset'
	]);

Route::get('logout', [
		'uses'	=> 'AuthController@processLogout',
		'as'	=> 'logout'
	]);

############## FOR AJAX REQUEST ROUTE GOES HERE ######
	Route::post('ajax/userinfo',[
				'uses'	=> 'UserinfoController@getUserInfo', 
				'as'	=> 'ajax.userinfo'
			]);

	Route::post('ajax/kitchen',[
				'uses'	=> 'UserinfoController@getkitchen', 
				'as'	=> 'ajax.kitchen'
			]);

	Route::post('ajax/categorybykitchen',[
				'uses'	=> 'CategoryController@getcategorybyKitchen', 
				'as'	=> 'ajax.categorybykitchen'
			]);
	Route::post('ajax/categoryinfo',[
				'uses'	=> 'CategoryController@getCategoryInfo', 
				'as'	=> 'ajax.categoryinfo'
			]);

	Route::post('ajax/foodinfo',[
				'uses'	=> 'FoodController@getFoodInfo', 
				'as'	=> 'ajax.foodinfo'
			]);

	Route::post('ajax/foodgroupbycategory',[
				'uses'	=> 'FoodController@getFoodgroupByCategory', 
				'as'	=> 'ajax.foodgroupbycategory'
			]);

	Route::post('ajax/foodgroupinfo',[
				'uses'	=> 'FoodgroupController@getFoodgroupInfo', 
				'as'	=> 'ajax.foodgroupinfo'
			]);

	Route::post('ajax/addonbybranch',[
				'uses'	=> 'FoodController@getAddonByBranch', 
				'as'	=> 'ajax.addonbybranch'
			]);

	Route::post('ajax/foodbybranch',[
				'uses'	=> 'FoodController@getfoodByBranch', 
				'as'	=> 'ajax.foodbybranch'
			]);
	// Route::get('ajax/menubybranch',[
	// 			'uses'	=> 'OrderController@getFoodMenuByBranch', 
	// 			'as'	=> 'ajax.menubybranch'
	// 		]);
	Route::post('ajax/menubybranch',[
				'uses'	=> 'OrderController@getFoodMenuByBranch', 
				'as'	=> 'ajax.menubybranch'
			]);

	Route::post('ajax/searchmemberbyid',[
				'uses'	=> 'OrderController@searchMemberByID', 
				'as'	=> 'ajax.searchmemberbyid'
			]);

	Route::post('ajax/orderinfo',[
				'uses'	=> 'OrderController@getOrderInfo', 
				'as'	=> 'ajax.orderinfo'
			]);
	Route::post('ajax/refund/orderinfo',[
				'uses'	=> 'BkashRefundController@getOrderInfo', 
				'as'	=> 'ajax.refund.orderinfo'
			]);

############## My Routes ###############
	Route::get('invoice/{orderid}','OrderController@printinvoice');
	Route::get('print-copy/{orderid}','OrderController@print_copy');

	Route::get('deleteorder/{ordernumber}','OrderController@deleteorder');
	Route::post('editcustomer','OrderController@editcustomer');
	Route::post('updateordercustomer/{customerid}','OrderController@updateordercustomer');

	Route::post('editbillingaddress','OrderController@editbillingaddress');
	Route::post('updatebillingaddress/{ordernumber}','OrderController@updatebillingaddress');

	Route::post('editpayment','OrderController@editpayment');
	Route::post('updatepayment/{ordernumber}','OrderController@updatepayment');

	Route::get('editfood/{customerid}/{ordernumber}','OrderController@editfood');
	Route::post('updateorder','OrderController@updateorder');
	Route::get('removeitem/{orderitemid}','OrderController@removeitem');

	Route::get('ajax/allcategory','OrderController@allCategoryAjax');

	Route::resource('customer-address','AddressController');
	
    Route::post('orderstatuscancel','OrderController@orderstatuscancel');
	
	Route::post('searchfood','OrderController@searchfood');

	Route::Resources([
        'deliveryzone'     => 'DeliveryzoneController',
        'general-category' => 'GeneralCategoryController',
        'general-food'     => 'GeneralFoodController',
	]);
	Route::post('deliveryzone/update','DeliveryzoneController@zoneupdate');

	// waiter wise sales report
	Route::get('waiter-sales-report','ReportController@waiterSalesReport')->name('waiter-sales-report');
	Route::get('waiter-sales-report-ajax','ReportController@waiterSalesReportAjax');

	Route::get('waiter-sales-report-download','ReportController@downloadWaiterSalesReport');

	// member wise sales report
	Route::get('member-sales-report','ReportController@memberSalesReport')->name('member-sales-report');
	Route::get('member-sales-report-ajax','ReportController@memberSalesReportAjax');
	Route::get('member-sales-report-download','ReportController@downloadMemberSalesReport');

	// Kitchen wise sales report
	Route::get('kitchen-sales-report','ReportController@kitchenSalesReport')->name('kitchen-sales-report');
	Route::get('kitchen-sales-report-ajax','ReportController@kitchenSalesReportAjax');
	Route::get('kitchen-sales-report-download','ReportController@downloadKitchenSalesReport');

	// Category wise sales report
	Route::get('category-sales-report','ReportController@categorySalesReport');
	Route::get('category-sales-report-ajax','ReportController@categorySalesReportAjax');

	// Order Timeline report
	Route::get('order-timeline-report','ReportController@orderTimelineReport');
	Route::get('order-timeline-report-ajax','ReportController@orderTimelineReportAjax');
	
	
	// Route::get('editorder/{ordernumber}','OrderController@editorder');

############## For Micro Site ##############
	Route::post('testingpurpose','OrderController@testingpurpose');
	
 Route::group(['as' => 'bkashmicrosite','prefix' => 'bkashmicrosite'] , function(){

    Route::get('/','MicrositeController@index');
	Route::post('branchwisemenu','MicrositeController@branchwisemenu');
	Route::get('latlngwisebranch','MicrositeController@latlngwisebranch');
	Route::get('foodmenubybranch','MicrositeController@foodmenubybranch');
	Route::post('previewcart','MicrositeController@previewcart');
	Route::post('billingdetails','MicrositeController@billingdetails');
	Route::post('customerorderinfo','MicrositeController@customerorderinfo');
	Route::get('paymentsuccess/{temporderid}','MicrositeController@paymentsuccess');
	Route::get('paymentcancel/','MicrositeController@paymentcancel');
	Route::get('searchmicrositefood','MicrositeController@searchMicrositeFood');
	Route::get('locationwisebranch','MicrositeController@locationwisebranch');
});


############## End of Micro Site ##############	


############## End My Routes ###############


 ############## Route for Website ###############
Route::namespace('Website')->group(function () {
	Route::get('/','OnlineOrderController@landingPage');
	Route::get('real-good-food','FoodMenuController@realGoodFood');
	Route::get('general-foodd','FoodMenuController@generalFood');
	Route::get('fooddetails','FoodMenuController@foodDetails');
	Route::get('location','MapController@location');
	Route::get('delivery','OnlineOrderController@index');
	Route::post('online-food-menu','OnlineOrderController@onlineFoodMenu');
	Route::get('onlinefoodajax','OnlineOrderController@onlineFoodAjax');
	Route::post('previewcart','OnlineOrderController@previewCart');
	// Route::post('billingdetails','OnlineOrderController@billingDetails');
	Route::post('customerorderinfo','OnlineOrderController@customerOrderinfo');
	Route::match(array('GET', 'POST'),'billingdetails', [
		'uses'	=> 'OnlineOrderController@billingDetails',
		'as'	=> 'billingdetails'
	]);
	
	Route::post('cashondelivery','OnlineOrderController@cashOnDelivery');

	Route::get('paymentsuccess/{temporderid}','OnlineOrderController@paymentSuccess');
	Route::get('paymentcancel/','OnlineOrderController@paymentCancel');
	Route::get('web_logout','OnlineOrderController@logout');
	
});
 ############## Route ends for Website ##########

############## END AJAX REQUEST ROUTE #########

Route::middleware(['checkauth'])->group(function(){
	
	Route::resource('/dashboard', 'DashboardController');

	Route::resource('userinfo', 'UserinfoController');
	Route::post('userinfo/update', [
			'uses'	=> 'UserinfoController@update',
			'as'	=> 'userinfo.update'
		]);
	Route::match(array('GET', 'POST'),'userinfo/{id}/resetpassword',[
			'uses'	=> 'UserinfoController@resetPassword', 
			'as'	=> 'userinfo.resetpassword'
		]);

	Route::get('profile',[
				'uses'	=> 'ProfileController@view', 
				'as'	=> 'profile.view'
			]);
	Route::match(array('GET', 'POST'),'profile/edit',[
			'uses'	=> 'ProfileController@edit', 
			'as'	=> 'profile.edit'
		]);
	Route::match(array('GET', 'POST'),'profile/changepassword',[
			'uses'	=> 'ProfileController@changePassword', 
			'as'	=> 'profile.changepassword'
		]);

	Route::resource('restaurant', 'RestaurantController', ['except' => ['update','show', 'destroy'] ] );


	Route::post('restaurant/update', [
			'uses'	=> 'RestaurantController@update',
			'as'	=> 'restaurant.update'
		]);

	Route::resource('restaurant/kitchen', 'KitchenController');
	Route::post('restaurant/kitchen/update', [
			'uses'	=> 'KitchenController@update',
			'as'	=> 'kitchen.update'
		]);

	Route::resource('category', 'CategoryController');
	Route::post('category/update', [
			'uses'	=> 'CategoryController@update',
			'as'	=> 'category.update' 
		]);

	Route::resource('foodgroup', 'FoodgroupController');
	Route::post('foodgroup/update', [
			'uses'	=> 'FoodgroupController@update',
			'as'	=> 'foodgroup.update' 
		]);

	Route::resource('food', 'FoodController');
	Route::post('food/update', [
			'uses'	=> 'FoodController@update',
			'as'	=> 'food.update' 
		]);


	Route::resource('order', 'OrderController');
	Route::post('order/update', [
			'uses'	=> 'OrderController@update',
			'as'	=> 'order.update' 
		]);
	
	Route::get('order-live-monitoring', [
			'uses'	=> 'OrderController@liveMonitor',
			'as'	=> 'order-live-monitoring' 
		]);

	Route::get('ajax/live-order-data', [
			'uses'	=> 'OrderController@ajaxLiveMonitor',
			'as'	=> 'ajax/live-order-data' 
		]);

	Route::resource('member', 'MemberinfoController');
	// Route::post('member/update', [
	// 		'uses'	=> 'MemberinfoController@update',
	// 		'as'	=> 'member.update' 
	// 	]);

	Route::get('member-datatable-ajax', [
			'uses'	=> 'MemberinfoController@memberDatatableAjax',
			'as'	=> 'member-datatable-ajax' 
		]);



	Route::resource('order-refund', 'BkashRefundController');
	Route::post('order-refund/request', [
			'uses'	=> 'BkashRefundController@refundRequest',
			'as'	=> 'order-refund.request' 
		]);
});

Route::middleware('checkbkashapiauth')->namespace('Api\Bkash')->group(function () {
	Route::post('bkashapi/create_payment','BkashController@createPayment');
	Route::post('bkashapi/execute_payment','BkashController@executePayment');
	Route::get('bkashapi/query_payment/{paymentID}','BkashController@queryPayment');
	Route::get('bkashapi/search_transaction/{trxID}','BkashController@searchTransaction');

	Route::post('bkashwebapi/create_payment','BkashWebController@createPayment');
	Route::post('bkashwebapi/execute_payment','BkashWebController@executePayment');
	Route::get('bkashwebapi/query_payment/{paymentID}','BkashWebController@queryPayment');
	Route::get('bkashwebapi/search_transaction/{trxID}','BkashWebController@searchTransaction');
});
