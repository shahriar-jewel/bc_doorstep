@extends('auth.layout')
@section('content')
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="{{ route('login') }}" method="post">
		{{ csrf_field() }}
		<h3 class="form-title">Sign In</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any username and password. </span>
		</div>
		<span class="help-block">
			@include('common.alert')
            @if (count($errors) > 0)
                <div class="alert alert-danger" data-close="alert">
                	<button class="close" data-close="alert"></button>
                    <ul>
                        @foreach ($errors as $error)
                          @if (strlen($error) > 0)
                            <li>{{ $error }}</li>
                          @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </span>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Username</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
			</div>
		</div>

		<div class="form-actions">
			<label class="checkbox">
			<input type="checkbox" name="remember" value="1"/> Remember me </label>
			<button type="submit" class="btn blue pull-right">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="login-options">
			<!-- <h4>Or login with</h4>
			<ul class="social-icons">
				<li>
					<a class="social-icon-color facebook" data-original-title="facebook" href="#"></a>
				</li>
				<li>
					<a class="social-icon-color twitter" data-original-title="Twitter" href="#"></a>
				</li>
				<li>
					<a class="social-icon-color googleplus" data-original-title="Goole Plus" href="#"></a>
				</li>
				<li>
					<a class="social-icon-color linkedin" data-original-title="Linkedin" href="#"></a>
				</li>
			</ul> -->
		</div>
		<div class="forget-password">
			<h4>Forgot your password ?</h4>
			<p>
				 no worries, click <a href="{{ route('forgetpassword') }}" >
				here </a>
				to reset your password.
			</p>
		</div>
	</form>
	<!-- END LOGIN FORM -->
	
	<!--  include Forget Password form   -->
	{{-- @include('auth.forget_password')  --}}

	<!--  include Registration form   -->
	{{-- @include('auth.registration') --}}
@endsection
