<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table>
		<tr><td>Dear User</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Please click on below link to reset your Password :-:</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><a href="{{ url('/user/reset-password/'.$code) }}">Reset Password</a></td></tr>
		<tr><td>&nbsp;</td></tr>	
		<tr><td>&nbsp;</td></tr>
		<tr><td>Thanks & Regards,</td></tr>
		<tr><td>Stack Developers</td></tr>
	</table>
</body>
</html>