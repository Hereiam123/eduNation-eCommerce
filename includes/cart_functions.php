
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
		if ($type_abbr == '1') 
		{
			$sp_type = '1';
		}	 
		else if ($type_abbr == '2') 
		{
			$sp_type = '2';
		} 
		else if ($type_abbr == '3') 
		{
			$sp_type = '3';
		} 
		else if ($type_abbr == '4') 
		{
			$sp_type = '4';
		} 
		else if ($type_abbr == '5') 
		{
			$sp_type = '5';
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

