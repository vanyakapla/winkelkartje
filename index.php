<?php 
	
session_start();
	include_once 'include/functions.php';
	if(isset($_SESSION['uid'])){
		$user = new User();
		$uid = $_SESSION['uid'];
		$admin = $_SESSION['admin'];
	}
		$dbClass = new DB_Class();
		$db = $dbClass -> open();
		
		
		
		
	if(isset($_GET['q'])&& $_GET['q'] == 'logout'){
		$user->user_logout();
		header('location:index.php');
	}


	if(isset($_REQUEST['command'])=='add' && $_REQUEST['productid']>0){
		
		
		$pid=$_REQUEST['productid'];
		addtocart($pid,1);
		header("location:index.php");
		exit();
	}

?>
<html>

	<head>
		<link href="include/style.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="jquery.colorbox.js"></script>
		<link rel="stylesheet" href="colorbox.css" />
		<script language="javascript">
			function addtocart(pid){
				document.form1.productid.value=pid;
				document.form1.command.value='add';
				document.form1.submit();
			}
		</script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				
				$(".ajax").colorbox();
				
				
				$(".inline").colorbox({inline:true, width:"50%"});
				

				
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
	</head>
	
	<body>
		<div id="wrapper">
		
		<?php function test(){
		?>
	
		<a class='inline' href="#inline_content2"><?php divlogin(); ?><input type="button" value="login" /></a>
		<?php
		}
		?>
		
			<div id="menubalk">
				<ul>
					<li><a href="index.php">index</a></li>
					<li><a href="registration.php">regristratie</a></li>
					<li><a href="shoppingcart.php">winkelwagen</a></li>
					<?php if (isset($_SESSION['admin']) && ($_SESSION['admin'] != "")){ ?>
					<li><a class='inline' href='#inline_content'>product toevoegen<?php $add = new Shop(); $toevoegen = $add -> add(); echo"</a></li>";  } ?>
				
				
								<li class="right">
								<?php 
							
									if(isset($_SESSION['admin'])){
									$status = $user->get_status($db, $uid, $admin);
									
									echo $status;}
									if(isset($_SESSION['uid'])){
									
										$user->get_fullname($db, $uid);
									}
									else{
										echo test();
										echo "<li class='right'>U bent niet ingelogd</li>";
										
									}
									
						
									if(isset($_SESSION['uid'])){
										echo "<a href=\"?q=logout\"><input type=\"button\" value=\"LOGOUT\"/></a>";
									}
								?>
								
						</li>
				</ul>
			</div>
			
			<div id="nav">
				<?php	
					$shop = new Shop();
					$show = $shop -> Show();
				?>
					
		</div>
			
			
		</div>
	</body>

</html>