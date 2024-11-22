<?php 
	include '../function.php';
	isLogin();
	permissionAdmin();
	url('id','trang_chu.php');
	url('application_id','trang_chu.php');
	deleteApplication($_GET['application_id']);
	header("location: nganh.php?id=".$_GET['id']);
 ?>