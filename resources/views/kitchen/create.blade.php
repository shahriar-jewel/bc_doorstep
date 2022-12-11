@extends('common.layout')
@section('extra_css')
<style type="text/css">
	div.checker {
    	margin-top: 2px;
    	margin-left: -2px;
	}
</style>
@endsection
@section('content')
	<div class="page-content">
		
		<!-- BEGIN PAGE HEADER-->
		<h3 class="page-title">
		Kitchen <small>create and edit</small>
		</h3>
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-dashboard"></i>
					<a href="{{ route('dashboard.index') }}">Dashboard</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('restaurant.index') }}">Restaurant</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="{{ route('kitchen.index') }}">Kitchen</a>
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
							<i class="fa fa-home"></i> Create New Kitchen
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('kitchen.store') }}" method="post" role="form">
	                        {{ csrf_field() }}
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label required">Restaurant</label>
									<div class="col-md-9 {{ $errors->has('restaurant') ? 'has-error' : '' }}">
										<select class="form-control select2me" name="restaurant" >
											<option value="">- select an option -</option>
											@foreach ($allRestaurants=getRestaurantByUserType() as $resid => $resname )
											<option value="{{ $resid }}" {{ old('restaurant') == $resid ? 'selected' : '' }}>
												{{ $resname }}
											</option>
											@endforeach
										</select>
										@if ($errors->has('restaurant'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('restaurant') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label required">Kitchen Name</label>
									<div class="col-md-9 {{ $errors->has('kitchenname') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="kitchenname" value="{{ old('kitchenname') }}" placeholder="Kitchen Name" required="">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label required">Contact No</label>
									<div class="col-md-9 {{ $errors->has('contactno') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-phone-square"></i>
											<input type="text" class="form-control" name="contactno" value="{{ old('contactno') }}" placeholder="Contact No" required="">
											@if ($errors->has('contactno'))
		                                    <span class="help-block">
		                                        <strong>{{ $errors->first('contactno') }}</strong>
		                                    </span>
		                                	@endif
	                                	</div>
									</div>
								</div>
								
								<div class="form-group ">
									<label class="col-md-3 control-label">Email Address</label>
									<div class="col-md-9 {{ $errors->has('email') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-envelope"></i>
											<input type="text" class="form-control" name="email" value="{{ old('email') }}"  placeholder="Email Address">
										</div>
										@if ($errors->has('email'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('email') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>

								<div class="form-group ">
									<label class="col-md-3 control-label">Address</label>
									<div class="col-md-9 {{ $errors->has('address') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="address" value="{{ old('address') }}" id="address" placeholder="Address">
										<button type="button" class="btn blue" id="btn-map">Get lat long</button>
										@if ($errors->has('address'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('address') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Latitude</label>
									<div class="col-md-3" >
										<input type="text" class="form-control" name="lat" id="lat" value="0" readonly>
									</div>
									<label class="col-md-2 control-label">Longitude</label>
									<div class="col-md-3">
										<input type="text" class="form-control" name="lng" id="lng" value="0" readonly>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-3 col-md-9">
										<div id="map" class="gmaps">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Other Detail</label>
									<div class="col-md-9 {{ $errors->has('name') ? 'has-error' : '' }}">
										<textarea class="form-control" name="otherdetail" rows="3" cols="4" placeholder="Other Detail">{{ old('otherdetail') }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Min-Order Amount</label>
									<div class="col-md-9 {{ $errors->has('minorderamount') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="minorderamount" value="{{ old('minorderamount') }}" placeholder="Min-Order">
										@if ($errors->has('minorderamount'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('minorderamount') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Min-Delivery Time</label>
									<div class="col-md-9 {{ $errors->has('mindeliverytime') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="mindeliverytime" value="{{ old('mindeliverytime') }}" placeholder="Min-Delivery Time ( in minutes )">
										<span class="help-block">
										example: 30 </span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Saturday : 
									</label>
									<div class="col-md-5">
										<div class="input-group input-large">
											<!-- <input type="text" class="form-control" name="product[available_from]"> -->
											<input class="form-control timepicker timepicker-no-seconds-open" name="satstarttime" value="{{ old('satstarttime') }}">
											<span class="input-group-addon">
											to </span>
											<input class="form-control timepicker timepicker-no-seconds-end" name="satendtime" value="{{ old('satendtime') }}">
											<!-- <input type="text" class="form-control" name="product[available_to]"> -->
										</div>
										<span class="help-block">
										availability timerange. </span>
									</div>
									<div class="col-md-4">
										<input type="checkbox" value="1" name="satcheck" class="make-switch" data-on-text="&nbsp;Open&nbsp;&nbsp;" data-off-text="&nbsp;Close&nbsp;" checked >
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Sunday : 
									</label>
									<div class="col-md-5">
										<div class="input-group input-large">
											<!-- <input type="text" class="form-control" name="product[available_from]"> -->
											<input class="form-control timepicker timepicker-no-seconds-open" name="sunstarttime" value="{{ old('sunstarttime') }}">
											<span class="input-group-addon">
											to </span>
											<input class="form-control timepicker timepicker-no-seconds-end" name="sunendtime" value="{{ old('sunendtime') }}">
											<!-- <input type="text" class="form-control" name="product[available_to]"> -->
										</div>
										<span class="help-block">
										availability timerange. </span>
									</div>
									<div class="col-md-4">
										<input type="checkbox" value="1" name="suncheck" class="make-switch" data-on-text="&nbsp;Open&nbsp;&nbsp;" data-off-text="&nbsp;Close&nbsp;" checked >
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Monday : 
									</label>
									<div class="col-md-5">
										<div class="input-group input-large">
											<!-- <input type="text" class="form-control" name="product[available_from]"> -->
											<input class="form-control timepicker timepicker-no-seconds-open" name="monstarttime" value="{{ old('monstarttime') }}">
											<span class="input-group-addon">
											to </span>
											<input class="form-control timepicker timepicker-no-seconds-end" name="monendtime" value="{{ old('monendtime') }}">
											<!-- <input type="text" class="form-control" name="product[available_to]"> -->
										</div>
										<span class="help-block">
										availability timerange. </span>
									</div>
									<div class="col-md-4">
										<input type="checkbox" value="1" name="moncheck" class="make-switch" data-on-text="&nbsp;Open&nbsp;&nbsp;" data-off-text="&nbsp;Close&nbsp;" checked >
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Tuesday : 
									</label>
									<div class="col-md-5">
										<div class="input-group input-large">
											<!-- <input type="text" class="form-control" name="product[available_from]"> -->
											<input class="form-control timepicker timepicker-no-seconds-open" name="tuestarttime" value="{{ old('tuestarttime') }}">
											<span class="input-group-addon">
											to </span>
											<input class="form-control timepicker timepicker-no-seconds-end" name="tueendtime" value="{{ old('tueendtime') }}">
											<!-- <input type="text" class="form-control" name="product[available_to]"> -->
										</div>
										<span class="help-block">
										availability timerange. </span>
									</div>
									<div class="col-md-4">
										<input type="checkbox" value="1" name="tuecheck" class="make-switch" data-on-text="&nbsp;Open&nbsp;&nbsp;" data-off-text="&nbsp;Close&nbsp;" checked >
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Wednesday : 
									</label>
									<div class="col-md-5">
										<div class="input-group input-large">
											<!-- <input type="text" class="form-control" name="product[available_from]"> -->
											<input class="form-control timepicker timepicker-no-seconds-open" name="wedstarttime" value="{{ old('wedstarttime') }}">
											<span class="input-group-addon">
											to </span>
											<input class="form-control timepicker timepicker-no-seconds-end" name="wedendtime" value="{{ old('wedendtime') }}">
											<!-- <input type="text" class="form-control" name="product[available_to]"> -->
										</div>
										<span class="help-block">
										availability timerange. </span>
									</div>
									<div class="col-md-4">
										<input type="checkbox" value="1" name="wedcheck" class="make-switch" data-on-text="&nbsp;Open&nbsp;&nbsp;" data-off-text="&nbsp;Close&nbsp;" checked >
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Thursday : 
									</label>
									<div class="col-md-5">
										<div class="input-group input-large">
											<!-- <input type="text" class="form-control" name="product[available_from]"> -->
											<input class="form-control timepicker timepicker-no-seconds-open" name="thustarttime" value="{{ old('thustarttime') }}">
											<span class="input-group-addon">
											to </span>
											<input class="form-control timepicker timepicker-no-seconds-end" name="thuendtime" value="{{ old('thuendtime') }}">
											<!-- <input type="text" class="form-control" name="product[available_to]"> -->
										</div>
										<span class="help-block">
										availability timerange. </span>
									</div>
									<div class="col-md-4">
										<input type="checkbox" value="1" name="thucheck" class="make-switch" data-on-text="&nbsp;Open&nbsp;&nbsp;" data-off-text="&nbsp;Close&nbsp;" checked >
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Friday : 
									</label>
									<div class="col-md-5">
										<div class="input-group input-large">
											<!-- <input type="text" class="form-control" name="product[available_from]"> -->
											<input class="form-control timepicker-no-seconds-open" name="fristarttime" value="{{ old('fristarttime') }}">
											<span class="input-group-addon">
											to </span>
											<input class="form-control timepicker-no-seconds-end" name="friendtime" value="{{ old('friendtime') }}">
											<!-- <input type="text" class="form-control" name="product[available_to]"> -->
										</div>
										<span class="help-block">
										availability timerange. </span>
									</div>
									<div class="col-md-4">
										<input type="checkbox" value="1" name="fricheck" class="make-switch" data-on-text="&nbsp;Open&nbsp;&nbsp;" data-off-text="&nbsp;Close&nbsp;" checked >
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="is_active" value="1" {{ old('is_active') != '0' ? 'checked' : '' }}  > Open </label>
											<label class="radio-inline">
											<input type="radio" name="is_active" value="0" {{ old('is_active') == '0' ? 'checked' : '' }}  > Closed </label>
											<label class="radio-inline">
										</div>
									</div>
								</div>
								
							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green">Submit</button>
										<button type="reset" class="btn red">Reset</button>
										<a href="{{ route('kitchen.index') }}" class="btn default">Cancel</a>
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

@section('extra_js')
<script type="text/javascript">
	$("#checkbox_zone").click(function(){
	    if($("#checkbox_zone").is(':checked') ){
	        $("#select2_multiple > option").prop("selected","selected");
	        $("#select2_multiple").trigger("change");
	    }else{
	        $("#select2_multiple > option").removeAttr("selected");
	         $("#select2_multiple").trigger("change");
	     }
	});
</script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}"></script>

<script type="text/javascript" src="{{ URL::asset('assets/custom/js/map.js') }}" ></script>
@endsection
