@extends('common.layout')
@section('content')
<div class="page-content">

	<!-- BEGIN PAGE HEADER-->
	<h3 class="page-title">
		Order View <small>refund</small>
	</h3>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="{{ route('dashboard.index') }}">Dashboard</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ route('order-refund.index') }}">Order</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Order detail and Refund </a>
			</li>
		</ul>
	</div>
	@include('common.alert')
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<div class="col-md-12">
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Order #{{ $orderDetail['ordernumber'] }} <span class="hidden-480">
						| {{ date('M d, Y g:i a' ,strtotime($orderDetail['created_at'])) }} </span>
					</div>
					<div class="actions">
						<!-- <a href="{{ url('invoice',$orderDetail['orderid']) }}" class="btn btn-primary btn-sm">
							<i class="fa fa-print"></i> Create Invoice 
						</a> -->
					</div>
				</div>
				<div class="portlet-body">
						<div class="tabbable">
							<ul class="nav nav-tabs nav-tabs-lg">
								<li class="active">
									<a href="#tab_1" data-toggle="tab">
									Details </a>
								</li>
								<li>
									<a href="#tab_2" data-toggle="tab">
										History <span class="badge badge-success">
										{{ count($orderDetail['orderlog']) }} </span>
									</a>
								</li>
							</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<div class="portlet yellow-crusta box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Order Details
												</div>
												
											</div>
											<div class="portlet-body">
												<div class="row static-info">
													<div class="col-md-5 name">
														Order #:
													</div>
													<div class="col-md-7 value">
														{{ $orderDetail['ordernumber'] }} 
													<!-- <span class="label label-info label-sm">
													Email confirmation was sent </span> -->
												</div>
											</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Order From:
													</div>
													<div class="col-md-7 value">
														@if($orderDetail['orderfrom'] == '1')
														    {{ __('Microsite') }}
														@elseif($orderDetail['orderfrom'] == '2')
															{{ __('Doorstep') }}
														@endif
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Order Date & Time:
													</div>
													<div class="col-md-7 value">
														{{ date('M d, Y g:i a' ,strtotime($orderDetail['created_at'])) }}
													</div>
												</div>
												<div class="row static-info">
													<div class="col-md-5 name">
														Order Status:
													</div>
													
													<div class="col-md-7 value">
														<span class="label label-success">
														{{ $allDeliverystatus[$orderDetail['orderstatus']] }}</span>
													</div>
												</div>
												@if($orderDetail['orderstatus'] != 5 && $orderDetail['orderstatus'] != 10)
												<div class="row static-info">
													<div class="col-md-5 name">
														
													</div>
													
												</div>
												@endif

												<div class="row static-info">
													<div class="col-md-5 name">
														Grand Total:
													</div>
													<div class="col-md-4 value">
														{{  sprintf( '%0.2f' , $orderDetail['totalamount'] ) }} Tk
														@if($orderDetail['paymentstatus'] == 2)
															<span class="label label-info">Refunded</span>
														@else
															<a class="btn btn-danger btn-sm" data-target="#refundmodal" data-toggle="modal" data-ordernumber="{{ $orderDetail['ordernumber'] }}">
															<i class="fa fa-remove"></i> Refund </a>
														@endif
													</div>
													<!-- <div class="col-md-3 value"></div> -->
												</div>
												<!-- <div class="row static-info">
													<div class="col-md-5 name">
														Payment Information:
													</div>
													<div class="col-md-7 value">
														Cash on Delivery
													</div>
												</div> -->
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-12">
										<div class="portlet blue-hoki box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Customer Information
												</div>
												<div class="actions" id="customer">
													<!-- <a href="{{ url('editcustomer',$orderDetail['ordernumber']) }}" class="btn btn-default btn-sm">
														<i class="fa fa-pencil"></i> Edit </a> -->
														<!-- <a data-target="#customermodal" data-toggle="modal" data-id="{{ $orderDetail['ordernumber'] }}" class="btn btn-default btn-sm customereditajax">
															<i class="fa fa-pencil"></i> Edit </a> -->
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																Customer Name:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['customer']['name'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Email:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['customer']['email'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Gender:
															</div>
															<div class="col-md-7 value">
																@if($orderDetail['customer']['gender'] == '1')
																{{ __('Male') }}
																@elseif($orderDetail['customer']['gender'] == '2')
																{{ __('Female') }}
																@else
																{{ __('Others') }}
																@endif

															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Location:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['deliveryzone']['zonename'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Phone Number:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['customer']['contactno'] }}
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>


										<form method="post" action="{{ url('updatebillingaddress',$orderDetail['ordernumber']) }}">
											{{ csrf_field() }}
											<div class="modal fade" id="billingmodal" tabindex="-1" role="basic" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
															<h4 class="modal-title" align="center"><strong>Update Bulling Address</strong></h4>
														</div>
														<div class="modal-body">

															<div class="row">
																<div class="col-md-12">
																	<label class="col-md-3 control-label">Billing Address</label>
																	<div class="col-md-8">
																		<select class="form-control" name="billingaddress" id="billingaddress">

																			<option value="">- - - Select - - -</option>

																			@if(!empty($customeraddress))
																			@foreach($customeraddress as $custaddress)
																			<option value="{{ $custaddress->address }}">{{ $custaddress->address }}</option>
																			@endforeach
																			@endif
																		</select>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn default" data-dismiss="modal">Close</button>

															<button type="submit" class="btn red ">Update</button>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
										</form>

											<div class="modal fade" id="refundmodal" tabindex="-1" role="basic" aria-hidden="true">
												<div class="modal-dialog">
													<form method="post" action="{{ route('order-refund.request') }}">
													{{ csrf_field() }}
													<div class="modal-content">
														<input type="hidden" name="order_number" value="{{ $orderDetail['ordernumber'] }}">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
															<h4 class="modal-title" align="center"><strong>Refund Request</strong></h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-12">
																	<label class="col-md-3 control-label">Refund Type</label>
																	<div class="col-md-9">
																		<div class="radio-list">
																			<label class="radio-inline">
																			<input type="radio" name="refund_type" value="1" checked> Full </label>
																			<label class="radio-inline">
																			<input type="radio" name="refund_type" value="2"> Partial </label>
																		</div>
																	</div>
																</div>
															</div>
															<div class="row">
																<div class="col-md-12">
																	<label class="col-md-3 control-label ">Refund Amount</label>
																	<div class="col-md-8 {{ $errors->has('refund_amount') ? 'has-error' : '' }}">
																		<input type="text" name="refund_amount" id="refund_amount" class="form-control" placeholder="Enter Amount" value="{{$orderDetail['amount'] }}">
																		@if ($errors->has('refund_amount'))
																		<span class="help-block has-error">
																			<strong>{{ $errors->first('refund_amount') }}</strong>
																		</span>
																		@endif
																	</div>
																</div>
															</div>

															<div class="row" style="padding-top: 5px;">
																<div class="col-md-12">
																	<label class="col-md-3 control-label ">Refund Reason</label>
																	<div class="col-md-8 {{ $errors->has('refund_reason') ? 'has-error' : '' }}">
																		<textarea class="form-control" name="refund_reason" rows="3" cols="4" placeholder="Enter Refund Reson" id="refund_reason" required></textarea>
																	</div>
																</div>
															</div>

														</div>
														<div class="modal-footer">
															<button type="button" class="btn default" data-dismiss="modal">Close</button>

															<button type="submit" class="btn red ">Submit</button>
														</div>
													</div>
													</form>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>


										<form method="post" action="{{ url('updatepayment',$orderDetail['ordernumber']) }}">
											{{ csrf_field() }}
											<div class="modal fade" id="paymentmodal" tabindex="-1" role="basic" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
															<h4 class="modal-title" align="center"><strong>Update Payment Method</strong></h4>
														</div>
														<div class="modal-body">

															<div class="row">
																<div class="col-md-12">
																	<label class="col-md-4 control-label">Payment Method</label>
																	<div class="col-md-8">
																		<select class="form-control" name="paymentmethod" id="paymentmethod">

																			<option value="">- - - Select - - -</option>
																			<option value="1">Cash On Delivery</option>
																			<option value="2">Card On Delivery</option>
																			<option value="3">Cash On bKash</option>

																		</select>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn default" data-dismiss="modal">Close</button>

															<button type="submit" class="btn red ">Update</button>
														</div>
													</div>
													<!-- /.modal-content -->
												</div>
												<!-- /.modal-dialog -->
											</div>
										</form>


								<div class="row">
									<div class="col-md-4 col-sm-12">
										<div class="portlet green-meadow box">
											<div class="portlet-title">
												<div class="caption">
													<i class="fa fa-cogs"></i>Billing Address
												</div>
												@if($orderDetail['orderstatus'] != 5 && $orderDetail['orderstatus'] != 10)
												<div class="actions" id="example1">
													<!-- <a data-target="#billingmodal" data-toggle="modal" data-id="{{ $orderDetail['ordernumber'] }}" class="btn btn-default btn-sm billingeditajax">
														<i class="fa fa-pencil"></i> Edit</a> -->
													</div>
													@endif
												</div>
												<div class="portlet-body">
													<div class="row static-info">
														<div class="col-md-12 value">
															<strong>
																{{ htmlspecialchars($orderDetail['shippingaddress']) }}
															</strong>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4 col-sm-12">
											<div class="portlet red-sunglo box">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-cogs"></i>Delivery Address
													</div>
													@if($orderDetail['orderstatus'] != 5 && $orderDetail['orderstatus'] != 10)
													<div class="actions">
														<!-- <a href="" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a> -->
													</div>
													@endif
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-12 value">
																<strong>
																	{{ htmlspecialchars($orderDetail['shippingaddress']) }}
																</strong>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-4 col-sm-12">
												<div class="portlet green-meadow box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-credit-card"></i>Payment Method
														</div>
														@if($orderDetail['orderstatus'] != 5 && $orderDetail['orderstatus'] != 10)
														<div class="actions" id="payment">
															<!-- <a data-target="#paymentmodal" data-toggle="modal" data-id="{{ $orderDetail['ordernumber'] }}" class="btn btn-default btn-sm paymenteditajax">
															<i class="fa fa-pencil"></i> Edit </a> -->
														</div>
														@endif
														</div>
														<div class="portlet-body">
															<div class="row static-info">
																<div class="col-md-12 value">
																	<strong>
																		@if($orderDetail['paymentmethod'] == '1')
																		<span>{{ __('Cash On Delivery') }}</span>
																		@elseif($orderDetail['paymentmethod'] == '2')
																		<span>{{ __('Card On Delivery') }}</span>
																		@elseif($orderDetail['paymentmethod'] == '3')
																		<span>{{ __('Cash On bKash') }}</span>
																		@endif
																	</strong>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="portlet grey-cascade box">
					<div class="portlet-title">
						<div class="caption">
		    				<i class="fa fa-cogs"></i>Ordered Items
						</div>
						@if($orderDetail['orderstatus'] < 3)
		    			<div class="actions">
							<a href="{{ url('editfood/' . $orderDetail['customerid'] . '/' . $orderDetail['ordernumber'])}}" class="btn btn-default btn-sm">
						<i class="fa fa-pencil"></i> Add </a>
						</div>
						@endif
					</div>
					<div class="portlet-body">
						<div class="table-responsive">
							<table class="table table-hover table-bordered table-striped">
								<thead>
									<tr>
										<th>
											#
										</th>
										<th>
											Food Picture
										</th>
										<th>
											Food Name
										</th>
										<!-- <th>
										 Item Status
										</th> -->
										<th>
											Price
										</th>
										<th>
											Toppings
										</th>
									<!-- <th>
										 Price
										</th> -->
										<th>
											Quantity
										</th>
									<!-- <th>
										 Tax Amount
									</th>
									<th>
										 Tax Percent
										</th> -->
									<!-- <th>
										 Discount Amount
										</th> -->
										<th>
											Total
										</th>
										<th>
											Action
										</th>
									</tr>
								</thead>
								<tbody>
									<?php $sl=1; ?>
									@foreach( $orderDetail['orderitem'] as $item )
									<tr>
										<td>
											{{ $sl++ }}
										</td>
										<td>
											@if( $item['foodinfo']['thumbnail'] )
											<img   src="{{ URL::asset('/upload/menu/thumbnail_images/'.$item['foodinfo']['thumbnail']) }}">
											@else
											<img src="http://www.placehold.it/100x80/EFEFEF/AAAAAA&text=no+image">
											@endif
										</td>
										<td>
											{{ $item['foodinfo']['foodname'] }}
										</td>
										<!-- <td>
										BDT {{ $item['foodinfo']['price'] }} 
										</td> -->
										<td>
											BDT {{ $item['price'] }} 
										</td>
										<td >
											@foreach( $item['orderitemaddon'] as $addon)
											+{{ $addon['addonInfo']['foodname'] }} ( BDT {{ $addon['price'] }} × {{ $addon['quantity'] }}  )
											<br>
											@endforeach
										</td>
										<td>
											{{ $item['quantity'] }}
										</td>
										<td>
											BDT {{ $item['totalprice'] }}
										</td>
										<td>
								          
											@if($orderDetail['orderstatus'] < 3)
											<a href="{{ url('removeitem/'.$item['orderitemid']) }}" onclick="return confirm('Are you sure to remove this item?')" class='btn btn-circle btn-xs red'><i class='fa fa-trash'></i> Remove </a>
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
			</div>
			<div class="col-md-6">
				<div class="well">
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							Sub Total:
						</div>
						<div class="col-md-3 value">
							{{ sprintf('%0.2f' , $orderDetail['amount'] ) }}  BDT
						</div>
					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							Discount:
						</div>
						<div class="col-md-3 value">
							{{ sprintf('%0.2f' , $orderDetail['discount'] ) }} BDT
						</div>
					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							Delivery Charge:
						</div>
						<div class="col-md-3 value">
							{{ sprintf('%0.2f' , $orderDetail['deliverycharge'] ) }} BDT
						</div>
					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							Grand Total:
						</div>
						<div class="col-md-3 value">
							{{ sprintf('%0.2f' , $orderDetail['totalamount'] ) }} BDT
						</div>
					</div>
					<!-- <div class="row static-info align-reverse">
						<div class="col-md-8 name">
							Total Paid:
						</div>
						<div class="col-md-3 value">
							
						</div>
					</div>
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							Total Refunded:
						</div>
						<div class="col-md-3 value">
						     
						</div>
					</div> -->
					<div class="row static-info align-reverse">
						<div class="col-md-8 name">
							Total Due:
						</div>
						<div class="col-md-3 value">
							{{ sprintf('%0.2f' , $orderDetail['totalamount'] ) }} BDT
						</div>
					</div>
				</div>
			</div>
		</div>
			</div>
									
	<div class="tab-pane" id="tab_2">
		<div class="table-container">
			<table class="table table-striped table-bordered table-hover" >
				<thead>
					<tr role="row" class="heading">
						<th >
							Order Status
						</th>
						<th>
							Short Note
						</th>
						<th>
							Log By 
						</th>
						<th>
							User Type
						</th>
						<th>
							Log Time 
						</th>
					</tr>
				</thead>
				<tbody>
					@foreach($orderDetail['orderlog'] as $orderlog)
					<tr>
						<td>{{ $allDeliverystatus[$orderlog->orderstatus] }}</td>
						<td>{{ $orderlog->shortnote }}</td>
						<td>{{ $orderlog->createdBy->fullname }}</td>
						<td>{{ $allUserType[$orderlog->createdBy->usertype] }}</td>
						<td>{{ $orderlog->created_at }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>





		@if(count($deliveryInfo) > 0)
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="portlet green-meadow box">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i>Rider Info & Order Current Location
						</div>
						<div class="actions">
							
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							
							<div class="col-md-3">
								<div class="row static-info">
									<div class="col-md-5 name">
										Rider Name:
									</div>
									<div class="col-md-7 value">
										{{ $deliveryInfo['rider']['fullname'] }}
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										Rider Mobile No:
									</div>
									<div class="col-md-7 value">
										{{ $deliveryInfo['rider']['contactno'] }}
									</div>
								</div>
							</div>
							<div class="col-md-9">
								<div id="map" class="gmaps">
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		@endif

	</div>

									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
		<input type="hidden" id="deliveryinfoLat" value="{{ count($deliveryInfo) > 0 ? $deliveryInfo['last_lat'] : 0 }}" >
		<input type="hidden" id="deliveryinfoLng" value="{{ count($deliveryInfo) > 0 ? $deliveryInfo['last_lng'] : 0 }}" >
		@endsection
		@section('extra_js')
		<script src="{{ asset('sweetalert.js') }}"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}"></script>
		
		<script type="text/javascript">
			var lat = document.getElementById('deliveryinfoLat').value;
			var lng = document.getElementById('deliveryinfoLng').value;
 	// console.log(lat);
 	// console.log(lng);
 	if ( lat != 0 && lng != 0 ) {
 		initMap(lat,lng);
 	}
 	function initMap(lat , lng) {
 		var map = new google.maps.Map(document.getElementById('map'), {
 			zoom: 15,
 			center: {lat: parseFloat(lat), lng: parseFloat(lng)}
 		});

        // var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
        var image = "{{ URL::asset('assets/custom/img/marker_dl_bike.png') }}";
        var beachMarker = new google.maps.Marker({
        	position: {lat: parseFloat(lat), lng: parseFloat(lng)},
        	map: map,
        	icon: image
        });
    }
</script>
<script type="text/javascript">
	// $('#refundmodal').on('click',".customereditajax", function(){
	// 	$.ajaxSetup({
	// 		headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
	// 	});
	// 	var button = $(this);
	// 	var orderno = button.attr("data-id");


	// 	var url = '{{ url('editcustomer') }}';
	// 	$.ajax({
	// 		url: url,
	// 		method:'POST',
	// 		data:{ordernumber: orderno},
	// 		dataType: "json",
	// 		success:function(data){
	// 			$('#name').val(data.name);
	// 			$('#email').val(data.email);
	// 			$('#phone').val(data.contactno);
	// 			if(data.gender == 1)
	// 			{
	// 				$("#M").prop("checked", true).trigger("click");
	// 			}
	// 			else if(data.gender == 2)
	// 			{
	// 				$("#F").prop("checked", true).trigger("click");
	// 			}
	// 			else if(data.gender == 3)
	// 			{
	// 				$("#O").prop("checked", true).trigger("click");
	// 			}
	// 		},
	// 		error:function(error){
	// 			console.log(error);
	// 			swal({
	// 				title: "Data Not Updated!",
	// 				text: "You clicked the button!",
	// 				icon: "error",
	// 				button: "Aww yiss!",
	// 				className: "myClass",

	// 			});
	// 		}
	// 	})
	// })
</script>



<script type="text/javascript">
$(document).ready(function(){
$('#cancelorder').on('click',function(){
   $.ajaxSetup({
  headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
});
  var button = $(this);
var ordernumber = button.attr("data-ordernumber");
var url = '{{ url('orderstatuscancel') }}';
  swal({
    title: "Are you sure ?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {

      $.ajax({
        url: url,
        method:'POST',
        data:{ordernumber : ordernumber},
        dataType : "json",
        success:function(data){ 
          console.log(data);
      },
      
    })
        swal("Order Canceled Successfully!", {
          icon: "success",
        });
        timer();
    } 
    else {
      swal("Order Not Canceled !", {
        icon: "info",
      });
    }
  });
})
})
</script>

<script type="text/javascript">
function timer()
{
var time = 1

setInterval( function() {

    time--;

    $('#time').html(time);

    if (time === 0) {

        location.reload();
    }    


}, 1000 );
}
</script>

@endsection