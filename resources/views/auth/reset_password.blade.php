@extends('auth.layout')
@section('content')
	<!-- BEGIN RESET PASSWORD FORM -->
	<form class="" action="{{ route('password.reset',$resetToken) }}" method="post">
		{{ csrf_field() }}
		<h3>Reset Your Password </h3>
		<p>
			 Enter your new password below to reset your password.
		</p>
		<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="New Password" name="password" value="{{ old('password') }}" />
				@if ($errors->has('password'))
	            <span class="help-block has-error">
	                <strong>{{ $errors->first('password') }}</strong>
	            </span>
	            @endif
	        </div>
		</div>
		<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Password" name="password_confirmation" value="{{ old('password_confirmation') }}" />
				@if ($errors->has('password_confirmation'))
	            <span class="help-block has-error">
	                <strong>{{ $errors->first('password_confirmation') }}</strong>
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
	<!-- END RESET PASSWORD FORM -->
@endsection