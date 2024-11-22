<?php 
	include '../function.php';
	isLogin();
	permissionAdmin();
	url('major_id','trang_chu.php');
	url('teacher_id','trang_chu.php');
	deleteTeacherForMajor($_GET['major_id'], $_GET['teacher_id']);
	header("location: giao_vien.php?id=".$_GET['major_id']);
 ?>