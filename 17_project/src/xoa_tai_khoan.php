<?php 
	include '../function.php';
	isLogin();
	permissionAdmin();
	url('id', 'tai_khoan.php');
	deleteAccount($_GET['id']);
	header("location: tai_khoan.php");
 ?>