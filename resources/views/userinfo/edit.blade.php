@extends('common.layout')
@section('content')
<div class="page-content">
	
	<!-- BEGIN PAGE HEADER-->
	<h3 class="page-title">
	Userinfo <small>create and edit</small>
	</h3>
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<i class="fa fa-dashboard"></i>
				<a href="{{ route('dashboard.index') }}">Dashboard</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="{{ route('userinfo.index') }}">Userinfo</a>
				<i class="fa fa-angle-right"></i>
			</li>
			<li>
				<a href="#">Edit User Info</a>
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
						<i class="fa fa-user"></i> Edit User Info
					</div>
					<!-- <div class="tools">
						<a href="" class="collapse">
						</a>
						<a href="#portlet-config" data-toggle="modal" class="config">
						</a>
						<a href="" class="reload">
						</a>
						<a href="" class="remove">
						</a>
					</div> -->
				</div>
				<div class="portlet-body form">
					@include('common.alert')
					<form class="form-horizontal" action="{{ route('userinfo.update') }}" method="post" role="form">
                        {{ csrf_field() }}
						<div class="form-body">
							<div class="form-group">
								<label class="col-md-3 control-label required">Full Name</label>
								<div class="col-md-9 {{ $errors->has('fullName') ? 'has-error' : '' }}">
									<input type="text" class="form-control" name="fullName" value="{{ old('fullName') ? old('fullName') : $userInfo['fullname'] }}" placeholder="Full Name">
									<span class="help-block">
									enter your full name. </span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label required">Mobile No</label>
								<div class="col-md-9 {{ $errors->has('mobileNo') ? 'has-error' : '' }}">
									<div class="input-icon">
										<i class="fa fa-phone-square"></i>
										<input type="text" class="form-control" name="mobileNo" value="{{ old('mobileNo') ? old('mobileNo') : $userInfo['contactno'] }}" placeholder="Mobile No">
										@if ($errors->has('mobileNo'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('mobileNo') }}</strong>
	                                    </span>
	                                	@endif
                                	</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Date of Birth</label>
								<div class="col-md-9">
									<div class="input-icon">
										<i class="fa fa-calendar"></i>
										<input class="form-control date-picker" name="dob" value="{{ old('dob') ? old('dob') : convertMySQLDateToWebFormat($userInfo['dateofbirth']) }}" size="16" type="text" placeholder="dd-mm-yyyy" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Gender</label>
								<div class="col-md-9">
									<div class="radio-list">
										<label class="radio-inline">
										<input type="radio" name="gender" value="1" {{ ( old('gender') != 2 || $userInfo['gender'] == 1 ) ? 'checked' : '' }}  > Male </label>
										<label class="radio-inline">
										<input type="radio" name="gender" value="2" {{ ( old('gender') == 2 || $userInfo['gender'] == 2 ) ? 'checked' : '' }}  > Female </label>
										<label class="radio-inline">
										<input type="radio" name="gender" value="3" {{ ( old('gender') == 3 || $userInfo['gender'] == 3 ) ? 'checked' : '' }}  > Other </label>
									</div>
								</div>
							</div>
							<div class="form-group ">
								<label class="col-md-3 control-label required">Email Address</label>
								<div class="col-md-9 {{ $errors->has('email') ? 'has-error' : '' }}">
									<div class="input-icon">
										<i class="fa fa-envelope"></i>
										<input type="text" class="form-control" name="email" value="{{ old('email') ? old('email') : $userInfo['email'] }}"  placeholder="Email Address" disabled>
									</div>
									@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                	@endif
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label required">User Type</label>
								<div class="col-md-9 {{ $errors->has('userType') ? 'has-error' : '' }}">
									<select class="form-control select2me" name="userType" id="usertype">
										<option value="">- select a type -</option>
										@foreach ($alluserType as $typeId => $typeName )
										<option value="{{ $typeId }}" {{ ( $userInfo['usertype'] == $typeId ) ? 'selected' : '' }} >{{ $typeName }}</option>
										@endforeach
									</select>
									@if ($errors->has('userType'))
                                    <span class="help-block has-error">
                                        <strong>{{ $errors->first('userType') }}</strong>
                                    </span>
	                                @endif
								</div>
							</div>
							<div class="form-group" id="restaurant">
								<label class="col-md-3 control-label required">Restaurant</label>
								<div class="col-md-9 {{ $errors->has('restaurant') ? 'has-error' : '' }}">
									<select class="form-control select2me" name="restaurant" id="restaurantid">
										<option value="">- select an option -</option>
										@foreach ($allRestaurant=getRestaurantByUserType() as $resid => $resname )
										<option value="{{ $resid }}"  {{ $userInfo['restaurantid'] == $resid ? 'selected' : '' }} >
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
							<div class="form-group" id="kitchen">
								<label class="col-md-3 control-label required">Kitchen</label>
								<div class="col-md-9 {{ $errors->has('kitchen') ? 'has-error' : '' }}">
									<select class="form-control select2" name="kitchen[]" id="kitchenid" multiple>
										<?php 
											$kitchenids = array();
											if ( isset($userInfo['kitchenID']) && count($userInfo['kitchenID']) > 0 ) {
												foreach ($userInfo['kitchenID'] as $kitchen ) {
													$kitchenids [] = $kitchen->kitchenid ;
												} 
											}
										?>
										@foreach ($alluserType=getKitchensbyRestaurant($userInfo['restaurantid']) as $kitchenid => $kitchenname )
										<option value="{{ $kitchenid }}" {{ in_array( $kitchenid , $kitchenids ) ? 'selected' : '' }} >
											{{ $kitchenname }}
										</option>
										@endforeach
									</select>
									@if ($errors->has('kitchen'))
                                    <span class="help-block has-error">
                                        <strong>{{ $errors->first('kitchen') }}</strong>
                                    </span>
	                                @endif
	                                <label>
										<input type="checkbox" id="checkbox_kitchen" >Select All Kitchen
	                                </label>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Status</label>
								<div class="col-md-9">
									<div class="radio-list">
										<label class="radio-inline">
										<input type="radio" name="isActive" value="1" {{ ( old('isActive') != 2 || $userInfo['isactive'] == 1 ) ? 'checked' : '' }}  > Active </label>
										<label class="radio-inline">
										<input type="radio" name="isActive" value="0" {{ ( old('isActive') == 2 || $userInfo['isactive'] == 0 ) ? 'checked' : '' }}  > Inactive </label>
									</div>
								</div>
							</div>
							<input type="hidden" name="userId" value="{{ $userInfo['userid'] }}">
						</div>

						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn green">Submit</button>
									<button type="reset" class="btn red">Reset</button>
									<a href="{{ route('userinfo.index') }}" class="btn default">Cancel</a>
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
$(document).ready(function(){

	var usertype = $('#usertype').val();
	if (usertype == -1) {
	    $("#kitchen").hide();
	    $("#restaurant").hide();
	}
	else if(usertype == 1 ){
	    $("#kitchen").hide();
	}
	
    $('#usertype').on('change', function() {
		if ( this.value == '1'  )
		{
		    $("#restaurant").show();
			$("#kitchen").hide();
		}
		else if ( this.value == '2' || this.value == '3' || this.value == '4')
		{
		    $("#restaurant").show();
			$("#kitchen").show();
		}
		else
		{
		    $("#restaurant").hide();
			$("#kitchen").hide();
		}
    });

    $('#restaurantid').on('change', function() {
    	var resID = this.value;
    	$.ajax({
	        method: "POST",
	        url: "{{ url('ajax/kitchen') }}",
	        dataType: "json",
	        data: { _token: "{{ csrf_token() }}" , res_id : resID }
	    }).done(function( resultData ) {
	    	console.log(resultData);
	        if( resultData.msg && resultData.msg=='success' && resultData.data && resultData.data.length > 0 ) {
	            var _data = resultData.data;
	            var _optValue = '';
	            for( var i=0; i<resultData.data.length; i++ ) {
	            	// _optValue="<option value='-1'>All</option>";
	                _optValue+= '<option value="'+resultData.data[i].kitchenid+'">'+resultData.data[i].kitchenname+'</option>';
	            }
	            $('#kitchenid').find('option').remove().end().append(_optValue);
	        } else if( resultData.msg && resultData.msg=='nodata' ) {
	            $('#kitchenid').find('option').remove();
	        }
	    });

    });

    $("#checkbox_kitchen").click(function(){
	    if($("#checkbox_kitchen").is(':checked') ){
	        $("#kitchenid > option").prop("selected","selected");
	        $("#kitchenid").trigger("change");
	    }else{
	        $("#kitchenid > option").removeAttr("selected");
	         $("#kitchenid").trigger("change");
	     }
	});

$('#kitchenid').select2({
    dropdownAutoWidth: true,
    multiple: true,
    width: '100%',
    height: '30px',
    placeholder: "Select",
    allowClear: true
});

});
</script>
@endsection