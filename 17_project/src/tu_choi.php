<?php 
	include '../function.php';
	isLogin();
	permission();
	url('id','trang_chu.php');
	url('application_id','trang_chu.php');
	rejectApplication($_GET['id'], $_GET['application_id'], $_SESSION['id']);
	header("location: nganh.php?id=".$_GET['id']);
 ?>