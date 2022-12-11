@extends('auth.layout')
@section('content')
	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="" action="{{ route('forgetpassword') }}" method="post">
		{{ csrf_field() }}
		<h3>Forget Password ?</h3>
		<p>
			 Enter your e-mail address below to reset your password.
		</p>
		@include('common.alert')
		<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
			<div class="input-icon">
				<i class="fa fa-envelope"></i>
				<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" />
				@if ($errors->has('email'))
	            <span class="help-block has-error">
	                <strong>{{ $errors->first('email') }}</strong>
	            </span>
	            @endif
			</div>
		</div>
		
		<div class="form-actions">
			<a href="{{ route('login') }}" class="btn btn-default">
			<i class="m-icon-swapleft"></i> Back </a>
			<button type="submit" class="btn blue pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="create-account">
		</div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
@endsection