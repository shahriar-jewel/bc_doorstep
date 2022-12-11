@extends('common.layout')
@section('extra_css')
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }} "/> -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
@endsection
@section('content')
<div class="page-content">

	<!-- BEGIN PAGE HEADER-->
	<h3 class="page-title">
		Deliveryzone <small>create and edit</small>
	</h3>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>
				<a href="{{ route('dashboard.index') }}">Dashboard</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Deliveryzone</a>
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
						<i class="fa fa-home"></i>Deliveryzone List
					</div>
						<!-- <div class="tools">
						</div> -->
						<div class="actions">
							
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="btn-group">
										<a href="{{ url('deliveryzone/create') }}" class="btn green">
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
												Deliveryzone Name
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
							$cusNo = 1;
							?>
							@foreach($deliveryzone as $dzone)
							<tr>
								<td>
									{{ $cusNo++ }}
								</td>
								<td>
									{{ $dzone->zonename }}
								</td>
								<td>
									<span class="label label-sm label-{{ $dzone->is_active == 1 ? 'success' : 'danger' }} ">
										{{ $dzone->is_active == 1 ? 'Active' : 'Inactive' }}
									</span>
								</td>
								
								<td align="center">
									<a href="" data-zoneid="{{ $dzone->zoneid }}" data-target="#zonemodal" data-toggle="modal" class="btn btn-circle btn-xs purple zoneedit">
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

	<form method="post" action="{{ url('deliveryzone/update') }}">
		{{ csrf_field() }}
		<div class="modal fade" id="zonemodal" tabindex="-1" role="basic" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title" align="center"><strong>Update Zone</strong></h4>
					</div>
					<div class="modal-body">

						<div class="row">
							<div class="col-md-12">
								<label class="col-md-3 control-label">Deliveryzone</label>
								<div class="col-md-8">
									<input type="text" name="zonename" id="zonename" class="form-control">
								</div>
								<div class="col-md-8">
									<input type="hidden" name="zoneid" id="zoneid" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label">Status</label>
							<div class="col-md-9">
								<div class="radio-list">
									<label class="radio-inline">
										<input type="radio" name="is_active" value="1" id="A"> Active </label>
										<label class="radio-inline">
											<input type="radio" name="is_active" value="0" id="I"> Inactive </label>
											<label class="radio-inline">
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
<script type="text/javascript">
	$('#sample_1').on('click',".zoneedit", function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
		});
		var button = $(this);
		var zoneid = button.attr("data-zoneid");

		$.ajax({
			url:'deliveryzone/' + zoneid + '/edit',
			dataType: "json",
			success:function(data){
				$('#zonename').val(data[0].zonename);
				$('#zoneid').val(data[0].zoneid);

				if(data[0].is_active == 1)
				{
					$('#A').prop('checked', true).trigger('click');
				}
				else if(data[0].is_active == 0)
				{
					$('#I').prop('checked', true).trigger('click');
				}
				else
				{
					$('#A').prop('checked', false);
					$('#I').prop('checked', false);
				}



			},
			error:function(error){
				console.log(error);
				swal({
					title: "Data Not Updated!",
					icon: "error",
					button: "Aww yiss!",
					className: "myClass",

				});
			}
		})
	})
</script>
@endsection