<?php
	require ('./includes/config.inc.php');
	require ('./includes/cart_functions.php');
	require (MYSQL);
	include ('./includes/header.php');
	
		if (isset($_COOKIE['SESSION'] )) 
		{
			$uid = $_COOKIE['SESSION'];
		} 
		else 
		{
			$uid = md5(uniqid('biped',true));
		}	
		
		setcookie('SESSION', $uid, time( )+(60*60*24*30));
		
		
		if (isset($_GET['sku'] )) 
		{
			list($sp_type, $pid) = parse_sku($_GET['sku'] );
		}
		
		if (isset ($sp_type, $pid, $_GET['action'] ) && ($_GET['action'] == 'add') ) 
		{
			$r = mysqli_query($dbc, "CALL add_to_cart('$uid', '$sp_type', $pid, 1)");
		}
		
		else if(isset ($_GET['action']) && ($_GET['action'] == 'viewCart'))
		{
			$r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");
			foreach()
			{
				
			}
		}
		
		else if (isset ($sp_type, $pid, $_GET['action'] ) && ($_GET['action'] =='remove') ) 
		{
			$r = mysqli_query($dbc, "CALL remove_from_cart('$uid', '$sp_type',$pid)");
		} 
		
		else if (isset ($sp_type, $pid, $_GET['action'], $_GET['qty'] ) && ($_GET['action'] == 'move') ) 
		{
			$qty = (filter_var($_GET['qty'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['qty'] : 1;
			$r = mysqli_query($dbc, "CALL add_to_cart('$uid', '$sp_type', $pid, $qty)");
			$r = mysqli_query($dbc, "CALL remove_from_wish_list('$uid','$sp_type', $pid)");
		} 
		else if (isset($_POST['quantity'] )) 
		{
			foreach ($_POST['quantity'] as $sku => $qty) 
			{
				list($sp_type, $pid) = parse_sku($sku);
				if (isset($sp_type, $pid)) 
				{
					$qty = (filter_var($qty, FILTER_VALIDATE_INT, array('min_range'=> 0))) ? $qty : 1;
					$r = mysqli_query($dbc, "CALL update_cart('$uid', '$sp_type',$pid, $qty)");
				}
			}
		}// End of main IF.
		
		if (mysqli_num_rows($r) > 0) 
		{		
			include("./cart.html");
		}
		else 
		{	 
			header("Location:./emptyCart.php");
		}
	
?>

<?php require('./includes/footer.php');?>