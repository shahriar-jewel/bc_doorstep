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
							<i class="fa fa-user"></i> Create New User
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('userinfo.store') }}" method="post" role="form">
	                        {{ csrf_field() }}
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label required">Full Name</label>
									<div class="col-md-9 {{ $errors->has('fullName') ? 'has-error' : '' }}">
										<input type="text" class="form-control" name="fullName" value="{{ old('fullName') }}" placeholder="Full Name">
										<span class="help-block">
										enter your full name. </span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label required">Mobile No</label>
									<div class="col-md-9 {{ $errors->has('mobileNo') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-phone-square"></i>
											<input type="text" class="form-control" name="mobileNo" value="{{ old('mobileNo') }}" placeholder="Mobile No">
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
											<input class="form-control date-picker" name="dob" value="{{ old('dob') }}" size="16" type="text" placeholder="dd-mm-yyyy" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Gender</label>
									<div class="col-md-9">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="gender" value="1" {{ old('gender') != 2 && old('gender') != 3 ? 'checked' : '' }}  > Male </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="2" {{ old('gender') == 2 ? 'checked' : '' }}  > Female </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="3" {{ old('gender') == 3 ? 'checked' : '' }}  > Other </label>
										</div>
									</div>
								</div>
								<div class="form-group ">
									<label class="col-md-3 control-label required">Email Address</label>
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
								<div class="form-group">
									<label class="col-md-3 control-label required">Password</label>
									<div class="col-md-9 {{ $errors->has('password') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-lock fa-fw"></i>
											<input type="password" class="form-control" name="password" placeholder="Password">
										</div>
										@if ($errors->has('password'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('password') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label required">Re-Type Password</label>
									<div class="col-md-9 {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-lock fa-fw"></i>
											<input type="password" class="form-control"  name="password_confirmation" placeholder="Re-type Password">
										</div>
										@if ($errors->has('password_confirmation'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>
								
								

								<div class="form-group">
									<label class="col-md-3 control-label required">User Type</label>
									<div class="col-md-9 {{ $errors->has('userType') ? 'has-error' : '' }}">
										<select class="form-control select2me" name="userType" id="usertype">
											<option value="">- select a type -</option>
											@foreach ($alluserType=getUserTypeByUser() as $typeId => $typeName )
											<option value="{{ $typeId }}" >
												{{ $typeName }}
											</option>
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
											@foreach ($allrestaurant=getRestaurantByUserType() as $resid => $resname )
											<option value="{{ $resid }}" >
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
											<!-- <option value="">- select an option -</option> -->
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
    $("#kitchen").hide();
    $("#restaurant").hide();
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
