<?php 
	session_start();
		include_once 'include/functions.php';
		$user = new User();
		$dbClass = new DB_Class();
		$db = $dbClass -> open();
		
		if($user->get_session()){
			header("location:index.php");
		}
		
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$login = $user->check_login($db, $_POST['emailusername'], $_POST['userPassReal']);
			if($login){
				header("Location: index.php");
			}
			else{
				$msg = 'Wrong username / password<br/>';
			}
		}
?>

		<script src="include/sha.js"></script>
		<script>
			function pass(){
				var password = document.getElementById("password").value;
				var newpass = hex_sha512(password);
				document.getElementById("userPassReal").value = newpass;
				return true;
			}
		</script>

		
			
				<h1>Login</h1>
			
			<div class="loginregist">
				<form method="POST" action="" name="login" onsubmit="pass();">
					<span style="color:green;">
						<?php
							if(isset($msg)){
								echo $msg;
							}
						?>
					</span>
					<br/>	
					<table>					
						<tr>
							<td class="veldnaam">Email or Username</td>							
							<td><input type="text" name="emailusername"  class="veld" placeholder="Enter Username/Email" required/></td>
						</tr>
						<tr>
							<td class="veldnaam">Password</td>							
							<td><input type="password" name="password" id="password"  class="veld"  placeholder="Enter Password" required/></td>
						</tr>
						<tr>
							<td></td>
							<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input class="knop" type="submit" value="Login" onsubmit="pass();"/>
							<input type="hidden" name="userPassReal" id="userPassReal"></td>
						</tr>
						<tr>
							<td>No account yet <a href="registration.php">register<a/></td>
						</tr>
					</table>
				</form>
			</div>
		
