<div id="Main">
<h1>Welcome to iWarz</h1>
<?php 

if( $_SESSION[errors] ) {
	echo( "<h2>Errors</h2>\n" );
	echo( $_SESSION[errorlist] );
}
$_SESSION[errors] = false;
$_SESSION[errorlist] = "";

?>
<h2>Log in</h2>
<form action="?request=login" method="POST">
<table class="noBorderBackground">
	<tr>
		<td>Username</td>
		<td><input type="TEXT" name="username" maxlength=20></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="PASSWORD" name="password" maxlength=15></td>
	</tr>
	<tr>
		<td>Remember</td> 
		<td><input type="CHECKBOX" name="remember"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="SUBMIT" value="Log in" class="submitbutton"> <a>Forgot password</a></td>
	</tr>
</table>
</form>
<h2>Register</h2>
<form id="RegisterForm" action="?request=register" method="POST">
<table class="noBorderBackground">
	<tr>
		<td>Username</td>
		<td><input type="TEXT" name="username" maxlength="20" class="memorize" onKeyUp="CheckUsername();"></td>
		<td id="ErrorCellUsername"></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="PASSWORD" name="password1" maxlength="15" onKeyUp="CheckPasswords();"></td>
		<td rowspan="2" id="ErrorCellPasswords"></td>
	</tr>
	<tr>
		<td>Repeat password</td>
		<td><input type="PASSWORD" name="password2" maxlength="15" onKeyUp="CheckPasswords();"></td>
	</tr>
	<tr>
		<td>Email</td>
		<td><input type="TEXT" name="email" maxlength="50" class="memorize" onKeyUp="CheckEmail();"></td>
		<td id="ErrorCellEmail"></td>
	</tr>
	<tr>
		<td>Color</td>
		<td>
			<select name="team" class="memorize">
				<option value="">Select color</option>
				<option value="1">Red</option>
				<option value="2">Black</option>
				<option value="3">Orange</option>
				<option value="4">Green</option>
			</select>
		</td>
		<td id="ErrorCellTeam"></td>
	</tr>
	<tr>
		<td colspan="3"><input type="SUBMIT" value="Register" class="submitbutton"></td>
	</tr>
</table>
</form>
<?php DrawTable( "DOMINATION", "NONE", "", false, "Game overview" ); ?>
</div>