<?php  include_once('includes/session.php') ?>	
<?php  include_once('includes/core.php') ?>	
<?php if(!isset($_SESSION['user_id'])){header('location:index');}?>	
<?php  include_once('includes/header.php') ?>
<style type="text/css">
	.left{
		border-radius: 4px;
		border:1px solid #FE980F;
	}
</style>
	<section>
		<div class="container" style="margin-bottom :100px;">
			<div class="row">
				<div class="col-sm-3 left" style="background: #efefef; padding: 10px;">
					<h4 class="text-center"><b>User Information</b></h4>
					<center>
						<img class="img-responsive img-circle" style="border:3px solid #FE980F;margin-bottom:30px;"  src="images/users/1.jpg" width="150" height="150" />
					</center>
					<table align="center" style="margin-bottom: 90px;">
						<tr>
							<td>Name</td>
							<td>Name</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>Email</td>
						</tr>
					</table>
					<a href="includes/edit" class="btn btn-primary btn-sm btn-block">Edit Information</a>	
					<a href="includes/logout" class="btn btn-danger btn-sm btn-block">Logout</a>	
				</div>
				<div class="col-sm-9">
					<?php echo $_SESSION['user_id']; ?>
				</div>
			</div>
		</div>
	</section><!--/form-->
<?php  include_once('includes/footer.php') ?>	