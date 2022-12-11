@extends('common.layout')
@section('extra_css')
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }} "/> -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
@endsection
@section('content')
<div class="page-content">

	<!-- BEGIN PAGE HEADER-->
	<h3 class="page-title">
		Category List <small>create and edit</small>
	</h3>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>
				<a href="{{ route('dashboard.index') }}">Dashboard</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">General Category</a>
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
						<i class="fa fa-home"></i>General Category List
					</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="btn-group">
										<a href="{{ route('general-category.create') }}" class="btn green">
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
									<tr style="background-color: #37ccc2;color: white;">
										<th>
											#
										</th>
										<th>
											General Category
										</th>
										<th>
											Name Color
										</th>

										<th>
											Picture
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

									<?php 
									$cusNo = 1;
									?>
									@foreach($categorylist as $category)
									<tr>
										<td>
											{{ $cusNo++ }}
										</td>
										<td>
											{{ $category['name'] }}
										</td>
										<td>
											{{ $category['namecolor'] }}
										</td>
										<td>
											<img src="{{ url('upload/menu/thumbnail_images/'.$category['picture']) }}" width="100px">
										</td>
										<td>
											@if($category['is_active'] == 1)
											<span class="label label-sm label-success">{{ __('Published') }}</span>
											@else
											<span class="label label-sm label-danger">{{ __('Not Published') }}</span>
											@endif
										</td>

										<td align="center">
											<a href="{{ route('general-category.edit',$category['id']) }}" class="btn btn-circle btn-xs purple id">
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