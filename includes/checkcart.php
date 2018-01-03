<?php
require_once 'class.Cart.php';
$cart = new Cart(['cartMaxItem'	=> 0,'itemMaxQuantity'	=> 99,'useCookie'	=> false,]);

// ADD PRODUCT
if(isset($_POST['add_product_btn'])) {
	$qty=$_POST['qty'];
	$name=$_POST['product_name'];
	$price=$_POST['product_price'];
	$pid=$_POST['product_id'];
	$image=$_POST['product_image'];	
	$cart->add($pid, $qty, ['name'=>$name,'price'=> $price,'pid'=>$pid, 'image' => $image ]);
	header('location:../cart.php');
}

// REMOVE PRODUCT 
if(isset($_GET['action']) && isset($_GET['pid']) && $_GET['action']=='Remove')
{
	$pid=$_GET['pid'];	
	$cart->remove($pid);
	header('location:../cart.php');
}
//
?>