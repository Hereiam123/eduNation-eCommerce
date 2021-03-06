
<?php
	function get_just_price($regular, $sales) 
	{
		if ((0 < $sales) && ($sales < $regular)) 
		{
			return number_format($sales, 2);
		} 
		else 
		{
			return number_format($regular, 2);
		}
	}
	
	function parse_sku($sku) 
	{
	// Grab the first character:
	$type_abbr = substr($sku, 0, 1);
	// Grab the remaining characters:
	$pid = substr($sku, 1);
	// Validate the type:
	if ($type_abbr == 'C') 
	{
		$sp_type = 'coffee';
	} 
	else if ($type_abbr == 'O') 
	{
		$sp_type = 'other';
	} 
	else 
	{
		$sp_type = NULL;
	}
	// Validate the product ID:
	$pid = (filter_var($pid, FILTER_VALIDATE_INT, array('min_range' => 1)))
	?$pid : NULL;
	// Return the values:
	return array($sp_type, $pid);
} // End of parse_sku( ) function.

?>

<?php
		
		if (isset($_COOKIE['SESSION'] )) 
		{
			$uid = $_COOKIE['SESSION'];
		} 
		else 
		{
			$uid = md5(uniqid('biped',true));
		}	
		
		setcookie('SESSION', $uid, time( )+(60*60*24*30));
		
		require (MYSQL);
		
		if (isset($_GET['sku'] )) 
		{
			list($sp_type, $pid) = parse_sku($_GET['sku'] );
		}
		
		if (isset ($sp_type, $pid, $_GET['action'] ) && ($_GET['action'] == 'add') ) 
		{
			$r = mysqli_query($dbc, "CALL add_to_cart('$uid', '$sp_type', $pid, 1)");
		}
		
		else if (isset ($sp_type, $pid, $_GET['action'] ) && ($_GET['action'] =='remove') ) 
		{
			$r = mysqli_query($dbc, "CALL remove_from_cart('$uid', '$sp_type',$pid)");
		} 
		
		elseif (isset ($sp_type, $pid, $_GET['action'], $_GET['qty'] ) && ($_GET['action'] == 'move') ) 
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
		
		$r = mysqli_query($dbc, "CALL get_shopping_cart_contents('$uid')");
		
		if (mysqli_num_rows($r) > 0) 
		{
			include ('./views/cart.html');
		} 
		else 
		{ // Empty cart!
			include ('./views/emptycart.html');
		}	
?>