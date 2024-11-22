<?php
	include '../function.php';
	if (isset($_SESSION['id'])) {
		header("location:trang_chu.php");
	}
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
		<div class="d-flex justify-content-center"><h1>Đăng nhập</h1></div>
		<div class="d-flex justify-content-center">
			<form class="w-25" method="POST">
				<div class="mb-3">
				  <input type="text" class="form-control" id="username" name="username" placeholder="Nhập username" value="<?php val('submitLogin','username') ?>">
				</div>
				<div class="mb-3">
				    <div class="col">
				      <input type="password" class="form-control" id="inputPassword" placeholder="Nhập Password" name="password" value="<?php val('submitLogin','password') ?>">
				    </div>
				</div>
				<input type="submit" class="btn btn-primary" name="submitLogin" value="Đăng nhập">
				<a href="dang_ky.php" class="btn btn-success">Chưa có tài khoản</a>
			  </form>
		</div><br>
		<div class="d-flex justify-content-center">
			<?php 
				if (isset($_POST['submitLogin'])) {
					if (trim($_POST['username']) == "" || trim($_POST['password']) == "") {
						echo "<div class='alert alert-danger text-center' role='alert'>Không để trống tài khoản hoặc mật khẩu</div>";
					}else{
						if (login(trim($_POST['username']), trim($_POST['password']))) {
							header("location: trang_chu.php");
						}else{
							echo "<div class='alert alert-danger text-center' role='alert'>Tài khoản hoặc mật khẩu không chính xác</div>";
						}
					}
				}
		 	?>
		</div>
		
	</main>
	<?php include 'footer.php'; ?>
</body>

	
</html>