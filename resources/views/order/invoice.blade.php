@extends('common.layout')
@section('extra_css')
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }} "/> -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
<style type="text/css">
	.center{
		text-align: center;
	}
</style>
@endsection
@section('content')
<div class="page-content">
	
	
	
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="invoice">
		<div class="row invoice-logo">
			<!-- <div class="col-xs-6 invoice-logo-space">
				<img src="../../assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
			</div> -->
					<!-- <div class="col-xs-6">
						<p>
							 #5652256 / 28 Feb 2013 <span class="muted">
							Consectetuer adipiscing elit </span>
						</p>
					</div> -->
				</div>
				<hr/>
				<div class="row">
					<div class="col-xs-8">
						<h3>Order Number :  #{{ $orderDetail['ordernumber'] }}</h3>
						<ul class="list-unstyled">
							
							
						</ul>
					</div>
					
					<div class="col-xs-4 invoice-payment">
						<h3>Customer Details:</h3>
						<ul class="list-unstyled">
							<li>
								<strong>Customer Name :</strong> {{ $orderDetail['customer']['name'] }}
							</li>
							<li>
								<strong>Phone :</strong> {{ $orderDetail['customer']['contactno'] }}
							</li>
							<li>
								<strong>Location :</strong> {{ $orderDetail['deliveryzone']['zonename'] }}
							</li>
							
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
										#
									</th>
									<th>
										Food Name
									</th>
									<th class="hidden-480">
										Price
									</th>
									<th class="hidden-480">
										Quantity
									</th>
									<th class="hidden-480">
										Toppings
									</th>
									<th>
										Total
									</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 1; ?>
								@foreach( $orderDetail['orderitem'] as $item )
								<tr>
									<td>
										{{ $i++ }}
									</td>
									<td>
										{{ $item['foodinfo']['foodname'] }}
									</td>
									<td>
										{{ $item['foodinfo']['price'] }}
									</td>
									<td class="hidden-480">
										{{ $item['quantity'] }}
									</td>
									<td class="hidden-480">
										@foreach($item['orderitemaddon'] as $addon)
										+{{ $addon['addonInfo']['foodname'] }} ( BDT {{ $addon['price'] }} × {{ $addon['quantity'] }})
										<br>
										@endforeach
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
				<div class="row">
					<div class="col-xs-8">
						<!-- <div class="well">
							<address>
								<strong>Loop, Inc.</strong><br/>
								795 Park Ave, Suite 120<br/>
								San Francisco, CA 94107<br/>
								<abbr title="Phone">P:</abbr> (234) 145-1810 </address>
								<address>
									<strong>Full Name</strong><br/>
									<a href="mailto:#">
									first.last@email.com </a>
								</address>
							</div> -->
						</div>
						<div class="col-xs-4 invoice-block">
							<ul class="list-unstyled amounts">
								<li>
									<strong>Sub - Total amount : </strong> {{ sprintf('%0.2f' , $orderDetail['amount'] ) }}  BDT
								</li>
								<li>
									<strong>Discount :</strong> {{ sprintf('%0.2f' , $orderDetail['discount'] ) }}  BDT
								</li>
								<li>
									<strong>Delivery Charge : </strong> {{ sprintf('%0.2f' , $orderDetail['deliverycharge'] ) }} BDT
								</li>
								<li>
									<strong>Grand Total :</strong> {{ sprintf('%0.2f' , $orderDetail['totalamount'] ) }} BDT
								</li>
							</ul>
							<br/>
							<a href="{{ url('print-copy/'.$orderDetail['orderid']) }}" class="btn btn-lg blue hidden-print margin-bottom-5">
								Print <i class="fa fa-print"></i>
							</a>
						</div>
					</div>
				</div>
				<!-- END PAGE CONTENT-->
			</div>
			@endsection
			@section('extra_js')
			<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }} "></script>
			<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }} "></script>
			<!-- <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }} "></script> -->
			<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }} "></script>

			<!-- <script src="{{ URL::asset('assets/admin/pages/scripts/table-advanced.js') }} "></script> -->
			@endsection