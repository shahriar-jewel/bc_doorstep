@extends('common.layout')
@section('extra_css')
<!-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }} "/> -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>
@endsection
@section('content')
<div class="page-content">

	<!-- BEGIN PAGE HEADER-->
	<h3 class="page-title">
		Customer <small>create and edit</small>
	</h3>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>
				<a href="{{ route('dashboard.index') }}">Dashboard</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Customer</a>
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
						<i class="fa fa-home"></i>Customer Address List
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

					<form method="post" action="{{ url('customer-address') }}">
						{{ csrf_field() }}
						<div class="modal fade" id="addressModal" tabindex="-1" role="basic" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title" align="center"><strong>Update Address</strong></h4>
									</div>

									<input type="hidden" name="id" id="id">

									<div class="modal-body">
										<div class="row">
												<label class="col-md-4 control-label ">Customer Name</label>
												<div class="col-md-8">
													<input type="text" name="name" id="name" class="form-control" readonly="">
												</div>
										</div>
										<div class="row">
												<label class="col-md-4 control-label ">Customer Address</label>
												<div class="col-md-8">
													<textarea type="text" name="address" id="address" class="form-control"></textarea>
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


					<div class="portlet-body">
						<div class="table-toolbar">
							
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
											Customer Name
										</th>
										<th>
											Contact No
										</th>

										<th>
											Address
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
									@foreach($allcustomeraddress as $cus)
									<tr>
										<td>
											{{ $cusNo++ }}
										</td>
										<td>
											{{ $cus->name }}
										</td>
										<td>
											{{ $cus->contactno }}
										</td>
										<td>
											{{ $cus->address }}
										</td>

										<td align="center">
											<a data-target="#addressModal" data-toggle="modal" data-name="{{ $cus->name }}" data-id="{{ $cus->id }}" class="btn btn-circle btn-xs purple id">
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#sample_1').on('click','.id',function(){
			var button = $(this);
			var id = button.attr('data-id');
			var name = button.attr('data-name');
			var url = '{{ url('customer-address/create') }}';

            $.ajax({
					url :url,
					data:{ID: id},
					dataType : "json",
					success:function(data)
					{
						document.getElementById('address').value = data.address;
						$('#id').val(id);
						$('#name').val(name);
					}
				});
		})
	})
</script>
@endsection