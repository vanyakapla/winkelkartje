<?php
	include_once 'config.php'; 
	
	function divlogin(){
		
			
			include_once 'include/functions.php';
			$user = new User();
			$dbClass = new DB_Class();
			$db = $dbClass -> open();
			
			if($user->get_session()){
				header("index.php");
			}
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$login = $user->check_login($db,$_POST['emailusername'], $_POST['userPassReal']);
				if($login){
					header("location:index.php");
				}
				else{
					$msg = 'Wrong username / password<br/>';
				}
			}
?>
		
		
		<div style='display:none'>
			<div id='inline_content2' style='padding:10px; background:#fff;'>
			
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
			
			
			
			</div>
		</div>
		<?php
		}
	
	
	
	
	
	
	
	
	
	
	
	class Shop{
	
	//  inhoud
	function Show(){
		$dbClass = new DB_Class();
		$db = $dbClass -> open();			
			
		echo ('<table border="0" cellpadding="1px" width="500px" class="tabel"> <form name="form1">
	<input type="hidden" name="productid" />
    <input type="hidden" name="command" />
</form>');
		$result=mysqli_query($db,"select * from producten") or die(mysql_error());
		while($row=mysqli_fetch_array($result)){
			echo ("<tr>
				<td><img src=". $row['Foto'] ." /></td>
				<td><b>	". $row['Naam']." </b><br />".$row['Beschrijving']."<br />Price: &euro;<big style='color:green'>".$row['Prijs']."</big><br /><br />
				<input type='button' value='Add to Cart' onclick='addtocart(" . $row['ID'] ." )' /></td> ");
				
			
			if (isset($_SESSION['admin']) && ($_SESSION['admin'] != "")){
				echo"<td><a href='include/edit.php/id=".$row['ID']."'>Edit</a><br></td>"; 
				
			
			}
			
			echo(" <tr><td colspan='2'><hr size='2' /></td></tr>");
			
		}
		echo ('</table>');
	}
		
		
		
		// bewerken 
		
		function edit(){
			$dbClass = new DB_Class();
			$db = $dbClass -> open();
			$inputdata = explode("/",$_SERVER['REQUEST_URI']);
			$input = $inputdata[3]; 
			
			echo(" <table class='tabel'> <form name = 'Edit' method='post'><tr>
		
		<th>Foto</th>
		<th>Naam</th>
		<th>Beschrijving</th>
		<th>prijs</th>
		
		</tr>");
			$result = mysqli_query($db,'SELECT Naam, Prijs ,Beschrijving, Foto FROM producten WHERE '.$input.'');
			while($row=mysqli_fetch_array($result)){ 
			echo("
				<tr>			
				<td><input type='text'value=" . $row['Foto'] ." name='foto_event2' /><br></td>
				<td><input type='text'value=" . $row['Naam'] ." size ='50' name='naam_event2'/><br></td>
				<td><input type='text'value=" . $row['Beschrijving'] ." name='beschrijving_event2'/><br></td>
				<td><input type='text' value=" . $row['Prijs'] ." name='prijs_event2'/><br></td>
				</tr>");
			
		
		}
		echo("</table><br><input type ='submit' value='Update' name='submit'/></a> <a href='../../index.php'>Back</a><br></form>");

		if(isset($_POST["foto_event2"]) && ($_POST["naam_event2"]) && ($_POST["beschrijving_event2"]) && ($_POST["prijs_event2"]))
					{
						$edit=("UPDATE producten SET 
						Foto='".$_POST['foto_event2']."', 
						Naam='".$_POST['naam_event2']."', 
						Beschrijving='".$_POST['beschrijving_event2']."',
						Prijs='".$_POST['prijs_event2']."' WHERE ".$input." ");
						
						$result= mysqli_query($db,$edit) or die('A error has occured: '.mysql_error());
						header("location:../../index.php");
					}
					
}

	
	// toevoegen
	
	function add(){
	$dbClass = new DB_Class();
			$db = $dbClass -> open();

echo'
<div style="display:none">
			<div id="inline_content" style="padding:10px; background:#fff;">
<table class="tabel">
<form  method="post" >
<tr>
<td>foto:</td><td><input type="text" value="images/" name="foto"></input></td>
<td>naam:</td><td><input type="text" name="naam"></input></td>
<td>beschrijving::</td> <td><input type="text" name="beschrijving"></input></td>
<td>prijs:</td> <td><input type="text" name="prijs"></input></td></tr>
<tr><td><input type="submit" value="maak"></input></td></tr>
</form>
</table>
</div>
</div>
';

if(isset($_POST["foto"]) && ($_POST["naam"]) && ($_POST["beschrijving"]) && ($_POST["prijs"]) )
{
	
	
    $ins="insert into producten (Foto,Naam,Beschrijving,Prijs)values('$_POST[foto]','$_POST[naam]','$_POST[beschrijving]','$_POST[prijs]' )";
    $result=mysqli_query($db,$ins) or die(mysql_error());		
    header("location: index.php");
   
	}
	else {
	mysql_error();
	
}
}
	
	
	
	
	
}
	class User{
		//registration
		public function register_user($db, $name, $username, $password, $email){
			$username = mysqli_real_escape_string($db, $username);
			$name = mysqli_real_escape_string($db, $name);
			$password = mysqli_real_escape_string($db, $password);
			$email = mysqli_real_escape_string($db, $email);
			//$password = md5($password);
			$salt = "fgwkergh578gw854yt0wf34dm9438y2fn54d0k34890";
			$password = hash_hmac('sha512', $password, $salt);
			$sql = mysqli_query($db, "SELECT `uid` FROM `users` WHERE `username` = '$username' OR `email` = '$email'");
			$no_rows = mysqli_num_rows($sql);
			if($no_rows == 0){
				$result = mysqli_query($db, "INSERT INTO `users`(`username`, `password`, `name`, `email`) VALUES ('$username', '$password', '$name', '$email')") or die(mysql_error());
				return $result;
			}
			else{
				return FALSE;
			}
		}
		//login
		public function check_login($db, $emailusername, $password){
			$emailusername = mysqli_real_escape_string($db, $emailusername);
			$password = mysqli_real_escape_string($db, $password);
			$salt = "fgwkergh578gw854yt0wf34dm9438y2fn54d0k34890";
			$password = hash_hmac('sha512', $password, $salt);
			$result = mysqli_query($db, "SELECT `uid` FROM users WHERE `email` = '$emailusername' OR `username` = '$emailusername' AND `password` = '$password'");
			$user_data = mysqli_fetch_array($result);
			$no_rows = mysqli_num_rows($result);
			if($no_rows == 1){
				$_SESSION['login'] = true;
				$_SESSION['uid'] = $user_data['uid'];
				
				$result = mysqli_query($db, "SELECT `admin` FROM `users` WHERE `uid` = " . $user_data['uid']);
				$user_status = mysqli_fetch_array($result);
				
				if($user_status['admin'] == 1){
					$_SESSION['admin'] = true;
				} else{
					$_SESSION['admin'] = false;
				}
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
		
		//admin checken
		public function get_status($db, $uid, $admin){
			if($_SESSION['admin'] == TRUE){
				return "Admin: ";
			} else{
				return "User: ";
			}
		}
		//naam ophalen
		public function get_fullname($db, $uid){
			$result = mysqli_query($db, "SELECT `name` FROM `users` WHERE `uid` = $uid");
			$user_data = mysqli_fetch_array($result);
			echo $user_data['name'];
		}
		//get session
		public function get_session(){
			if(!isset($_SESSION['login'])){
				return false;
			}
			return $_SESSION['login'];
		}
		//logout
		public function user_logout(){
			$_SESSION['login'] = FALSE;
			session_destroy();
		}
	}
	class item{
		
		function insert($db, $name, $onderwerp, $item, $datum){	
			
			$name = mysqli_real_escape_string($db, $name);
			$onderwerp = mysqli_real_escape_string($db, $onderwerp);
			$item = mysqli_real_escape_string($db, $item);
			$datum = mysqli_real_escape_string($db, $datum);

			$sql="INSERT INTO `items` (`name` ,`onderwerp`, `item`, `datum` ) VALUES ('".$name."','".$onderwerp."','".$item."','".$datum."')";
			if (!mysqli_query($db, $sql)){
				die('Error in inserting '.mysql_error());
			}
		}
	}
	
function get_product_name($pid){
			$dbClass = new DB_Class();
			$db = $dbClass -> open();
		$result=mysqli_query($db,"select Naam from producten where ID=$pid") or die("select name from products where serial=$pid"."<br/><br/>".mysql_error());
		$row=mysqli_fetch_array($result);
		return $row['Naam'];
	}
	function get_price($pid){
	$dbClass = new DB_Class();
			$db = $dbClass -> open();
		$result=mysqli_query($db,"select Prijs from producten where ID=$pid") or die("select name from products where serial=$pid"."<br/><br/>".mysql_error());
		$row=mysqli_fetch_array($result);
		return $row['Prijs'];
	}
	function remove_product($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				unset($_SESSION['cart'][$i]);
				break;
			}
		}
		$_SESSION['cart']=array_values($_SESSION['cart']);
	}
	function get_order_total(){
		$max=count($_SESSION['cart']);
		$sum=0;
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=$_SESSION['cart'][$i]['qty'];
			$price=get_price($pid);
			$sum+=$price*$q;
		}
		return $sum;
	}
	function addtocart($pid,$q){
		if($pid<1 or $q<1) return;
		
		if(is_array($_SESSION['cart'])){
			if(product_exists($pid)) return;
			$max=count($_SESSION['cart']);
			$_SESSION['cart'][$max]['productid']=$pid;
			$_SESSION['cart'][$max]['qty']=$q;
		}
		else{
			$_SESSION['cart']=array();
			$_SESSION['cart'][0]['productid']=$pid;
			$_SESSION['cart'][0]['qty']=$q;
		}
	}
	function product_exists($pid){
		$pid=intval($pid);
		$max=count($_SESSION['cart']);
		$flag=0;
		for($i=0;$i<$max;$i++){
			if($pid==$_SESSION['cart'][$i]['productid']){
				$flag=1;
				break;
			}
		}
		return $flag;
	}
	


?>