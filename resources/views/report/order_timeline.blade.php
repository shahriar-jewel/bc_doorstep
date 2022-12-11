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
		Order Timeline Report
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
			<div class="portlet box">
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
										<div class="col-md-3">
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
										<div class="col-md-3">
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

										<div class="col-md-2">
											<a href="#"><button type="button" class="btn green searchBtn"><i class="fa fa-search"></i></button></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div id="printTable1">
					<div class="row">
						<div class="col-md-12">
							<h2 class="text-center" style="background-color: #c0c2c1 !important; padding: 10px;-webkit-print-color-adjust: exact;">
								<b>Banani Club Limited</b><br>
								<small><b><u>Order Timeline</u></b></small><br>
								<small>Period : <span id="fromDate">****-**-**</span> To <span id="toDate">****-**-**</span></small>
							</h2>
						</div>
					</div>
					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content" style="background-color: #c0c2c1 !important; padding: 10px;-webkit-print-color-adjust: exact;">
								<tr>
								<th>
									 Order Number
								</th>
								<th>
									 Order Date
								</th>
								<th>
									 Member
								</th>
								<th>
									 Delivery Address
								</th>
								<th>
									 Total Amount
								</th>
								<th>
									 Rider
								</th>
								<th>
									 Confirmed
								</th>
								<th class="numeric">
									 Processing
								</th>
								<th class="numeric">
									 Ready To Pickup
								</th>
								<th class="numeric">
									 On Way
								</th>
								<th class="numeric">
									 Delivered
								</th>
							</tr>
							</thead>
							<tbody class="data-holder">
							<!-- <tr>
								<td colspan="12" class="text-center">No Data Found!</td>
							</tr> -->
						</tbody>
						<tfoot class="payment-total">
							
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END PAGE CONTENT-->
<button  type="button" class="btn btn-primary btn-bordred waves-effect w-md m-b-5 print_invoice">
	<i class="fa fa-print"></i>&nbsp;Print Report</button>
</div>
@endsection

@section('extra_js')

<script>
	$(document).ready(function(){
		$('.print_invoice').on('click',function(){
			printData();
		})
	})

	function printData(){
		var printContents = document.getElementById("printTable1").innerHTML;
		var originalContents = document.body.innerHTML;
		document.body.innerHTML = printContents;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#from, #to').on('change',function(){
			$('#fromDate').text($('#from').val())
			$('#toDate').text($('#to').val())
		})

		$('#categoryid').on('change',function(){
			$('#category').text($("#categoryid :selected").text());
		});


		$('.searchBtn').on('click',function(){
			$(this).find('i').attr('class','fa fa-spinner fa-spin');
			var from = $('#from').val();
			var to = $('#to').val();
			var url = "{{ url('order-timeline-report-ajax') }}";
			var htmlString = "";
			var orderfrom;
			var statuses;
			if(from == ''){
				alert('From field is required!');
				return false;
			}
			var statusList = {
				1 : 'Confirmed',
				2 : 'Processing',
				3 : 'Ready to Pickup',
				4 : 'On Way',
				5 : 'Delivered',
				10 : 'Cancelled'
			};

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
							var orderfrom = {
								'1' : 'Microsite',
								'2' : 'Doorstep',
								'3' : 'Website'
							};
							$.each(data,function(index,value){
								htmlString += "<tr>";
								htmlString += "<td>"+value.ordernumber+"</td>";
								htmlString += "<td>"+value.created_at+"</td>";
								htmlString += "<td>"+value['member'].name+"</td>";
								htmlString += "<td>"+value.deliveryzone.zonename +' '+value.tableno.tablename+"</td>";
								htmlString += "<td>"+value.totalamount+"</td>";
								if(value['deliveryinfo']){
									htmlString += "<td>"+value['deliveryinfo']['rider'].fullname+"</td>";
								}else{
									htmlString += "<td>-</td>";
								}
								
								for(var i = 0; i <= 4; i++){
									if(value['orderlog'][i]){
									 htmlString += "<td>"+value['orderlog'][i].created_at+"</td>";
									}else{
										htmlString += "<td>-</td>";
									}
								}
								htmlString += "</tr>";
							});
						}
						else{
							htmlString += "<tr>";
							htmlString += "<td colspan='12' class='text-center'>No Data Found!</td>";
							htmlString += "</tr>";
						}
						$('.data-holder').append(htmlString);
					}
				});
		    })
	})
</script>
@endsection
