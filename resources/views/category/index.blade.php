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
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		Category <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Category</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">View All</a>
				</li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				 <div class="portlet box green-haze">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-home"></i>Category List
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
										<a href="{{ route('category.create') }}" class="btn green">
										<i class="fa fa-plus"></i> Add New</a>
									</div>
								</div>
								<div class="col-md-6">
									<div class="btn-group pull-right">
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
									</div>
								</div>
							</div>
						</div>
						<div class="">
							@include('common.alert')	
							<table class="table table-striped table-bordered table-hover" id="categoryinfo">
							<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									Kitchen Name
								</th>
								<th>
									Name
								</th>
								<th>
									Image
								</th>
								<th>
									Serial No
								</th>
								<th>
									Category Type
								</th>
								<th>
									Status
								</th>
								<th>
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

<script>
	$(document).ready(function(){
		$('#categoryinfo').DataTable({
	        "processing": true,
	        "serverSide": true,
	        "ajax":{
	                 "url": "{{ url('ajax/categoryinfo') }}",
	                 "dataType": "json",
	                 "type": "POST",
	                 "data":{ _token: "{{csrf_token()}}"}
	               },
	        "columns": [
	            { "data": "slno" },
	            { "data": "kitchenname" },
	            { "data": "categoryname" },
	            { "data": "foodpicture" },
	            { "data": "serialno" },
	            { "data": "categorytype" , "sClass" : "center" },
	            { "data": "status" , "sClass" : "center" },
	            { "data": "action" , "orderable": false , "sClass" : "center" },
	        ],
	        // "order": [[ 5, "desc" ]]

	    });

	    $('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endsection