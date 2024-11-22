<?php
    include '../function.php';
    isLogin();
    permissionStudent();
    url('id','trang_chu.php');
    permissionSendApplication($_GET['id']);
    checkSendAplication($_GET['id']);
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
			<p class="h3" style="text-transform: capitalize;">Ngành <?php nameMajor($_GET['id']) ?></p>
         <a href="trang_chu.php" class="btn btn-primary">Trở lại</a>
		</div>
		<form method="POST" enctype="multipart/form-data">
         <div style="margin: 20px 13%;">
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Nhập tên bạn</label>
               <input class="form-control"  type="text" name="fullName" id="" value="<?php val('btn','fullName') ?>">
            </div>
            <?php 
            	showSubjects($_GET['id']);
             ?>
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Ảnh học bạ</label>
              	<input class="form-control"  type="file" name="img" id="">
            </div>

            <?php 
            	if (isset($_POST['btn'])) {
            		$check = 1;
                  if (trim($_POST['fullName']) == "") {
                     echo "Vui lòng nhập tên của bạn<br>";
                     $check = 0;
                  }
                  if (trim($_POST['subject_1']) == "") {
                     echo "Vui lòng nhập điểm môn 1<br>";
                     $check = 0;
                  }
                  if (trim($_POST['subject_2']) == "") {
                     echo "Vui lòng nhập điểm môn 2<br>";
                     $check = 0;
                  }
                  if (trim($_POST['subject_3']) == "") {
                     echo "Vui lòng nhập điểm môn 3<br>";
                     $check = 0;
                  }
                  if ($_FILES['img']['size'] == 0) {
                  	echo "Vui lòng nhập ảnh học bạ<br>";
                  	$check = 0;
                  }
                  if ($check == 1) {
                  	$fullName = trim($_POST['fullName']);
                  	$sub1 = trim($_POST['subject_1']);
                  	$sub2 = trim($_POST['subject_2']);
                  	$sub3 = trim($_POST['subject_3']);
                  	if ($_FILES['img']['error'] == 0 && $_FILES['img']['size'] < 100*1024*1024) {
                  		$type = explode('/', $_FILES['img']['type']);
                  		$types = array("png", "jpg", "jpeg");
                  		if (in_array($type[1], $types)) {
                  			$img = scandir("image");
	                        $count = 0;
	                        $name = pathinfo($_FILES['img']['name']);
	                        foreach ($img as $key => $value) {
	                           $temp = strpos($value, $name['filename']);
	                           if ($temp != "") {
	                              $count++;
	                           }
	                        }
	                        $file_img = 1;
	                        foreach ($img as $key => $value) {
	                           $v = pathinfo($value);
	                           if (strcmp($v['filename'], $name['filename']) == 0) {
	                              $file_img = 0;
	                           }
	                        }
	                        if ($file_img == 1) {
	                           $count = 0;
	                        }
	                        if ($count == 0) {
	                           if (move_uploaded_file($_FILES['img']['tmp_name'], "image/".$_FILES['img']['name']) &&
	                        		addAplication($_GET['id'], $fullName, $sub1, $sub2, $sub3, "image/".$_FILES['img']['name'])) {
	                              header("location: nganh.php?id=".$_GET['id']);
	                           }else{
	                              echo "<div class='alert alert-warning text-center' role='alert'>Thêm hồ sơ thất bại</div>";
	                           }
	                        }else{
	                           $file = pathinfo($_FILES['img']['name']);
	                           if (move_uploaded_file($_FILES['img']['tmp_name'], "image/".$file['filename']."($count).".$file['extension']) && 
	                        		addAplication($_GET['id'], $fullName, $sub1, $sub2, $sub3, "image/".$file['filename']."($count).".$file['extension'])) {
	                              header("location: nganh.php?id=".$_GET['id']);
	                           }else{
	                              echo "<div class='alert alert-warning text-center' role='alert'>Thêm hồ sơ thất bại</div>";
	                           }
	                        }
                  		}else{
                  			echo "File phải có đuôi là PNG hoặc JPG";
                  		}
                  	}else{
                  		echo "File lỗi hoặc file lớn hơn 100MB";
                  	}
                  }
            	}
             ?>

            <div style="margin: 20px 0 0 0;" class="d-grid">
               <input class="btn btn-primary btn-block" name="btn" type="submit" value="Nộp hồ sơ">
            </div>
         </div>
      </form>
	</main>
   <?php include 'footer.php'; ?>
</body>
</html>