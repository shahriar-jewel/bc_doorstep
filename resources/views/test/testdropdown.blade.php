@extends('common.layout')


@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		Restaurant <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('testdropdown') }}">Restaurant</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Add New</a>
				</li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				 <div class="portlet box green-haze ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-home"></i> Create New Restaurant
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal form-row-seperated" action="{{ route('testdropdown') }}" method="post" role="form" >
	                        {{ csrf_field() }}
							<div class="form-body">
								<div class="form-group">
									<label class="control-label col-md-3">Default</label>
									<div class="col-md-9">
										<select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]">
											<!-- <option>Dallas Cowboys</option>
											<option>New York Giants</option>
											<option >Philadelphia Eagles</option>
											<option >Washington Redskins</option>
											<option>Chicago Bears</option>
											<option>Detroit Lions</option>
											<option>Green Bay Packers</option>
											<option>Minnesota Vikings</option>
											<option >Atlanta Falcons</option>
											<option>Carolina Panthers</option>
											<option>New Orleans Saints</option>
											<option>Tampa Bay Buccaneers</option>
											<option>Arizona Cardinals</option>
											<option>St. Louis Rams</option>
											<option>San Francisco 49ers</option>
											<option>Seattle Seahawks</option> -->
											@foreach($bloodgroup as $id => $value)
												<option value="{{ $id }}">{{ $value }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Submit</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
@endsection

