<?php  include_once('includes/class.Cart.php') ?>	
<?php  include_once('includes/session.php') ?>	
<?php  include_once('includes/core.php') ?>
<?php  include_once('includes/header.php');
?>	
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<?php show_cart(); ?>						
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->
<?php  include_once('includes/footer.php') ?>	