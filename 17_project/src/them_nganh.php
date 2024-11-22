<?php
   include '../function.php';
   isLogin();
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
			<p class="h3">Thêm Ngành</p>
         <a href="trang_chu.php" class="btn btn-primary">Trở lại</a>
		</div>
		<form method="POST">
         <div style="margin: 20px 13%;">
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Nhập tên ngành</label>
               <input class="form-control"  type="text" name="name" id="" value="<?php val('btn','name') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Thời gian bắt đầu</label>
               <input class="form-control"  type="date" name="start_time" id="" value="<?php val('btn','start_time') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Thời gian kết thúc</label>
               <input class="form-control"  type="date" name="end_time" id="" value="<?php val('btn','end_time') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Trạng thái</label>
               <select class="form-select" name="active">
               	<option value="1" <?php selectedVal("active", "1") ?>>Hiện</option>
						<option value="0" <?php selectedVal("active", "0") ?>>Ẩn</option>
					</select>
            </div>

				<div class="form-group">
					<label for="name_quiz"><span style="color: red;">*</span>Chọn khốp xét tuyển</label>
               <?php 
               	showSubjectGroup();
               ?>
             </div>

            <?php 
            	if (isset($_POST['btn'])) {
            		$check = 1;
                  if (trim($_POST['name']) == "") {
                     echo "Vui lòng nhập tên ngành<br>";
                     $check = 0;
                  }
                  if (trim($_POST['start_time']) == "") {
                     echo "Vui lòng nhập ngày bắt đầu<br>";
                     $check = 0;
                  }
                  if (trim($_POST['end_time']) == "") {
                     echo "Vui lòng nhập ngày kết thúc<br>";
                     $check = 0;
                  }
                  if ($_POST['sub'] == "") {
                     echo "Vui lòng chọn khối xét tuyển<br>";
                     $check = 0;
                  }
                  if ($check == 1) {
                  	$name = trim($_POST['name']);
                  	$name = strtolower($name);
                  	$start = trim($_POST['start_time']);
                  	$end = trim($_POST['end_time']);
                  	$sub = $_POST['sub'];
                  	$active = $_POST['active'];
                  	if ($start >= $end) {
                  		echo "Ngày bắt đầu phải nhỏ hơn ngày kết thúc<br>";
                  	}else{
                  		if (!existsMajorName($name, 0)) {
                  			if (addMajor($name, $start, $end, $sub, $active)) {
	                  			header("location: trang_chu.php");
	                  		}else{
	                  			echo "<div class='alert alert-danger text-center' role='alert'>Thêm ngành thất bại</div>";
	                  		}
                  		}else{
                  			echo "<div class='alert alert-danger text-center' role='alert'>Đã tồn tại tên ngành này</div>";
                  		}
                  	}
                  }
            	}
             ?>

            <div style="margin: 20px 0 0 0;" class="d-grid">
               <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm ngành">
            </div>
         </div>
      </form>
	</main>
   <?php include 'footer.php'; ?>
</body>
</html>