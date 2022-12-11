@extends('common.layout')
@section('content')
<div class="page-content">

	<!-- BEGIN PAGE HEADER-->
	<h3 class="page-title">
		Dashboard Statistics
	</h3>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-home"></i>
				<a href="#">Home</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Dashboard</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Default Dashboard</a>
			</li>
		</ul>
		<div class="page-toolbar">
			<div class="btn-group pull-right">
				<button type="button" class="btn btn-fit-height grey-salt dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="1000" data-close-others="true">
					Actions <i class="fa fa-angle-down"></i>
				</button>
			</div>
		</div>
	</div>
	<!-- END PAGE HEADER-->
	<!-- BEGIN PAGE CONTENT-->
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN DASHBOARD STATS -->
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue-madison">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								{{ $totalOrder }}
							</div>
							<div class="desc">
								Today's Total Order
							</div>
						</div>
						<a class="more" href="#">
							View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red-intense">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								BDT. {{ $totalAmount == '' ? 0 : $totalAmount }}
							</div>
							<div class="desc">
								Today's Total Sales
							</div>
						</div>
						<a class="more" href="#">
							View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green-haze">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								{{ $monthToDateOrderCount }}
							</div>
							<div class="desc">
								Month To Date Order Count
							</div>
						</div>
						<a class="more" href="#">
							View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple-plum">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								BDT. {{ $monthToDateSale == '' ? 0 : $monthToDateSale }}
							</div>
							<div class="desc">
								Month To Date Sale
							</div>
						</div>
						<a class="more" href="#">
							View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- END DASHBOARD STATS -->


			<div class="row">

				<div class="col-md-6">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-comments"></i>Top 5 Frequent Members
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable">
								<table class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>
												Name
											</th>
											<th>
												Mobile
											</th>
											<th>
												No. Of Order
											</th>
											<th>
												Total Order Amount (CM)
											</th>

										</tr>
									</thead>
									<tbody>
										@forelse($customerData as $customer)
										<tr class="success">
											<td>
												{{ $customer->name }}
											</td>
											<td>
												{{ $customer->contactno }}
											</td>
											<td>
												{{ $customer->noOfOrder }}
											</td>
											<td>
												BDT. {{ $customer->totalOrderAmountCM }}
											</td>

										</tr>
										@empty
										<tr class="info">
											<td colspan="5" class="text-center">
												<span>No Recors Found!</span>
											</td>
										</tr>
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<!-- BEGIN CHART PORTLET-->
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-bar-chart font-green-haze"></i>
								<span class="caption-subject bold uppercase font-green-haze"> Payment Mode Wise Statistics</span>
							</div>
						</div>
						<div class="portlet-body">
							<div id="chart_7" class="chart" style="height: 300px;">
							</div>

						</div>
					</div>
					<!-- END CHART PORTLET-->
				</div>
			</div>

		</div>
	</div>
	<!-- END PAGE CONTENT-->
</div>
@endsection
@section('extra_js')
<script>
	var ChartsAmcharts = function() {
		var initChartSample7 = function() {

			var mode_data = "{{ $modeData }}";
		// console.log(JSON.parse(channel_data.replace(/&quot;/g,'"')));

		var chart = AmCharts.makeChart("chart_7", {
			"type": "pie",
			"theme": "light",

			"fontFamily": 'Open Sans',

			"color":    '#888',

			"dataProvider": JSON.parse(mode_data.replace(/&quot;/g,'"')),
			"valueField": "value",
			"titleField": "mode",
			"outlineAlpha": 0.4,
			"depth3D": 15,
			"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
			"angle": 30,
			"exportConfig": {
				menuItems: [{
					icon: '/lib/3/images/export.png',
					format: 'png'
				}]
			}
		});
	};

	return {
        //main function to initiate the module

        init: function() {
        	initChartSample7();
        }
    };

}();
jQuery(document).ready(function() {    
	ChartsAmcharts.init();
});
</script>
@endsection