@extends('common.layout')
@section('content')
		<div class="page-content">
			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Order View <small>refund order details</small>
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
						<a href="#">bKash Refund</a>
					</li>
				</ul>
				<div class="page-toolbar">
					<!-- <div class="btn-group pull-right">
						<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
						Actions <i class="fa fa-angle-down"></i>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li>
								<a href="#">Action</a>
							</li>
							<li>
								<a href="#">Another action</a>
							</li>
							<li>
								<a href="#">Something else here</a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="#">Separated link</a>
							</li>
						</ul>
					</div> -->
				</div>
			</div>
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
								<!-- <a href="{{ route('order.index') }}" class="btn default yellow-stripe">
								<i class="fa fa-angle-left"></i>
								<span class="hidden-480">
								Back </span>
								</a>
								<div class="btn-group">
									<a class="btn default yellow-stripe dropdown-toggle" href="#" data-toggle="dropdown">
									<i class="fa fa-cog"></i>
									<span class="hidden-480">
									Tools </span>
									<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="#">
											Export to Excel </a>
										</li>
										<li>
											<a href="#">
											Export to CSV </a>
										</li>
										<li>
											<a href="#">
											Export to XML </a>
										</li>
										<li class="divider">
										</li>
										<li>
											<a href="#">
											Print Invoice </a>
										</li>
									</ul>
								</div> -->
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
									<!-- <li>
										<a href="#tab_3" data-toggle="tab">
										Credit Memos </a>
									</li>
									<li>
										<a href="#tab_4" data-toggle="tab">
										Shipments <span class="badge badge-danger">
										2 </span>
										</a>
									</li>
									<li>
										<a href="#tab_5" data-toggle="tab">
										History </a>
									</li> -->
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
														<div class="actions">
															<a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a>
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
														<div class="row static-info">
															<div class="col-md-5 name">
																Payment Status:
															</div>
															<div class="col-md-7 value">
																<span class="label label-info">
																{{ $allPaymentStatus[$orderDetail['paymentstatus']] }}</span>
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Grand Total:
															</div>
															<div class="col-md-7 value">
																{{  sprintf( '%0.2f' , $orderDetail['totalamount'] ) }} Tk
																@if($orderDetail['paymentstatus'] == 1)
																	<a class="btn btn-danger btn-sm" data-target="#refundmodal" data-toggle="modal" data-ordernumber="{{ $orderDetail['ordernumber'] }}">
																	<i class="fa fa-remove"></i> Refund </a>
																@endif
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Refund Amount:
															</div>
															<div class="col-md-7 value">
																{{  sprintf( '%0.2f' , $orderDetail['bkashrefund']['refund_amount'] ) }} Tk
															</div>
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
															<i class="fa fa-cogs"></i>Payment Details
														</div>
														<div class="actions">
															<!-- <a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a> -->
														</div>
													</div>
													<div class="portlet-body">
														<div class="row static-info">
															<div class="col-md-5 name">
																 Invoice ID:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['paymentinfo']['transactionlog']['tran_id'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Payment ID:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['paymentinfo']['transactionlog']['tran_payment_id'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Payment Method:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['paymentinfo']['payment_type'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Original TrxID:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['paymentinfo']['transactionlog']['tran_bank_id'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																Refund TrxID:
															</div>
															<div class="col-md-7 value">
																{{ $orderDetail['bkashrefund']['refund_trxid'] }}
															</div>
														</div>
														<div class="row static-info">
															<div class="col-md-5 name">
																 Refund Date:
															</div>
															<div class="col-md-7 value">
																@if(!is_null($orderDetail['bkashrefund']['refund_date']))
																{{ date('M d, Y g:i a' ,strtotime($orderDetail['bkashrefund']['refund_date'])) }}
																@endif
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="portlet blue-hoki box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Customer Information
														</div>
														<div class="actions">
															<!-- <a href="#" class="btn btn-default btn-sm">
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
											<div class="col-md-6 col-sm-12">
												<div class="portlet green-meadow box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Billing Address
														</div>
														<div class="actions">
															<!-- <a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a> -->
														</div>
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
											<div class="col-md-6 col-sm-12">
												<div class="portlet red-sunglo box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Delivery Address
														</div>
														<div class="actions">
															<!-- <a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a> -->
														</div>
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
										</div>
										<div class="row">
										</div>
										<div class="row">
											<div class="col-md-12 col-sm-12">
												<div class="portlet grey-cascade box">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-cogs"></i>Ordered Items
														</div>
														<div class="actions">
															<!-- <a href="#" class="btn btn-default btn-sm">
															<i class="fa fa-pencil"></i> Edit </a> -->
														</div>
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
																		+{{ $addon['addonInfo']['foodname'] }} ( BDT {{ $addon['price'] }}  )
																		<br>
																	@endforeach
																	</td>
																	<td>
																	{{ $item['quantity'] }}
																	</td>
																	<td>
																	BDT {{ $item['totalprice'] }}
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
										<input type="radio" id="refund_typeFull" name="refund_type" value="1" checked> Full </label>
										<label class="radio-inline">
										<input type="radio" id="refund_typePartial" name="refund_type" value="2"> Partial </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label class="col-md-3 control-label ">Refund Amount</label>
								<div class="col-md-8 {{ $errors->has('refund_amount') ? 'has-error' : '' }}">
									<input type="text" name="refund_amount" id="refund_amount" class="form-control" placeholder="Enter Amount" value="{{$orderDetail['amount'] }}" readonly>
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
		<input type="hidden" id="deliveryinfoLat" value="{{ count($deliveryInfo) > 0 ? $deliveryInfo['last_lat'] : 0 }}" >
		<input type="hidden" id="deliveryinfoLng" value="{{ count($deliveryInfo) > 0 ? $deliveryInfo['last_lng'] : 0 }}" >
@endsection
@section('extra_js')
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

    $(function () {
        $("input[name='refund_type']").click(function () {
            if ($("#refund_typePartial").is(":checked")) {
                $("#refund_amount").removeAttr("readonly");
                $("#refund_amount").focus();
            } else {
                $("#refund_amount").attr("readonly", "readonly");
            }
        });
    });

</script>
@endsection