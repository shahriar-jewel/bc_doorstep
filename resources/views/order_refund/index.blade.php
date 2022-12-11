@extends('common.layout')
@section('extra_css')
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }} "/> -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}" />
<style type="text/css">
	.center{
	  text-align: center;
	}
</style>

@endsection
@section('content')
<div class="page-content">
	
	<!-- BEGIN PAGE HEADER-->
	<h3 class="page-title">
	Order <small>bkash refund</small>
	</h3>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="#">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Order</a>
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
			 <div class="portlet box green-haze">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-home"></i>Order List
					</div>
					<!-- <div class="tools">
					</div> -->
					<div class="actions">
						<!-- <a href="{{ route('userinfo.create') }}" class="btn green btn-sm">
						<i class="fa fa-plus"></i> Add New</a> -->
						<!-- <div class="btn-group">
							<a class="btn default" href="#" data-toggle="dropdown">
							Columns <i class="fa fa-angle-down"></i>
							</a>
							<div id="" class="dropdown-menu hold-on-click dropdown-checkboxes ">
								<label><input type="checkbox" checked data-column="0">SL no.</label>
								<label><input type="checkbox" checked data-column="1">Full Name</label>
								<label><input type="checkbox" checked data-column="2">Gender</label>
								<label><input type="checkbox" checked data-column="3">Email</label>
								<label><input type="checkbox" checked data-column="4">Contact No</label>
								<label><input type="checkbox" checked data-column="5">User Type</label>
								<label><input type="checkbox" checked data-column="6">Status</label>
								<label><input type="checkbox" checked data-column="7">Action</label>
							</div>
						</div> -->
						
					</div>
				</div>
				<div class="portlet-body">
					<div class="table-toolbar">
						<div class="row">
							<div class="col-md-6">
								<div class="btn-group">
									<!-- <a href="{{ route('order.create') }}" class="btn green"> -->
									<!-- <i class="fa fa-plus"></i> Add New</a> -->
								</div>
							</div>
							<div class="col-md-6">
								<!-- <div class="btn-group pull-right">
									<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>
									</button>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="#">
											Print </a>
										</li>
										<li>
											<a href="#">
											Save as PDF </a>
										</li>
										<li>
											<a href="#">
											Export to Excel </a>
										</li>
									</ul>
								</div> -->
							</div>
						</div>
					</div>
					<div class="">
						@include('common.alert')	
						<table class="table table-striped table-bordered table-hover" id="orderinfo">
						<thead>
						<tr>
							<th>
								#
							</th>
							<th>
								Order Number
							</th>
							<th>
								Order Date
							</th>
							<th>
								Order From
							</th>
							<th>
								Branch Name
							</th>
							<th>
								Customer Name
							</th>
							<th >
								Customer Mobile
							</th>
							<th>
								Total Price
							</th>
							<th>
								Order Status
							</th>
							<th>
								Original TrxID
							</th>
							<th>
								Refund TrxID
							</th>
							<th>
								Refund Date
							</th>
							<th >
								Bkash Mobile
							</th>
							<th>
								Refund Amount
							</th>
							<th>
								Payment Status
							</th>
							<th >
								Action
							</th>
						</tr>
						</thead>
						</table>
					</div>
				</div>
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

<script>
	// jQuery(document).ready(function() {    
	// 	// TableAjax.init();
	// 	TableAdvanced.init();
	// });
	$(document).ready(function(){
		$('#orderinfo').DataTable({
	        "processing": true,
	        "serverSide": true,
	        "ajax":{
	                 "url": "{{ url('ajax/refund/orderinfo') }}",
	                 "dataType": "json",
	                 "type": "POST",
	                 "data":{ _token: "{{csrf_token()}}"}
	               },
	        "columns": [
	            { "data": "slno" },
	            { "data": "ordernumber" },
	            { "data": "orderdate" },
	            { "data": "orderfrom" },
	            { "data": "branchname" },
	            { "data": "customername" },
	            { "data": "customermobile" },
	            { "data": "totalprice" },
	            { "data": "orderstatus" , "sClass" : "center" },
	            { "data": "originaltrxid" },
	            { "data": "refundtrxid" },
	            { "data": "refunddate" },
	            { "data": "bkashmobile" },
	            { "data": "refundamount" },
	            { "data": "paymentstatus" , "sClass" : "center" },
	            { "data": "action" ,"orderable": false , "sClass" : "center" },
                
	        ],
	        "order": [[ 2, "desc" ]]

	    });

	    $('[data-toggle="tooltip"]').tooltip();
	});
</script>

@endsection