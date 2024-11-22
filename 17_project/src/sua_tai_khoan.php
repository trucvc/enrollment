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
			<p class="h3">Sửa Tài Khoản <?php nameAccount($_GET['id']) ?></p>
         <a href="tai_khoan.php" class="btn btn-primary">Trở lại</a>
		</div>
		<form method="POST">
         <div style="margin: 20px 13%;">
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Tên tài khoản</label>
               <input class="form-control" readonly type="text" name="name" id="" value="<?php getAccount($_GET['id'], 'username') ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Mật khẩu</label>
               <input class="form-control"  type="password" name="password" id="" value="<?php  ?>">
            </div>

            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Quyền</label>
               <select class="form-select" name="role">
                  <option value="student" <?php echo (getRoleAccount($_GET['id'], "role") == "student") ? "selected" : ""; ?>>student</option>
                  <option value="teacher" <?php echo (getRoleAccount($_GET['id'], "role") == "teacher") ? "selected" : ""; ?>>teacher</option>
               	<option value="admin" <?php echo (getRoleAccount($_GET['id'], "role") == "admin") ? "selected" : "";  ?>>admin</option>
					</select>
            </div>

            <?php
            	if (isset($_POST['btn'])) {
                  $password = trim($_POST['password']);
                  $role = $_POST['role'];
                  if (updateAccount($_GET['id'], $password, $role)) {
	                  header("location: tai_khoan.php");
                  }else{
	                  echo "<div class='alert alert-danger text-center' role='alert'>Sửa tài khoản thất bại</div>";
                  }
               }
            ?>

            <div style="margin: 20px 0 0 0;" class="d-grid">
               <input class="btn btn-primary btn-block" name="btn" type="submit" value="Sửa tài khoản">
            </div>
         </div>
      </form>
	</main>
   <?php include 'footer.php'; ?>
</body>
</html>