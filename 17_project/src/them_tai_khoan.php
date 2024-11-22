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
			<p class="h3">Thêm Tài Khoản</p>
         <a href="tai_khoan.php" class="btn btn-primary">Trở lại</a>
		</div>
		<form method="POST">
         <div style="margin: 20px 13%;">
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Tên tài khoản</label>
               <input class="form-control" type="text" name="name" id="" value="<?php val('btn', 'name') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Mật khẩu</label>
               <input class="form-control"  type="password" name="password" id="" value="<?php val('btn', 'password') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Quyền</label>
               <select class="form-select" name="role">
                  <option value="student" <?php selectedVal("role", "student") ?>>student</option>
                  <option value="teacher" <?php selectedVal("role", "teacher") ?>>teacher</option>
               	<option value="admin" <?php selectedVal("role", "admin") ?>>admin</option>
					</select>
            </div>

            <?php
            	if (isset($_POST['btn'])) {
                  $check = 1;
                  if (trim($_POST['name']) == "") {
                     echo "Vui lòng nhập tên tài khoản<br>";
                     $check = 0;
                  }
                  if (trim($_POST['password']) == "") {
                     echo "Vui lòng nhập mật khẩu<br>";
                     $check = 0;
                  }
                  if ($_POST['role'] == "") {
                     echo "Vui lòng chọn quyền<br>";
                     $check = 0;
                  }
                  if ($check == 1) {
                     $name = trim($_POST['name']);
                     $name = strtolower($name);
                     $password = trim($_POST['password']);
                     $role = $_POST['role'];
                     if (!existsUserName($name)) {
                        if (addAccount($name, md5($password), $role)) {
                           header("location: tai_khoan.php");
                        }else{
                           echo "<div class='alert alert-danger text-center' role='alert'>Thêm tài khoản thất bại</div>";
                        }
                     }else{
                        echo "<div class='alert alert-danger text-center' role='alert'>Đã tồn tại tên tài khoản này</div>";
                     }
                  }
               }
            ?>

            <div style="margin: 20px 0 0 0;" class="d-grid">
               <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm tài khoản">
            </div>
         </div>
      </form>
	</main>
   <?php include 'footer.php'; ?>
</body>
</html>