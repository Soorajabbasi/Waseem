<?php  
	include_once('includes/session.php');
	include_once('includes/core.php');
	if(isset($_SESSION['user_id'])){header('location:dashboard');}	
	if (isset($_POST['login-btn'])) {create_account();}
	include_once('includes/header.php'); 
?>
	<section style="margin-bottom:100px; margin-top: 20px;"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6 login-form">
						<p class="page-name">Signup</p>
						<p>Please Register your self to discover more</p></center>
						<form id="signup-form" method="post">
							<div class="form-group">
								<label for="firstname">First Name</label>
								<input type="text" name="firstname" placeholder="First Name" />
							</div>
							<div class="form-group">
								<label for="lastname">Last Name</label>
								<input type="text" name="lastname" placeholder="Last Name" />
							</div>
							<div class="form-group">
								<label for="phonenumber">Phone Number</label>
								<input type="text" name="phonenumber" placeholder="Phone Number" />
							</div>
							<div class="form-group">
								<label for="email">Email Address</label>
								<input type="text"  name="email" placeholder="Email Address" />
							</div>
							
							<label for="password">Password</label>
							<input type="password" name="password" placeholder="Password" />
							<button name="login-btn" type="submit" class="btn btn-default">Create Account</button>
						</form>	
				</div>
				<div class="col-md-3"></div>
			</div>
		</div>
	</section><!--/form-->
<?php  include_once('includes/footer.php') ?>