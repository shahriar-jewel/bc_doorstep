@extends('common.layout')
@section('extra_css')
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }} "/> -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
@endsection
@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		Food <small>add and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Food</a>
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
							<i class="icon-bag"></i>Food List
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
										<a href="{{ route('food.create') }}" class="btn green">
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
							<table class="table table-striped table-bordered table-hover" id="sample_1">
							<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									Branch Name
								</th>
								<th>
									Category Name
								</th>
								<th>
									Food Group
								</th>
								<th>
									Food Name
								</th>
								<th>
									Food Image
								</th>
								<th width="30%">
									Detail
								</th>
								<th>
									Price
								</th>
								<th>
									Quantity
								</th>
								<th>
									Status
								</th>
								<th>
									Action
								</th>
							</tr>
							</thead>
							<tbody>
							
							<?php // $resNo = ($allrestaurant->currentPage() * $allrestaurant->perPage() ) - ($allrestaurant->perPage() - 1 ); 
								$foodNo = 1;
							?>
							@foreach($allfood as $food)
							<tr>
								<td>
									{{ $foodNo++ }}
								</td>
								<td>
									{{ isset($food['branch']) ? $food['branch']['branchname'] : '' }}
								</td>
								<td>
									{{ isset($food['category']) ? $food['category']['name'] : '' }}
								</td>
								<td>
									{{ isset($food['foodgroup']) ? $food['foodgroup']['foodgroupname'] : '' }}
								</td>
								<td>
									{{ $food['foodname'] }}
								</td>
								<td align="center">
									@if( !is_null($food['thumbnail']) )
									<img src="{{ URL::asset('upload/menu/thumbnail_images/'.$food['thumbnail']) }}">
									@endif
								</td>
								<td align="center">
									{{ $food['otherdetail'] }}
								</td>
								<td>
									{{ sprintf('%0.2f' , $food['price']) }} Tk
								</td>
								<td>
									{{ $food['quantity'] }} 
								</td>
								<td align="center">
									<span class="label label-sm label-{{ $food['status'] == 1 ? 'success' : 'danger' }} ">
									{{ $food['status'] == 1 ? 'Published' : 'Not Published' }}
									</span>
								</td>
								<td align="center">
									<a href="{{ route('food.edit',$food['foodid']) }}" class="btn btn-circle btn-xs purple">
									<i class="fa fa-edit"></i> Edit </a>
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
		<!-- END PAGE CONTENT-->
	</div>
@endsection

@section('extra_js')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }} "></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js') }} "></script>
<!-- <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/js/dataTables.scroller.min.js') }} "></script> -->
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }} "></script>

<script src="{{ URL::asset('assets/admin/pages/scripts/table-advanced.js') }} "></script>
<script>
	jQuery(document).ready(function() {    
		// TableAjax.init();
		TableAdvanced.init();
	});
</script>
@endsection