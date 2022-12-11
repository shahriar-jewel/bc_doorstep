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
		Member Order Report <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Report</a>
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
<div class="row">
			<div class="col-md-12">
				<div class="portlet box green-haze ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-user"></i> Search Criteria
						</div>
					</div>
					<div class="portlet-body form form-horizontal">
						@include('common.alert')
						
							<div class="form-body">
								<div class="row global">
									<div class="col-md-4">
										<div class="form-group">
									<label class="col-md-5 control-label">From Date</label>
									<div class="col-md-7 {{ $errors->has('from') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-calendar"></i>
											<input type="text" class="form-control date-picker" name="from" id="from" placeholder="from date">
											@if ($errors->has('from'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('from') }}</strong>
		                                    </span>
		                                	@endif
	                                	</div>
									</div>
								</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
									<label class="col-md-5 control-label">To Date</label>
									<div class="col-md-7 {{ $errors->has('to') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-calendar"></i>
											<input type="text" class="form-control date-picker" name="to"  id="to" placeholder="to date">
											@if ($errors->has('to'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('to') }}</strong>
		                                    </span>
		                                	@endif
	                                	</div>
									</div>
								</div>
									</div>
			
									<div class="col-md-4">
										<a href="#"><button type="button" class="btn green searchBtn"><i class="fa fa-search"></i></button></a>
									</div>
								</div>
								<!-- <div class="form-group" >
									<div class="col-md-6">
										<label class="col-md-3 control-label ">Branch</label>
											<div class="col-md-9 {{ $errors->has('branch') ? 'has-error' : '' }}">
												<select class="form-control select2me" name="branch" id="branchid">
													<option value="">-select your branch-</option>
													@if(!empty($branches))
													@foreach($branches as $branch)
													<option value="{{ $branch['branchid'] }}">{{ $branch['branchname'] }}</option>
													@endforeach
													@endif
												</select>
												@if ($errors->has('branch'))
												<span class="help-block has-error">
													<strong>{{ $errors->first('branch') }}</strong>
												</span>
												@endif
											</div>
									   </div>
									   <div class="col-md-6">
									   	<a href="{{ url('orderstatustime/excel') }}"><button type="button" class="btn green searchBtn">excel Download</button></a>
									   </div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
					<div class="portlet-body">
						<!-- BEGIN SAMPLE TABLE PORTLET-->
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>Data
							</div>
							<div class="tools">
								<a href="{{ url('member-sales-report-download') }}"><button type="button" class="btn white">excel Download</button></a>
							</div>
						</div>
						<div class="portlet-body flip-scroll">
							<table class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content">
							<tr>
								<th>
									 Member Name
								</th>
								<th>
									 NoOfOrder
								</th>
								<th>
									 Total Sales
								</th>
							</tr>
							</thead>
							<tbody class="data-holder">
							<!-- <tr>
								<td colspan="12" class="text-center">No Data Found!</td>
							</tr> -->
							</tbody>
							</table>
						</div>
					</div>
					<!-- END SAMPLE TABLE PORTLET-->
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
@endsection

@section('extra_js')
<script type="text/javascript">
	$(document).ready(function(){
		$('.searchBtn').on('click',function(){
			$(this).find('i').attr('class','fa fa-spinner fa-spin');
			var from = $('#from').val();
			var to = $('#to').val();
			var url = "{{ url('member-sales-report-ajax') }}";
			var htmlString = "";
			var orderfrom;
			var statuses;
			if(from == ''){
				alert('From field is required!');
			}

			$.ajax({
					url :url,
					method : "GET",
					data:{
						from : from,
						to : to
					},
					dataType : "json",
					success:function(data)
					{
						$('.searchBtn').find('i').attr('class','fa fa-search');
						console.log(data)
						$('.data-holder').empty();


						if(data.length > 0){
							$.each(data,function(index,value){
								htmlString += "<tr>";
								htmlString += "<td>"+value.name+"</td>";
								htmlString += "<td>"+value.totalOrder+"</td>";
								htmlString += "<td>"+value.grandTotal+"</td>";
								htmlString += "</tr>";
							});
						}
						else{
							htmlString += "<tr>";
							htmlString += "<td colspan='3' class='text-center'>No Data Found!</td>";
							htmlString += "</tr>";
						}
						$('.data-holder').append(htmlString);


					}
				});
		    })
	    })
</script>
@endsection