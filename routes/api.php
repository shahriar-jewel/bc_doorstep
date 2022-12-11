<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {


	Route::post('login',[
			'uses'	=> 'Api\AuthController@appsLogin',
			'as'	=> 'login'
	]);

	Route::post('forgetpassword',[
			'uses'	=> 'Api\AuthController@forgetPassword',
			'as'	=> 'forgetpassword'
	]);
	Route::post('resetpassword',[
			'uses'	=> 'Api\AuthController@passwordReset',
			'as'	=> 'resetpassword'
	]);


	// Route::get('/wrongresponse', function () {
	//     return "Error occured";
	// });

		Route::get('test',[
			'uses'	=> 'ApiController@test',
			'as'	=> 'test'
		]);

	Route::middleware(['checkapiauth'])->namespace('Api')->group(function () {

		Route::post('updatedeviceid',[
				'uses'	=> 'AuthController@updateGCMID',
				'as'	=> 'updatedeviceid'
		]);

		Route::post('locationupdate',[
				'uses'	=> 'AuthController@locationUpdate',
				'as'	=> 'locationupdate'
		]);

		Route::post('logout',[
				'uses'	=> 'AuthController@Logout',
				'as'	=> 'logout'
		]);

		Route::post('changepassword',[
				'uses'	=> 'AuthController@changePassword',
				'as'	=> 'changepassword'
		]);

		Route::post('orderdetail',[
				'uses'	=> 'OrderController@orderDetail',
				'as'	=> 'orderdetail'
		]);

		Route::post('single-orderdetail',[
				'uses'	=> 'OrderController@singleOrderDetail',
				'as'	=> 'single-orderdetail'
		]);
		
		Route::post('orderacceptdeny',[
				'uses'	=> 'OrderController@orderAcceptDeny',
				'as'	=> 'orderacceptdeny'
		]);

		Route::post('orderstatement',[
				'uses'	=> 'OrderController@statement',
				'as'	=> 'orderstatement'
		]);
		
		Route::post('menulist',[
				'uses'	=> 'MenuController@menuList',
				'as'	=> 'menulist'
		]);

		Route::post('menulist-bcmember',[
				'uses'	=> 'MenuController@menuListBCMember',
				'as'	=> 'menulist-bcmember'
		]);

		Route::post('changefoodstatus',[
				'uses'	=> 'MenuController@changeFoodstatus',
				'as'	=> 'changefoodstatus'
		]);


		Route::post('getriderinfo',[
				'uses'	=> 'RiderController@getRiderinfo',
				'as'	=> 'getriderinfo'
		]);

		Route::post('assignrider',[
				'uses'	=> 'RiderController@assignRider',
				'as'	=> 'assignrider'
		]);

		Route::post('riderjoblist',[
				'uses'	=> 'RiderController@riderJobList',
				'as'	=> 'riderjoblist'
		]);

		Route::post('rideracknowledgement',[
				'uses'	=> 'RiderController@riderJobAccept',
				'as'	=> 'rideracknowledgement'
		]);

		Route::post('get-member',[
				'uses'	=> 'OrderController@getMember',
				'as'	=> 'get-member'
		]);

		Route::post('member-update',[
				'uses'	=> 'OrderController@memberUpdate',
				'as'	=> 'member-update'
		]);

		Route::post('member-list',[
				'uses'	=> 'OrderController@getAllMembers',
				'as'	=> 'member-list'
		]);

		Route::post('waiter-orders',[
				'uses'	=> 'OrderController@getWaiterOrders',
				'as'	=> 'waiter-orders'
		]);

		Route::post('order-data',[
				'uses'	=> 'OrderController@getOrderData',
				'as'	=> 'order-data'
		]);

		Route::post('getbill',[
				'uses'	=> 'OrderController@getBill',
				'as'	=> 'getbill'
		]);

		Route::post('billclose',[
				'uses'	=> 'OrderController@billClose',
				'as'	=> 'billclose'
		]);

		Route::post('billhistory',[
				'uses'	=> 'OrderController@billHistory',
				'as'	=> 'billhistory'
		]);

		Route::post('deliveryzone',[
				'uses'	=> 'OrderController@getAllDeliveryZone',
				'as'	=> 'deliveryzone'
		]);

		Route::post('tableno',[
				'uses'	=> 'OrderController@getTable',
				'as'	=> 'tableno'
		]);

	});

		Route::get('pushtest',[
				'uses'	=> 'ApiController@pushtest',
				'as'	=> 'pushtest'
		]);

});

// Route::middleware(['checkbkashapiauth'])->namespace('Api\Bkash')->group(function () {
// Route::namespace('Api\Bkash')->group(function () {
// 	Route::post('create_payment','BkashController@createPayment');
// 	Route::post('execute_payment','BkashController@executePayment');
// 	Route::get('query_payment/{paymentID}','BkashController@queryPayment');
// 	Route::get('search_transaction/{trxID}','BkashController@searchTransaction');
// });
