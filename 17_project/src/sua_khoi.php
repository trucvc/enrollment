<?php
    include '../function.php';
    isLogin();
    url('id','trang_chu.php');
    permissionAdmin();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tuyển sinh</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>
    <?php include 'navbar.php';?>
	<main style="min-height: 100vh; max-width: 100%;">
		<div id="action" style="margin: 20px 0 0 13%;">
			<p class="h3" style="text-transform: capitalize;">Chỉnh sửa khối xét tuyển</p>
         <a href="khoi.php" class="btn btn-primary">Trở lại</a>
		</div>
		<form method="POST" enctype="multipart/form-data">
         <div style="margin: 20px 13%;">
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Nhập tên khối</label>
               <input class="form-control"  type="text" name="name" id="" value="<?php getSubjectGroup($_GET['id'],'group_name') ?>">
            </div>
            
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Nhập tên môn 1</label>
               <input class="form-control"  type="text" name="subject_1" id="" value="<?php getSubjectGroup($_GET['id'],'subject_1') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Nhập tên môn 2</label>
               <input class="form-control"  type="text" name="subject_2" id="" value="<?php getSubjectGroup($_GET['id'],'subject_2') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Nhập tên môn 3</label>
               <input class="form-control"  type="text" name="subject_3" id="" value="<?php getSubjectGroup($_GET['id'],'subject_3') ?>">
            </div>

            <?php 
            	if (isset($_POST['btn'])) {
            		$check = 1;
                  if (trim($_POST['name']) == "") {
                     echo "Vui lòng nhập tên của khối xét tuyển<br>";
                     $check = 0;
                  }
                  if (trim($_POST['subject_1']) == "") {
                     echo "Vui lòng nhập tên môn 1<br>";
                     $check = 0;
                  }
                  if (trim($_POST['subject_2']) == "") {
                     echo "Vui lòng nhập tên môn 2<br>";
                     $check = 0;
                  }
                  if (trim($_POST['subject_3']) == "") {
                     echo "Vui lòng nhập tên môn 3<br>";
                     $check = 0;
                  }
                  if ($check == 1) {
                  	$name = trim($_POST['name']);
                  	$name = strtoupper($name);
                  	$sub1 = ucwords(trim($_POST['subject_1']));
                  	$sub2 = ucwords(trim($_POST['subject_2']));
                  	$sub3 = ucwords(trim($_POST['subject_3']));
                  	if (!existsGroupName($name, $_GET['id'])) {
                  		if (updateSubjectGroup($_GET['id'], $name, $sub1, $sub2, $sub3)) {
	                  		header("location: khoi.php");
	                  	}else{
	                  		echo "<div class='alert alert-danger text-center' role='alert'>Sửa khối xét tuyển thất bại</div>";
	                  	}
                  	}else{
                  		echo "<div class='alert alert-danger text-center' role='alert'>Đã tồn tại tên khối xét tuyển này</div>";
                  	}
                  }
            	}
             ?>

            <div style="margin: 20px 0 0 0;" class="d-grid">
               <input class="btn btn-primary btn-block" name="btn" type="submit" value="Sửa khối xét tuyển">
            </div>
         </div>
      </form>
	</main>
   <?php include 'footer.php'; ?>
</body>
</html>