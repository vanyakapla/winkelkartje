<?php
	include_once 'include/functions.php';
	include_once 'include/config.php';

	$user = new User();
	$dbClass = new DB_Class();
	$db = $dbClass -> open();
	//ingelogd checken
	if($user->get_session()){
		header("location:index.php");
	}
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		// echo $_POST['userPassReal'];
		$register = $user->register_user($db, $_POST['name'], $_POST['username'], $_POST['userPassReal'], $_POST['email']);
		if($register){
			echo'Registration successfull Click here to <a href="login.php">login<a/><br/><br/>';
		}
		else{
			echo'Registration failed. email or username alredy exists please try again';
		}
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="include/style.css" />
	</head>
	<body>
		<script src="include/sha.js"></script>
		<script>
			function pass(){
				var password = document.getElementById("password").value;
				var newpass = hex_sha512(password);
				document.getElementById("userPassReal").value = newpass;
				return true;
			}
			function checkPassword() { 
				if (document.reg.password.value != document.reg.password2.value) { 
					alert ('!!!!The passwords do not match!!!!');
					return false; 
				} 
			}
			  
		</script>
		<div class="loginmain">
			<div class="title">
					<h1>Register</h1>
			</div>
			<div class="loginregist">
				<form method="POST" action="registration.php" name="reg" onsubmit="pass();">
					<br/>	
					<table>					
						<tr>
							<td class="veldnaam">Full name</td>
							<td><input type="text" name="name" class="veld" placeholder="Enter Full name"  required/></td>
						</tr>
						<tr>
							<td class="veldnaam">Username</td>
							<td><input type="text" name="username" class="veld" placeholder="Choose Username" required/></td>
						</tr>
						<tr>
							<td class="veldnaam">Password</td>
							<td><input type="password" name="password" id="password" class="veld"  placeholder="Enter Password" required maxlength=16 /></td>
						</tr>
						<tr>
							<td class="veldnaam">Retype password</td>
							<td><input type="password" name="password2" id="password2" class="veld"  placeholder="Retype Password" required/></td>
						</tr>
						<tr>
							<td class="veldnaam">Email</td>
							<td><input type="email" name="email" class="veld" placeholder="Enter Email" required/>
							<input type="hidden" name="userPassReal" id="userPassReal"></td>
						</tr>
						<tr>
							<td></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input name="CheckPassword" class="knop" type="submit" value="Register" onClick="return checkPassword();"/></td>
						</tr>
						<tr>
							<td>Already have an account </td><td><a href="login.php">Login<a/><br/></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>