<?php
error_reporting(0);
	
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

	if(isset($_REQUEST['command'])=='delete' && $_REQUEST['pid']>0){
		remove_product($_REQUEST['pid']);
	}
	
	if($_REQUEST['command']=='clear'){
		unset($_SESSION['cart']);
	}
	else if(isset($_REQUEST['command'])=='update'){
		$max=count($_SESSION['cart']);
		for($i=0;$i<$max;$i++){
			$pid=$_SESSION['cart'][$i]['productid'];
			$q=intval($_REQUEST['product'.$pid]);
			if($q>0 && $q<=999){
				$_SESSION['cart'][$i]['qty']=$q;
			}
			
		}
	}

?>

<html>

	<head>
		<link href="include/style.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="jquery.colorbox.js"></script>
		<link rel="stylesheet" href="colorbox.css" />
		<script language="javascript">
	function del(pid){
		if(confirm('Do you really mean to delete this item')){
			document.form1.pid.value=pid;
			document.form1.command.value='delete';
			document.form1.submit();
		}
	}
	function clear_cart(){
		if(confirm('This will empty your shopping cart, continue?')){
			document.form1.command.value='clear';
			document.form1.submit();
		}
	}
	function update_cart(){
		document.form1.command.value='update';
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
	</body>
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
				<form name="form1" method="post">
<input type="hidden" name="pid" />
<input type="hidden" name="command" />
	<div style="margin:0px auto; width:600px;" >
    <div style="padding-bottom:10px">
    	<h1 align="center">Your Shopping Cart</h1>
    <input type="button" value="Continue Shopping" onclick="window.location='index.php'" />
    </div>
    	
    	<table border="0"  cellpadding="5px" cellspacing="1px" style="font-family:Verdana, Geneva, sans-serif; font-size:11px; background-color:#E1E1E1" width="100%">
    	<?php
			if(isset($_SESSION['cart'])){
            	echo '<tr bgcolor="#FFFFFF" style="font-weight:bold"><td>Serial</td><td>Name</td><td>Price</td><td>Qty</td><td>Amount</td><td>Options</td></tr>';
				$max=count($_SESSION['cart']);
				for($i=0;$i<$max;$i++){
					$pid=$_SESSION['cart'][$i]['productid'];
					$q=$_SESSION['cart'][$i]['qty'];
					$pname=get_product_name($pid);
					if($q==0) continue;
			?>
            		<tr bgcolor="#FFFFFF"><td><?php echo $i+1?></td><td><?php echo $pname?></td>
                    <td>$ <?php echo get_price($pid)?></td>
                    <td><input type="text" name="product<?php echo $pid?>" value="<?php echo $q?>" maxlength="3" size="2" /></td>                    
                    <td>$ <?php echo get_price($pid)*$q?></td>
                    <td><a href="javascript:del(<?php echo $pid?>)">Remove</a></td></tr>
            <?php					
				}
			?>
				<tr><td><b>Order Total: $<?php echo get_order_total()?></b></td><td colspan="5" align="right"><input type="button" value="Clear Cart" onclick="clear_cart()"><input type="button" value="Update Cart" onclick="update_cart()"><input type="button" value="Place Order" onclick="window.location='billing.php'"></td></tr>
			<?php
            }
			else{
				echo "<tr bgColor='#FFFFFF'><td>There are no items in your shopping cart!</td>";
			}
		?>
        </table>
    </div>
</form>
					
		</div>
			
			
		</div>
	</body>

</html>
	
	
