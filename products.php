<?php  include_once('includes/session.php') ?>	
<?php  include_once('includes/core.php') ?>
<?php include_once 'includes/header.php';
if(isset($_GET['subcatid'])){$link=$_GET['subcatid'];}
else if(isset($_GET['companyid'])){$link=$_GET['companyid'];}
else if(isset($_GET['search'])){$link=$_GET['search'];}
?>
	<section id="advertisement">
		<div class="container">
			<img src="images/shop/advertisement.jpg" alt="" />
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian">
							<?php all_categories();?>
						</div>
						<div class="brands_products"><!--brands_products-->
							<h2>Brands</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
									<?php all_compnies(); ?>
								</ul>
							</div>
						</div><!--/brands_products-->
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
						
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
						<?php if(isset($_GET['subcatid'])){products($link,'Products');}
						 	else if(isset($_GET['companyid'])){products($link,'Company');}
						 	else if(isset($_GET['search'])){products($link,'Search');}
						 		?>
						<div class="col-md-12" hidden>
							<ul class="pagination">
								<li class="active"><a href="">1</a></li>
								<li><a href="">2</a></li>
								<li><a href="">3</a></li>
								<li><a href="">&raquo;</a></li>
							</ul>
						</div>
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>