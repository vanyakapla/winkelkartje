<?php 
	
session_start();
	include_once 'functions.php';
	if(isset($_SESSION['uid'])){
		$user = new User();
		$uid = $_SESSION['uid'];
		$admin = $_SESSION['admin'];
	}
		$dbClass = new DB_Class();
		$db = $dbClass -> open();
		
	if(isset($_GET['q'])&& $_GET['q'] == 'logout'){
		$user->user_logout();
		header('location:../../index.php');
	}
	
?>
<html>

	<head>
		<link href="../style.css" rel="stylesheet" type="text/css" />
		
		
	</head>
	
	<body>
		<div id="wrapper">
		
			<div id="menubalk">
				<ul>
					<li><a href="../../index.php">index</a></li>
					<li><a href=".././registration.php">regristratie</a></li>
					<li><a href="../../login.php">login</a></li>
					<li><a href="#">winkelwagen</a></li>
				</ul>
				
								
								<?php 
									if(isset($_SESSION['admin'])){
									$status = $user->get_status($db, $uid, $admin);
									echo $status;}
									if(isset($_SESSION['uid'])){
										$user->get_fullname($db, $uid);
									}
									else{
										echo "U bent niet ingelogd.";
									}
									
									if(!isset ($_SESSION ['uid']) == true){
										echo "<input type=\"button\" value=\"Inloggen\" onclick=\"parent.location='../../login.php'\" >";
									}
								?>
						
						
								<?php 
									if(isset($_SESSION['uid'])){
										echo "<a href=\"?q=logout\"><input type=\"button\" value=\"LOGOUT\"/></a>";
									}
								?>
								
						
			</div>
			
			<div id="nav">
				<?php
				if (isset($_SESSION['admin']) && ($_SESSION['admin'] != "")){
				$edit = new Shop();
					$show = $edit -> edit();
					}
					else{ echo"admin inhoud";}

				?>
			</div>
			
		</div>
	</body>

</html>




