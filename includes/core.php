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

function show_cart()
{	
	$cart = new Cart;
	if($cart->isEmpty())
	{
		echo "<tr><td colspan='5' align='center'><h4>There is nothing in your cart.</h4><td><tr>";
	}
	$allItems = $cart->getItems();
	echo $cart->getAttributeTotal('price');
	foreach ($allItems as $items) {
		foreach ($items as $item) {
		$pid=$item['attributes']['pid'];
		?>
			<tr>
				<td class="cart_product">
					<img width="60" src="images/products/<?php echo $item['attributes']['image']; ?>" alt="Image Not Availabile">
				</td>
				<td class="cart_description">
					<h4><a href=""><?php echo $item['attributes']['name']; ?></a></h4>
					<p>Web ID: 1089772</p>
				</td>
				<td class="cart_price">
					<p><?php echo amount($item['attributes']['price']); ?></p>
				</td>
				<td class="cart_quantity">
					<div class="cart_quantity_button">
						<a class="cart_quantity_up" href=""> + </a>
						<input class="cart_quantity_input" type="text" name="quantity" value="<?php echo $item['quantity']; ?>" autocomplete="off" size="2">
						<a class="cart_quantity_down" href=""> - </a>
					</div>
				</td>
				<td class="cart_total">
					<p class="cart_total_price"><?php echo amount($item['attributes']['price']); ?></p>
				</td>
				<td class="cart_delete">
					<a href="includes/checkcart.php?action=Remove&pid=<?php echo $pid; ?>" class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
				</td>
			</tr>
    	<?php
    	}
	}
}
function all_compnies()
{
	global $conn;
	$sql="SELECT * FROM compnies";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		while($data=mysqli_fetch_assoc($result))
		{
			$sql2="SELECT * FROM products WHERE company='{$data['company_id']}'";
			$result2=mysqli_query($conn,$sql2);
			if(mysqli_num_rows($result2)>=1)
			{
				$items=mysqli_num_rows($result2);
			}else{$items==0;}		
			?>
				<li><a href="products?companyid=<?php echo encryptor('encode', $data['company_id']); ?>"> <span class="pull-right">(<?php echo $items;?>)</span><?php echo $data['company_name']; ?></a></li>		
			<?php
		}
	}
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
	else if($page=='Company')
	{
		$sql="SELECT * FROM products WHERE company='$subcat_id' AND quantity>=1";
	}
	else if($page =='Search')
	{
		$sql="SELECT * FROM products WHERE product_name LIKE '%$link%' OR product_description LIKE '%$link%' AND quantity>=1";
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
							<a href="details?pid=<?php echo $data['prodcut_id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>View Details</a>
						</div>
						<div class="product-overlay">
							<div class="overlay-content">
								<h2><?php amount($data['product_price']); ?></h2>
								<p><?php echo $data['product_name']; ?></p>
								<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
								<a href="details?pid=<?php echo $data['prodcut_id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>View Details</a>
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
	else{
		echo"<h3 class='text-center'>No products found!</h3>";
	}
}
function prodcut_details($value)
{
	global $conn;
	$pid=mysqli_real_escape_string($conn,$value);
	$sql="SELECT * FROM products WHERE prodcut_id='$pid'";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		return mysqli_fetch_assoc($result);
	}else
	{
		echo "No Product Found For given Id.";
	}
}
function company($value)
{
	global $conn;
	$id=mysqli_real_escape_string($conn,$value);
	$sql="SELECT company_name FROM compnies WHERE company_id='$id'";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		$data=mysqli_fetch_assoc($result);
		echo $data['company_name'];
	}else
	{
		echo "No Company found";
	}
}
function cat($value)
{
	global $conn;
	$id=mysqli_real_escape_string($conn,$value);
	$sql="SELECT cat_title FROM categories WHERE cat_id='$id'";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		$data=mysqli_fetch_assoc($result);
		echo $data['cat_title'];
	}else
	{
		echo "No Company found";
	}
}
function reviews($value)
{
	global $conn;
	$pid=mysqli_real_escape_string($conn,$value);
	$sql="SELECT * FROM `reviews` WHERE `porduct_id`='$pid' AND `review_status`='active'";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		while($data=mysqli_fetch_assoc($result))
		{
		?>
		<ul>
			<li><a href=""><i class="fa fa-user"></i><?php echo $data['review_author'];?></a></li>
			<li><a href=""><i class="fa fa-clock-o"></i><?php echo $data['review_date'];?></a></li>
			<li><a href=""><i class="fa fa-star"></i><?php echo $data['ratings'];?></a></li>
		</ul>
		<p><?php echo $data['review_des'];?></p>
		<hr>
		<?php
		}
	}else
	{
		echo "<h3>No Reviews yet given.</h3>";
	}	
}
function count_reviews($value)
{
	global $conn;
	$pid=mysqli_real_escape_string($conn,$value);
	$sql="SELECT * FROM `reviews` WHERE `porduct_id`='$pid' AND `review_status`='active'";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		echo mysqli_num_rows($result);
	}else
	{
		echo "0";
	}	
}
function company_products($value,$pid)
{
	global $conn;
	$company=mysqli_real_escape_string($conn,$value);
	$sql="SELECT * FROM products WHERE company='$company' AND prodcut_id!='$pid' AND quantity>=1 LIMIT 4";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		while($data=mysqli_fetch_assoc($result))
		{
		?>
		<div class="col-sm-3">
			<div class="product-image-wrapper">
				<div class="single-products">
					<div class="productinfo text-center">
						<img src="images/home/gallery1.jpg" alt="" />
						<h2><?php echo amount($data['product_price']); ?></h2>
						<p><?php echo $data['product_name']; ?></p>
						<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
	}else
	{
		echo "<h4>No any product found!</h4>";
	}	
}
function add_review($value)
{
	global $conn;
	$name=mysqli_real_escape_string($conn,$_POST['name']);
	$pid=mysqli_real_escape_string($conn,$value);
	$des=mysqli_real_escape_string($conn,$_POST['review_des']);
	$date= date('d-m-Y');
	$rate='5';
	$sql="INSERT INTO `reviews`(`porduct_id`, `review_author`, `review_des`, `review_date`, `ratings`, `review_status`) VALUES ('$pid','$name','$des','$date','$rate','pending')";
	if(mysqli_query($conn,$sql))
	{
		echo "Added";
	}else
	{
		echo "Not Added";
	}
}
function new_items($value)
{
	global $conn;
	$vale=mysqli_real_escape_string($conn,$value);
	$sql="SELECT *FROM products WHERE mark_as ='New' AND quantity>=1 LIMIT 3";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		while($data=mysqli_fetch_assoc($result))
		{
		$id=$data['prodcut_id'];
		?>
		<div class="col-sm-4">
			<div class="product-image-wrapper">
				<div class="single-products">
					<div class="productinfo text-center">
						<img src="images/products/<?php echo $data['image']; ?>" alt="" />
						<h2><?php echo amount($data['product_price']); ?></h2>
						<p><?php echo $data['product_name']; ?></p>
						<a href="details?pid=<?php echo $id; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
					</div>
				</div>
			</div>
		</div>
	<?php 
		}
	}
}
function tabs()
{
	global $conn;
	$sql="SELECT cat_title FROM categories LIMIT 5";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{	$c=1;
		while($data=mysqli_fetch_assoc($result))
		{
			$cat=$data['cat_title'];
			if($c==1)
			{
				echo"<li class='active'><a href='#$cat' data-toggle='tab'> $cat </a></li>";
			}
			else 
			{
				echo"<li><a href='#$cat' data-toggle='tab'> $cat </a></li>";
			}
			$c++;
		}
	}
}
function tab_content()
{
	global $conn;
	$sql="SELECT cat_title,cat_id FROM categories LIMIT 5";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{	$active='active in';
		while($data=mysqli_fetch_assoc($result))
		{
			$cat=$data['cat_title'];
			$cat_id=$data['cat_id'];
			if(isset($active) AND $active=='active in')
			{
				echo"<div class='tab-pane fade $active ' id='$cat' >ONE</div>";
				unset($active);
			}
			else
			{
				echo"<div class='tab-pane fade' id='$cat' >.
				".catwise($cat_id)."</div>";
			}
		}

	}
}
function catwise($cat)
{
	global $conn;
	$vale=mysqli_real_escape_string($conn,$cat);
	$sql="SELECT *FROM products WHERE cat ='$cat' AND quantity>=1 LIMIT 3";
	$result=mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>=1)
	{
		while($data=mysqli_fetch_assoc($result))
		{
		$id=$data['prodcut_id'];
		print_r($data);
		?>
		<div class="col-sm-3">
			<div class="product-image-wrapper">
				<div class="single-products">
					<div class="productinfo text-center">
						<img src="images/products/<?php echo $data['image']; ?>" alt="" />
						<h2><?php echo amount($data['product_price']); ?></h2>
						<p><?php echo $data['product_name']; ?></p>
						<a href="details?pid=<?php echo $id; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
					</div>
				</div>
			</div>
		</div>
	<?php 
		}
	}
	unset($data);
	unset($result);
}
function create_account()
{
	global $conn;
	$firstname=mysqli_real_escape_string($conn,$_POST['firstname']);
	$lastname=mysqli_real_escape_string($conn,$_POST['lastname']);
	$phonenumber=mysqli_real_escape_string($conn,$_POST['phonenumber']);
	$email=mysqli_real_escape_string($conn,$_POST['email']);
	$password=mysqli_real_escape_string($conn,$_POST['password']);
	$sql="INSERT INTO `users`(`first_name`, `last_name`, `phonenumber`, `email`, `password`, `role`, `status`) VALUES ('$firstname','$lastname','$phonenumber','$email','$password','User','Active')";
	if(mysqli_query($conn,$sql))
	{
		$uid=mysqli_insert_id($conn);
		echo $_SESSION['user_id']=$uid;
		if(isset($_SESSION['user_id']))
		{
			header('location:dashboard');
		}
	}else{
		echo mysqli_error($conn);
	}
}
function login()
{
	global $conn;
	$email=mysqli_real_escape_string($conn,$_POST['email']);
	$password=mysqli_real_escape_string($conn,$_POST['password']);
	$sql="SELECT email FROM users WHERE email='$email'";
	$result=mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)==1)
		{	
			$sql2="SELECT password FROM users WHERE password='$password' AND email='$email'";
			$result2=mysqli_query($conn,$sql2);
			if(mysqli_num_rows($result2)==1)
			{					
				$sql3="SELECT id FROM users WHERE password = '$password' AND email='$email'";
				$result3=mysqli_query($conn,$sql3);
				if(mysqli_num_rows($result3)==1)
				{
					$row_data=mysqli_fetch_assoc($result3);
					$user_id=$row_data['id'];
					//include('includes/session.php');
					$_SESSION['user_id'] = $user_id;
					if(isset($_SESSION['user_id']))
					{
						header('location:dashboard');
					}
				}			
			}// Password
			else
			{
				echo "Password is Incorrect";
			}		
			
		}// Username 
		else
		{
			echo "Email is Incorrect";
		}
}
function add_to_cart()
{
	global $conn;
	echo $qty=mysqli_real_escape_string($conn,$_POST['qty']);
	echo $pid=mysqli_real_escape_string($conn,$_POST['product_id']);
	
}
?>