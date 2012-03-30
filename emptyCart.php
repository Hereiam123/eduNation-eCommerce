<?php
	require ('./includes/config.inc.php');
	require ('./includes/cart_functions.php');
	require (MYSQL);
	include ('./includes/header.php');
?>

			<div id="home">
				<div id="cart">
				<!-- box begin -->
					<div class="box alt">
						<div class="left-top-corner">
							<div class="right-top-corner">
								<div class="border-top">
								</div>
							</div>
						</div>
						<div class="border-left">
							<div class="border-right">
								<div class="inner">
								<h2>Your Shopping Cart</h2>
								<p>Your shopping cart is currently empty.</p>
								</div>
							</div>
						</div>
					<div class="left-bot-corner"><div class="right-bot-corner"><div class="border-bot"></div></div></div></div>
				<!-- box end -->
				</div>
			</div>
			
<?php include ('./includes/footer.php'); ?>