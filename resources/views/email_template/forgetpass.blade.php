<!DOCTYPE html>
<html>
<head>
	<title>Password Reset Email</title>
</head>
<body>
	<p>You are receiving this email because we received a password reset request for your account. Click the link below to reset your password:</p>
	<p>Click here to reset your password: {!! url('password/reset/'.$token) !!} </p>
	<p>If you did not request a password reset, no further action is required.</p>
</body>
</html>