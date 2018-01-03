<?php
	include('session.php');
	include('connection.php');
	unset($_SESSION['user_id']);
	session_destroy();
	header('location:../index');
?>