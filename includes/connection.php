<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "store";
//global $mysqli;
//$mysqli = new mysqli($host, $user, $pass, $db);
// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);
print_r($conn);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
