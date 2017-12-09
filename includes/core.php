<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "store";
//global $mysqli;
//$mysqli = new mysqli($host, $user, $pass, $db);
// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);
// Check connection
if (!$conn) {
	echo "Not OK";
    die("Connection failed: " . mysqli_connect_error());
}else{
	echo "OK";
}

function all_categories()
{
	global $conn;
	$sql="SELECT * FROM categories";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		while($data=mysqli_fetch_assoc($result))
		{
		//else{echo mysqli_error($conn);}
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordian" href="<?php echo "#".$data['cat_id']; ?>">
						<span class="badge pull-right"><i class="fa fa-plus"></i></span>
						<?php echo $data['cat_title']; ?>
					</a>
				</h4>
			</div>
			<div id="<?php echo $data['cat_id']; ?>" class="panel-collapse collapse">
				<div class="panel-body">
					<ul>
						<?php  
						$sql2="SELECT subcat_title FROM sub_categories WHERE cat_id={$data['cat_id']};";
						$result2=mysqli_query($conn,$sql2);	
						if(mysqli_num_rows($result2)>=1){
							while($data2=mysqli_fetch_assoc($result2))
							{	
								echo"<li><a href='#''>".
							 	$data2['subcat_title']." </a></li>";
							}
						}else{echo"<li><a href='#''>No Sub Category! </a></li>"; }
						?>
					</ul>
				</div>
			</div>
		</div>
		<?php
		}//while
	}//if
	else{
		echo "No Category In database";
	}
}//function
?>