<?php 
	include '../function.php';
	isLogin();
	permissionAdmin();
	url('id','trang_chu.php');
	hiddenMajor($_GET['id']);
	header("location: trang_chu.php");
 ?>