<?php  include_once('includes/header.php') ?>	
	<style type="text/css">
		#forgot{
			margin-top:50px;
			margin-bottom: 200px;
		}
	</style>
	<section id="forgot"><!--form-->
		<div class="container">
			<div class="row">
				<p class="page-name">Forgot Password</p>
				<div class="col-md-3 col-sm-3 col-xs-12"></div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<br><br>
					<p>Please fill the form and press enter to recover your password.</p>
					<div class="forgot-form">
						<form id="forgot-form" method="get" action="blank.php">
							<div class="">
								<input type="text" name="email" placeholder="Email Address" />
							</div>
							
							<button name="login-btn" type="submit" class="btn btn-default pull-right btn-block">Get Code</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section><!--/form-->
<?php  include_once('includes/footer.php') ?>	