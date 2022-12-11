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
					<a href="{{ route('restaurant.index') }}">Restaurant</a>
					<i class="fa fa-angle-right"></i>
				</li>
				<li>
					<a href="#">Edit</a>
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
							<i class="fa fa-home"></i> Edit Restaurant
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('restaurant.update') }}" method="post" role="form">
	                        {{ csrf_field() }}
							<input type="hidden" name="resid" value="{{ $restaurant['restaurantid'] }}">

							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label required">Name</label>
									<div class="col-md-9 {{ $errors->has('name') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $restaurant['name'] }}" placeholder="Name">
										@if ($errors->has('name'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('name') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label required">Contact No</label>
									<div class="col-md-9 {{ $errors->has('contactno') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-phone-square"></i>
											<input type="text" class="form-control" name="contactno" value="{{ old('contactno') ? old('contactno') : $restaurant['contactno'] }}" placeholder="Contact No">
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
											<input type="text" class="form-control" name="email" value="{{ old('email') ? old('email') : $restaurant['email'] }}"  placeholder="Email Address">
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
										<input type="text" class="form-control" name="address" value="{{ old('address') ? old('address') : $restaurant['address'] }}"  placeholder="Address">
										@if ($errors->has('address'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('address') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Other Detail</label>
									<div class="col-md-9 {{ $errors->has('name') ? 'has-error' : '' }}">
										<textarea class="form-control" name="otherdetail" rows="3" cols="4" placeholder="Other Detail">{{ old('otherdetail') ? old('otherdetail') : $restaurant['otherdetail'] }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Website Url</label>
									<div class="col-md-9 {{ $errors->has('websiteurl') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="websiteurl" value="{{ old('websiteurl') ? old('websiteurl') : $restaurant['websiteurl']  }}"  placeholder="Website Url">
										@if ($errors->has('websiteurl'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('websiteurl') }}</strong>
	                                    </span>
	                                	@endif
									</div>
								</div>

								<div class="form-group" >
									<label class="col-md-3 control-label required">Restaurant Types</label>
									<div class="col-md-9 {{ $errors->has('restauranttype') ? 'has-error' : '' }}">
										<select class="form-control select2" name="restauranttype[]" id="select2_multiple" multiple>
											@foreach ($allType=getRestauranttypes() as $typeid => $typename )
											<option value="{{ $typeid }}" {{ in_array( $typeid , $typeIDs ) ? 'selected' : '' }} >
												{{ $typename }}
											</option>
											@endforeach
										</select>
										
										@if ($errors->has('restauranttype'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('restauranttype') }}</strong>
	                                    </span>
		                                @endif
		                                <label>
											<input type="checkbox" id="checkbox_restype" >Select All Restaurant Type
		                                </label>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="is_active" value="1" {{ old('is_active') != '0' || $restaurant['is_active'] == 1 ? 'checked' : '' }}  > Open </label>
											<label class="radio-inline">
											<input type="radio" name="is_active" value="0" {{ old('is_active') == '0' || $restaurant['is_active'] == '0'  ? 'checked' : '' }}  > Closed </label>
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
										<a href="{{ route('restaurant.index') }}" class="btn default">Cancel</a>
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
	$("#checkbox_restype").click(function(){
	    if($("#checkbox_restype").is(':checked') ){
	        $("#select2_multiple > option").prop("selected","selected");
	        $("#select2_multiple").trigger("change");
	    }else{
	        $("#select2_multiple > option").removeAttr("selected");
	         $("#select2_multiple").trigger("change");
	     }
	});
</script>
@endsection