<?php
	include '../function.php';
	isLogin();
	permissionStudent();
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

	<main style="min-height: 100vh; margin-top: 10%;">
		<div class="d-flex justify-content-center"><h1>Đổi mật khẩu</h1></div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
				  <input type="password" class="form-control" id="username" name="old-password" placeholder="Nhập Password cũ" value="<?php val('submitLogin','old-password') ?>">
				</div>
				<div class="mb-3">
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password mới" name="password" value="<?php val('submitLogin','password') ?>">
				    </div>
				</div>
				<div class="mb-3">
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Xác Thực Password" name="re-password" value="<?php val('submitLogin','re-password') ?>">
				    </div>
				</div>
				<input type="submit" class="btn btn-success" name="submitLogin" value="Đổi mật khẩu">
			  </form>
		</div><br>
		<div class="d-flex justify-content-center">
			<?php 
				if (isset($_POST['submitLogin'])) {
					if (trim($_POST['old-password']) == "" || trim($_POST['password']) == "" || trim($_POST['re-password']) == "") {
						echo "<div class='alert alert-danger text-center' role='alert'>Không để trống dữ liệu</div>";
					}else{
						if (trim($_POST['password']) == trim($_POST['re-password'])) {
							changePassword(trim($_POST['old-password']), trim($_POST['password']));
						}else{
							echo "<div class='alert alert-danger text-center' role='alert'>Mật khẩu chưa giống nhau</div>";
						}
					}
				}
		 	?>
		</div>
		
	</main>
	<?php include 'footer.php'; ?>
</body>

	
</html>