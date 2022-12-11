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
		Kitchen Sales Report
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

										<div class="col-md-3">
											<div class="form-group">
												<label class="col-md-5 control-label">Select Kitchen</label>
												<div class="col-md-7">
													<select class="form-control select2me" style="width: 100%" name="kitchenid" id="kitchenid">
														<option value="">- - - select kitchen - - -</option>
														@if(!empty($kitchens))
														@foreach($kitchens as $kitchen)
														<option value="{{ $kitchen['kitchenid'] }}">{{ $kitchen['kitchenname'] }}</option>
														@endforeach
														@endif
													</select>
												</div>
											</div>
										</div>

										<div class="col-md-3">
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
								<small><b><u>Sales Statement</u></b></small><br>
								<small>Kitchen : <span id="kitchen">*****</span></small><br>
								<small>Period : <span id="fromDate">****-**-**</span> To <span id="toDate">****-**-**</span></small>
							</h2>
						</div>
					</div>
					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content" style="background-color: #c0c2c1 !important; padding: 10px;-webkit-print-color-adjust: exact;">
								<tr>
									<th>
										Invoice Id
									</th>
									<th>
										Reference
									</th>
									<th>
										Date
									</th>
									<th>
										A/C #
									</th>
									<th>
										Member
									</th>
									<th>
										Mode
									</th>
									<th>
										Paid
									</th>
									<th>
										Due
									</th>
									<th>
										Total
									</th>
									<th>
										Waiter
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

		$('#kitchenid').on('change',function(){
			$('#kitchen').text($("#kitchenid :selected").text());
		});


		$('.searchBtn').on('click',function(){
			$(this).find('i').attr('class','fa fa-spinner fa-spin');
			var from = $('#from').val();
			var to = $('#to').val();
			var kitchenid = $('#kitchenid').val();
			// console.log(kitchenid)
			var url = "{{ url('kitchen-sales-report-ajax') }}";
			var htmlString = "", paymentString = "";
			var orderfrom;
			var paid,due, sum= 0;
			var cashCard = 0, card = 0, credit = 0;
			var mode = {
				1 : 'Cashcard',
				2 : 'Card',
				3 : 'Credit'
			};
			if(from == ''){
				alert('From field is required!');
			}

			$.ajax({
				url :url,
				method : "GET",
				data:{
					from,
					to,
					kitchenid
				},
				dataType : "json",
				success:function(data)
				{
					$('.searchBtn').find('i').attr('class','fa fa-search');
					// console.log(data)
					$('.data-holder').empty();
					$('.payment-total').empty();
					const groupBy = data.reduce((group, value) => {
						switch(value.paymentmethod){
								case 1 : 
									group['cashcard'] = cashCard += value.totalamount;
									break;
								case 2 :
								    group['card'] = card += value.totalamount;
								    break;
								case 3 : 
								    group['credit'] = credit += value.totalamount;
								    break;
								default : 
								    break;
							}
						return group;
					}, {});

					// console.log(groupBy);

					if(data.length > 0){
						$.each(data,function(index,value){
							paid = value.paymentmethod=== 3 ? 0 : value.totalamount;
							due = value.paymentmethod=== 3 ? value.totalamount : 0;
							htmlString += "<tr>";
							htmlString += "<td>"+value.orderid+"</td>";
							htmlString += "<td>"+value.ordernumber+"</td>";
							htmlString += "<td>"+value.created_at+"</td>";
							htmlString += "<td>"+value.member_id+"</td>";
							htmlString += "<td>"+value.membername+"</td>";
							htmlString += "<td>"+mode[value.paymentmethod]+"</td>";
							htmlString += "<td>"+paid+"</td>";
							htmlString += "<td>"+due+"</td>";
							htmlString += "<td>"+value.totalamount+"</td>";
							htmlString += "<td>"+value.waitername+"</td>";
							htmlString += "</tr>";
						});

						paymentString += "<tr>"
						paymentString += "<td colspan='9'>Cashcard : </td>"
						paymentString += "<td>"+cashCard+"</td>"
						paymentString += "</tr>"
						paymentString += "<tr>"
						paymentString += "<td colspan='9'>Card : </td>"
						paymentString += "<td>"+card+"</td>"
						paymentString += "</tr>"
						paymentString += "<tr>"
						paymentString += "<td colspan='9'>Credit : </td>"
						paymentString += "<td>"+credit+"</td>"
						paymentString += "</tr>"
					}
					else{
						htmlString += "<tr>";
						htmlString += "<td colspan='10' class='text-center'>No Data Found!</td>";
						htmlString += "</tr>";
					}
					$('.data-holder').append(htmlString);
					$('.payment-total').append(paymentString);
				}
			});
		})
	})
</script>
@endsection