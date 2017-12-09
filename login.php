<?php include_once 'includes/header.php'; ?>
	<section id="form" style="margin-top: 50px;"><!--form-->
		<div class="container">	
			<div class="row">
				<div class="col-sm-4 "></div>
				<div class="col-sm-4 ">
					<div class="login-form"><!--login form-->
						<h2>Login</h2>
						<form id="login-form" method="get" action="blank.php">
							<input type="text" id="login-email" name="email" placeholder="Email Address" />
							<input type="password" id="password" name="password" placeholder="Password" />
							<br>
							<span>
								<a href="forgot.php">Forgot Password?</a> 
							</span>
							<button name="login-btn" type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</section><!--/form-->
<?php include_once 'includes/footer.php'; ?>	