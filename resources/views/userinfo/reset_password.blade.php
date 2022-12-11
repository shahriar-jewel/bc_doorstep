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
					<a href="#">Reset Password</a>
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
							<i class="fa fa-cog"></i> Reset Password
						</div>
					</div>
					<div class="portlet-body form">
						@include('common.alert')
						<form class="form-horizontal" action="{{ route('userinfo.resetpassword', $userInfo['userid'] ) }}" method="post" role="form">
	                        {{ csrf_field() }}
							<div class="form-body">
								<div class="form-group">
									<label class="col-md-3 control-label">Full Name</label>
									<div class="col-md-9">
										<span class="form-control-static">
											{{ $userInfo['fullname'] }}
										</span>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Password</label>
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
