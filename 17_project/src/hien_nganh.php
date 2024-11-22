<?php 
	include '../function.php';
	isLogin();
	permissionAdmin();
	url('id','trang_chu.php');
	showMajor($_GET['id']);
	header("location: trang_chu.php");
 ?>