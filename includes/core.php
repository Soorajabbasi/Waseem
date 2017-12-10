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
	//echo "OK";
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
						$sql2="SELECT subcat_id, subcat_title FROM sub_categories WHERE cat_id={$data['cat_id']};";
						$result2=mysqli_query($conn,$sql2);	
						if(mysqli_num_rows($result2)>=1){
							while($data2=mysqli_fetch_assoc($result2))
							{	
								$id =$data2['subcat_id'];
								$link=encryptor("encode", $id);
								echo"<li><a href='products?subcatid=$link'>".
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
function encryptor($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    //pls set your unique hashing key
    $secret_key = 'muni';
    $secret_iv = 'muni123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number
    if( $action == 'encode' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decode' ){
    	//decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
function amount($value)
{
	echo "Rs.".$value."/=";
}
function products($link,$page)
{
	global $conn;
	$subcat=encryptor("decode",$link);
	$subcat_id=mysqli_real_escape_string($conn,$subcat);
	if($page=='Products')
	{
		$sql="SELECT * FROM products WHERE subcat='$subcat_id' AND quantity>=1";
	}
	else if($page=='Index'){
		$sql="SELECT * FROM products WHERE quantity>=1";
	}
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		while($data=mysqli_fetch_assoc($result))
		{?>
			<div class="col-sm-4">
				<div class="product-image-wrapper">
					<div class="single-products">
						<div class="productinfo text-center">
							<img src="images/products/<?php echo $data['image']; ?>" alt="" />
							<h2><?php amount($data['product_price']); ?></h2>
							<p><?php echo $data['product_name']; ?></p>
							<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
						</div>
						<div class="product-overlay">
							<div class="overlay-content">
								<h2><?php amount($data['product_price']); ?></h2>
								<p><?php echo $data['product_name']; ?></p>
								<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
							</div>
						</div>
					</div>
					<div class="choose" hidden="true">
						<ul class="nav nav-pills nav-justified">
							<li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
							<li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
						</ul>
					</div>
				</div>
			</div>
		<?php
		}
	}
}
?>