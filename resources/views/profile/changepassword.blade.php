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
					<a href="#">Change Password</a>
				</li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				 <div class="portlet green-haze box ">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-cogs"></i> Change Password
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('profile.changepassword') }}" method="post" role="form">
	                        {{ csrf_field() }}
	                        <input type="hidden" name="profileId" value="{{ session()->get('user.userid') }}">
							<div class="form-body">
								
								<div class="form-group">
									<label class="col-md-3 control-label">Old Password</label>
									<div class="col-md-9 {{ $errors->has('oldpassword') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-lock fa-fw"></i>
											<input type="password" class="form-control" name="oldpassword" placeholder="Old Password">
										</div>
										@if ($errors->has('oldpassword'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('oldpassword') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">New Password</label>
									<div class="col-md-9 {{ $errors->has('newpassword') ? 'has-error' : '' }}">
										<div class="input-icon">
											<i class="fa fa-lock fa-fw"></i>
											<input type="password" class="form-control" name="newpassword" placeholder="New Password">
										</div>
										@if ($errors->has('newpassword'))
	                                    <span class="help-block has-error">
	                                        <strong>{{ $errors->first('newpassword') }}</strong>
	                                    </span>
		                                @endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Re-Type Password</label>
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

							</div>

							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
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
