@extends('common.layout')
@section('content')
		<div class="page-content">
			
			<!-- BEGIN PAGE HEADER-->
			<h3 class="page-title">
			Profile <small>view and edit</small>
			</h3>
			<div class="page-bar">
				<ul class="page-breadcrumb">
					<li>
						<i class="fa fa-home"></i>
						<a href="{{ route('dashboard.index') }}">Home</a>
						<i class="fa fa-angle-right"></i>
					</li>
					<li>
						<a href="{{ route('profile.view') }}">Profile</a>
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
				<div class="col-md-12 col-sm-12">
					<div class="portlet green-haze box">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cogs"></i>Edit Profile Information
							</div>
						</div>
						<div class="portlet-body form">
							@include('common.alert')
							<form class="form-horizontal" action="{{ route('profile.edit') }}" method="post" role="form">
	                        {{ csrf_field() }}
	                        <input type="hidden" name="profileId" value="{{ session()->get('doorstepuser.userid') }}">
	                        <div class="form-body">
								<div class="row static-info">
									<div class="col-md-5 name">
										 Full Name:
									</div>
									<div class="col-md-7 value">
										<input type="text" class="form-control" name="fullName" value="{{ old('fullName') ? old('fullName') : session()->get('doorstepuser.fullname')  }}" placeholder="Full Name">
										@if ($errors->has('fullName'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('fullName') }}</strong>
	                                    </span>
	                                	@endif 
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										 Email:
									</div>
									<div class="col-md-7 value">
										{{ session()->get('doorstepuser.email')  }}
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										 Phone Number:
									</div>
									<div class="col-md-7 value">
										<input type="text" class="form-control" name="mobileNo" value="{{ old('mobileNo') ? old('mobileNo') : session()->get('doorstepuser.contactno')  }}" placeholder="Mobile No">
										@if ($errors->has('mobileNo'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('mobileNo') }}</strong>
	                                    </span>
	                                	@endif 

									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										 Gender:
									</div>
									<div class="col-md-7 value">
										<div class="radio-list">
											<label class="radio-inline">
											<input type="radio" name="gender" value="1" {{ ( old('gender') != 2 || session()->get('doorstepuser.gender') == 1 ) ? 'checked' : '' }}  > Male </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="2" {{ ( old('gender') == 2 || session()->get('doorstepuser.gender') == 2 ) ? 'checked' : '' }}  > Female </label>
											<label class="radio-inline">
											<input type="radio" name="gender" value="3" {{ ( old('gender') == 3 || session()->get('doorstepuser.gender') == 3 ) ? 'checked' : '' }}  > Other </label>
										</div>
									</div>
								</div>
								<div class="row static-info">
									<div class="col-md-5 name">
										 Date of Birth:
									</div>
									<div class="col-md-7 value">
										<input class="form-control date-picker" name="dob" value="{{ old('dob') ? old('dob') : convertMySQLDateToWebFormat(session()->get('doorstepuser.dateofbirth')) }}" size="16" type="text" placeholder="dd-mm-yyyy" data-date="12-02-2012" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-5 col-md-7">
										<button type="submit" class="btn green">Submit</button>
										<button type="reset" class="btn red">Reset</button>
										<a href="{{ route('profile.view') }}" class="btn default">Cancel</a>
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
